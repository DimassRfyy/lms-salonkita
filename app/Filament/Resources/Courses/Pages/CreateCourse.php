<?php

namespace App\Filament\Resources\Courses\Pages;

use App\Filament\Resources\Courses\CourseResource;
use App\Support\Youtube;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class CreateCourse extends CreateRecord
{
    protected static string $resource = CourseResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['introduction_video_url'] = Youtube::extractId($data['introduction_video_url'] ?? null);

        $user = Auth::user();
        if ($user?->role === 'coach') {
            $data['user_id'] = $user->id;
            $data['is_published'] = false;
        }

        return $data;
    }

    protected function handleRecordCreation(array $data): Model
    {
        return static::getModel()::create($data);
    }

    protected function getCreatedNotification(): ?Notification
    {
        $user = Auth::user();

        if ($user?->role === 'coach') {
            return Notification::make()
                ->title('Kelas Berhasil Diajukan')
                ->body('Kelas baru berhasil disimpan dengan status Belum Aktif dan akan ditinjau oleh Admin.')
                ->success();
        }

        return Notification::make()
            ->title('Kelas Berhasil Dibuat')
            ->body('Silakan tambahkan section dan video materi pembelajaran di bawah.')
            ->success();
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('edit', ['record' => $this->getRecord()]);
    }
}
