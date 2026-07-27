<?php

namespace App\Models;

use App\Models\PromoCode;
use App\Models\MentoringEntitlement;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

class Transaction extends Model
{
    use HasFactory;

    public const STATUS_PENDING = 'PENDING';
    public const STATUS_PAID = 'PAID';
    public const STATUS_SETTLED = 'SETTLED';
    public const STATUS_EXPIRED = 'EXPIRED';

    public const PAID_STATUSES = [
        self::STATUS_PAID,
        self::STATUS_SETTLED,
        'settlement',
        'capture',
    ];

    protected $fillable = [
        'trx_id',
        'user_id',
        'course_id',
        'promo_code_id',
        'payment_method',
        'xendit_id',
        'invoice_url',
        'status',
        'xendit_raw_response',
        'discount_amount',
        'paid_at',
        'price',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'integer',
            'discount_amount' => 'integer',
            'xendit_raw_response' => 'array',
            'paid_at' => 'datetime',
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

    public function promoCode(): BelongsTo
    {
        return $this->belongsTo(PromoCode::class);
    }

    public function mentoringEntitlement(): HasOne
    {
        return $this->hasOne(MentoringEntitlement::class);
    }

    public function isPaid(): bool
    {
        return in_array(mb_strtoupper((string) $this->status), ['PAID', 'SETTLED', 'SETTLEMENT', 'CAPTURE'], true);
    }

    public function isPending(): bool
    {
        return mb_strtoupper((string) $this->status) === 'PENDING';
    }

    public function getStatusLabelAttribute(): string
    {
        $statusUpper = mb_strtoupper((string) $this->status);

        return match ($statusUpper) {
            'PENDING' => 'Menunggu Pembayaran',
            'PAID', 'SETTLED', 'SETTLEMENT' => 'Berhasil Dibayar',
            'EXPIRED', 'EXPIRE' => 'Kedaluwarsa',
            'CANCEL', 'CANCELLED' => 'Dibatalkan',
            default => ucfirst((string) $this->status),
        };
    }

    public function getStatusBadgeClassAttribute(): string
    {
        $statusUpper = mb_strtoupper((string) $this->status);

        return match ($statusUpper) {
            'PENDING' => 'text-amber-700 bg-amber-100',
            'PAID', 'SETTLED', 'SETTLEMENT', 'CAPTURE' => 'text-emerald-700 bg-emerald-100',
            'EXPIRED', 'EXPIRE', 'CANCEL', 'CANCELLED', 'DENY', 'FAILURE' => 'text-rose-700 bg-rose-100',
            default => 'text-slate-700 bg-slate-100',
        };
    }

    public function scopePaid($query)
    {
        return $query->whereIn('status', ['PAID', 'SETTLED', 'settlement', 'capture', 'paid', 'settled']);
    }
}
