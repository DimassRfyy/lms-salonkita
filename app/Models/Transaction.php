<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'trx_id',
        'user_id',
        'course_id',
        'payment_method',
        'proof_of_payment',
        'is_paid',
        'price',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'integer',
            'is_paid' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (self $transaction) {
            if ($transaction->trx_id) {
                return;
            }

            do {
                $trxId = 'TRX-' . now()->format('Ymd') . '-' . Str::upper(Str::random(6));
            } while (self::query()->where('trx_id', $trxId)->exists());

            $transaction->trx_id = $trxId;
        });
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function scopePaid($query)
    {
        return $query->where('is_paid', true);
    }
}
