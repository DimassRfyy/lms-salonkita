<?php

namespace App\Filament\Resources\CourseVideoQuizzes\Pages;

use App\Filament\Resources\CourseVideoQuizzes\CourseVideoQuizResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageCourseVideoQuizzes extends ManageRecords
{
    protected static string $resource = CourseVideoQuizResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}