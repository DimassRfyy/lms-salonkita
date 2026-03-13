<?php

namespace App\Filament\Resources\CourseDiscussions\Pages;

use App\Filament\Resources\CourseDiscussions\CourseDiscussionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageCourseDiscussions extends ManageRecords
{
    protected static string $resource = CourseDiscussionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
