<?php

namespace App\Filament\Resources\Mentoring\Templates\Pages;

use App\Filament\Resources\Mentoring\Templates\MentorAvailabilityTemplateResource;
use App\Support\Mentoring\MentorAvailabilitySlotGenerator;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Support\Facades\Auth;

class ManageMentorAvailabilityTemplates extends ManageRecords
{
    protected static string $resource = MentorAvailabilityTemplateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Tambah Pola Baru'),
            Action::make('generateAllSlots')
                ->label('Terapkan Jadwal ke Kalender')
                ->icon('heroicon-m-calendar-days')
                ->color('success')
                ->modalHeading('Buka Jadwal Mentoring ke Kalender')
                ->modalDescription('Pola jadwal rutin aktif yang sudah Anda buat akan otomatis dibuatkan slot tanggal nyata di kalender bimbingan agar siswa dapat langsung memilih dan membooking sesi Anda.')
                ->modalSubmitActionLabel('Buat Slot Jadwal')
                ->form([
                    Select::make('horizon_days')
                        ->label('Pilih Periode Buka Jadwal')
                        ->options([
                            14 => '2 Minggu ke Depan (14 Hari)',
                            30 => '1 Bulan ke Depan (30 Hari) - Direkomendasikan',
                            60 => '2 Bulan ke Depan (60 Hari)',
                            90 => '3 Bulan ke Depan (90 Hari)',
                        ])
                        ->default(30)
                        ->required()
                        ->helperText('Slot akan otomatis dibuat untuk hari & jam rutin aktif yang belum ada di kalender.'),
                ])
                ->action(function (array $data): void {
                    $user = Auth::user();

                    if ($user === null) {
                        return;
                    }

                    $horizonDays = (int) ($data['horizon_days'] ?? 30);
                    $generatedCount = app(MentorAvailabilitySlotGenerator::class)
                        ->generateForMentor($user, $horizonDays);

                    if ($generatedCount > 0) {
                        Notification::make()
                            ->title('Jadwal Berhasil Diterapkan ke Kalender')
                            ->body("Berhasil menambahkan {$generatedCount} slot jadwal sesi bimbingan baru untuk {$horizonDays} hari ke depan.")
                            ->success()
                            ->send();
                    } else {
                        Notification::make()
                            ->title('Jadwal Sudah Terbuka')
                            ->body("Slot jadwal untuk seluruh pola rutin Anda sudah ada di kalender untuk periode {$horizonDays} hari ke depan.")
                            ->info()
                            ->send();
                    }
                }),
        ];
    }
}