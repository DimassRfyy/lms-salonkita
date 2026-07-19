<?php

namespace App\Filament\Widgets;

use App\Models\Course;
use App\Models\CourseTaskSubmission;
use Filament\Facades\Filament;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;

class CoachStatsOverview extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    public static function canView(): bool
    {
        return Filament::auth()->user()?->role === 'coach';
    }

    protected function getStats(): array
    {
        $coachId = Filament::auth()->id();

        $ownedCourseIds = Course::query()
            ->where('user_id', $coachId)
            ->pluck('id');

        $totalCourses = $ownedCourseIds->count();
        $publishedCourses = Course::query()
            ->where('user_id', $coachId)
            ->where('is_published', true)
            ->count('*');

        $totalStudents = $ownedCourseIds->isEmpty()
            ? 0
            : (int) DB::table('course_user')
                ->whereIn('course_id', $ownedCourseIds)
                ->distinct('user_id')
                ->count('user_id');

        $pendingReviews = $ownedCourseIds->isEmpty()
            ? 0
            : CourseTaskSubmission::query()
                ->whereIn('course_id', $ownedCourseIds)
                ->where('status', CourseTaskSubmission::STATUS_PENDING)
                ->count('*');

        $reviewedSubmissions = $ownedCourseIds->isEmpty()
            ? 0
            : CourseTaskSubmission::query()
                ->whereIn('course_id', $ownedCourseIds)
                ->where('status', CourseTaskSubmission::STATUS_REVIEWED)
                ->count('*');

        $averageScore = $ownedCourseIds->isEmpty()
            ? null
            : CourseTaskSubmission::query()
                ->whereIn('course_id', $ownedCourseIds)
                ->where('status', CourseTaskSubmission::STATUS_REVIEWED)
                ->whereNotNull('score')
                ->avg('score');

        return [
            Stat::make('Kelas Saya', number_format($totalCourses))
                ->description(number_format($publishedCourses) . ' kelas published')
                ->descriptionIcon('heroicon-m-academic-cap')
                ->color('success'),

            Stat::make('Total Siswa', number_format($totalStudents))
                ->description('Siswa terdaftar di kelas kamu')
                ->descriptionIcon('heroicon-m-users')
                ->color('primary'),

            Stat::make('Menunggu Review', number_format($pendingReviews))
                ->description('Task yang belum direview')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),

            Stat::make('Sudah Direview', number_format($reviewedSubmissions))
                ->description(
                    $averageScore !== null
                        ? 'Rata-rata skor ' . number_format((float) $averageScore, 1)
                        : 'Belum ada skor'
                )
                ->descriptionIcon('heroicon-m-check-badge')
                ->color('success'),
        ];
    }
}
