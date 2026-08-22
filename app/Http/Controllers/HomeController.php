<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseCertificate;
use App\Models\CourseDiscussion;
use App\Models\CourseReview;
use App\Models\CourseTaskSubmission;
use App\Models\CourseVideoQuizCompletion;
use App\Models\CourseVideoWatch;
use App\Models\Transaction;
use App\Models\User;
use App\Support\Youtube;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use SweetAlert2\Laravel\Swal;

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
            ->withCount('videos')
            ->withSum('videos as total_duration_seconds', 'duration_seconds')
            ->orderByPivot('created_at', 'desc')
            ->get();

        $ownedCourseIds = $ownedCourses->modelKeys();

        $watchedVideoCounts = CourseVideoWatch::query()
            ->selectRaw('course_id, COUNT(DISTINCT course_video_id) as watched_videos_count')
            ->where('user_id', $user->id)
            ->whereIn('course_id', $ownedCourseIds, 'and', false)
            ->groupBy('course_id')
            ->pluck('watched_videos_count', 'course_id');

        $ownedCourses = $ownedCourses->map(function ($course) use ($watchedVideoCounts) {
            $totalVideosCount = (int) ($course->videos_count ?? 0);
            $watchedVideosCount = (int) ($watchedVideoCounts[$course->id] ?? 0);
            $progressPercentage = $totalVideosCount > 0
                ? (int) round(($watchedVideosCount / $totalVideosCount) * 100)
                : 0;

            $course->setAttribute('progress_percentage', min(100, $progressPercentage));
            $course->setAttribute('progress_label', min(100, $progressPercentage) . '%');

            return $course;
        })
        ->sortBy(fn ($course) => $course->progress_percentage >= 100 ? 1 : 0)
        ->values();

        $recommendedCourses = Course::query()
            ->with('category')
            ->withSum('videos as total_duration_seconds', 'duration_seconds')
            ->where('is_published', true)
            ->when(! empty($ownedCourseIds), fn($query) => $query->whereNotIn('id', $ownedCourseIds, 'and'))
            ->latest()
            ->paginate(8)
            ->withQueryString();

        $savedCourseIds = $user->savedCourses()
            ->pluck('courses.id');

        $availableMentoringEntitlement = $user->availableMentoringEntitlements()
            ->with(['course', 'booking.mentor', 'booking.slot'])
            ->latest('granted_at')
            ->first();

        $latestMentoringBooking = $user->mentoringBookingsAsStudent()
            ->with(['course', 'mentor', 'slot'])
            ->latest('starts_at')
            ->first();

        $mentoringHistory = $user->mentoringBookingsAsStudent()
            ->with(['course', 'mentor', 'slot'])
            ->latest('starts_at')
            ->take(5)
            ->get();

        $hasMentoringAccess = $availableMentoringEntitlement !== null || $latestMentoringBooking !== null;

        return view('pages.dashboard', compact(
            'ownedCourses',
            'recommendedCourses',
            'continueWatching',
            'savedCourseIds',
            'availableMentoringEntitlement',
            'latestMentoringBooking',
            'mentoringHistory',
            'hasMentoringAccess'
        ));
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
                'sections.videos.quiz.questions.options',
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
        $hasPendingTransaction = false;
        if ($viewer) {
            $isCourseInstructor = $viewer->id === (int) $course->user_id;
            $hasCourseAccess = $isCourseInstructor
                || $viewer->ownedCourses()->where('courses.id', $course->id)->exists();

            if (! $hasCourseAccess) {
                $hasPendingTransaction = $viewer->transactions()
                    ->where('course_id', $course->id)
                    ->latest('created_at')
                    ->where('status', Transaction::STATUS_PENDING)
                    ->exists();
            }
        }

        $videos = $course->sections->flatMap->videos->values();
        $requestedVideoId = $hasCourseAccess ? (int) $request->query('video') : 0;
        $currentVideo = $requestedVideoId > 0 ? $videos->firstWhere('id', $requestedVideoId) : null;

        $currentVideoIndex = null;
        if ($hasCourseAccess && $currentVideo) {
            $currentVideoIndex = $videos->search(fn($video) => $video->id === $currentVideo->id);
        }

        $quizCompletionVideoIds = collect();
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

            $quizCompletionVideoIds = $viewer->courseVideoQuizCompletions()
                ->where('course_id', $course->id)
                ->pluck('course_video_id');
        }

        $videoUnlockMap = [];
        foreach ($videos as $index => $video) {
            if ($index === 0) {
                $videoUnlockMap[$video->id] = true;
                continue;
            }

            $previousVideo = $videos->get($index - 1);
            $previousQuiz = $previousVideo?->quiz;
            $requiresPreviousQuiz = (bool) ($previousQuiz && $previousQuiz->is_active && $previousQuiz->questions->isNotEmpty());

            $videoUnlockMap[$video->id] = ! $requiresPreviousQuiz
                || $quizCompletionVideoIds->contains($previousVideo->id);
        }

        if ($hasCourseAccess && $requestedVideoId > 0 && $currentVideo && ! ($videoUnlockMap[$currentVideo->id] ?? false)) {
            $fallbackVideo = $videos->first(fn($video) => (bool) ($videoUnlockMap[$video->id] ?? false));
            $currentVideo = $fallbackVideo;
            $currentVideoIndex = $currentVideo ? $videos->search(fn($video) => $video->id === $currentVideo->id) : null;
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

        $presentationEmbedUrl = $hasCourseAccess ? $course->presentation_url : null;

        $averageRating = $course->reviews->count() > 0
            ? number_format((float) $course->reviews->avg('rating'), 1)
            : $course->rating_label;

        $studentsCount = (int) ($course->students_count ?? 0);

        $courseSections = $course->sections->map(function ($section) use ($videos, $currentVideo, $currentVideoIndex, $course, $hasCourseAccess, $watchedVideoIds, $videoUnlockMap) {
            $sectionDurationSeconds = (int) $section->videos->sum('duration_seconds');
            $sectionHours = intdiv($sectionDurationSeconds, 3600);
            $sectionMinutes = intdiv($sectionDurationSeconds % 3600, 60);
            $sectionDurationLabel = trim(($sectionHours > 0 ? $sectionHours . ' jam ' : '') . max($sectionMinutes, 1) . ' menit');
            $hasCurrentVideo = $hasCourseAccess && $currentVideo ? $section->videos->contains('id', $currentVideo->id) : false;

            $sectionVideos = $section->videos->map(function ($video) use ($videos, $currentVideo, $currentVideoIndex, $course, $hasCourseAccess, $watchedVideoIds, $videoUnlockMap) {
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
                $isLocked = ! ((bool) ($videoUnlockMap[$video->id] ?? false));
                $isWatched = $watchedVideoIds->contains($video->id)
                    || (is_int($videoIndex) && is_int($currentVideoIndex) && $videoIndex < $currentVideoIndex);
                $stateClass = $isLocked
                    ? 'locked'
                    : ($isCurrentVideo ? 'now-playing' : ($isWatched ? 'watched' : 'unwatched'));

                return (object) [
                    'title' => $video->title,
                    'duration_label' => $video->duration_label,
                    'state_class' => $stateClass,
                    'is_watched' => $isWatched,
                    'is_locked' => $isLocked,
                    'url' => $isLocked ? null : route('course', ['slug' => $course->slug, 'video' => $video->id]),
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

        $currentVideoQuiz = $currentVideo?->quiz;
        $hasCurrentVideoQuiz = (bool) ($currentVideoQuiz && $currentVideoQuiz->is_active && $currentVideoQuiz->questions->isNotEmpty());
        $isCurrentVideoQuizCompleted = $hasCourseAccess
            && $currentVideo
            && $quizCompletionVideoIds->contains($currentVideo->id);

        $currentVideoQuizCompletion = null;
        if ($hasCourseAccess && $viewer && $currentVideo && $currentVideoQuiz) {
            $currentVideoQuizCompletion = CourseVideoQuizCompletion::query()
                ->where('user_id', $viewer->id)
                ->where('course_video_quiz_id', $currentVideoQuiz->id)
                ->first();
        }

        $nextVideo = null;
        if ($hasCourseAccess && is_int($currentVideoIndex)) {
            $nextVideo = $videos->get($currentVideoIndex + 1);
        }

        $nextVideoUrl = null;
        if ($nextVideo && ($videoUnlockMap[$nextVideo->id] ?? false)) {
            $nextVideoUrl = route('course', ['slug' => $course->slug, 'video' => $nextVideo->id]);
        }

        $taskSubmission = null;
        $certificate = null;
        if ($hasCourseAccess && $viewer) {
            $taskSubmission = CourseTaskSubmission::query()
                ->where('course_id', $course->id)
                ->where('user_id', $viewer->id)
                ->first();

            $certificate = CourseCertificate::query()
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
            'hasPendingTransaction',
            'totalVideosCount',
            'watchedVideosCount',
            'progressPercentage',
            'presentationEmbedUrl',
            'courseSections',
            'activeVideoTitle',
            'currentVideoQuiz',
            'hasCurrentVideoQuiz',
            'isCurrentVideoQuizCompleted',
            'currentVideoQuizCompletion',
            'nextVideoUrl',
            'taskSubmission',
            'canSubmitTask',
            'certificate'
        ));
    }

    public function storeCourseVideoQuiz(Request $request, string $slug)
    {
        /** @var User $user */
        $user = $request->user();

        $course = Course::query()
            ->with('sections.videos.quiz.questions.options')
            ->where('is_published', true)
            ->where('slug', $slug)
            ->firstOrFail();

        $hasAccess = $user->ownedCourses()->where('courses.id', $course->id)->exists()
            || $user->id === (int) $course->user_id;
        abort_unless($hasAccess, 403);

        $videoId = (int) $request->input('video_id');
        $videos = $course->sections->flatMap->videos->values();
        $video = $videos->firstWhere('id', $videoId);
        abort_unless($video, 404);

        $quiz = $video->quiz;
        abort_unless($quiz && $quiz->is_active && $quiz->questions->isNotEmpty(), 404);

        $validated = $request->validate([
            'video_id' => ['required', 'integer'],
            'answers' => ['required', 'array'],
        ]);

        $totalQuestions = $quiz->questions->count();
        $correctAnswers = 0;
        $questionResults = [];

        foreach ($quiz->questions as $question) {
            $selectedOptionId = (int) ($validated['answers'][$question->id] ?? 0);
            abort_unless($selectedOptionId > 0, 422, 'Semua soal wajib dijawab.');

            $selectedOption = $question->options->firstWhere('id', $selectedOptionId);
            abort_unless($selectedOption, 422, 'Jawaban quiz tidak valid.');

            $correctOption = $question->options->firstWhere('is_correct', true);
            $isCorrect = (bool) $selectedOption->is_correct;

            if ($isCorrect) {
                $correctAnswers++;
            }

            $questionResults[] = [
                'question_id' => $question->id,
                'question_text' => $question->question,
                'selected_option_id' => $selectedOption->id,
                'selected_option_text' => $selectedOption->option_text,
                'is_correct' => $isCorrect,
            ];
        }

        $score = $totalQuestions > 0
            ? (int) round(($correctAnswers / $totalQuestions) * 100)
            : 0;

        $passingScore = (int) ($quiz->passing_score ?? 70);
        $isPassed = $score >= $passingScore;

        CourseVideoQuizCompletion::query()->updateOrCreate([
            'user_id' => $user->id,
            'course_video_quiz_id' => $quiz->id,
        ], [
            'course_id' => $course->id,
            'course_video_id' => $video->id,
            'score' => $score,
            'is_passed' => $isPassed,
            'completed_at' => now(),
        ]);

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'score' => $score,
                'passing_score' => $passingScore,
                'is_passed' => $isPassed,
                'total_questions' => $totalQuestions,
                'correct_count' => $correctAnswers,
                'results' => $questionResults,
                'message' => $isPassed
                    ? 'Selamat! Kamu berhasil menyelesaikan quiz.'
                    : 'Kamu belum mencapai nilai minimum kelulusan. Silakan pelajari kembali materinya dan ulangi quiz.',
            ]);
        }

        return redirect()
            ->to(route('course', ['slug' => $course->slug, 'video' => $video->id]))
            ->with('success', 'Quiz berhasil dikerjakan.');
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
            ->with('success', 'Yeay, tugasmu berhasil dikirim! Sekarang tinggal tunggu dicek dulu ya.');
    }

    public function storeCourseDiscussion(Request $request, string $slug)
    {
        /** @var User $user */
        $user = $request->user();

        $course = Course::query()
            ->where('is_published', true)
            ->where('slug', $slug)
            ->firstOrFail();

        $hasAccess = $user->id === (int) $course->user_id
            || $user->ownedCourses()->where('courses.id', $course->id)->exists();
        abort_unless($hasAccess, 403, 'Kamu belum memiliki akses ke kelas ini.');

        $validated = $request->validate([
            'message' => ['required', 'string', 'min:3', 'max:2000'],
        ], [
            'message.required' => 'Pesan diskusi wajib diisi.',
            'message.min' => 'Pesan diskusi minimal 3 karakter.',
            'message.max' => 'Pesan diskusi maksimal 2000 karakter.',
        ]);

        CourseDiscussion::query()->create([
            'course_id' => $course->id,
            'user_id' => $user->id,
            'parent_id' => null,
            'subject' => 'Diskusi Kelas',
            'message' => $validated['message'],
        ]);

        return redirect()
            ->to(route('course', ['slug' => $course->slug]) . '#diskusi')
            ->with('success', 'Diskusi berhasil dikirim.');
    }

    public function profile()
    {
        return view('pages.profile');
    }

    public function savedCourses(Request $request)
    {
        /** @var User $user */
        $user = $request->user();

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

        Swal::toastSuccess([
            'title' => 'Kelas berhasil disimpan.',
            'position' => 'top-end',
            'showConfirmButton' => false,
            'timer' => 2200,
            'timerProgressBar' => true,
            'didOpen' => '(toast) => { toast.onmouseenter = Swal.stopTimer; toast.onmouseleave = Swal.resumeTimer; }',
        ]);

        return back();
    }

    public function destroySavedCourse(Request $request, Course $course)
    {
        /** @var User $user */
        $user = $request->user();

        $user->savedCourses()->detach($course->id);

        Swal::toastSuccess([
            'title' => 'Kelas dihapus dari tersimpan.',
            'position' => 'top-end',
            'showConfirmButton' => false,
            'timer' => 2200,
            'timerProgressBar' => true,
            'didOpen' => '(toast) => { toast.onmouseenter = Swal.stopTimer; toast.onmouseleave = Swal.resumeTimer; }',
        ]);

        return back();
    }

    public function allCourses(Request $request)
    {
        $search = trim((string) $request->query('search', ''));

        $courses = Course::query()
            ->with('category')
            ->withSum('videos as total_duration_seconds', 'duration_seconds')
            ->where('is_published', true)
            ->when($search !== '', fn($query) => $query->where('name', 'like', '%' . $search . '%'))
            ->latest()
            ->paginate(8)
            ->withQueryString();

        return view('pages.all_courses', compact('courses', 'search'));
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

        abort_unless((bool) $submission, 403, 'Selesaikan tugas dan tunggu review terlebih dahulu sebelum klaim sertifikat.');

        $existingReview = CourseReview::query()
            ->where('course_id', $course->id)
            ->where('user_id', $user->id)
            ->first();

        $hasReviewed = (bool) $existingReview;
        $certificate = null;

        if ($hasReviewed) {
            $certificate = CourseCertificate::query()->firstOrCreate([
                'course_id' => $course->id,
                'user_id' => $user->id,
            ], [
                'certificate_code' => 'SLN-' . date('Ym') . '-' . strtoupper(Str::random(6)),
                'issued_at' => now(),
            ]);
        }

        return view('pages.claim_certificate', compact('course', 'submission', 'hasReviewed', 'existingReview', 'certificate'));
    }

    public function storeCourseReviewAndClaim(Request $request, string $slug)
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

        abort_unless((bool) $submission, 403, 'Selesaikan tugas dan tunggu review terlebih dahulu sebelum klaim sertifikat.');

        $validated = $request->validate([
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'review' => ['required', 'string', 'min:5', 'max:1000'],
        ], [
            'rating.required' => 'Rating bintang wajib dipilih.',
            'rating.min' => 'Rating minimal 1 bintang.',
            'rating.max' => 'Rating maksimal 5 bintang.',
            'review.required' => 'Ulasan wajib diisi.',
            'review.min' => 'Ulasan minimal 5 karakter.',
            'review.max' => 'Ulasan maksimal 1000 karakter.',
        ]);

        CourseReview::query()->updateOrCreate([
            'course_id' => $course->id,
            'user_id' => $user->id,
        ], [
            'rating' => $validated['rating'],
            'review' => $validated['review'],
        ]);

        // Terbitkan sertifikat
        CourseCertificate::query()->firstOrCreate([
            'course_id' => $course->id,
            'user_id' => $user->id,
        ], [
            'certificate_code' => 'SLN-' . date('Ym') . '-' . strtoupper(Str::random(6)),
            'issued_at' => now(),
        ]);

        session()->flash('claimed_now', true);

        Swal::fire([
            'title' => '🎉 Selamat!',
            'text' => 'Ulasan berhasil dikirim dan sertifikat kelulusanmu telah resmi diterbitkan!',
            'icon' => 'success',
            'confirmButtonText' => 'Lihat Sertifikat',
            'confirmButtonColor' => '#ec4899',
        ]);

        return redirect()->route('claim-certificate', ['slug' => $course->slug]);
    }

    public function downloadCertificate(Request $request, string $slug)
    {
        /** @var User $user */
        $user = $request->user();

        $course = Course::query()
            ->where('is_published', true)
            ->where('slug', $slug)
            ->firstOrFail();

        $certificate = CourseCertificate::query()
            ->where('course_id', $course->id)
            ->where('user_id', $user->id)
            ->firstOrFail();

        $pdf = Pdf::loadView('pdf.certificate', compact('course', 'user', 'certificate'))
            ->setPaper('a4', 'landscape');

        $fileName = 'Sertifikat-' . Str::slug($course->name) . '-' . $certificate->certificate_code . '.pdf';

        return $pdf->download($fileName);
    }

    public function viewCertificate(Request $request, string $slug)
    {
        /** @var User $user */
        $user = $request->user();

        $course = Course::query()
            ->where('is_published', true)
            ->where('slug', $slug)
            ->firstOrFail();

        $certificate = CourseCertificate::query()
            ->where('course_id', $course->id)
            ->where('user_id', $user->id)
            ->firstOrFail();

        $pdf = Pdf::loadView('pdf.certificate', compact('course', 'user', 'certificate'))
            ->setPaper('a4', 'landscape');

        $fileName = 'Sertifikat-' . Str::slug($course->name) . '.pdf';

        return $pdf->stream($fileName);
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
                    'description' => 'Mantap! Hasil review dan nilaimu udah ada nih, silakan dicek ya!',
                    'primary_action_label' => 'Lihat Hasil Review',
                    'primary_action_url' => $submission->google_drive_url,
                    'secondary_action_label' => 'Lanjut Kelas',
                    'secondary_action_url' => route('course', ['slug' => $course->slug]),
                ],
                $submission?->isPending() => [
                    'label' => 'Menunggu Review',
                    'badge_class' => 'text-amber-700 bg-amber-100',
                    'progress_class' => 'bg-amber-500',
                    'description' => 'Tugasnya udah dikirim nih, tinggal tunggu dicek sama coach ya!',
                    'primary_action_label' => 'Lihat Tugas Terkirim',
                    'primary_action_url' => $submission->google_drive_url,
                    'secondary_action_label' => null,
                    'secondary_action_url' => null,
                ],
                $totalVideosCount > 0 && $watchedVideosCount >= $totalVideosCount => [
                    'label' => 'Siap Submit Tugas',
                    'badge_class' => 'text-emerald-700 bg-emerald-100',
                    'progress_class' => 'bg-emerald-500',
                    'description' => 'Hore, semua video sudah selesai! Sekarang, kamu sudah bisa mulai kumpulin tugasnya, ya.',
                    'primary_action_label' => 'Buka Kelas untuk Submit',
                    'primary_action_url' => route('course', ['slug' => $course->slug]),
                    'secondary_action_label' => null,
                    'secondary_action_url' => null,
                ],
                default => [
                    'label' => 'Sedang Menonton Video',
                    'badge_class' => 'text-pink-700 bg-pink-100',
                    'progress_class' => 'bg-pink-500',
                    'description' => 'Yuk, selesaikan video materinya dulu supaya kamu bisa lanjut submit tugas!',
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

}
