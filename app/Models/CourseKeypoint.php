<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CourseKeypoint extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'point',
        'sort_order',
    ];

    protected static function booted(): void
    {
        static::creating(function (CourseKeypoint $keypoint) {
            if (blank($keypoint->sort_order) || (int) $keypoint->sort_order === 0) {
                $maxOrder = (int) (static::where('course_id', $keypoint->course_id)->max('sort_order') ?? 0);
                $keypoint->sort_order = $maxOrder + 1;
            }
        });
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
}
