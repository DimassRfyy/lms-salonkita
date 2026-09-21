<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;

class PublicMentorCoachController extends Controller
{
    /**
     * Tampilkan daftar seluruh mentor yang telah disetujui.
     */
    public function mentors(Request $request)
    {
        $search = trim((string) $request->query('search', ''));

        $mentors = User::query()
            ->where('role', 'mentor')
            ->where('is_approved', true)
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%')
                        ->orWhere('job_title', 'like', '%' . $search . '%')
                        ->orWhere('bio', 'like', '%' . $search . '%')
                        ->orWhere('city', 'like', '%' . $search . '%');
                });
            })
            ->withCount([
                'courses' => fn ($q) => $q->where('is_published', true),
            ])
            ->latest()
            ->paginate(8)
            ->withQueryString();

        return view('pages.mentors.index', compact('mentors', 'search'));
    }

    /**
     * Tampilkan detail profil mentor beserta kelas yang diasuh.
     */
    public function mentorDetail(int $id)
    {
        $mentor = User::query()
            ->where('role', 'mentor')
            ->where('is_approved', true)
            ->findOrFail($id);

        $courses = Course::query()
            ->where('user_id', $mentor->id)
            ->where('is_published', true)
            ->with('category')
            ->withSum('videos as total_duration_seconds', 'duration_seconds')
            ->latest()
            ->paginate(8)
            ->withQueryString();

        $savedCourseIds = auth()->user()?->savedCourses()->pluck('courses.id') ?? collect();

        return view('pages.mentors.show', compact('mentor', 'courses', 'savedCourseIds'));
    }

    /**
     * Tampilkan daftar seluruh coach yang telah disetujui.
     */
    public function coaches(Request $request)
    {
        $search = trim((string) $request->query('search', ''));

        $coaches = User::query()
            ->where('role', 'coach')
            ->where('is_approved', true)
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%')
                        ->orWhere('job_title', 'like', '%' . $search . '%')
                        ->orWhere('bio', 'like', '%' . $search . '%')
                        ->orWhere('city', 'like', '%' . $search . '%');
                });
            })
            ->withCount([
                'courses' => fn ($q) => $q->where('is_published', true),
            ])
            ->latest()
            ->paginate(8)
            ->withQueryString();

        return view('pages.coaches.index', compact('coaches', 'search'));
    }

    /**
     * Tampilkan detail profil coach beserta kelas yang diasuh.
     */
    public function coachDetail(int $id)
    {
        $coach = User::query()
            ->where('role', 'coach')
            ->where('is_approved', true)
            ->findOrFail($id);

        $courses = Course::query()
            ->where('user_id', $coach->id)
            ->where('is_published', true)
            ->with('category')
            ->withSum('videos as total_duration_seconds', 'duration_seconds')
            ->latest()
            ->paginate(8)
            ->withQueryString();

        $savedCourseIds = auth()->user()?->savedCourses()->pluck('courses.id') ?? collect();

        return view('pages.coaches.show', compact('coach', 'courses', 'savedCourseIds'));
    }
}
