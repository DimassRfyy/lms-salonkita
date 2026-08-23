<?php

namespace App\Filament\Resources\Courses\Pages;

use App\Filament\Resources\Courses\CourseResource;
use App\Models\Course;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class ListCourses extends ListRecords
{
    protected static string $resource = CourseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        $user = Auth::user();

        $baseQuery = Course::query();
        if ($user?->role === 'coach') {
            $baseQuery->where('user_id', $user->id);
        }

        $allCount = (clone $baseQuery)->count();
        $activeCount = (clone $baseQuery)->where('is_published', true)->count();
        $inactiveCount = (clone $baseQuery)->where('is_published', false)->count();

        return [
            'all' => Tab::make('Semua Kelas')
                ->badge($allCount > 0 ? (string) $allCount : null)
                ->icon('heroicon-m-rectangle-stack'),
            'active' => Tab::make('Kelas Aktif')
                ->badge($activeCount > 0 ? (string) $activeCount : null)
                ->badgeColor('success')
                ->icon('heroicon-m-check-circle')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('is_published', true)),
            'inactive' => Tab::make('Belum Aktif / Menunggu Review')
                ->badge($inactiveCount > 0 ? (string) $inactiveCount : null)
                ->badgeColor('warning')
                ->icon('heroicon-m-clock')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('is_published', false)),
        ];
    }
}
