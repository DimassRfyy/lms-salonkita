<?php

namespace App\Support\Mentoring;

use App\Models\MentorAvailabilitySlot;
use App\Models\MentorAvailabilityTemplate;
use App\Models\User;
use Carbon\Carbon;

class MentorAvailabilitySlotGenerator
{
    public function generateForMentor(User $mentor, int $horizonDays = 60): int
    {
        return $mentor->mentorAvailabilityTemplates()
            ->where('is_active', true)
            ->get()
            ->sum(fn (MentorAvailabilityTemplate $template): int => $this->generateForTemplate($template, $horizonDays));
    }

    public function generateForTemplate(MentorAvailabilityTemplate $template, int $horizonDays = 60): int
    {
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
}