<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseTaskSubmission;
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

        $savedCourseIds = $user->savedCourses()
            ->pluck('courses.id');

        return view('pages.dashboard', compact('ownedCourses', 'recommendedCourses', 'continueWatching', 'savedCourseIds'));
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

        $taskSubmission = null;
        if ($hasCourseAccess && $viewer) {
            $taskSubmission = CourseTaskSubmission::query()
                ->where('course_id', $course->id)
                ->where('user_id', $viewer->id)
                ->first();
        }

        $canSubmitTask = $hasCourseAccess
            && $totalVideosCount > 0
            && $watchedVideosCount >= $totalVideosCount
            && (! $taskSubmission || ! $taskSubmission->isReviewed());

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
            'activeVideoTitle',
            'taskSubmission',
            'canSubmitTask'
        ));
    }

    public function storeCourseTaskSubmission(Request $request, string $slug)
    {
        /** @var User $user */
        $user = $request->user();

        $course = Course::query()
            ->with('sections.videos')
            ->where('is_published', true)
            ->where('slug', $slug)
            ->firstOrFail();

        $hasAccess = $user->ownedCourses()->where('courses.id', $course->id)->exists();
        abort_unless($hasAccess, 403);

        $videos = $course->sections->flatMap->videos;
        $totalVideosCount = $videos->count();

        $watchedVideosCount = $user->courseVideoWatches()
            ->where('course_id', $course->id)
            ->distinct('course_video_id')
            ->count('course_video_id');

        if ($totalVideosCount === 0 || $watchedVideosCount < $totalVideosCount) {
            return redirect()
                ->to(route('course', ['slug' => $course->slug]) . '#tugas')
                ->with('error', 'Selesaikan semua video terlebih dahulu sebelum submit tugas.');
        }

        $existingSubmission = CourseTaskSubmission::query()
            ->where('course_id', $course->id)
            ->where('user_id', $user->id)
            ->first();

        if ($existingSubmission?->isReviewed()) {
            return redirect()
                ->to(route('course', ['slug' => $course->slug]) . '#tugas')
                ->with('error', 'Tugas sudah direview dan tidak dapat diubah.');
        }

        $validated = $request->validate([
            'subject' => ['required', 'string', 'max:255'],
            'google_drive_url' => ['required', 'url', 'max:1000', 'regex:/^https?:\/\/(drive\.google\.com|docs\.google\.com)\/.+/i'],
        ], [
            'google_drive_url.regex' => 'Link harus berupa URL Google Drive atau Google Docs.',
        ]);

        CourseTaskSubmission::query()->updateOrCreate([
            'course_id' => $course->id,
            'user_id' => $user->id,
        ], [
            'subject' => $validated['subject'],
            'google_drive_url' => $validated['google_drive_url'],
            'status' => CourseTaskSubmission::STATUS_PENDING,
            'score' => null,
        ]);

        return redirect()
            ->to(route('course', ['slug' => $course->slug]))
            ->with('success', 'Tugas berhasil dikirim. Status saat ini: menunggu review.');
    }

    public function profile()
    {
        return view('pages.profile');
    }

    public function savedCourses()
    {
        /** @var User $user */
        $user = request()->user();

        $savedCourses = $user->savedCourses()
            ->with('category')
            ->withSum('videos as total_duration_seconds', 'duration_seconds')
            ->orderByPivot('created_at', 'desc')
            ->get();

        return view('pages.saved_courses', compact('savedCourses'));
    }

    public function storeSavedCourse(Request $request, Course $course)
    {
        /** @var User $user */
        $user = $request->user();

        abort_unless($course->is_published, 404);

        $user->savedCourses()->syncWithoutDetaching([$course->id]);

        return back()->with('success', 'Kelas berhasil disimpan.');
    }

    public function destroySavedCourse(Request $request, Course $course)
    {
        /** @var User $user */
        $user = $request->user();

        $user->savedCourses()->detach($course->id);

        return back()->with('success', 'Kelas dihapus dari tersimpan.');
    }

    public function allCourses()
    {
        return view('pages.all_courses');
    }

    public function claimCertificate(Request $request, string $slug)
    {
        /** @var User $user */
        $user = $request->user();

        $course = Course::query()
            ->where('is_published', true)
            ->where('slug', $slug)
            ->firstOrFail();

        $hasAccess = $user->ownedCourses()->where('courses.id', $course->id)->exists();
        abort_unless($hasAccess, 403);

        $submission = CourseTaskSubmission::query()
            ->where('course_id', $course->id)
            ->where('user_id', $user->id)
            ->where('status', CourseTaskSubmission::STATUS_REVIEWED)
            ->first();

        abort_unless((bool) $submission, 403);

        return view('pages.claim_certificate', compact('course', 'submission'));
    }

    public function task(Request $request)
    {
        /** @var User $user */
        $user = $request->user();

        $courses = $user->ownedCourses()
            ->with([
                'category',
                'taskSubmissions' => fn($query) => $query->where('user_id', $user->id),
            ])
            ->withCount('videos')
            ->orderByPivot('created_at', 'desc')
            ->get();

        $watchedCounts = $user->courseVideoWatches()
            ->selectRaw('course_id, COUNT(DISTINCT course_video_id) as watched_videos_count')
            ->groupBy('course_id')
            ->pluck('watched_videos_count', 'course_id');

        $taskCourses = $courses->map(function (Course $course) use ($watchedCounts) {
            $totalVideosCount = (int) ($course->videos_count ?? 0);
            $watchedVideosCount = min((int) ($watchedCounts[$course->id] ?? 0), $totalVideosCount);
            $progressPercentage = $totalVideosCount > 0
                ? (int) round(($watchedVideosCount / $totalVideosCount) * 100)
                : 0;

            /** @var CourseTaskSubmission|null $submission */
            $submission = $course->taskSubmissions->first();

            $taskState = match (true) {
                $submission?->isReviewed() => [
                    'label' => 'Selesai Direview',
                    'badge_class' => 'text-sky-700 bg-sky-100',
                    'progress_class' => 'bg-sky-500',
                    'description' => 'Review tugas sudah selesai. Cek hasil penilaian dan skor Anda.',
                    'primary_action_label' => 'Lihat Hasil Review',
                    'primary_action_url' => $submission->google_drive_url,
                    'secondary_action_label' => 'Lanjut Kelas',
                    'secondary_action_url' => route('course', ['slug' => $course->slug]),
                ],
                $submission?->isPending() => [
                    'label' => 'Menunggu Review',
                    'badge_class' => 'text-amber-700 bg-amber-100',
                    'progress_class' => 'bg-amber-500',
                    'description' => 'Tugas sudah dikirim dan sedang menunggu proses review dari mentor.',
                    'primary_action_label' => 'Lihat Tugas Terkirim',
                    'primary_action_url' => $submission->google_drive_url,
                    'secondary_action_label' => null,
                    'secondary_action_url' => null,
                ],
                $totalVideosCount > 0 && $watchedVideosCount >= $totalVideosCount => [
                    'label' => 'Siap Submit Tugas',
                    'badge_class' => 'text-emerald-700 bg-emerald-100',
                    'progress_class' => 'bg-emerald-500',
                    'description' => 'Semua video sudah selesai. Student sudah bisa masuk ke tahap submit tugas.',
                    'primary_action_label' => 'Buka Kelas untuk Submit',
                    'primary_action_url' => route('course', ['slug' => $course->slug]),
                    'secondary_action_label' => null,
                    'secondary_action_url' => null,
                ],
                default => [
                    'label' => 'Sedang Menonton Video',
                    'badge_class' => 'text-pink-700 bg-pink-100',
                    'progress_class' => 'bg-pink-500',
                    'description' => 'Progress belajar masih berjalan. Selesaikan semua video untuk membuka submit tugas.',
                    'primary_action_label' => 'Lanjut Nonton',
                    'primary_action_url' => route('course', ['slug' => $course->slug]),
                    'secondary_action_label' => null,
                    'secondary_action_url' => null,
                ],
            };

            return (object) [
                'course' => $course,
                'status_label' => $taskState['label'],
                'status_badge_class' => $taskState['badge_class'],
                'progress_bar_class' => $taskState['progress_class'],
                'description' => $taskState['description'],
                'primary_action_label' => $taskState['primary_action_label'],
                'primary_action_url' => $taskState['primary_action_url'],
                'secondary_action_label' => $taskState['secondary_action_label'],
                'secondary_action_url' => $taskState['secondary_action_url'],
                'total_videos_count' => $totalVideosCount,
                'watched_videos_count' => $watchedVideosCount,
                'progress_percentage' => min(100, $progressPercentage),
                'score' => $submission?->score,
                'submitted_at' => $submission?->created_at,
            ];
        })->values();

        return view('pages.task', compact('taskCourses'));
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
