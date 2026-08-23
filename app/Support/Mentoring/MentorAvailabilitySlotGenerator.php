<?php

namespace App\Support\Mentoring;

use App\Models\MentorAvailabilitySlot;
use App\Models\MentorAvailabilityTemplate;
use App\Models\User;
use Carbon\Carbon;

class MentorAvailabilitySlotGenerator
{
    public function pruneExpiredAvailableSlots(int $mentorId): int
    {
        return MentorAvailabilitySlot::query()
            ->where('mentor_id', $mentorId)
            ->where('status', MentorAvailabilitySlot::STATUS_AVAILABLE)
            ->where('starts_at', '<', now())
            ->delete();
    }

    public function generateForMentor(User $mentor, int $horizonDays = 60): int
    {
        $this->pruneExpiredAvailableSlots((int) $mentor->id);

        return $mentor->mentorAvailabilityTemplates()
            ->where('is_active', true)
            ->get()
            ->sum(fn (MentorAvailabilityTemplate $template): int => $this->generateForTemplate($template, $horizonDays));
    }

    public function generateForTemplate(MentorAvailabilityTemplate $template, int $horizonDays = 60): int
    {
        $this->pruneExpiredAvailableSlots((int) $template->mentor_id);
        $days = max(1, $horizonDays);
        $startDate = Carbon::today();
        $endDate = Carbon::today()->addDays($days);
        $createdCount = 0;

        for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
            if ((int) $date->dayOfWeek !== (int) $template->day_of_week) {
                continue;
            }

            $windowStart = Carbon::parse($date->toDateString() . ' ' . $template->start_time);
            $windowEnd = Carbon::parse($date->toDateString() . ' ' . $template->end_time);

            if ($windowEnd->lte($windowStart)) {
                continue;
            }

            $slot = MentorAvailabilitySlot::firstOrCreate(
                [
                    'mentor_id' => $template->mentor_id,
                    'starts_at' => $windowStart->toDateTimeString(),
                    'ends_at' => $windowEnd->toDateTimeString(),
                ],
                [
                    'mentor_availability_template_id' => $template->id,
                    'status' => MentorAvailabilitySlot::STATUS_AVAILABLE,
                ]
            );

            if ($slot->wasRecentlyCreated) {
                $createdCount++;
            }
        }

        return $createdCount;
    }

    public function syncTemplateSlots(MentorAvailabilityTemplate $template, int $horizonDays = 30): array
    {
        $this->pruneExpiredAvailableSlots((int) $template->mentor_id);

        $futureSlotsQuery = MentorAvailabilitySlot::query()
            ->where('mentor_availability_template_id', $template->id)
            ->where('starts_at', '>=', now());

        $bookedCount = (clone $futureSlotsQuery)
            ->where('status', MentorAvailabilitySlot::STATUS_BOOKED)
            ->count();

        // Hapus semua slot kosong masa depan yang belum dibooking agar jadwal lama dibersihkan
        $deletedUnbookedCount = (clone $futureSlotsQuery)
            ->where('status', MentorAvailabilitySlot::STATUS_AVAILABLE)
            ->delete();

        $newCreatedCount = 0;
        if ($template->is_active) {
            $newCreatedCount = $this->generateForTemplate($template, $horizonDays);
        }

        return [
            'deleted_unbooked' => $deletedUnbookedCount,
            'booked_retained' => $bookedCount,
            'new_created' => $newCreatedCount,
        ];
    }

    public function cleanupTemplateSlotsOnDelete(int $templateId): int
    {
        return MentorAvailabilitySlot::query()
            ->where('mentor_availability_template_id', $templateId)
            ->where('status', MentorAvailabilitySlot::STATUS_AVAILABLE)
            ->where('starts_at', '>=', now())
            ->delete();
    }
}