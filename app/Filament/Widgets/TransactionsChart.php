<?php

namespace App\Filament\Widgets;

use App\Models\Transaction;
use Filament\Facades\Filament;
use Filament\Widgets\ChartWidget;

class TransactionsChart extends ChartWidget
{
    protected ?string $heading = 'Total Price per Bulan';
    protected ?string $maxHeight = '280px';
    protected int | string | array $columnSpan = [
        'default' => 'full',
        'md' => 1,
        'xl' => 1,
    ];
    protected static ?int $sort = 2;

    public static function canView(): bool
    {
        return Filament::auth()->user()?->role === 'admin';
    }

    protected function getData(): array
    {
        $startDate = now()->startOfMonth()->subMonths(11);
        $endDate = now()->endOfMonth();

        $monthlyTotals = Transaction::query()
            ->paid()
            ->get(['paid_at', 'price'])
            ->filter(function (Transaction $transaction) use ($startDate, $endDate): bool {
                return $transaction->paid_at !== null
                    && $transaction->paid_at->betweenIncluded($startDate, $endDate);
            })
            ->groupBy(fn (Transaction $transaction): string => $transaction->paid_at->format('Y-m'));

        $labels = [];
        $priceTotals = [];

        for ($month = $startDate->copy(); $month->lte($endDate); $month->addMonth()) {
            $monthKey = $month->format('Y-m');
            $transactions = $monthlyTotals->get($monthKey, collect());

            $labels[] = $month->translatedFormat('M Y');
            $priceTotals[] = $transactions->sum('price');
        }

        return [
            'datasets' => [
                [
                    'label' => 'Total price',
                    'data' => $priceTotals,
                    'backgroundColor' => '#0ea5e9',
                    'borderColor' => '#0284c7',
                    'borderRadius' => 4,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getOptions(): array
    {
        return [
            'responsive' => true,
            'maintainAspectRatio' => false,
            'plugins' => [
                'legend' => [
                    'display' => false,
                ],
            ],
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'ticks' => [
                        'precision' => 0,
                    ],
                ],
                'x' => [
                    'grid' => [
                        'display' => false,
                    ],
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
