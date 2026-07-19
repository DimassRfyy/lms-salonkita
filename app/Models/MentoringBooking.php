<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\MentorAvailabilitySlot;
use App\Models\MentoringEntitlement;

class MentoringBooking extends Model
{
    use HasFactory;

    public const STATUS_CONFIRMED = 'confirmed';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_CANCELED = 'canceled';
    public const STATUS_NO_SHOW = 'no_show';

    protected $fillable = [
        'mentoring_entitlement_id',
        'mentor_id',
        'student_id',
        'course_id',
        'mentor_availability_slot_id',
        'starts_at',
        'ends_at',
        'status',
        'meeting_platform',
        'meeting_url',
        'notes',
        'booked_at',
        'canceled_at',
        'completed_at',
    ];

    protected function casts(): array
    {
        return [
            'starts_at' => 'datetime',
            'ends_at' => 'datetime',
            'booked_at' => 'datetime',
            'canceled_at' => 'datetime',
            'completed_at' => 'datetime',
        ];
    }

    public function entitlement(): BelongsTo
    {
        return $this->belongsTo(MentoringEntitlement::class, 'mentoring_entitlement_id');
    }

    public function mentor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'mentor_id');
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function slot(): BelongsTo
    {
        return $this->belongsTo(MentorAvailabilitySlot::class, 'mentor_availability_slot_id');
    }
}