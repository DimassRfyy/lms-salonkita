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

    public function getDurationLabelAttribute(): string
    {
        $seconds = max(0, (int) $this->duration_seconds);
        $minutes = intdiv($seconds, 60);
        $remainingSeconds = $seconds % 60;

        return sprintf('%02d:%02d', $minutes, $remainingSeconds);
    }
}
