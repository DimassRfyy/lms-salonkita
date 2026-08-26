<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MentoringRequest extends Model
{
    use HasFactory;

    public const STATUS_PENDING = 'pending';
    public const STATUS_APPROVED = 'approved';
    public const STATUS_REJECTED = 'rejected';
    public const STATUS_CANCELED = 'canceled';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_TERMINATED = 'terminated';

    protected $fillable = [
        'mentoring_entitlement_id',
        'student_id',
        'mentor_id',
        'course_id',
        'status',
        'student_notes',
        'rejection_reason',
        'termination_reason',
        'reviewed_at',
        'terminated_at',
        'terminated_by',
    ];

    protected function casts(): array
    {
        return [
            'reviewed_at' => 'datetime',
            'terminated_at' => 'datetime',
        ];
    }

    public function isPending(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }

    public function isApproved(): bool
    {
        return $this->status === self::STATUS_APPROVED;
    }

    public function isRejected(): bool
    {
        return $this->status === self::STATUS_REJECTED;
    }

    public function isCanceled(): bool
    {
        return $this->status === self::STATUS_CANCELED;
    }

    public function isTerminated(): bool
    {
        return $this->status === self::STATUS_TERMINATED;
    }

    public function entitlement(): BelongsTo
    {
        return $this->belongsTo(MentoringEntitlement::class, 'mentoring_entitlement_id');
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function mentor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'mentor_id');
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
}
