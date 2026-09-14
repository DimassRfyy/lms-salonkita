<?php

namespace Database\Seeders;

use App\Models\Achievement;
use Illuminate\Database\Seeder;

class AchievementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $achievements = [
            // -------------------------------------------------------
            // GROUP: Course Completion
            // -------------------------------------------------------
            [
                'name'        => 'First Graduate',
                'level'       => Achievement::LEVEL_BEGINNER,
                'category'    => Achievement::CATEGORY_COURSE_COMPLETION,
                'description' => 'Complete your first course.',
                'icon'        => '🎓',
                'badge_color' => 'green',
                'sort_order'  => 1,
            ],
            [
                'name'        => 'Rising Scholar',
                'level'       => Achievement::LEVEL_INTERMEDIATE,
                'category'    => Achievement::CATEGORY_COURSE_COMPLETION,
                'description' => 'Complete 3 courses.',
                'icon'        => '📚',
                'badge_color' => 'blue',
                'sort_order'  => 2,
            ],
            [
                'name'        => 'Master of Craft',
                'level'       => Achievement::LEVEL_EXPERT,
                'category'    => Achievement::CATEGORY_COURSE_COMPLETION,
                'description' => 'Complete 7 courses.',
                'icon'        => '🏆',
                'badge_color' => 'gold',
                'sort_order'  => 3,
            ],

            // -------------------------------------------------------
            // GROUP: Learning Activity (Video Watched)
            // -------------------------------------------------------
            [
                'name'        => 'Curious Learner',
                'level'       => Achievement::LEVEL_BEGINNER,
                'category'    => Achievement::CATEGORY_LEARNING_ACTIVITY,
                'description' => 'Watch 5 lesson videos.',
                'icon'        => '👀',
                'badge_color' => 'green',
                'sort_order'  => 4,
            ],
            [
                'name'        => 'Dedicated Learner',
                'level'       => Achievement::LEVEL_INTERMEDIATE,
                'category'    => Achievement::CATEGORY_LEARNING_ACTIVITY,
                'description' => 'Watch 20 lesson videos.',
                'icon'        => '🎬',
                'badge_color' => 'blue',
                'sort_order'  => 5,
            ],
            [
                'name'        => 'Learning Marathon',
                'level'       => Achievement::LEVEL_EXPERT,
                'category'    => Achievement::CATEGORY_LEARNING_ACTIVITY,
                'description' => 'Watch 50 lesson videos.',
                'icon'        => '🔥',
                'badge_color' => 'gold',
                'sort_order'  => 6,
            ],

            // -------------------------------------------------------
            // GROUP: Assignment Completion
            // -------------------------------------------------------
            [
                'name'        => 'First Submission',
                'level'       => Achievement::LEVEL_BEGINNER,
                'category'    => Achievement::CATEGORY_ASSIGNMENT_COMPLETION,
                'description' => 'Submit your first assignment.',
                'icon'        => '📝',
                'badge_color' => 'green',
                'sort_order'  => 7,
            ],
            [
                'name'        => 'Task Achiever',
                'level'       => Achievement::LEVEL_INTERMEDIATE,
                'category'    => Achievement::CATEGORY_ASSIGNMENT_COMPLETION,
                'description' => 'Submit 3 assignments.',
                'icon'        => '✅',
                'badge_color' => 'blue',
                'sort_order'  => 8,
            ],
            [
                'name'        => 'Assignment Master',
                'level'       => Achievement::LEVEL_EXPERT,
                'category'    => Achievement::CATEGORY_ASSIGNMENT_COMPLETION,
                'description' => 'Submit 7 assignments.',
                'icon'        => '🌟',
                'badge_color' => 'gold',
                'sort_order'  => 9,
            ],
        ];

        foreach ($achievements as $data) {
            Achievement::updateOrCreate(
                ['name' => $data['name']],
                array_merge($data, ['is_active' => true, 'points_reward' => 0])
            );
        }
    }
}
