<?php

namespace App\Filament\Pages;

use Filament\Actions\Action;
use Filament\Facades\Filament;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Support\Enums\Width;
use Illuminate\Contracts\Support\Htmlable;

class Dashboard extends BaseDashboard
{
    public function getTitle(): string | Htmlable
    {
        $role = Filament::auth()->user()?->role;
        $roleLabel = match ($role) {
            'admin' => 'Admin',
            'mentor' => 'Mentor',
            'coach' => 'Coach',
            default => 'User',
        };

        return 'Dashboard ' . $roleLabel;
    }

    protected function getHeaderActions(): array
    {
        $role = Filament::auth()->user()?->role;

        if ($role === 'mentor') {
            return [
                Action::make('mentorGuide')
                    ->label('Panduan & Alur Mentor')
                    ->icon('heroicon-m-academic-cap')
                    ->color('primary')
                    ->modalHeading('Panduan Alur Kerja Mentor')
                    ->modalDescription('Ikuti langkah-langkah praktis berikut untuk mengelola bimbingan Anda dari awal hingga tuntas.')
                    ->modalWidth(Width::FourExtraLarge)
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Tutup Panduan')
                    ->modalContent(view('filament.pages.mentor-guide-modal')),
            ];
        }

        return [];
    }
}
