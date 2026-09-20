<?php

namespace App\Filament\Resources\Courses\Pages;

use App\Filament\Resources\Courses\CourseResource;
use App\Models\Course;
use App\Support\Youtube;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;

class EditCourse extends EditRecord
{
    protected static string $resource = CourseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['introduction_video_url'] = Youtube::extractId($data['introduction_video_url'] ?? null);

        if (($data['level'] ?? '') === Course::LEVEL_BASIC) {
            $data['price'] = 0;
        }

        $user = Auth::user();
        if ($user?->role === 'coach') {
            unset($data['is_published']);
            $data['user_id'] = $user->id;
        }

        return $data;
    }
}
