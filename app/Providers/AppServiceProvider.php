<?php

namespace App\Providers;

use App\Http\Responses\LogoutResponse;
use App\Models\User;
use App\Observers\UserObserver;
use Filament\Auth\Http\Responses\Contracts\LogoutResponse as LogoutResponseContract;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(LogoutResponseContract::class, LogoutResponse::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        User::observe(UserObserver::class);

        ResetPassword::toMailUsing(function (object $notifiable, string $token) {
            $url = url(route('password.reset', [
                'token' => $token,
                'email' => $notifiable->getEmailForPasswordReset(),
            ], false));

            return (new MailMessage)
                ->subject('Permintaan Reset Password - LMS SalonKita')
                ->greeting('Halo ' . ($notifiable->name ?? 'Pengguna SalonKita') . '!')
                ->line('Kami menerima permintaan untuk mengatur ulang kata sandi akun LMS SalonKita Anda.')
                ->action('Atur Ulang Password', $url)
                ->line('Tautan reset password ini hanya berlaku selama 60 menit.')
                ->line('Jika Anda tidak meminta perubahan kata sandi, abaikan email ini. Akun Anda tetap aman.')
                ->salutation("Salam hangat,\nTim LMS SalonKita");
        });
    }
}
