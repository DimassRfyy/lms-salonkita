<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class PointTransaction extends Model
{
    use HasFactory;

    public const TYPE_EARN = 'EARN';
    public const TYPE_REDEEM = 'REDEEM';
    public const TYPE_EXPIRE = 'EXPIRE';
    public const TYPE_ADJUSTMENT = 'ADJUSTMENT';

    protected $fillable = [
        'user_id',
        'type',
        'amount',
        'balance_after',
        'source_type',
        'source_id',
        'description',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'integer',
            'balance_after' => 'integer',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function source(): MorphTo
    {
        return $this->morphTo();
    }
}
