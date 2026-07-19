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

    public const STATUS_PENDING = 'pending';
    public const STATUS_SETTLEMENT = 'settlement';
    public const STATUS_CAPTURE = 'capture';
    public const STATUS_EXPIRE = 'expire';
    public const STATUS_CANCEL = 'cancel';
    public const STATUS_DENY = 'deny';
    public const STATUS_FAILURE = 'failure';
    public const STATUS_REFUND = 'refund';
    public const STATUS_PARTIAL_REFUND = 'partial_refund';
    public const STATUS_CHARGEBACK = 'chargeback';

    public const PAID_STATUSES = [
        self::STATUS_SETTLEMENT,
        self::STATUS_CAPTURE,
    ];

    protected $fillable = [
        'trx_id',
        'user_id',
        'course_id',
        'promo_code_id',
        'payment_method',
        'snap_token',
        'snap_redirect_url',
        'midtrans_transaction_id',
        'status',
        'midtrans_fraud_status',
        'midtrans_raw_response',
        'discount_amount',
        'paid_at',
        'price',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'integer',
            'discount_amount' => 'integer',
            'midtrans_raw_response' => 'array',
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
        return $this->status === self::STATUS_SETTLEMENT
            || ($this->status === self::STATUS_CAPTURE && $this->midtrans_fraud_status === 'accept');
    }

    public function isPending(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_PENDING => 'Menunggu Pembayaran',
            self::STATUS_SETTLEMENT => 'Berhasil Dibayar',
            self::STATUS_CAPTURE => $this->midtrans_fraud_status === 'accept'
                ? 'Berhasil Dibayar'
                : 'Capture',
            self::STATUS_EXPIRE => 'Kedaluwarsa',
            self::STATUS_CANCEL => 'Dibatalkan',
            self::STATUS_DENY => 'Ditolak',
            self::STATUS_FAILURE => 'Gagal',
            self::STATUS_REFUND => 'Refund',
            self::STATUS_PARTIAL_REFUND => 'Partial Refund',
            self::STATUS_CHARGEBACK => 'Chargeback',
            default => ucfirst((string) $this->status),
        };
    }

    public function getStatusBadgeClassAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_PENDING => 'text-amber-700 bg-amber-100',
            self::STATUS_SETTLEMENT,
            self::STATUS_CAPTURE => 'text-emerald-700 bg-emerald-100',
            self::STATUS_EXPIRE,
            self::STATUS_CANCEL,
            self::STATUS_DENY,
            self::STATUS_FAILURE => 'text-rose-700 bg-rose-100',
            self::STATUS_REFUND,
            self::STATUS_PARTIAL_REFUND,
            self::STATUS_CHARGEBACK => 'text-sky-700 bg-sky-100',
            default => 'text-slate-700 bg-slate-100',
        };
    }

    public function scopePaid($query)
    {
        return $query->where(function ($query): void {
            $query->where('status', self::STATUS_SETTLEMENT)
                ->orWhere(function ($query): void {
                    $query->where('status', self::STATUS_CAPTURE)
                        ->where('midtrans_fraud_status', 'accept');
                });
        });
    }
}
