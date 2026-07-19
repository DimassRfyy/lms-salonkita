<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\CourseTaskSubmission;
use App\Models\CourseVideoQuizCompletion;
use App\Models\CourseVideoWatch;
use App\Models\MentorAvailabilitySlot;
use App\Models\MentorAvailabilityTemplate;
use App\Models\MentorUnavailabilityException;
use App\Models\MentoringBooking;
use App\Models\MentoringEntitlement;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'avatar',
        'whatsapp_number',
        'birth_date',
        'city',
        'country',
        'job_title',
        'bio',
        'instagram_url',
        'tiktok_url',
        'youtube_url',
        'role',
        'is_approved',
        'provider',
        'provider_id',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'birth_date' => 'date',
            'password' => 'hashed',
            'is_approved' => 'boolean',
        ];
    }

    public function getAvatarUrlAttribute(): ?string
    {
        if (! $this->avatar) {
            return null;
        }

        if (str_starts_with($this->avatar, 'http://') || str_starts_with($this->avatar, 'https://')) {
            return $this->avatar;
        }

        return Storage::url($this->avatar);
    }

    public function courses(): HasMany
    {
        return $this->hasMany(Course::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function ownedCourses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class, 'course_user')
            ->withTimestamps();
    }

    public function savedCourses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class, 'saved_courses')
            ->withTimestamps();
    }

    public function courseReviews(): HasMany
    {
        return $this->hasMany(CourseReview::class);
    }

    public function courseDiscussions(): HasMany
    {
        return $this->hasMany(CourseDiscussion::class);
    }

    public function courseTaskSubmissions(): HasMany
    {
        return $this->hasMany(CourseTaskSubmission::class);
    }

    public function courseVideoWatches(): HasMany
    {
        return $this->hasMany(CourseVideoWatch::class);
    }

    public function courseVideoQuizCompletions(): HasMany
    {
        return $this->hasMany(CourseVideoQuizCompletion::class);
    }

    public function mentoringEntitlements(): HasMany
    {
        return $this->hasMany(MentoringEntitlement::class, 'student_id');
    }

    public function availableMentoringEntitlements(): HasMany
    {
        return $this->mentoringEntitlements()
            ->where('status', 'active')
            ->whereColumn('used_quota', '<', 'total_quota');
    }

    public function mentorAvailabilityTemplates(): HasMany
    {
        return $this->hasMany(MentorAvailabilityTemplate::class, 'mentor_id');
    }

    public function mentorAvailabilitySlots(): HasMany
    {
        return $this->hasMany(MentorAvailabilitySlot::class, 'mentor_id');
    }

    public function mentoringBookingsAsMentor(): HasMany
    {
        return $this->hasMany(MentoringBooking::class, 'mentor_id');
    }

    public function mentoringBookingsAsStudent(): HasMany
    {
        return $this->hasMany(MentoringBooking::class, 'student_id');
    }

    public function mentorUnavailabilityExceptions(): HasMany
    {
        return $this->hasMany(MentorUnavailabilityException::class, 'mentor_id');
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return match ($this->role) {
            'admin' => true,
            'mentor', 'coach' => (bool) $this->is_approved,
            default => false,
        };
    }
}
