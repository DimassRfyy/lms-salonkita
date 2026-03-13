<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin = User::updateOrCreate(
            ['email' => 'admin@salonkita.test'],
            [
                'name' => 'Admin Salonkita',
                'role' => 'admin',
                'password' => Hash::make('password'),
            ]
        );

        $coachOne = User::updateOrCreate(
            ['email' => 'coach1@salonkita.test'],
            [
                'name' => 'Coach One',
                'role' => 'coach',
                'password' => Hash::make('password'),
            ]
        );

        $coachTwo = User::updateOrCreate(
            ['email' => 'coach2@salonkita.test'],
            [
                'name' => 'Coach Two',
                'role' => 'coach',
                'password' => Hash::make('password'),
            ]
        );

        $categories = collect([
            'Makeup Artist',
            'Hair Styling',
            'Nail Art',
        ])->map(fn (string $name) => Category::updateOrCreate(
            ['slug' => Str::slug($name)],
            ['name' => $name]
        ));

        Course::updateOrCreate(
            ['slug' => 'basic-makeup-technique'],
            [
                'name' => 'Basic Makeup Technique',
                'category_id' => $categories[0]->id,
                'user_id' => $coachOne->id,
            ]
        );

        Course::updateOrCreate(
            ['slug' => 'fundamental-hair-styling'],
            [
                'name' => 'Fundamental Hair Styling',
                'category_id' => $categories[1]->id,
                'user_id' => $coachTwo->id,
            ]
        );
    }
}
