<?php

namespace App\Http\Controllers;

use App\Models\Course;
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

    public function dashboard()
    {
        $recommendedCourses = Course::query()
            ->with('category')
            ->withSum('videos as total_duration_seconds', 'duration_seconds')
            ->where('is_published', true)
            ->latest()
            ->take(4)
            ->get();

        $allCourses = Course::query()
            ->with('category')
            ->withSum('videos as total_duration_seconds', 'duration_seconds')
            ->where('is_published', true)
            ->latest()
            ->take(8)
            ->get();

        return view('pages.dashboard', compact('recommendedCourses', 'allCourses'));
    }

    public function course(?string $slug = null, Request $request)
    {
        $query = Course::query()
            ->with('category')
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

        $videos = $course->sections->flatMap->videos->values();
        $requestedVideoId = (int) $request->query('video');
        $currentVideo = $requestedVideoId > 0 ? $videos->firstWhere('id', $requestedVideoId) : null;

        $currentVideoIndex = null;
        if ($currentVideo) {
            $currentVideoIndex = $videos->search(fn($video) => $video->id === $currentVideo->id);
        }

        $embedUrl = Youtube::embedUrl($currentVideo?->video_url)
            ?? Youtube::embedUrl($course->introduction_video_url)
            ?? Youtube::embedUrl($videos->first()?->video_url);

        $averageRating = $course->reviews->count() > 0
            ? number_format((float) $course->reviews->avg('rating'), 1)
            : $course->rating_label;

        $courseSections = $course->sections->map(function ($section) use ($videos, $currentVideo, $currentVideoIndex, $course) {
            $sectionDurationSeconds = (int) $section->videos->sum('duration_seconds');
            $sectionHours = intdiv($sectionDurationSeconds, 3600);
            $sectionMinutes = intdiv($sectionDurationSeconds % 3600, 60);
            $sectionDurationLabel = trim(($sectionHours > 0 ? $sectionHours . ' jam ' : '') . max($sectionMinutes, 1) . ' menit');
            $hasCurrentVideo = $currentVideo ? $section->videos->contains('id', $currentVideo->id) : false;

            $sectionVideos = $section->videos->map(function ($video) use ($videos, $currentVideo, $currentVideoIndex, $course) {
                $videoIndex = $videos->search(fn($globalVideo) => $globalVideo->id === $video->id);
                $isCurrentVideo = $currentVideo && $video->id === $currentVideo->id;
                $isWatched = is_int($videoIndex) && is_int($currentVideoIndex) && $videoIndex < $currentVideoIndex;
                $stateClass = $isCurrentVideo ? 'now-playing' : ($isWatched ? 'watched' : 'unwatched');

                return (object) [
                    'title' => $video->title,
                    'duration_label' => $video->duration_label,
                    'state_class' => $stateClass,
                    'is_watched' => $isWatched,
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

        $activeVideoTitle = $currentVideo?->title ?? 'Video perkenalan kelas';

        return view('pages.course', compact(
            'course',
            'currentVideo',
            'currentVideoIndex',
            'embedUrl',
            'averageRating',
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

    public function transaction()
    {
        return view('pages.transaction');
    }
}
