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

        $mentorCount = User::query()
            ->where('role', 'mentor')
            ->where('is_approved', true)
            ->count();

        $coachCount = User::query()
            ->where('role', 'coach')
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
                ->modifyQueryUsing(
                    fn(Builder $query) => $query
                        ->whereIn('role', ['mentor', 'coach'])
                        ->where('is_approved', false)
                ),
            'mentors' => Tab::make('Mentor')
                ->badge($mentorCount > 0 ? (string) $mentorCount : null)
                ->badgeColor('warning')
                ->icon('heroicon-m-academic-cap')
                ->modifyQueryUsing(
                    fn(Builder $query) => $query
                        ->where('role', 'mentor')
                        ->where('is_approved', true)
                ),
            'coaches' => Tab::make('Coach')
                ->badge($coachCount > 0 ? (string) $coachCount : null)
                ->badgeColor('info')
                ->icon('heroicon-m-sparkles')
                ->modifyQueryUsing(
                    fn(Builder $query) => $query
                        ->where('role', 'coach')
                        ->where('is_approved', true)
                ),
            'students' => Tab::make('Student')
                ->badge($studentCount > 0 ? (string) $studentCount : null)
                ->badgeColor('gray')
                ->icon('heroicon-m-user')
                ->modifyQueryUsing(
                    fn(Builder $query) => $query
                        ->where('role', 'student')
                ),
        ];
    }
}
