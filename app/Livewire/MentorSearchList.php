<?php

namespace App\Livewire;

use App\Models\MentorAvailabilitySlot;
use App\Models\MentoringRequest;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class MentorSearchList extends Component
{
    use WithPagination;

    public string $search = '';

    public string $city = '';

    public bool $hasSlots = false;

    public string $sortBy = 'popular';

    public ?int $activeEntitlementId = null;

    protected $queryString = [
        'search' => ['except' => ''],
        'city' => ['except' => ''],
        'hasSlots' => ['except' => false],
        'sortBy' => ['except' => 'popular'],
    ];

    public function mount(?int $activeEntitlementId = null): void
    {
        $this->activeEntitlementId = $activeEntitlementId;
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingCity(): void
    {
        $this->resetPage();
    }

    public function updatingHasSlots(): void
    {
        $this->resetPage();
    }

    public function updatingSortBy(): void
    {
        $this->resetPage();
    }

    public function resetFilters(): void
    {
        $this->reset(['search', 'city', 'hasSlots', 'sortBy']);
        $this->resetPage();
    }

    public function getAvailableCitiesProperty(): Collection
    {
        return User::query()
            ->where('role', 'mentor')
            ->where('is_approved', true)
            ->whereNotNull('city')
            ->where('city', '!=', '')
            ->distinct()
            ->orderBy('city')
            ->pluck('city');
    }

    public function render(): View
    {
        $searchTerm = trim($this->search);

        $mentors = User::query()
            ->where('role', 'mentor')
            ->where('is_approved', true)
            ->withCount([
                'mentorAvailabilitySlots as available_slots_count' => fn ($query) => $query
                    ->where('status', MentorAvailabilitySlot::STATUS_AVAILABLE)
                    ->where('starts_at', '>=', now()),
                'activeMentees as total_students_count',
            ])
            ->when($searchTerm !== '', function (Builder $query) use ($searchTerm) {
                $query->where(function (Builder $sub) use ($searchTerm) {
                    $sub->where('name', 'like', '%' . $searchTerm . '%')
                        ->orWhere('job_title', 'like', '%' . $searchTerm . '%')
                        ->orWhere('bio', 'like', '%' . $searchTerm . '%')
                        ->orWhere('city', 'like', '%' . $searchTerm . '%');
                });
            })
            ->when($this->city !== '', function (Builder $query) {
                $query->where('city', $this->city);
            })
            ->when($this->hasSlots, function (Builder $query) {
                $query->whereHas('mentorAvailabilitySlots', function (Builder $slotQuery) {
                    $slotQuery->where('status', MentorAvailabilitySlot::STATUS_AVAILABLE)
                        ->where('starts_at', '>=', now());
                });
            })
            ->when($this->sortBy === 'popular', function (Builder $query) {
                $query->orderByDesc('total_students_count')->orderBy('name');
            })
            ->when($this->sortBy === 'slots', function (Builder $query) {
                $query->orderByDesc('available_slots_count')->orderBy('name');
            })
            ->when($this->sortBy === 'name_asc', function (Builder $query) {
                $query->orderBy('name', 'asc');
            })
            ->when($this->sortBy === 'name_desc', function (Builder $query) {
                $query->orderBy('name', 'desc');
            })
            ->paginate(8);

        return view('livewire.mentor-search-list', [
            'mentors' => $mentors,
            'cities' => $this->availableCities,
        ]);
    }
}
