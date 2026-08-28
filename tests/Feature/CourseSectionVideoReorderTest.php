<?php

use App\Filament\Resources\Courses\Pages\EditCourse;
use App\Filament\Resources\Courses\RelationManagers\SectionsRelationManager;
use App\Models\Category;
use App\Models\Course;
use App\Models\CourseSection;
use App\Models\CourseVideo;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

test('course sections and videos are ordered by sort_order by default', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $category = Category::create(['name' => 'Makeup Artist', 'slug' => 'makeup-artist']);

    $course = Course::create([
        'name' => 'Kursus Tata Rias Pengantin',
        'category_id' => $category->id,
        'user_id' => $admin->id,
        'price' => 250000,
        'rating' => 5.0,
        'is_published' => true,
    ]);

    // Create sections out of order
    $sectionB = CourseSection::create([
        'course_id' => $course->id,
        'title' => 'Section B (Urutan 2)',
        'sort_order' => 2,
    ]);

    $sectionA = CourseSection::create([
        'course_id' => $course->id,
        'title' => 'Section A (Urutan 1)',
        'sort_order' => 1,
    ]);

    // Create videos out of order in Section A
    $videoA2 = CourseVideo::create([
        'course_section_id' => $sectionA->id,
        'title' => 'Video A2',
        'video_url' => 'dQw4w9WgXcQ',
        'duration_seconds' => 300,
        'sort_order' => 2,
    ]);

    $videoA1 = CourseVideo::create([
        'course_section_id' => $sectionA->id,
        'title' => 'Video A1',
        'video_url' => 'dQw4w9WgXcQ',
        'duration_seconds' => 200,
        'sort_order' => 1,
    ]);

    // Verify course->sections order
    $loadedSections = $course->fresh()->sections;
    expect($loadedSections->first()->id)->toBe($sectionA->id);
    expect($loadedSections->last()->id)->toBe($sectionB->id);

    // Verify section->videos order
    $loadedVideos = $sectionA->fresh()->videos;
    expect($loadedVideos->first()->id)->toBe($videoA1->id);
    expect($loadedVideos->last()->id)->toBe($videoA2->id);
});

test('sections relation manager can reorder sections via table reordering', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $category = Category::create(['name' => 'Hair Styling', 'slug' => 'hair-styling']);

    $course = Course::create([
        'name' => 'Kursus Hair Styling Masterclass',
        'category_id' => $category->id,
        'user_id' => $admin->id,
        'price' => 300000,
        'rating' => 5.0,
        'is_published' => true,
    ]);

    $section1 = CourseSection::create([
        'course_id' => $course->id,
        'title' => 'Section Pertama',
        'sort_order' => 1,
    ]);

    $section2 = CourseSection::create([
        'course_id' => $course->id,
        'title' => 'Section Kedua',
        'sort_order' => 2,
    ]);

    $this->actingAs($admin);

    // Reorder records in Livewire relation manager component
    Livewire::test(SectionsRelationManager::class, [
        'ownerRecord' => $course,
        'pageClass' => EditCourse::class,
    ])
        ->call('reorderTable', [(string) $section2->id, (string) $section1->id]);

    $section1->refresh();
    $section2->refresh();

    // Section 2 should now have sort_order 1 (or lower) and Section 1 should have sort_order 2
    expect($section2->sort_order)->toBeLessThan($section1->sort_order);

    $orderedSections = $course->fresh()->sections;
    expect($orderedSections->first()->id)->toBe($section2->id);
});

test('sections relation manager saves video sort_order correctly on repeater submit', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $category = Category::create(['name' => 'Skincare', 'slug' => 'skincare']);

    $course = Course::create([
        'name' => 'Kursus Skincare Rutin',
        'category_id' => $category->id,
        'user_id' => $admin->id,
        'price' => 150000,
        'rating' => 5.0,
        'is_published' => true,
    ]);

    $this->actingAs($admin);

    $component = Livewire::test(SectionsRelationManager::class, [
        'ownerRecord' => $course,
        'pageClass' => EditCourse::class,
    ])->mountTableAction('create');

    $videoKeys = array_keys($component->get('mountedActions.0.data.videos') ?? []);
    $firstKey = $videoKeys[0] ?? 'video1';
    $secondKey = 'video2';

    $component
        ->setTableActionData([
            'title' => 'Dasar Perawatan Kulit',
            'videos' => [
                $firstKey => [
                    'title' => 'Video Pengenalan',
                    'video_url' => 'dQw4w9WgXcQ',
                    'duration_seconds' => '05:00',
                ],
                $secondKey => [
                    'title' => 'Video Langkah Praktik',
                    'video_url' => 'dQw4w9WgXcQ',
                    'duration_seconds' => '10:30',
                ],
            ],
        ])
        ->callMountedTableAction()
        ->assertHasNoTableActionErrors();

    $createdSection = CourseSection::where('course_id', $course->id)->first();
    expect($createdSection)->not->toBeNull();

    $videos = $createdSection->videos()->get();
    expect($videos)->toHaveCount(2);

    $firstVideo = $videos->firstWhere('title', 'Video Pengenalan');
    $secondVideo = $videos->firstWhere('title', 'Video Langkah Praktik');

    expect($firstVideo->sort_order)->toBeLessThan($secondVideo->sort_order);
    expect($firstVideo->duration_seconds)->toBe(300);
    expect($secondVideo->duration_seconds)->toBe(630);
});

test('student course page respects section and video sort_order for curriculum and player sequence', function () {
    $student = User::factory()->create(['role' => 'student']);
    $category = Category::create(['name' => 'Nail Art', 'slug' => 'nail-art']);

    $course = Course::create([
        'name' => 'Kursus Nail Art Profesional',
        'slug' => 'kursus-nail-art-profesional',
        'category_id' => $category->id,
        'user_id' => $student->id,
        'price' => 100000,
        'rating' => 5.0,
        'is_published' => true,
    ]);

    // Give student access
    $student->ownedCourses()->attach($course->id);

    // Section 1
    $section1 = CourseSection::create([
        'course_id' => $course->id,
        'title' => 'Modul 1: Alat dan Bahan',
        'sort_order' => 1,
    ]);

    $video1 = CourseVideo::create([
        'course_section_id' => $section1->id,
        'title' => 'Video 1.1: Pengenalan Alat',
        'video_url' => 'dQw4w9WgXcQ',
        'duration_seconds' => 180,
        'sort_order' => 1,
    ]);

    $video2 = CourseVideo::create([
        'course_section_id' => $section1->id,
        'title' => 'Video 1.2: Pemilihan Bahan',
        'video_url' => 'dQw4w9WgXcQ',
        'duration_seconds' => 240,
        'sort_order' => 2,
    ]);

    // Section 2
    $section2 = CourseSection::create([
        'course_id' => $course->id,
        'title' => 'Modul 2: Teknik Dasar',
        'sort_order' => 2,
    ]);

    $video3 = CourseVideo::create([
        'course_section_id' => $section2->id,
        'title' => 'Video 2.1: Praktik Awal',
        'video_url' => 'dQw4w9WgXcQ',
        'duration_seconds' => 360,
        'sort_order' => 1,
    ]);

    $this->actingAs($student);

    $response = $this->get(route('course', ['slug' => $course->slug]));
    $response->assertOk();

    // Verify first active video is video 1.1
    $response->assertSee('Video 1.1: Pengenalan Alat');
    $response->assertSee('Modul 1: Alat dan Bahan');
    $response->assertSee('Modul 2: Teknik Dasar');
});

test('newly created section automatically receives the next sort_order sequentially', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $category = Category::create(['name' => 'Hair Styling', 'slug' => 'hair-styling']);

    $course = Course::create([
        'name' => 'Kursus Hair Styling Modern',
        'category_id' => $category->id,
        'user_id' => $admin->id,
        'price' => 200000,
        'rating' => 5.0,
        'is_published' => true,
    ]);

    // Create first section with sort_order 1
    $section1 = CourseSection::create([
        'course_id' => $course->id,
        'title' => 'Section Pertama',
        'sort_order' => 1,
    ]);

    // Create second section via Eloquent without explicitly passing sort_order
    $section2 = CourseSection::create([
        'course_id' => $course->id,
        'title' => 'Section Kedua',
    ]);

    expect($section2->sort_order)->toBe(2);

    $this->actingAs($admin);

    // Create third section via Filament SectionsRelationManager
    $component = Livewire::test(SectionsRelationManager::class, [
        'ownerRecord' => $course,
        'pageClass' => EditCourse::class,
    ])->mountTableAction('create');

    $component
        ->setTableActionData([
            'title' => 'Section Ketiga',
            'videos' => [],
        ])
        ->callMountedTableAction()
        ->assertHasNoTableActionErrors();

    $section3 = CourseSection::where('course_id', $course->id)->where('title', 'Section Ketiga')->first();
    expect($section3)->not->toBeNull();
    expect($section3->sort_order)->toBe(3);

    // Verify final ordering in course sections relationship
    $allSections = $course->fresh()->sections->values();
    expect($allSections[0]->id)->toBe($section1->id);
    expect($allSections[1]->id)->toBe($section2->id);
    expect($allSections[2]->id)->toBe($section3->id);
});

