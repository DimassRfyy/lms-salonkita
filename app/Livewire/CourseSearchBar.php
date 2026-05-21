<?php

namespace App\Livewire;

use App\Models\Course;
use Illuminate\View\View;
use Livewire\Component;

class CourseSearchBar extends Component
{
    public string $search = '';

    public function getSuggestionsProperty()
    {
        $term = trim($this->search);

        if (mb_strlen($term) < 2) {
            return collect();
        }

        return Course::query()
            ->select(['id', 'name', 'slug'])
            ->where('is_published', true)
            ->where('name', 'like', '%' . $term . '%')
            ->latest()
            ->limit(5)
            ->get();
    }

    public function searchCourses()
    {
        $term = trim($this->search);

        if ($term === '') {
            return null;
        }

        return redirect()->route('all-courses', ['search' => $term]);
    }

    public function render(): View
    {
        return view('livewire.course-search-bar');
    }
}