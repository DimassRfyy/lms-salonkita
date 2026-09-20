<?php

use App\Models\Category;
use App\Models\Course;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('creating a course with level basic enforces price to 0', function () {
    $author = User::factory()->create(['role' => 'coach']);
    $category = Category::create(['name' => 'Hair', 'slug' => 'hair']);

    $course = Course::create([
        'name' => 'Basic Salon Class',
        'level' => Course::LEVEL_BASIC,
        'price' => 250000,
        'category_id' => $category->id,
        'user_id' => $author->id,
        'rating' => 5,
        'is_published' => true,
    ]);

    expect($course->fresh()->price)->toEqual(0);
    expect($course->isBasic())->toBeTrue();
});

test('updating an existing course to basic resets price to 0', function () {
    $author = User::factory()->create(['role' => 'coach']);
    $category = Category::create(['name' => 'Makeup', 'slug' => 'makeup']);

    $course = Course::create([
        'name' => 'Pro Makeup Class',
        'level' => Course::LEVEL_INTERMEDIATE,
        'price' => 300000,
        'category_id' => $category->id,
        'user_id' => $author->id,
        'rating' => 5,
        'is_published' => true,
    ]);

    expect($course->fresh()->price)->toEqual(300000);

    $course->update(['level' => Course::LEVEL_BASIC]);

    expect($course->fresh()->price)->toEqual(0);
});

test('updating price on a basic course is ignored and kept as 0', function () {
    $author = User::factory()->create(['role' => 'coach']);
    $category = Category::create(['name' => 'Skin', 'slug' => 'skin']);

    $course = Course::create([
        'name' => 'Basic Skincare',
        'level' => Course::LEVEL_BASIC,
        'price' => 0,
        'category_id' => $category->id,
        'user_id' => $author->id,
        'rating' => 5,
        'is_published' => true,
    ]);

    $course->update(['price' => 450000]);

    expect($course->fresh()->price)->toEqual(0);
});

test('intermediate and advanced courses preserve custom price', function () {
    $author = User::factory()->create(['role' => 'coach']);
    $category = Category::create(['name' => 'Nails', 'slug' => 'nails']);

    $course = Course::create([
        'name' => 'Advanced Nail Art',
        'level' => Course::LEVEL_ADVANCED,
        'price' => 500000,
        'category_id' => $category->id,
        'user_id' => $author->id,
        'rating' => 5,
        'is_published' => true,
    ]);

    expect($course->fresh()->price)->toEqual(500000);
    expect($course->isPaid())->toBeTrue();
});

test('payment page redirects basic courses back to course detail', function () {
    $student = User::factory()->create(['role' => 'student']);
    $author = User::factory()->create(['role' => 'coach']);
    $category = Category::create(['name' => 'Hair', 'slug' => 'hair-2']);

    $course = Course::create([
        'name' => 'Free Basic Barber',
        'level' => Course::LEVEL_BASIC,
        'price' => 0,
        'category_id' => $category->id,
        'user_id' => $author->id,
        'rating' => 5,
        'is_published' => true,
    ]);

    $response = $this->actingAs($student)->get(route('transaction', ['course' => $course->slug]));

    $response->assertRedirect(route('course', ['slug' => $course->slug]));
});
