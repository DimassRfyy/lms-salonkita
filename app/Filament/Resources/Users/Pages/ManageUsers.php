<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use App\Models\User;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class ManageUsers extends ManageRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        if (Auth::user()?->role !== 'admin') {
            return [];
        }

        return [
            CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        $user = Auth::user();
        if ($user?->role !== 'admin') {
            return [];
        }

        $pendingCount = User::query()
            ->whereIn('role', ['mentor', 'coach'])
            ->where('is_approved', false)
            ->count();

        $mentorCoachCount = User::query()
            ->whereIn('role', ['mentor', 'coach'])
            ->where('is_approved', true)
            ->count();

        $studentCount = User::query()
            ->where('role', 'student')
            ->count();

        return [
            'all' => Tab::make('Semua User'),
            'pending_approval' => Tab::make('Menunggu Persetujuan')
                ->badge($pendingCount > 0 ? (string) $pendingCount : null)
                ->badgeColor('warning')
                ->icon('heroicon-m-clock')
                ->modifyQueryUsing(fn (Builder $query) => $query
                    ->whereIn('role', ['mentor', 'coach'])
                    ->where('is_approved', false)
                ),
            'mentors_coaches' => Tab::make('Mentor & Coach')
                ->badge($mentorCoachCount > 0 ? (string) $mentorCoachCount : null)
                ->icon('heroicon-m-academic-cap')
                ->modifyQueryUsing(fn (Builder $query) => $query
                    ->whereIn('role', ['mentor', 'coach'])
                    ->where('is_approved', true)
                ),
            'students' => Tab::make('Student')
                ->badge($studentCount > 0 ? (string) $studentCount : null)
                ->badgeColor('gray')
                ->icon('heroicon-m-user')
                ->modifyQueryUsing(fn (Builder $query) => $query
                    ->where('role', 'student')
                ),
        ];
    }
}
