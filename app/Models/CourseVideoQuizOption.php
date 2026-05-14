<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\CourseVideoQuizQuestion;

class CourseVideoQuizOption extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_video_quiz_question_id',
        'option_text',
        'is_correct',
    ];

    protected function casts(): array
    {
        return [
            'is_correct' => 'boolean',
        ];
    }

    public function question(): BelongsTo
    {
        return $this->belongsTo(CourseVideoQuizQuestion::class, 'course_video_quiz_question_id');
    }
}