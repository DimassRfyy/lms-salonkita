<?php

namespace App\Livewire;

use App\Models\MentorAvailabilitySlot;
use App\Models\MentoringBooking;
use App\Models\MentoringEntitlement;
use App\Models\MentoringRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Livewire\Component;

class MentoringBookingSlotPicker extends Component
{
    public MentoringEntitlement $entitlement;

    public User $mentor;

    public string $selectedDate = '';

    public ?int $selectedSlotId = null;

    public string $selectedSlotLabel = '';

    public bool $showConfirmModal = false;

    public ?string $errorMessage = null;

    public function mount(MentoringEntitlement $entitlement, User $mentor): void
    {
        $this->entitlement = $entitlement;
        $this->mentor = $mentor;

        $this->initDefaultDate();
    }

    public function initDefaultDate(): void
    {
        $firstDate = MentorAvailabilitySlot::query()
            ->where('mentor_id', $this->mentor->id)
            ->where('status', MentorAvailabilitySlot::STATUS_AVAILABLE)
            ->where('starts_at', '>=', now())
            ->orderBy('starts_at', 'asc')
            ->value(DB::raw('DATE(starts_at)'));

        $this->selectedDate = $firstDate ?: now()->addDay()->toDateString();
    }

    public function selectDate(string $date): void
    {
        $this->selectedDate = $date;
        $this->selectedSlotId = null;
        $this->selectedSlotLabel = '';
        $this->showConfirmModal = false;
        $this->errorMessage = null;
    }

    public function confirmSlot(int $slotId): void
    {
        $this->errorMessage = null;

        $slot = MentorAvailabilitySlot::query()
            ->where('mentor_id', $this->mentor->id)
            ->whereKey($slotId)
            ->first();

        if (! $slot || ! $slot->isAvailable()) {
            $this->errorMessage = 'Slot jadwal ini sudah tidak tersedia. Silakan pilih slot lain.';
            return;
        }

        $this->selectedSlotId = $slot->id;
        $this->selectedSlotLabel = ($slot->starts_at?->translatedFormat('l, d F Y') ?? '-') . ' pukul ' . ($slot->starts_at?->format('H:i') ?? '-') . ' - ' . ($slot->ends_at?->format('H:i') ?? '-') . ' WIB';
        $this->showConfirmModal = true;
    }

    public function closeModal(): void
    {
        $this->showConfirmModal = false;
        $this->selectedSlotId = null;
        $this->selectedSlotLabel = '';
    }

    public function executeBooking(): mixed
    {
        $this->errorMessage = null;
        $user = Auth::user();

        if (! $user || $user->role !== 'student') {
            $this->errorMessage = 'Anda harus login sebagai siswa.';
            return null;
        }

        if (! $this->selectedSlotId) {
            $this->errorMessage = 'Silakan pilih slot terlebih dahulu.';
            return null;
        }

        try {
            DB::transaction(function () use ($user): void {
                $lockedEntitlement = MentoringEntitlement::query()
                    ->whereKey($this->entitlement->id)
                    ->lockForUpdate()
                    ->firstOrFail();

                abort_unless($lockedEntitlement->status === 'active' && $lockedEntitlement->used_quota < $lockedEntitlement->total_quota, 422, 'Kuota mentoring sudah habis.');

                $slot = MentorAvailabilitySlot::query()
                    ->with('mentor')
                    ->whereKey($this->selectedSlotId)
                    ->lockForUpdate()
                    ->firstOrFail();

                abort_unless($slot->isAvailable(), 422, 'Jadwal sudah tidak tersedia atau baru saja diambil siswa lain.');
                abort_unless($slot->mentor && $slot->mentor->role === 'mentor' && $slot->mentor->is_approved, 422, 'Mentor tidak tersedia.');

                $existingBooking = $slot->booking()->lockForUpdate()->first();
                abort_unless(! $existingBooking, 422, 'Jadwal sudah diambil siswa lain.');

                // Verify approved active mentorship exists for this mentor
                $approvedRequest = MentoringRequest::query()
                    ->where('student_id', $user->id)
                    ->where('mentor_id', $slot->mentor_id)
                    ->where('status', MentoringRequest::STATUS_APPROVED)
                    ->lockForUpdate()
                    ->first();

                abort_unless($approvedRequest !== null, 422, 'Permohonan untuk mentor ini belum disetujui.');

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
            });

            session()->flash('success', 'Jadwal mentoring berhasil dikunci untuk ' . $this->selectedSlotLabel . '!');

            return redirect()->route('mentoring.index');
        } catch (\Throwable $e) {
            $this->errorMessage = $e->getMessage();
            $this->showConfirmModal = false;
            return null;
        }
    }

    public function render(): View
    {
        // 1. Ambil SEMUA tanggal mendatang yang memiliki slot aktif (tanpa batas 13 hari)
        $slotCountsByDate = MentorAvailabilitySlot::query()
            ->selectRaw('DATE(starts_at) as slot_date, COUNT(*) as slots_count')
            ->where('mentor_id', $this->mentor->id)
            ->where('status', MentorAvailabilitySlot::STATUS_AVAILABLE)
            ->where('starts_at', '>=', now())
            ->groupBy('slot_date')
            ->orderBy('slot_date', 'asc')
            ->pluck('slots_count', 'slot_date');

        // Build array list of dates with active slots
        $availableDates = $slotCountsByDate->map(function ($count, $dateKey) {
            $carbonDate = Carbon::parse($dateKey);
            return [
                'date_key' => $dateKey,
                'day_name' => $carbonDate->translatedFormat('D'),
                'day_number' => $carbonDate->format('d'),
                'month_name' => $carbonDate->translatedFormat('M'),
                'full_label' => $carbonDate->translatedFormat('l, d F Y'),
                'slots_count' => (int) $count,
                'is_active' => $dateKey === $this->selectedDate,
            ];
        })->values();

        // 2. Ambil slot pada tanggal yang dipilih
        $slots = MentorAvailabilitySlot::query()
            ->where('mentor_id', $this->mentor->id)
            ->where('status', MentorAvailabilitySlot::STATUS_AVAILABLE)
            ->whereDate('starts_at', $this->selectedDate)
            ->where('starts_at', '>=', now())
            ->orderBy('starts_at', 'asc')
            ->get();

        return view('livewire.mentoring-booking-slot-picker', [
            'availableDates' => $availableDates,
            'slots' => $slots,
            'totalAvailableSlots' => $slotCountsByDate->sum(),
        ]);
    }
}
