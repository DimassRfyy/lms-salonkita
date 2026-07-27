<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Str;

class RewardRedemption extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'reward_item_id',
        'points_spent',
        'status',
        'redemption_code',
        'used_at',
    ];

    protected function casts(): array
    {
        return [
            'points_spent' => 'integer',
            'used_at' => 'datetime',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (self $redemption) {
            if (! $redemption->redemption_code) {
                $redemption->redemption_code = 'RDM-' . Str::upper(Str::random(8));
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function rewardItem(): BelongsTo
    {
        return $this->belongsTo(RewardItem::class);
    }

    public function pointTransaction(): MorphOne
    {
        return $this->morphOne(PointTransaction::class, 'source');
    }
}
