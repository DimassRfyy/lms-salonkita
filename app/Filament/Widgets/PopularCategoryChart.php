<?php

namespace App\Filament\Widgets;

use App\Models\Transaction;
use Filament\Facades\Filament;
use Filament\Widgets\ChartWidget;

class PopularCategoryChart extends ChartWidget
{
    protected ?string $heading = 'Kategori Kelas Paling Laris';
    protected ?string $maxHeight = '27vh';

    protected static ?int $sort = 2;

    public static function canView(): bool
    {
        return Filament::auth()->user()?->role === 'admin';
    }

    protected function getData(): array
    {
        $salesByCategory = Transaction::query()
            ->paid()
            ->with(['course.category'])
            ->get(['course_id'])
            ->filter(fn (Transaction $transaction): bool => $transaction->course !== null && $transaction->course->category !== null)
            ->groupBy(fn (Transaction $transaction): string => $transaction->course->category->name)
            ->map(fn ($transactions): int => $transactions->count())
            ->sortDesc();

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah kelas terjual',
                    'data' => $salesByCategory->values()->all(),
                    'backgroundColor' => [
                        '#0ea5e9',
                        '#22c55e',
                        '#f59e0b',
                        '#ef4444',
                        '#8b5cf6',
                        '#14b8a6',
                        '#ec4899',
                        '#64748b',
                    ],
                ],
            ],
            'labels' => $salesByCategory->keys()->all(),
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }
}
