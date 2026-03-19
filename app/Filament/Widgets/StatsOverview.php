<?php

namespace App\Filament\Widgets;

use App\Models\Course;
use App\Models\Transaction;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;

class StatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $totalCourses = Course::query()->count();
        $activeCourses = Course::query()->where('is_published', true)->count();

        $totalStudents = User::query()->where('role', 'student')->count();

        $totalEnrollments = DB::table('course_user')->count();
        $newEnrollmentsThisMonth = DB::table('course_user')
            ->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])
            ->count();

        $paidTransactions = Transaction::query()->paid()->count();
        $revenue = (int) Transaction::query()->paid()->sum('price');

        return [
            Stat::make('Kelas Aktif', number_format($activeCourses))
                ->description(number_format($totalCourses) . ' total kelas')
                ->descriptionIcon('heroicon-m-academic-cap')
                ->color('success'),

            Stat::make('Total Student', number_format($totalStudents))
                ->description('2 student baru bulan ini')
                ->descriptionIcon('heroicon-m-users')
                ->color('primary'),

            Stat::make('Total Enrollment', number_format($totalEnrollments))
                ->description(number_format($newEnrollmentsThisMonth) . ' enrollment bulan ini')
                ->descriptionIcon('heroicon-m-user-plus')
                ->color('warning'),

            Stat::make('Transaksi Berhasil', number_format($paidTransactions))
                ->description('Total ' . $this->formatRupiah($revenue))
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success'),
        ];
    }

    private function formatRupiah(int $amount): string
    {
        return 'Rp ' . number_format($amount, 0, ',', '.');
    }
}
