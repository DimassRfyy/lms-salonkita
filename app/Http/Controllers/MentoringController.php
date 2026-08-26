<?php

namespace App\Http\Controllers;

use App\Models\MentorAvailabilitySlot;
use App\Models\MentoringBooking;
use App\Models\MentoringEntitlement;
use App\Models\MentoringRequest;
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

        $availableMentoringEntitlements = $user->availableMentoringEntitlements()
            ->with('course')
            ->latest('granted_at')
            ->get();

        $availableMentoringEntitlement = $availableMentoringEntitlements->first();

        // 1 Student = 1 Dedicated Mentor relationship checks
        $activeMentorship = $user->activeMentorship()
            ->with(['mentor', 'course'])
            ->first();

        $pendingMentorship = $user->pendingMentorship()
            ->with(['mentor', 'course'])
            ->first();

        $latestMentoringRequest = $user->mentoringRequestsAsStudent()
            ->with(['mentor', 'course'])
            ->latest()
            ->first();

        // Active upcoming booking
        $activeMentoringBooking = $user->mentoringBookingsAsStudent()
            ->where('status', MentoringBooking::STATUS_CONFIRMED)
            ->where('starts_at', '>=', now()->subHours(2))
            ->with(['course', 'mentor', 'slot'])
            ->orderBy('starts_at')
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

        $hasMentoringAccess = $availableMentoringEntitlements->isNotEmpty()
            || $activeMentorship !== null
            || $pendingMentorship !== null
            || $latestMentoringBooking !== null;

        $totalRemainingQuota = $availableMentoringEntitlements->sum(fn ($e) => max(0, $e->total_quota - $e->used_quota));

        return view('pages.mentoring.detail', compact(
            'availableMentoringEntitlements',
            'availableMentoringEntitlement',
            'activeMentorship',
            'pendingMentorship',
            'latestMentoringRequest',
            'activeMentoringBooking',
            'latestMentoringBooking',
            'mentoringHistory',
            'hasMentoringAccess',
            'totalRemainingQuota'
        ));
    }

    public function mentors(Request $request)
    {
        $user = $request->user();
        abort_unless($user && $user->role === 'student', 403);

        // Check if student already has an active dedicated mentor
        $activeMentorship = $user->activeMentorship()->with('mentor')->first();
        if ($activeMentorship && $activeMentorship->mentor) {
            return redirect()
                ->route('mentoring.book')
                ->with('info', 'Anda sudah memiliki mentor aktif (' . $activeMentorship->mentor->name . '). Silakan langsung pilih jadwal bimbingan atau putus hubungan jika ingin berganti mentor.');
        }

        // Check if student has a pending request
        $pendingMentorship = $user->pendingMentorship()->with('mentor')->first();
        if ($pendingMentorship && $pendingMentorship->mentor) {
            return redirect()
                ->route('mentoring.index')
                ->with('info', 'Permohonan bimbingan Anda ke ' . $pendingMentorship->mentor->name . ' sedang ditinjau.');
        }

        $availableEntitlements = $user->availableMentoringEntitlements()
            ->with('course')
            ->latest('granted_at')
            ->get();

        if ($availableEntitlements->isEmpty()) {
            return redirect()
                ->route('mentoring.index')
                ->with('error', 'Halaman daftar mentor hanya tersedia jika Anda memiliki kuota mentoring aktif.');
        }

        $activeEntitlement = $availableEntitlements->first();

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

        $activeRequest = $pendingMentorship ?? $activeMentorship;

        return view('pages.mentoring.index', compact('availableEntitlements', 'mentorCards', 'activeEntitlement', 'activeMentorship', 'pendingMentorship', 'activeRequest'));
    }

    public function apply(Request $request, MentoringEntitlement $entitlement): RedirectResponse
    {
        $user = $request->user();
        abort_unless($user && $user->role === 'student', 403);
        abort_unless($entitlement->student_id === $user->id, 403);
        abort_unless($entitlement->status === 'active' && $entitlement->used_quota < $entitlement->total_quota, 422, 'Kuota mentoring sudah habis.');

        // Guard against multiple active or pending mentorships (1 Student = 1 Mentor model)
        if ($user->activeMentorship()->exists()) {
            return redirect()
                ->route('mentoring.book')
                ->with('info', 'Anda sudah memiliki mentor aktif. Silakan pilih jadwal sesi dengan mentor Anda.');
        }

        if ($user->pendingMentorship()->exists()) {
            return redirect()
                ->route('mentoring.index')
                ->with('info', 'Anda masih memiliki permohonan yang menunggu persetujuan mentor.');
        }

        $validated = $request->validate([
            'mentor_id' => ['required', 'integer', 'exists:users,id'],
            'student_notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $mentor = User::query()
            ->whereKey($validated['mentor_id'])
            ->where('role', 'mentor')
            ->where('is_approved', true)
            ->firstOrFail();

        MentoringRequest::query()->create([
            'mentoring_entitlement_id' => $entitlement->id,
            'student_id' => $user->id,
            'mentor_id' => $mentor->id,
            'course_id' => $entitlement->course_id,
            'status' => MentoringRequest::STATUS_PENDING,
            'student_notes' => $validated['student_notes'] ?? null,
        ]);

        return redirect()
            ->route('mentoring.index')
            ->with('success', 'Permohonan bimbingan berhasil diajukan ke ' . $mentor->name . '. Mohon tunggu persetujuan mentor sebelum memilih jadwal.');
    }

    public function cancelRequest(Request $request, MentoringRequest $mentoringRequest): RedirectResponse
    {
        $user = $request->user();
        abort_unless($user && $user->role === 'student', 403);
        abort_unless($mentoringRequest->student_id === $user->id, 403);
        abort_unless($mentoringRequest->isPending(), 422, 'Hanya permohonan yang berstatus menunggu yang dapat dibatalkan.');

        $mentoringRequest->update([
            'status' => MentoringRequest::STATUS_CANCELED,
        ]);

        return redirect()
            ->route('mentoring.index')
            ->with('success', 'Permohonan mentoring berhasil dibatalkan. Anda dapat mengajukan ke mentor lain.');
    }

    public function terminateMentorship(Request $request): RedirectResponse
    {
        $user = $request->user();
        abort_unless($user && $user->role === 'student', 403);

        $validated = $request->validate([
            'termination_reason' => ['required', 'string', 'min:5', 'max:1000'],
        ], [
            'termination_reason.required' => 'Mohon berikan alasan pembatalan / pergantian mentor.',
            'termination_reason.min' => 'Alasan pembatalan minimal 5 karakter.',
        ]);

        $activeMentorship = $user->activeMentorship()->with('mentor')->first();

        if (! $activeMentorship) {
            return redirect()
                ->route('mentoring.index')
                ->with('error', 'Anda tidak memiliki mentor aktif saat ini.');
        }

        $mentorName = $activeMentorship->mentor?->name ?? 'Mentor';

        DB::transaction(function () use ($activeMentorship, $validated, $user): void {
            // 1. Mark relationship as terminated with audit reason
            $activeMentorship->update([
                'status' => MentoringRequest::STATUS_TERMINATED,
                'termination_reason' => $validated['termination_reason'],
                'terminated_at' => now(),
                'terminated_by' => 'student',
            ]);

            // 2. Safely cancel any upcoming unexecuted bookings with this mentor & refund quota
            $upcomingBookings = MentoringBooking::query()
                ->where('student_id', $user->id)
                ->where('mentor_id', $activeMentorship->mentor_id)
                ->where('status', MentoringBooking::STATUS_CONFIRMED)
                ->where('starts_at', '>=', now())
                ->with(['slot', 'entitlement'])
                ->lockForUpdate()
                ->get();

            foreach ($upcomingBookings as $booking) {
                $booking->update([
                    'status' => MentoringBooking::STATUS_CANCELED,
                ]);

                if ($booking->slot) {
                    $booking->slot->update([
                        'status' => MentorAvailabilitySlot::STATUS_AVAILABLE,
                    ]);
                }

                if ($booking->entitlement && $booking->entitlement->used_quota > 0) {
                    $booking->entitlement->decrement('used_quota');
                }
            }
        });

        return redirect()
            ->route('mentoring.mentors')
            ->with('success', 'Hubungan mentoring dengan ' . $mentorName . ' berhasil diakhiri. Kuota sesi Anda tetap aman dan Anda dapat memilih mentor baru.');
    }

    public function book(Request $request, ?MentoringEntitlement $entitlement = null)
    {
        $user = $request->user();
        abort_unless($user && $user->role === 'student', 403);

        // Find active mentorship
        $activeMentorship = $user->activeMentorship()
            ->with('mentor')
            ->first();

        if (! $activeMentorship || ! $activeMentorship->mentor) {
            return redirect()
                ->route('mentoring.index')
                ->with('error', 'Anda belum memiliki mentor yang aktif. Silakan pilih dan ajukan permohonan mentor terlebih dahulu.');
        }

        $selectedMentor = $activeMentorship->mentor;

        // Fetch available entitlements with unused quota
        $availableEntitlements = $user->availableMentoringEntitlements()
            ->with('course')
            ->latest('granted_at')
            ->get();

        if ($availableEntitlements->isEmpty()) {
            return redirect()
                ->route('mentoring.index')
                ->with('error', 'Kuota mentoring Anda sudah habis atau belum memiliki paket mentoring aktif.');
        }

        // If specific entitlement was requested, verify it; otherwise use the first active one
        if ($entitlement && $entitlement->student_id === $user->id && $entitlement->used_quota < $entitlement->total_quota) {
            $currentEntitlement = $entitlement->load('course');
        } else {
            $currentEntitlement = $availableEntitlements->first();
        }

        return view('pages.mentoring.book', [
            'entitlement' => $currentEntitlement,
            'availableEntitlements' => $availableEntitlements,
            'activeMentorship' => $activeMentorship,
            'selectedMentor' => $selectedMentor,
        ]);
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

            // Verify active approved mentorship exists for this mentor
            $activeMentorship = MentoringRequest::query()
                ->where('student_id', $user->id)
                ->where('mentor_id', $slot->mentor_id)
                ->where('status', MentoringRequest::STATUS_APPROVED)
                ->lockForUpdate()
                ->first();

            abort_unless($activeMentorship !== null, 422, 'Mentor ini belum menyetujui permohonan bimbingan Anda.');

            MentoringBooking::query()->create([
                'mentoring_entitlement_id' => $lockedEntitlement->id,
                'mentor_id' => $slot->mentor_id,
                'student_id' => $user->id,
                'course_id' => $lockedEntitlement->course_id,
                'mentor_availability_slot_id' => $slot->id,
                'starts_at' => $slot->starts_at,
                'ends_at' => $slot->ends_at,
                'status' => MentoringBooking::STATUS_CONFIRMED,
                'booked_at' => now(),
            ]);

            $slot->update([
                'status' => MentorAvailabilitySlot::STATUS_BOOKED,
            ]);

            $lockedEntitlement->update([
                'used_quota' => min($lockedEntitlement->total_quota, $lockedEntitlement->used_quota + 1),
            ]);

            // Keep active mentorship approved so student remains paired with this mentor!
        });

        return redirect()
            ->route('mentoring.index')
            ->with('success', 'Jadwal sesi mentoring berhasil dikonfirmasi.');
    }
}