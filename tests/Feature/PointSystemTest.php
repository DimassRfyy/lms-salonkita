<?php

use App\Models\Category;
use App\Models\Course;
use App\Models\CourseSection;
use App\Models\CourseTaskSubmission;
use App\Models\CourseVideo;
use App\Models\RewardItem;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('user receives 40 points when buying a course successfully', function () {
    $student = User::factory()->create(['points_balance' => 0]);
    $coach = User::factory()->create(['role' => 'coach']);
    $category = Category::create(['name' => 'Makeup', 'slug' => 'makeup']);
    $course = Course::create([
        'name' => 'Belajar Makeup Dasar',
        'slug' => 'belajar-makeup-dasar',
        'price' => 150000,
        'category_id' => $category->id,
        'user_id' => $coach->id,
        'is_published' => true,
    ]);

    $transaction = Transaction::create([
        'trx_id' => 'TRX-TEST-001',
        'user_id' => $student->id,
        'course_id' => $course->id,
        'price' => 150000,
        'status' => Transaction::STATUS_PENDING,
    ]);

    $this->actingAs($student);
    $response = $this->get(route('payments.xendit.finish', ['order_id' => $transaction->trx_id]));

    $student->refresh();
    expect($student->points_balance)->toBe(40);
    expect($student->pointTransactions()->count())->toBe(1);
    expect($student->pointTransactions()->first()->amount)->toBe(40);
});

test('user receives 20 points when completing all course materials', function () {
    $student = User::factory()->create(['points_balance' => 0]);
    $coach = User::factory()->create(['role' => 'coach']);
    $category = Category::create(['name' => 'Hair', 'slug' => 'hair']);
    $course = Course::create([
        'name' => 'Belajar Hair Styling',
        'slug' => 'belajar-hair-styling',
        'price' => 150000,
        'category_id' => $category->id,
        'user_id' => $coach->id,
        'is_published' => true,
    ]);

    $student->ownedCourses()->attach($course->id);

    $section = CourseSection::create([
        'course_id' => $course->id,
        'title' => 'Section 1',
        'sort_order' => 1,
    ]);

    $video1 = CourseVideo::create([
        'course_section_id' => $section->id,
        'title' => 'Video 1',
        'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
        'duration_seconds' => 120,
        'sort_order' => 1,
    ]);

    $this->actingAs($student);
    $this->get(route('course', ['slug' => $course->slug, 'video' => $video1->id]));

    $student->refresh();
    expect($student->points_balance)->toBe(20);
    expect($student->pointTransactions()->where('amount', 20)->count())->toBe(1);
});

test('user receives 10 points when submitting course task', function () {
    $student = User::factory()->create(['points_balance' => 0]);
    $coach = User::factory()->create(['role' => 'coach']);
    $category = Category::create(['name' => 'Nails', 'slug' => 'nails']);
    $course = Course::create([
        'name' => 'Nail Art Masterclass',
        'slug' => 'nail-art-masterclass',
        'price' => 100000,
        'category_id' => $category->id,
        'user_id' => $coach->id,
        'is_published' => true,
    ]);

    $student->ownedCourses()->attach($course->id);

    $section = CourseSection::create([
        'course_id' => $course->id,
        'title' => 'Section 1',
        'sort_order' => 1,
    ]);

    $video1 = CourseVideo::create([
        'course_section_id' => $section->id,
        'title' => 'Video 1',
        'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
        'duration_seconds' => 60,
        'sort_order' => 1,
    ]);

    $student->courseVideoWatches()->create([
        'course_id' => $course->id,
        'course_video_id' => $video1->id,
        'watched_at' => now(),
    ]);

    $this->actingAs($student);
    $response = $this->post(route('course.task-submission.store', ['slug' => $course->slug]), [
        'subject' => 'Tugas Praktik Nail Art',
        'google_drive_url' => 'https://drive.google.com/file/d/123456789/view',
    ]);

    $student->refresh();
    expect($student->points_balance)->toBe(10);
    expect($student->pointTransactions()->where('amount', 10)->count())->toBe(1);
});

test('user receives 10 points when reviewing course and claiming certificate', function () {
    $student = User::factory()->create(['points_balance' => 0]);
    $coach = User::factory()->create(['role' => 'coach']);
    $category = Category::create(['name' => 'Spa', 'slug' => 'spa']);
    $course = Course::create([
        'name' => 'Spa & Massage Course',
        'slug' => 'spa-massage-course',
        'price' => 200000,
        'category_id' => $category->id,
        'user_id' => $coach->id,
        'is_published' => true,
    ]);

    $student->ownedCourses()->attach($course->id);

    CourseTaskSubmission::create([
        'course_id' => $course->id,
        'user_id' => $student->id,
        'subject' => 'Tugas Spa',
        'google_drive_url' => 'https://drive.google.com/file/d/test/view',
        'status' => CourseTaskSubmission::STATUS_REVIEWED,
        'score' => 90,
    ]);

    $this->actingAs($student);
    $response = $this->post(route('course.review.store', ['slug' => $course->slug]), [
        'rating' => 5,
        'review' => 'Kelasnya sangat lengkap dan mudah dipahami.',
    ]);

    $student->refresh();
    expect($student->points_balance)->toBe(10);
    expect($student->certificates()->where('course_id', $course->id)->count())->toBe(1);
    expect($student->pointTransactions()->where('amount', 10)->count())->toBe(1);
});

test('user can access points page and redeem rewards', function () {
    $student = User::factory()->create(['points_balance' => 100]);
    $rewardItem = RewardItem::create([
        'name' => 'Voucher Diskon 50k',
        'description' => 'Diskon Rp 50.000 untuk kelas berikutnya',
        'points_required' => 80,
        'stock' => 10,
        'is_active' => true,
        'type' => 'VOUCHER',
    ]);

    $this->actingAs($student);
    $response = $this->get(route('points.index'));
    $response->assertStatus(200);
    $response->assertSee('Voucher Diskon 50k');
    $response->assertSee('Total Poin Saya');

    // Redeem item
    $redeemResponse = $this->post(route('points.redeem', ['rewardItem' => $rewardItem->id]));
    $redeemResponse->assertRedirect(route('points.index'));

    $student->refresh();
    expect($student->points_balance)->toBe(20);
    expect($student->rewardRedemptions()->count())->toBe(1);
});
