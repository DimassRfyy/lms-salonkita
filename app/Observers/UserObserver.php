<?php

namespace App\Observers;

use App\Mail\MentorCoachApprovedMail;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        // Jika akun mentor/coach langsung dibuat dalam kondisi approved
        if ($user->is_approved && in_array($user->role, ['mentor', 'coach'], true)) {
            $this->sendApprovalNotification($user);
        }
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        // Periksa apakah status is_approved baru saja diubah menjadi true untuk role mentor/coach
        if ($user->wasChanged('is_approved') && $user->is_approved && in_array($user->role, ['mentor', 'coach'], true)) {
            $this->sendApprovalNotification($user);
        }
    }

    /**
     * Kirim email notifikasi persetujuan akun mentor/coach.
     */
    protected function sendApprovalNotification(User $user): void
    {
        try {
            Mail::to($user->email)->send(new MentorCoachApprovedMail($user));
            Log::info("Email notifikasi approval {$user->role} berhasil dikirim ke: {$user->email}");
        } catch (\Throwable $e) {
            Log::error("Gagal mengirim email notifikasi approval ke {$user->email}: " . $e->getMessage());
        }
    }
}
