<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\MentorAvailabilityTemplate;
use App\Models\MentoringBooking;

class MentorAvailabilitySlot extends Model
{
    use HasFactory;

    public const STATUS_AVAILABLE = 'available';
    public const STATUS_BOOKED = 'booked';
    public const STATUS_BLOCKED = 'blocked';

    protected $fillable = [
        'mentor_id',
        'mentor_availability_template_id',
        'starts_at',
        'ends_at',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'starts_at' => 'datetime',
            'ends_at' => 'datetime',
        ];
    }

    public function mentor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'mentor_id');
    }

    public function template(): BelongsTo
    {
        return $this->belongsTo(MentorAvailabilityTemplate::class, 'mentor_availability_template_id');
    }

    public function booking(): HasOne
    {
        return $this->hasOne(MentoringBooking::class);
    }

    public function isAvailable(): bool
    {
        return $this->status === self::STATUS_AVAILABLE;
    }
}