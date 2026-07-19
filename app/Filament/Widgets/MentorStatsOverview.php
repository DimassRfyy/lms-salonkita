<?php

namespace App\Filament\Widgets;

use App\Models\MentorAvailabilitySlot;
use App\Models\MentoringBooking;
use Filament\Facades\Filament;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class MentorStatsOverview extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    public static function canView(): bool
    {
        return Filament::auth()->user()?->role === 'mentor';
    }

    protected function getStats(): array
    {
        $mentorId = Filament::auth()->id();

        $availableSlots = MentorAvailabilitySlot::query()
            ->where('mentor_id', $mentorId)
            ->where('status', MentorAvailabilitySlot::STATUS_AVAILABLE)
            ->where('starts_at', '>=', now())
            ->count('*');

        $bookedSlots = MentoringBooking::query()
            ->where('mentor_id', $mentorId)
            ->whereIn('status', [
                MentoringBooking::STATUS_CONFIRMED,
                MentoringBooking::STATUS_COMPLETED,
            ])
            ->count('*');

        $waitingMeetingUrl = MentoringBooking::query()
            ->where('mentor_id', $mentorId)
            ->where('status', MentoringBooking::STATUS_CONFIRMED)
            ->where(function ($query): void {
                $query->whereNull('meeting_url')
                    ->orWhere('meeting_url', '');
            })
            ->count('*');

        return [
            Stat::make('Jadwal Tersedia', number_format($availableSlots))
                ->description('Slot mentoring yang masih bisa dibooking')
                ->descriptionIcon('heroicon-m-calendar-days')
                ->color('success'),

            Stat::make('Jadwal Dibooking', number_format($bookedSlots))
                ->description('Total booking confirmed & completed')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('primary'),

            Stat::make('Menunggu URL Meeting', number_format($waitingMeetingUrl))
                ->description('Booking confirmed tanpa link Meet/Zoom')
                ->descriptionIcon('heroicon-m-link')
                ->color('warning'),
        ];
    }
}
