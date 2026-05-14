<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\CourseVideoQuiz;
use App\Models\CourseVideoQuizOption;

class CourseVideoQuizQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_video_quiz_id',
        'question',
    ];

    public function quiz(): BelongsTo
    {
        return $this->belongsTo(CourseVideoQuiz::class, 'course_video_quiz_id');
    }

    public function options(): HasMany
    {
        return $this->hasMany(CourseVideoQuizOption::class, 'course_video_quiz_question_id');
    }
}