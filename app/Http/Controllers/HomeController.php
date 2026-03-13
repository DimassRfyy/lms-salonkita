<?php

namespace App\Http\Controllers;

use App\Models\Course;

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

    public function course()
    {
        return view('pages.course');
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
