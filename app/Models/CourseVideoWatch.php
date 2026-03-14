<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CourseVideoWatch extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'course_id',
        'course_video_id',
        'watched_at',
    ];

    protected function casts(): array
    {
        return [
            'watched_at' => 'datetime',
        ];
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function video(): BelongsTo
    {
        return $this->belongsTo(CourseVideo::class, 'course_video_id');
    }
}
