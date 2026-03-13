<?php

namespace App\Models;

use App\Models\CourseDiscussion;
use App\Models\CourseKeypoint;
use App\Models\CourseReview;
use App\Models\CourseSection;
use App\Models\CourseTaskSubmission;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
