<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Course;
use App\Models\CourseKeypoint;
use App\Models\CourseReview;
use App\Models\CourseSection;
use App\Models\CourseVideo;
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

        $studentOne = User::updateOrCreate(
            ['email' => 'student1@salonkita.test'],
            [
                'name' => 'Student One',
                'role' => 'student',
                'password' => Hash::make('password'),
            ]
        );

        $studentTwo = User::updateOrCreate(
            ['email' => 'student2@salonkita.test'],
            [
                'name' => 'Student Two',
                'role' => 'student',
                'password' => Hash::make('password'),
            ]
        );

        $studentThree = User::updateOrCreate(
            ['email' => 'student3@salonkita.test'],
            [
                'name' => 'Student Three',
                'role' => 'student',
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

        $courseOne = Course::updateOrCreate(
            ['slug' => 'basic-makeup-technique'],
            [
                'name' => 'Basic Makeup Technique',
                'description' => 'Pelajari teknik dasar makeup dari nol hingga mahir bersama instruktur berpengalaman.',
                'category_id' => $categories[0]->id,
                'user_id' => $coachOne->id,
                'price' => 299000,
                'rating' => 4.80,
                'is_published' => true,
                'introduction_video_url' => 'https://www.youtube.com/watch?v=example_makeup',
            ]
        );

        $courseTwo = Course::updateOrCreate(
            ['slug' => 'fundamental-hair-styling'],
            [
                'name' => 'Fundamental Hair Styling',
                'description' => 'Kuasai teknik styling rambut dasar hingga lanjutan untuk berbagai acara.',
                'category_id' => $categories[1]->id,
                'user_id' => $coachTwo->id,
                'price' => 349000,
                'rating' => 4.70,
                'is_published' => true,
                'introduction_video_url' => 'https://www.youtube.com/watch?v=example_hair',
            ]
        );

        foreach ([$courseOne, $courseTwo] as $index => $course) {
            // 1 Section per course
            $section = CourseSection::updateOrCreate(
                ['course_id' => $course->id, 'title' => 'Section 1: Pengenalan'],
                ['course_id' => $course->id, 'title' => 'Section 1: Pengenalan']
            );

            // 2 Videos per section
            CourseVideo::updateOrCreate(
                ['course_section_id' => $section->id, 'title' => 'Video 1: Perkenalan Alat & Bahan'],
                [
                    'course_section_id' => $section->id,
                    'title' => 'Video 1: Perkenalan Alat & Bahan',
                    'video_url' => 'https://www.youtube.com/watch?v=video1_course' . ($index + 1),
                    'duration_seconds' => 480,
                ]
            );

            CourseVideo::updateOrCreate(
                ['course_section_id' => $section->id, 'title' => 'Video 2: Teknik Dasar'],
                [
                    'course_section_id' => $section->id,
                    'title' => 'Video 2: Teknik Dasar',
                    'video_url' => 'https://www.youtube.com/watch?v=video2_course' . ($index + 1),
                    'duration_seconds' => 720,
                ]
            );

            // 1 Review per course (alternating students)
            CourseReview::updateOrCreate(
                ['course_id' => $course->id, 'user_id' => $studentOne->id],
                [
                    'course_id' => $course->id,
                    'user_id' => $studentOne->id,
                    'rating' => $index === 0 ? 5 : 4,
                    'review' => $index === 0
                        ? 'Materi sangat lengkap dan mudah dipahami!'
                        : 'Instruktur menjelaskan dengan sabar dan detail.',
                ]
            );

            // 4 Keypoints per course
            $keypoints = $index === 0
                ? [
                    'Memahami jenis-jenis alat makeup profesional',
                    'Teknik dasar foundation dan concealer',
                    'Cara membentuk alis yang sempurna',
                    'Teknik shading dan highlighting wajah',
                ]
                : [
                    'Memahami karakteristik berbagai jenis rambut',
                    'Teknik dasar blow dry dan smoothing',
                    'Cara membuat curly dan wavy hair',
                    'Finishing dan perawatan styling rambut',
                ];

            foreach ($keypoints as $point) {
                CourseKeypoint::updateOrCreate(
                    ['course_id' => $course->id, 'point' => $point],
                    ['course_id' => $course->id, 'point' => $point]
                );
            }
        }
    }
}
