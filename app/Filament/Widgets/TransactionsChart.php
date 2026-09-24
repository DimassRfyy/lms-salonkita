<?php

namespace App\Filament\Widgets;

use App\Models\Transaction;
use Filament\Facades\Filament;
use Filament\Widgets\ChartWidget;

class TransactionsChart extends ChartWidget
{
    protected ?string $heading = 'Transaksi & Pendapatan per Bulan';
    protected ?string $maxHeight = '280px';
    protected int | string | array $columnSpan = [
        'default' => 'full',
        'md' => 1,
        'xl' => 1,
    ];
    protected static ?int $sort = 2;
    protected ?string $pollingInterval = null;

    public ?string $filter = 'all';

    public static function canView(): bool
    {
        return Filament::auth()->user()?->role === 'admin';
    }

    protected function getFilters(): ?array
    {
        return [
            'all' => 'Semua (Pendapatan & Nilai Promo)',
            'revenue' => 'Hanya Pendapatan Masuk (Rp)',
            'count' => 'Jumlah Transaksi (Qty)',
        ];
    }

    protected function getData(): array
    {
        $startDate = now()->startOfMonth()->subMonths(11);
        $endDate = now()->endOfMonth();

        $monthlyTransactions = Transaction::query()
            ->paid()
            ->get(['id', 'paid_at', 'created_at', 'price', 'discount_amount'])
            ->filter(function (Transaction $transaction) use ($startDate, $endDate): bool {
                $date = $transaction->paid_at ?? $transaction->created_at;
                return $date instanceof \Carbon\CarbonInterface && $date->betweenIncluded($startDate, $endDate);
            })
            ->groupBy(function (Transaction $transaction): string {
                $date = $transaction->paid_at ?? $transaction->created_at;
                return $date instanceof \Carbon\CarbonInterface ? $date->format('Y-m') : 'unknown';
            });

        $labels = [];
        $revenueData = [];
        $promoData = [];
        $paidCountData = [];
        $promoCountData = [];

        for ($month = $startDate->copy(); $month->lte($endDate); $month->addMonth()) {
            $monthKey = $month->format('Y-m');
            $transactions = $monthlyTransactions->get($monthKey, collect());

            $labels[] = $month->translatedFormat('M Y');
            $revenueData[] = (int) $transactions->sum('price');
            $promoData[] = (int) $transactions->sum('discount_amount');
            $paidCountData[] = $transactions->where('price', '>', 0)->count();
            $promoCountData[] = $transactions->where('price', 0)->count();
        }

        if ($this->filter === 'count') {
            return [
                'datasets' => [
                    [
                        'label' => 'Transaksi Berbayar (Qty)',
                        'data' => $paidCountData,
                        'backgroundColor' => '#ec4899',
                        'borderColor' => '#db2777',
                        'borderRadius' => 4,
                    ],
                    [
                        'label' => 'Transaksi Klaim Promo (Qty)',
                        'data' => $promoCountData,
                        'backgroundColor' => '#a855f7',
                        'borderColor' => '#9333ea',
                        'borderRadius' => 4,
                    ],
                ],
                'labels' => $labels,
            ];
        }

        if ($this->filter === 'revenue') {
            return [
                'datasets' => [
                    [
                        'label' => 'Pendapatan Masuk (Rp)',
                        'data' => $revenueData,
                        'backgroundColor' => '#ec4899',
                        'borderColor' => '#db2777',
                        'borderRadius' => 4,
                    ],
                ],
                'labels' => $labels,
            ];
        }

        return [
            'datasets' => [
                [
                    'label' => 'Pendapatan Masuk (Rp)',
                    'data' => $revenueData,
                    'backgroundColor' => '#ec4899',
                    'borderColor' => '#db2777',
                    'borderRadius' => 4,
                ],
                [
                    'label' => 'Nilai Diskon Promo (Rp)',
                    'data' => $promoData,
                    'backgroundColor' => '#a855f7',
                    'borderColor' => '#9333ea',
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
                    'display' => true,
                    'position' => 'top',
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
