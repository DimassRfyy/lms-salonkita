<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class RewardItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'points_required',
        'stock',
        'type',
        'payload',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'points_required' => 'integer',
            'stock' => 'integer',
            'payload' => 'array',
            'is_active' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (self $item) {
            if (! $item->slug) {
                $item->slug = Str::slug($item->name) . '-' . Str::random(5);
            }
        });
    }

    public function redemptions(): HasMany
    {
        return $this->hasMany(RewardRedemption::class);
    }
}
