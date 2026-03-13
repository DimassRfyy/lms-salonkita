<?php

namespace App\Models;

use App\Models\CourseSection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CourseVideo extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_section_id',
        'title',
        'video_url',
        'duration_seconds',
    ];

    public function section(): BelongsTo
    {
        return $this->belongsTo(CourseSection::class, 'course_section_id');
    }
}
