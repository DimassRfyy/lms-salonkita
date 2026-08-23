<?php

namespace App\Filament\Resources\Mentoring\Slots\Pages;

use App\Filament\Resources\Mentoring\Slots\MentorAvailabilitySlotResource;
use App\Models\MentorAvailabilitySlot;
use App\Support\Mentoring\MentorAvailabilitySlotGenerator;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ManageRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class ManageMentorAvailabilitySlots extends ManageRecords
{
    protected static string $resource = MentorAvailabilitySlotResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Tambah Slot Manual'),

            Action::make('cleanupExpiredSlots')
                ->label('Bersihkan Slot Kadaluarsa')
                ->icon('heroicon-m-trash')
                ->color('danger')
                ->requiresConfirmation()
                ->modalHeading('Bersihkan Slot yang Sudah Lewat')
                ->modalDescription('Sistem akan menghapus slot kosong (status tersedia) yang tanggal dan jamnya sudah lewat dari waktu saat ini. Slot yang sudah dibooking siswa TIDAK akan terhapus.')
                ->modalSubmitActionLabel('Ya, Bersihkan Sekarang')
                ->action(function (): void {
                    $mentorId = Auth::id();
                    if (! $mentorId) {
                        return;
                    }

                    $deletedCount = app(MentorAvailabilitySlotGenerator::class)
                        ->pruneExpiredAvailableSlots($mentorId);

                    if ($deletedCount > 0) {
                        Notification::make()
                            ->title('Pembersihan Berhasil')
                            ->body("{$deletedCount} slot kosong yang sudah kadaluarsa berhasil dihapus dari sistem.")
                            ->success()
                            ->send();
                    } else {
                        Notification::make()
                            ->title('Tidak Ada Slot Kadaluarsa')
                            ->body('Tidak ada slot kosong yang sudah lewat. Kalender Anda sudah bersih.')
                            ->info()
                            ->send();
                    }
                }),
        ];
    }

    public function getTabs(): array
    {
        $mentorId = Auth::id();

        $baseQuery = MentorAvailabilitySlot::query()->where('mentor_id', $mentorId);

        $upcomingCount = (clone $baseQuery)
            ->where(function (Builder $query): void {
                $query->where('starts_at', '>=', now())
                    ->orWhere('status', MentorAvailabilitySlot::STATUS_BOOKED);
            })
            ->count();

        $bookedCount = (clone $baseQuery)
            ->where('status', MentorAvailabilitySlot::STATUS_BOOKED)
            ->count();

        $expiredCount = (clone $baseQuery)
            ->where('status', MentorAvailabilitySlot::STATUS_AVAILABLE)
            ->where('starts_at', '<', now())
            ->count();

        return [
            'upcoming' => Tab::make('Slot Mendatang & Aktif')
                ->badge($upcomingCount > 0 ? (string) $upcomingCount : null)
                ->badgeColor('success')
                ->icon('heroicon-m-clock')
                ->modifyQueryUsing(fn (Builder $query) => $query->where(function (Builder $q): void {
                    $q->where('starts_at', '>=', now())
                        ->orWhere('status', MentorAvailabilitySlot::STATUS_BOOKED);
                })),

            'booked' => Tab::make('Sudah Dibooking')
                ->badge($bookedCount > 0 ? (string) $bookedCount : null)
                ->badgeColor('info')
                ->icon('heroicon-m-check-badge')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', MentorAvailabilitySlot::STATUS_BOOKED)),

            'expired' => Tab::make('Kadaluarsa (Belum Dibooking)')
                ->badge($expiredCount > 0 ? (string) $expiredCount : null)
                ->badgeColor('warning')
                ->icon('heroicon-m-x-circle')
                ->modifyQueryUsing(fn (Builder $query) => $query
                    ->where('status', MentorAvailabilitySlot::STATUS_AVAILABLE)
                    ->where('starts_at', '<', now())
                ),
        ];
    }
}