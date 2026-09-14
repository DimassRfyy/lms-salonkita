<?php

namespace App\Services;

use App\Models\Achievement;
use App\Models\CourseCertificate;
use App\Models\CourseTaskSubmission;
use App\Models\CourseVideoWatch;
use App\Models\User;

class AchievementService
{
    /**
     * Check and award course completion achievements.
     * Milestones:
     * - Beginner: 1 course (First Graduate)
     * - Intermediate: 3 courses (Rising Scholar)
     * - Expert: 7 courses (Master of Craft)
     *
     * @return array<string> List of newly unlocked achievement names
     */
    public function checkCourseCompletion(User $user): array
    {
        // Total completed courses based on issued certificates
        $count = CourseCertificate::query()
            ->where('user_id', $user->id)
            ->distinct('course_id')
            ->count('course_id');

        $milestones = [
            'First Graduate'  => 1,
            'Rising Scholar'  => 3,
            'Master of Craft' => 7,
        ];

        return $this->evaluateMilestones(
            user: $user,
            category: Achievement::CATEGORY_COURSE_COMPLETION,
            currentCount: $count,
            milestones: $milestones
        );
    }

    /**
     * Check and award video watching / learning activity achievements.
     * Milestones:
     * - Beginner: 5 videos (Curious Learner)
     * - Intermediate: 20 videos (Dedicated Learner)
     * - Expert: 50 videos (Learning Marathon)
     *
     * @return array<string> List of newly unlocked achievement names
     */
    public function checkLearningActivity(User $user): array
    {
        $count = CourseVideoWatch::query()
            ->where('user_id', $user->id)
            ->distinct('course_video_id')
            ->count('course_video_id');

        $milestones = [
            'Curious Learner'   => 5,
            'Dedicated Learner' => 20,
            'Learning Marathon' => 50,
        ];

        return $this->evaluateMilestones(
            user: $user,
            category: Achievement::CATEGORY_LEARNING_ACTIVITY,
            currentCount: $count,
            milestones: $milestones
        );
    }

    /**
     * Check and award assignment completion achievements.
     * Milestones:
     * - Beginner: 1 assignment (First Submission)
     * - Intermediate: 3 assignments (Task Achiever)
     * - Expert: 7 assignments (Assignment Master)
     *
     * @return array<string> List of newly unlocked achievement names
     */
    public function checkAssignmentCompletion(User $user): array
    {
        $count = CourseTaskSubmission::query()
            ->where('user_id', $user->id)
            ->count();

        $milestones = [
            'First Submission'  => 1,
            'Task Achiever'     => 3,
            'Assignment Master' => 7,
        ];

        return $this->evaluateMilestones(
            user: $user,
            category: Achievement::CATEGORY_ASSIGNMENT_COMPLETION,
            currentCount: $count,
            milestones: $milestones
        );
    }

    /**
     * Evaluate milestones and unlock achievements if user reached the threshold.
     *
     * @param  array<string, int>  $milestones Name => threshold
     * @return array<string>
     */
    protected function evaluateMilestones(User $user, string $category, int $currentCount, array $milestones): array
    {
        $newlyUnlocked = [];

        // Fetch active achievements matching category
        $achievements = Achievement::query()
            ->where('is_active', true)
            ->where('category', $category)
            ->whereIn('name', array_keys($milestones))
            ->get();

        $unlockedIds = $user->achievements()->pluck('achievements.id')->all();

        foreach ($achievements as $achievement) {
            $threshold = $milestones[$achievement->name] ?? null;

            if ($threshold !== null && $currentCount >= $threshold) {
                if (! in_array($achievement->id, $unlockedIds, true)) {
                    $user->achievements()->syncWithoutDetaching([
                        $achievement->id => [
                            'unlocked_at' => now(),
                            'progress_percentage' => 100,
                            'notes' => "Unlocked with count: {$currentCount}/{$threshold}",
                        ],
                    ]);

                    $newlyUnlocked[] = $achievement->name;
                }
            }
        }

        return $newlyUnlocked;
    }

    /**
     * Get user progress stats and thresholds for each achievement category.
     *
     * @return array{
     *     course_count: int,
     *     video_count: int,
     *     task_count: int,
     *     thresholds: array<string, int>
     * }
     */
    public function getProgressStats(User $user): array
    {
        $courseCount = CourseCertificate::query()
            ->where('user_id', $user->id)
            ->distinct('course_id')
            ->count('course_id');

        $videoCount = CourseVideoWatch::query()
            ->where('user_id', $user->id)
            ->distinct('course_video_id')
            ->count('course_video_id');

        $taskCount = CourseTaskSubmission::query()
            ->where('user_id', $user->id)
            ->count();

        $thresholds = [
            'First Graduate'    => 1,
            'Rising Scholar'    => 3,
            'Master of Craft'   => 7,
            'Curious Learner'   => 5,
            'Dedicated Learner' => 20,
            'Learning Marathon' => 50,
            'First Submission'  => 1,
            'Task Achiever'     => 3,
            'Assignment Master' => 7,
        ];

        return [
            'course_count' => $courseCount,
            'video_count'  => $videoCount,
            'task_count'   => $taskCount,
            'thresholds'   => $thresholds,
        ];
    }

    /**
     * Run all checks for a given user (useful on profile load or batch update).
     *
     * @return array<string>
     */
    public function checkAll(User $user): array
    {
        return array_merge(
            $this->checkCourseCompletion($user),
            $this->checkLearningActivity($user),
            $this->checkAssignmentCompletion($user)
        );
    }
}
