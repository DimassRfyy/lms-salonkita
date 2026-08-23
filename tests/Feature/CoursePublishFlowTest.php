<?php

use App\Filament\Resources\Courses\CourseResource;
use App\Filament\Resources\Courses\Pages\CreateCourse;
use App\Filament\Resources\Courses\Pages\EditCourse;
use App\Filament\Resources\Courses\Pages\ListCourses;
use App\Models\Category;
use App\Models\Course;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

test('coach creating a course always has is_published set to false', function () {
    $coach = User::factory()->create(['role' => 'coach', 'is_approved' => true]);
    $category = Category::create(['name' => 'Makeup Artist', 'slug' => 'makeup-artist']);

    $this->actingAs($coach);

    $component = Livewire::test(CreateCourse::class);
    $keypointKeys = array_keys($component->get('data.keypoints') ?? []);
    $keypointsData = [];
    foreach ($keypointKeys as $i => $key) {
        $keypointsData[$key] = ['point' => 'Poin ' . ($i + 1)];
    }

    $component
        ->fillForm([
            'name' => 'Kelas Baru dari Coach',
            'description' => 'Deskripsi kelas yang dibuat oleh coach.',
            'category_id' => $category->id,
            'price' => 150000,
            'rating' => 5.0,
            'is_published' => true, // Attempt to set true from payload
            'keypoints' => $keypointsData,
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    $course = Course::where('slug', 'kelas-baru-dari-coach')->first();
    expect($course)->not->toBeNull();
    expect($course->is_published)->toBeFalse();
    expect($course->user_id)->toBe($coach->id);
});

test('coach editing a course cannot modify is_published status', function () {
    $coach = User::factory()->create(['role' => 'coach', 'is_approved' => true]);
    $category = Category::create(['name' => 'Hair Styling', 'slug' => 'hair-styling']);

    $course = Course::create([
        'name' => 'Kelas Coach Edit',
        'slug' => 'kelas-coach-edit',
        'description' => 'Deskripsi lama.',
        'category_id' => $category->id,
        'user_id' => $coach->id,
        'price' => 200000,
        'rating' => 5.0,
        'is_published' => false,
    ]);

    $this->actingAs($coach);

    Livewire::test(EditCourse::class, ['record' => $course->getKey()])
        ->fillForm([
            'name' => 'Kelas Coach Edit Update',
            'is_published' => true, // Attempt to publish on edit
        ])
        ->call('save')
        ->assertHasNoFormErrors();

    $course->refresh();
    expect($course->name)->toBe('Kelas Coach Edit Update');
    expect($course->is_published)->toBeFalse();
});

test('admin can create and directly publish a course', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $coach = User::factory()->create(['role' => 'coach', 'is_approved' => true]);
    $category = Category::create(['name' => 'Nail Art', 'slug' => 'nail-art']);

    $this->actingAs($admin);

    $component = Livewire::test(CreateCourse::class);
    $keypointKeys = array_keys($component->get('data.keypoints') ?? []);
    $keypointsData = [];
    foreach ($keypointKeys as $i => $key) {
        $keypointsData[$key] = ['point' => 'Poin Admin ' . ($i + 1)];
    }

    $component
        ->fillForm([
            'name' => 'Kelas Langsung Aktif Admin',
            'description' => 'Kelas yang dibuat oleh admin langsung dipublikasikan.',
            'category_id' => $category->id,
            'user_id' => $coach->id,
            'price' => 300000,
            'rating' => 5.0,
            'is_published' => true,
            'keypoints' => $keypointsData,
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    $course = Course::where('slug', 'kelas-langsung-aktif-admin')->first();
    expect($course)->not->toBeNull();
    expect($course->is_published)->toBeTrue();
    expect($course->user_id)->toBe($coach->id);
});

test('course resource navigation badge shows pending count', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $coachA = User::factory()->create(['role' => 'coach', 'is_approved' => true]);
    $coachB = User::factory()->create(['role' => 'coach', 'is_approved' => true]);
    $category = Category::create(['name' => 'General', 'slug' => 'general']);

    // Published course
    Course::create([
        'name' => 'Course 1',
        'category_id' => $category->id,
        'user_id' => $coachA->id,
        'price' => 100000,
        'is_published' => true,
    ]);

    // Inactive course coach A
    Course::create([
        'name' => 'Course 2',
        'category_id' => $category->id,
        'user_id' => $coachA->id,
        'price' => 100000,
        'is_published' => false,
    ]);

    // Inactive course coach B
    Course::create([
        'name' => 'Course 3',
        'category_id' => $category->id,
        'user_id' => $coachB->id,
        'price' => 100000,
        'is_published' => false,
    ]);

    // Admin should see 2 pending courses in badge
    $this->actingAs($admin);
    expect(CourseResource::getNavigationBadge())->toBe('2');

    // Coach A should only see 1 pending course in badge
    $this->actingAs($coachA);
    expect(CourseResource::getNavigationBadge())->toBe('1');
});

test('list courses tabs separate active and inactive courses correctly', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $coach = User::factory()->create(['role' => 'coach', 'is_approved' => true]);
    $category = Category::create(['name' => 'General', 'slug' => 'general']);

    $activeCourse = Course::create([
        'name' => 'Kelas Published',
        'category_id' => $category->id,
        'user_id' => $coach->id,
        'price' => 100000,
        'is_published' => true,
    ]);

    $inactiveCourse = Course::create([
        'name' => 'Kelas Belum Aktif',
        'category_id' => $category->id,
        'user_id' => $coach->id,
        'price' => 100000,
        'is_published' => false,
    ]);

    $this->actingAs($admin);

    $component = Livewire::test(ListCourses::class);

    // Active tab
    $component->set('activeTab', 'active')
        ->assertCanSeeTableRecords([$activeCourse])
        ->assertCanNotSeeTableRecords([$inactiveCourse]);

    // Inactive tab
    $component->set('activeTab', 'inactive')
        ->assertCanSeeTableRecords([$inactiveCourse])
        ->assertCanNotSeeTableRecords([$activeCourse]);
});
