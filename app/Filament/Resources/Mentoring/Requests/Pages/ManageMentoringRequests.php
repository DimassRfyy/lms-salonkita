<?php

namespace App\Filament\Resources\Mentoring\Requests\Pages;

use App\Filament\Resources\Mentoring\Requests\MentoringRequestResource;
use Filament\Resources\Pages\ManageRecords;

class ManageMentoringRequests extends ManageRecords
{
    protected static string $resource = MentoringRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
