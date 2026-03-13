<?php

namespace App\Models;

use App\Models\CourseDiscussion;
use App\Models\CourseKeypoint;
use App\Models\CourseReview;
use App\Models\CourseSection;
use App\Models\CourseTaskSubmission;
use App\Models\CourseVideo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'thumbnail',
        'description',
        'category_id',
        'user_id',
        'price',
        'rating',
        'is_published',
        'introduction_video_url',
    ];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'rating' => 'decimal:2',
        ];
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function instructor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function sections(): HasMany
    {
        return $this->hasMany(CourseSection::class)->orderBy('created_at');
    }

    public function videos(): HasManyThrough
    {
        return $this->hasManyThrough(
            CourseVideo::class,
            CourseSection::class,
            'course_id',
            'course_section_id'
        );
    }

    public function getDurationLabelAttribute(): string
    {
        $durationSeconds = (int) ($this->total_duration_seconds ?? 0);

        if ($durationSeconds <= 0) {
            return 'Durasi belum tersedia';
        }

        $hours = intdiv($durationSeconds, 3600);
        $minutes = intdiv($durationSeconds % 3600, 60);

        return trim(($hours > 0 ? $hours . ' Jam ' : '') . max($minutes, 1) . ' Menit');
    }

    public function getRatingLabelAttribute(): string
    {
        return number_format((float) $this->rating, 1);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(CourseReview::class);
    }

    public function discussions(): HasMany
    {
        return $this->hasMany(CourseDiscussion::class);
    }

    public function keypoints(): HasMany
    {
        return $this->hasMany(CourseKeypoint::class)->orderBy('created_at');
    }

    public function taskSubmissions(): HasMany
    {
        return $this->hasMany(CourseTaskSubmission::class)->orderBy('created_at');
    }
}
