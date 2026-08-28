<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CourseSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'title',
        'sort_order',
    ];

    protected static function booted(): void
    {
        static::creating(function (CourseSection $section) {
            if (blank($section->sort_order) || (int) $section->sort_order === 0) {
                $maxOrder = (int) (static::where('course_id', $section->course_id)->max('sort_order') ?? 0);
                $section->sort_order = $maxOrder + 1;
            }
        });
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function videos(): HasMany
    {
        return $this->hasMany(CourseVideo::class)->orderBy('sort_order')->orderBy('id');
    }
}
