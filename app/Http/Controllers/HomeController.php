<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseVideoWatch;
use App\Models\Transaction;
use App\Models\User;
use App\Support\Youtube;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home()
    {
        $courses = Course::query()
            ->with('category')
            ->withSum('videos as total_duration_seconds', 'duration_seconds')
            ->where('is_published', true)
            ->latest()
            ->take(4)
            ->get();

        return view('pages.home', compact('courses'));
    }

    public function dashboard(Request $request)
    {
        /** @var User $user */
        $user = $request->user();

        $lastWatched = $user->courseVideoWatches()
            ->with([
                'course.category',
                'video',
            ])
            ->latest('watched_at')
            ->first();

        $continueWatching = null;
        if ($lastWatched && $lastWatched->course && $lastWatched->video) {
            $course = $lastWatched->course;
            $totalVideosCount = $course->videos()->count();

            $watchedVideosCount = $user->courseVideoWatches()
                ->where('course_id', $course->id)
                ->distinct('course_video_id')
                ->count('course_video_id');

            $progressPercentage = $totalVideosCount > 0
                ? (int) round(($watchedVideosCount / $totalVideosCount) * 100)
                : 0;

            $continueWatching = (object) [
                'course' => $course,
                'video' => $lastWatched->video,
                'progress_percentage' => min(100, $progressPercentage),
                'progress_label' => min(100, $progressPercentage) . '%',
                'url' => route('course', ['slug' => $course->slug, 'video' => $lastWatched->course_video_id]),
            ];
        }

        $ownedCourses = $user
            ->ownedCourses()
            ->with('category')
            ->withSum('videos as total_duration_seconds', 'duration_seconds')
            ->orderByPivot('created_at', 'desc')
            ->take(8)
            ->get();

        $ownedCourseIds = $ownedCourses->pluck('id');

        $recommendedCourses = Course::query()
            ->with('category')
            ->withSum('videos as total_duration_seconds', 'duration_seconds')
            ->where('is_published', true)
            ->when($ownedCourseIds->isNotEmpty(), fn($query) => $query->whereNotIn('id', $ownedCourseIds))
            ->latest()
            ->take(4)
            ->get();

        return view('pages.dashboard', compact('ownedCourses', 'recommendedCourses', 'continueWatching'));
    }

    public function course(?string $slug = null, Request $request)
    {
        /** @var User|null $viewer */
        $viewer = $request->user();

        $query = Course::query()
            ->with('category')
            ->withCount('students')
            ->withSum('videos as total_duration_seconds', 'duration_seconds')
            ->with([
                'keypoints',
                'sections.videos',
                'reviews.student',
                'discussions' => fn($discussionQuery) => $discussionQuery
                    ->whereNull('parent_id')
                    ->with(['student', 'replies.student'])
                    ->latest(),
            ])
            ->where('is_published', true);

        $course = $slug
            ? (clone $query)->where('slug', $slug)->firstOrFail()
            : (clone $query)->latest()->firstOrFail();

        $hasCourseAccess = false;
        if ($viewer) {
            $isCourseInstructor = $viewer->id === (int) $course->user_id;
            $hasCourseAccess = $isCourseInstructor
                || $viewer->ownedCourses()->where('courses.id', $course->id)->exists();
        }

        $videos = $course->sections->flatMap->videos->values();
        $requestedVideoId = $hasCourseAccess ? (int) $request->query('video') : 0;
        $currentVideo = $requestedVideoId > 0 ? $videos->firstWhere('id', $requestedVideoId) : null;

        $currentVideoIndex = null;
        if ($hasCourseAccess && $currentVideo) {
            $currentVideoIndex = $videos->search(fn($video) => $video->id === $currentVideo->id);
        }

        $watchedVideoIds = collect();
        if ($hasCourseAccess && $viewer) {
            if ($currentVideo) {
                CourseVideoWatch::query()->updateOrCreate([
                    'user_id' => $viewer->id,
                    'course_video_id' => $currentVideo->id,
                ], [
                    'course_id' => $course->id,
                    'watched_at' => now(),
                ]);
            }

            $watchedVideoIds = $viewer->courseVideoWatches()
                ->where('course_id', $course->id)
                ->pluck('course_video_id');
        }

        $totalVideosCount = $videos->count();
        $watchedVideosCount = min($watchedVideoIds->unique()->count(), $totalVideosCount);
        $progressPercentage = $totalVideosCount > 0
            ? (int) round(($watchedVideosCount / $totalVideosCount) * 100)
            : 0;

        $embedUrl = $hasCourseAccess
            ? (Youtube::embedUrl($currentVideo?->video_url)
                ?? Youtube::embedUrl($course->introduction_video_url)
                ?? Youtube::embedUrl($videos->first()?->video_url))
            : Youtube::embedUrl($course->introduction_video_url);

        $averageRating = $course->reviews->count() > 0
            ? number_format((float) $course->reviews->avg('rating'), 1)
            : $course->rating_label;

        $studentsCount = (int) ($course->students_count ?? 0);

        $courseSections = $course->sections->map(function ($section) use ($videos, $currentVideo, $currentVideoIndex, $course, $hasCourseAccess, $watchedVideoIds) {
            $sectionDurationSeconds = (int) $section->videos->sum('duration_seconds');
            $sectionHours = intdiv($sectionDurationSeconds, 3600);
            $sectionMinutes = intdiv($sectionDurationSeconds % 3600, 60);
            $sectionDurationLabel = trim(($sectionHours > 0 ? $sectionHours . ' jam ' : '') . max($sectionMinutes, 1) . ' menit');
            $hasCurrentVideo = $hasCourseAccess && $currentVideo ? $section->videos->contains('id', $currentVideo->id) : false;

            $sectionVideos = $section->videos->map(function ($video) use ($videos, $currentVideo, $currentVideoIndex, $course, $hasCourseAccess, $watchedVideoIds) {
                if (! $hasCourseAccess) {
                    return (object) [
                        'title' => $video->title,
                        'duration_label' => $video->duration_label,
                        'state_class' => 'locked',
                        'is_watched' => false,
                        'is_locked' => true,
                        'url' => null,
                    ];
                }

                $videoIndex = $videos->search(fn($globalVideo) => $globalVideo->id === $video->id);
                $isCurrentVideo = $currentVideo && $video->id === $currentVideo->id;
                $isWatched = $watchedVideoIds->contains($video->id)
                    || (is_int($videoIndex) && is_int($currentVideoIndex) && $videoIndex < $currentVideoIndex);
                $stateClass = $isCurrentVideo ? 'now-playing' : ($isWatched ? 'watched' : 'unwatched');

                return (object) [
                    'title' => $video->title,
                    'duration_label' => $video->duration_label,
                    'state_class' => $stateClass,
                    'is_watched' => $isWatched,
                    'is_locked' => false,
                    'url' => route('course', ['slug' => $course->slug, 'video' => $video->id]),
                ];
            })->values();

            return (object) [
                'title' => $section->title,
                'videos_count' => $section->videos->count(),
                'duration_label' => $sectionDurationLabel,
                'has_current_video' => $hasCurrentVideo,
                'videos' => $sectionVideos,
            ];
        })->values();

        $activeVideoTitle = $hasCourseAccess
            ? ($currentVideo?->title ?? 'Video preview kelas')
            : 'Video perkenalan kelas (preview)';

        return view('pages.course', compact(
            'course',
            'currentVideo',
            'currentVideoIndex',
            'embedUrl',
            'averageRating',
            'studentsCount',
            'hasCourseAccess',
            'totalVideosCount',
            'watchedVideosCount',
            'progressPercentage',
            'courseSections',
            'activeVideoTitle'
        ));
    }

    public function profile()
    {
        return view('pages.profile');
    }

    public function savedCourses()
    {
        return view('pages.saved_courses');
    }

    public function allCourses()
    {
        return view('pages.all_courses');
    }

    public function task()
    {
        return view('pages.task');
    }

    public function transaction(Request $request)
    {
        $courseSlug = (string) $request->query('course');

        abort_if($courseSlug === '', 404);

        $course = Course::query()
            ->with('category')
            ->where('is_published', true)
            ->where('slug', $courseSlug)
            ->firstOrFail();

        return view('pages.transaction', compact('course'));
    }

    public function storeTransaction(Request $request)
    {
        /** @var User $user */
        $user = $request->user();

        $validated = $request->validate([
            'course_id' => ['required', 'integer', 'exists:courses,id'],
            'payment_method' => ['required', 'in:bank_transfer,e_wallet'],
            'proof_of_payment' => ['nullable', 'image', 'max:5120'],
        ]);

        $course = Course::query()
            ->where('is_published', true)
            ->findOrFail((int) $validated['course_id']);

        if ($user->ownedCourses()->where('courses.id', $course->id)->exists()) {
            return redirect()
                ->route('course', ['slug' => $course->slug])
                ->with('success', 'Kelas sudah kamu miliki.');
        }

        $proofOfPaymentPath = null;
        if ($request->hasFile('proof_of_payment')) {
            $proofOfPaymentPath = $request->file('proof_of_payment')->store('proof-of-payments', 'public');
        }

        Transaction::create([
            'user_id' => $user->id,
            'course_id' => $course->id,
            'payment_method' => $validated['payment_method'],
            'proof_of_payment' => $proofOfPaymentPath,
            'price' => (int) $course->price,
            'is_paid' => true,
        ]);

        $user->ownedCourses()->syncWithoutDetaching([$course->id]);

        return redirect()
            ->route('course', ['slug' => $course->slug])
            ->with('success', 'Pembayaran berhasil. Kelas sudah aktif di akun kamu.');
    }
}
