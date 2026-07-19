<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\MentoringBooking;

class MentoringEntitlement extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id',
        'student_id',
        'course_id',
        'total_quota',
        'used_quota',
        'status',
        'granted_at',
        'expires_at',
    ];

    protected function casts(): array
    {
        return [
            'total_quota' => 'integer',
            'used_quota' => 'integer',
            'granted_at' => 'datetime',
            'expires_at' => 'datetime',
        ];
    }

    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class);
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function booking(): HasOne
    {
        return $this->hasOne(MentoringBooking::class);
    }
}