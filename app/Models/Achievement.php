<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Achievement extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'icon',
        'badge_color',
        'points_reward',
        'is_active',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'points_reward' => 'integer',
            'sort_order' => 'integer',
        ];
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function (Achievement $achievement) {
            if (blank($achievement->slug) && filled($achievement->name)) {
                $achievement->slug = Str::slug($achievement->name);
            }
        });
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'achievement_user')
            ->withPivot(['unlocked_at', 'progress_percentage', 'notes'])
            ->withTimestamps();
    }

    public function students(): BelongsToMany
    {
        return $this->users()->where('users.role', 'student');
    }
}
