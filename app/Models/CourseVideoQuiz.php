<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\CourseVideoQuizQuestion;

class CourseVideoQuiz extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_video_id',
        'title',
        'passing_score',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'passing_score' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    public function video(): BelongsTo
    {
        return $this->belongsTo(CourseVideo::class, 'course_video_id');
    }

    public function questions(): HasMany
    {
        return $this->hasMany(CourseVideoQuizQuestion::class, 'course_video_quiz_id');
    }
}