<?php

namespace App\Filament\Resources\Mentoring\Bookings\Pages;

use Filament\Resources\Pages\ManageRecords;

class ManageMentoringBookings extends ManageRecords
{
    protected static string $resource = \App\Filament\Resources\Mentoring\Bookings\MentoringBookingResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
