<?php

namespace App\Filament\Resources\CourseTaskSubmissions\Pages;

use App\Filament\Resources\CourseTaskSubmissions\CourseTaskSubmissionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageCourseTaskSubmissions extends ManageRecords
{
    protected static string $resource = CourseTaskSubmissionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
