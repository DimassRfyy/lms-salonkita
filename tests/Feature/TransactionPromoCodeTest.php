<?php

use App\Livewire\TransactionPromoCode;
use App\Models\Category;
use App\Models\Course;
use App\Models\PromoCode;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

test('transaction promo code component mounts with null initial promo code without error', function () {
    Livewire::test(TransactionPromoCode::class, [
        'coursePrice' => 100000,
        'initialPromoCode' => null,
    ])
    ->assertSet('promoCode', '')
    ->assertSet('finalPrice', 100000);
});

test('transaction promo code component mounts with string initial promo code', function () {
    Livewire::test(TransactionPromoCode::class, [
        'coursePrice' => 100000,
        'initialPromoCode' => 'DISCOUNT50',
    ])
    ->assertSet('promoCode', 'DISCOUNT50');
});

test('global promo code applies to any course', function () {
    $promo = PromoCode::create([
        'code' => 'ALLCOURSES10',
        'name' => '10% All Courses',
        'type' => 'percentage',
        'value' => 10,
        'is_active' => true,
    ]);

    Livewire::test(TransactionPromoCode::class, [
        'coursePrice' => 100000,
        'courseId' => 999,
        'initialPromoCode' => 'ALLCOURSES10',
    ])
    ->assertSet('isPromoValid', true)
    ->assertSet('discountAmount', 10000)
    ->assertSet('finalPrice', 90000)
    ->assertSet('promoMessage', 'Promo berhasil dipakai.');
});

test('course-specific promo code applies to the designated course', function () {
    $author = User::factory()->create();
    $category = Category::create(['name' => 'Makeup', 'slug' => 'makeup']);
    $courseA = Course::create([
        'name' => 'Kelas A',
        'slug' => 'kelas-a',
        'price' => 200000,
        'category_id' => $category->id,
        'user_id' => $author->id,
        'is_published' => true,
    ]);

    $promo = PromoCode::create([
        'code' => 'KELASA100',
        'name' => 'Diskon Khusus Kelas A',
        'type' => 'percentage',
        'value' => 100,
        'is_active' => true,
    ]);
    $promo->courses()->attach($courseA->id);

    Livewire::test(TransactionPromoCode::class, [
        'coursePrice' => 200000,
        'courseId' => $courseA->id,
        'initialPromoCode' => 'KELASA100',
    ])
    ->assertSet('isPromoValid', true)
    ->assertSet('discountAmount', 200000)
    ->assertSet('finalPrice', 0)
    ->assertSet('promoMessage', 'Promo berhasil dipakai.');
});

test('course-specific promo code is rejected when used for another course', function () {
    $author = User::factory()->create();
    $category = Category::create(['name' => 'Skincare', 'slug' => 'skincare']);
    $courseA = Course::create([
        'name' => 'Kelas A',
        'slug' => 'kelas-a',
        'price' => 200000,
        'category_id' => $category->id,
        'user_id' => $author->id,
        'is_published' => true,
    ]);
    $courseB = Course::create([
        'name' => 'Kelas B',
        'slug' => 'kelas-b',
        'price' => 200000,
        'category_id' => $category->id,
        'user_id' => $author->id,
        'is_published' => true,
    ]);

    $promo = PromoCode::create([
        'code' => 'KELASAONLY',
        'name' => 'Hanya Kelas A',
        'type' => 'fixed',
        'value' => 50000,
        'is_active' => true,
    ]);
    $promo->courses()->attach($courseA->id);

    Livewire::test(TransactionPromoCode::class, [
        'coursePrice' => 200000,
        'courseId' => $courseB->id,
        'initialPromoCode' => 'KELASAONLY',
    ])
    ->assertSet('isPromoValid', false)
    ->assertSet('discountAmount', 0)
    ->assertSet('finalPrice', 200000)
    ->assertSet('promoMessage', 'Kode promo tidak berlaku untuk kelas ini.');
});

test('storeTransaction controller rejects promo code that does not apply to the course', function () {
    $user = User::factory()->create(['role' => 'student']);
    $author = User::factory()->create();
    $category = Category::create(['name' => 'Hair', 'slug' => 'hair']);
    $courseA = Course::create([
        'name' => 'Kelas A',
        'slug' => 'kelas-a',
        'price' => 200000,
        'category_id' => $category->id,
        'user_id' => $author->id,
        'is_published' => true,
    ]);
    $courseB = Course::create([
        'name' => 'Kelas B',
        'slug' => 'kelas-b',
        'price' => 200000,
        'category_id' => $category->id,
        'user_id' => $author->id,
        'is_published' => true,
    ]);

    $promo = PromoCode::create([
        'code' => 'KELASA100',
        'name' => 'Khusus Kelas A 100%',
        'type' => 'percentage',
        'value' => 100,
        'is_active' => true,
    ]);
    $promo->courses()->attach($courseA->id);

    // Try applying promo for Kelas B
    $response = $this->actingAs($user)->post(route('transaction.store'), [
        'course_id' => $courseB->id,
        'promo_code' => 'KELASA100',
    ]);

    $response->assertSessionHasErrors(['promo_code']);
});

