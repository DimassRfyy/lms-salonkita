<?php

namespace App\Http\Controllers;

use App\Models\MentorAvailabilitySlot;
use App\Models\MentoringBooking;
use App\Models\MentoringEntitlement;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MentoringController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        abort_unless($user && $user->role === 'student', 403);

        $availableMentoringEntitlement = $user->availableMentoringEntitlements()
            ->with('course')
            ->latest('granted_at')
            ->first();

        $latestMentoringBooking = $user->mentoringBookingsAsStudent()
            ->with(['course', 'mentor', 'slot'])
            ->latest('starts_at')
            ->first();

        $mentoringHistory = $user->mentoringBookingsAsStudent()
            ->with(['course', 'mentor', 'slot'])
            ->latest('starts_at')
            ->take(10)
            ->get();

        $hasMentoringAccess = $availableMentoringEntitlement !== null || $latestMentoringBooking !== null;

        return view('pages.mentoring.detail', compact(
            'availableMentoringEntitlement',
            'latestMentoringBooking',
            'mentoringHistory',
            'hasMentoringAccess'
        ));
    }

    public function mentors(Request $request)
    {
        $user = $request->user();
        abort_unless($user && $user->role === 'student', 403);

        $availableEntitlements = $user->availableMentoringEntitlements()
            ->with('course')
            ->latest('granted_at')
            ->get();

        if ($availableEntitlements->isEmpty()) {
            return redirect()
                ->route('mentoring.index')
                ->with('error', 'Halaman daftar mentor hanya tersedia jika kamu punya jatah mentoring aktif.');
        }

        $mentorCards = User::query()
            ->where('role', 'mentor')
            ->where('is_approved', true)
            ->withCount([
                'mentorAvailabilitySlots as available_slots_count' => fn ($query) => $query
                    ->where('status', MentorAvailabilitySlot::STATUS_AVAILABLE)
                    ->where('starts_at', '>=', now()),
            ])
            ->orderBy('name')
            ->get();

        return view('pages.mentoring.index', compact('availableEntitlements', 'mentorCards'));
    }

    public function book(Request $request, MentoringEntitlement $entitlement)
    {
        $user = $request->user();
        abort_unless($user && $user->role === 'student', 403);
        abort_unless($entitlement->student_id === $user->id, 403);
        abort_unless($entitlement->status === 'active' && $entitlement->used_quota < $entitlement->total_quota, 422, 'Kuota mentoring sudah habis.');

        $mentors = User::query()
            ->where('role', 'mentor')
            ->where('is_approved', true)
            ->withCount([
                'mentorAvailabilitySlots as available_slots_count' => fn ($query) => $query
                    ->where('status', MentorAvailabilitySlot::STATUS_AVAILABLE)
                    ->where('starts_at', '>=', now()),
            ])
            ->orderBy('name')
            ->get();

        $selectedMentorId = (int) $request->query('mentor_id', 0);
        $selectedMentor = $selectedMentorId > 0
            ? $mentors->firstWhere('id', $selectedMentorId)
            : $mentors->firstWhere('available_slots_count', '>', 0) ?? $mentors->first();

        $windowStart = now()->startOfDay();
        $windowEnd = now()->addDays(13)->endOfDay();
        $slotCountsByDate = collect();
        $selectedDate = $request->query('date');

        if ($selectedMentor) {
            $slotCountsByDate = MentorAvailabilitySlot::query()
                ->selectRaw('DATE(starts_at) as slot_date, COUNT(*) as slots_count')
                ->where('mentor_id', $selectedMentor->id)
                ->where('status', MentorAvailabilitySlot::STATUS_AVAILABLE)
                ->where('starts_at', '>=', $windowStart)
                ->where('starts_at', '<=', $windowEnd)
                ->groupBy('slot_date')
                ->orderBy('slot_date', 'asc')
                ->pluck('slots_count', 'slot_date');

            if (! $selectedDate || ! preg_match('/^\d{4}-\d{2}-\d{2}$/', $selectedDate)) {
                $selectedDate = $slotCountsByDate->keys()->first() ?: now()->addDay()->toDateString();
            }
        } else {
            $selectedDate = now()->addDay()->toDateString();
        }

        $availableDates = collect(range(0, 13))->map(function (int $offset) use ($windowStart, $slotCountsByDate): array {
            $date = $windowStart->copy()->addDays($offset);
            $dateKey = $date->toDateString();
            $slotCount = (int) ($slotCountsByDate[$dateKey] ?? 0);

            return [
                'date' => $date,
                'date_key' => $dateKey,
                'label' => $date->translatedFormat('D, d M'),
                'slots_count' => $slotCount,
                'is_available' => $slotCount > 0,
            ];
        });

        $availableSlots = collect();
        if ($selectedMentor) {
            $availableSlots = MentorAvailabilitySlot::query()->with('mentor')
                ->where('mentor_id', $selectedMentor->id)
                ->where('status', MentorAvailabilitySlot::STATUS_AVAILABLE)
                ->whereDate('starts_at', $selectedDate)
                ->where('starts_at', '>=', now())
                ->orderBy('starts_at')
                ->get();
        }

        return view('pages.mentoring.book', compact(
            'entitlement',
            'mentors',
            'selectedMentor',
            'selectedDate',
            'availableDates',
            'availableSlots'
        ));
    }

    public function store(Request $request, MentoringEntitlement $entitlement): RedirectResponse
    {
        $user = $request->user();
        abort_unless($user && $user->role === 'student', 403);
        abort_unless($entitlement->student_id === $user->id, 403);

        $validated = $request->validate([
            'slot_id' => ['required', 'integer', 'exists:mentor_availability_slots,id'],
        ]);

        DB::transaction(function () use ($entitlement, $validated, $user): void {
            $lockedEntitlement = MentoringEntitlement::query()
                ->whereKey($entitlement->id)
                ->lockForUpdate()
                ->firstOrFail();

            abort_unless($lockedEntitlement->status === 'active' && $lockedEntitlement->used_quota < $lockedEntitlement->total_quota, 422, 'Kuota mentoring sudah habis.');

            $slot = MentorAvailabilitySlot::query()
                ->with('mentor')
                ->whereKey($validated['slot_id'])
                ->lockForUpdate()
                ->firstOrFail();

            abort_unless($slot->isAvailable(), 422, 'Jadwal sudah tidak tersedia.');
            abort_unless($slot->mentor && $slot->mentor->role === 'mentor' && $slot->mentor->is_approved, 422, 'Mentor tidak tersedia.');

            $existingBooking = $slot->booking()->lockForUpdate()->first();
            abort_unless(! $existingBooking, 422, 'Jadwal sudah diambil siswa lain.');

            MentoringBooking::query()->create([
                'mentoring_entitlement_id' => $lockedEntitlement->id,
                'mentor_id' => $slot->mentor_id,
                'student_id' => $user->id,
                'course_id' => $lockedEntitlement->course_id,
                'mentor_availability_slot_id' => $slot->id,
                'starts_at' => $slot->starts_at,
                'ends_at' => $slot->ends_at,
                'status' => MentoringBooking::STATUS_CONFIRMED,
                'meeting_platform' => $slot->meeting_platform,
                'meeting_url' => $slot->meeting_url,
                'booked_at' => now(),
            ]);

            $slot->update([
                'status' => MentorAvailabilitySlot::STATUS_BOOKED,
            ]);

            $lockedEntitlement->update([
                'used_quota' => min($lockedEntitlement->total_quota, $lockedEntitlement->used_quota + 1),
            ]);
        });

        return redirect()
            ->route('mentoring.index')
            ->with('success', 'Jadwal mentoring berhasil diambil.');
    }
}