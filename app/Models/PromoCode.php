<?php

namespace App\Models;

use App\Models\Course;
use App\Models\PromoCodeRedemption;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PromoCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'type',
        'value',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'value' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    public function getDescriptionAttribute(): string
    {
        return $this->type === 'percentage'
            ? $this->value . '%'
            : 'Rp ' . number_format((int) $this->value, 0, ',', '.');
    }

    public function courses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class, 'course_promo_code');
    }

    public function appliesToCourse(int|Course|null $course): bool
    {
        $courseId = $course instanceof Course ? $course->id : (int) $course;

        if ($this->relationLoaded('courses')) {
            if ($this->courses->isEmpty()) {
                return true;
            }

            return $courseId > 0 && $this->courses->contains('id', $courseId);
        }

        if ($this->courses()->doesntExist()) {
            return true;
        }

        return $courseId > 0 && $this->courses()->where('courses.id', $courseId)->exists();
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function redemptions(): HasMany
    {
        return $this->hasMany(PromoCodeRedemption::class);
    }
}