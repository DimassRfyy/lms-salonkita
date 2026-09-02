<?php

use App\Models\Achievement;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('student profile displays achievements and badge counts accurately', function () {
    $student = User::factory()->create(['role' => 'student']);

    $ach1 = Achievement::create([
        'name' => 'Beauty Starter',
        'slug' => 'beauty-starter',
        'description' => 'Menyelesaikan video materi pertama dan kuis pertama',
        'icon' => '💄',
        'badge_color' => 'pink',
        'is_active' => true,
    ]);

    $ach2 = Achievement::create([
        'name' => 'Hair Styling Virtuoso',
        'slug' => 'hair-styling-virtuoso',
        'description' => 'Menyelesaikan seluruh modul kelas dalam kategori Hair Styling',
        'icon' => '💇‍♀️',
        'badge_color' => 'amber',
        'is_active' => true,
    ]);

    // Grant ach1 to student
    $student->achievements()->attach($ach1->id, ['unlocked_at' => now(), 'progress_percentage' => 100]);

    $this->actingAs($student);
    $response = $this->get(route('profile'));

    $response->assertStatus(200);
    $response->assertSee('1 Badges');
    $response->assertSee('1 / 2 Terbuka');
    $response->assertSee('Beauty Starter');
    $response->assertSee('Hair Styling Virtuoso');
    $response->assertSee('Terbuka');
    $response->assertSee('Belum Terbuka');
});

test('admin can grant and revoke achievement to student', function () {
    $student = User::factory()->create(['role' => 'student']);
    $achievement = Achievement::create([
        'name' => 'Rajin Belajar',
        'slug' => 'rajin-belajar',
        'description' => 'Menonton materi pembelajaran minimal 1 video/hari selama 7 hari berturut-turut',
        'icon' => '🔥',
        'badge_color' => 'purple',
        'is_active' => true,
    ]);

    expect($student->achievements()->count())->toBe(0);

    // Direct grant
    $achievement->users()->syncWithoutDetaching([
        $student->id => [
            'unlocked_at' => now(),
            'progress_percentage' => 100,
            'notes' => 'Manual grant demo',
        ],
    ]);

    $student->refresh();
    expect($student->achievements()->count())->toBe(1);
    expect($student->achievements()->first()->name)->toBe('Rajin Belajar');

    // Revoke
    $achievement->users()->detach($student->id);
    $student->refresh();
    expect($student->achievements()->count())->toBe(0);
});
