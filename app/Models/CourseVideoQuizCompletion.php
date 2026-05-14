<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CourseVideoQuizCompletion extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'course_id',
        'course_video_id',
        'course_video_quiz_id',
        'score',
        'is_passed',
        'completed_at',
    ];

    protected function casts(): array
    {
        return [
            'score' => 'integer',
            'is_passed' => 'boolean',
            'completed_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function video(): BelongsTo
    {
        return $this->belongsTo(CourseVideo::class, 'course_video_id');
    }

    public function quiz(): BelongsTo
    {
        return $this->belongsTo(CourseVideoQuiz::class, 'course_video_quiz_id');
    }
}