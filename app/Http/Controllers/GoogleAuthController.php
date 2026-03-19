<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Throwable;

class GoogleAuthController extends Controller
{
    public function redirectToGoogle(): RedirectResponse
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback(): RedirectResponse
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (Throwable $th) {
            return redirect()->route('login')->withErrors([
                'email' => 'Login Google gagal. Coba lagi beberapa saat.',
            ]);
        }

        $email = $googleUser->getEmail();
        $googleId = $googleUser->getId();

        if (! $email || ! $googleId) {
            return redirect()->route('login')->withErrors([
                'email' => 'Akun Google tidak memiliki data yang valid.',
            ]);
        }

        $user = User::query()
            ->where('provider', 'google')
            ->where('provider_id', $googleId)
            ->first();

        if (! $user) {
            $user = User::query()->where('email', $email)->first();
        }

        if (! $user) {
            $user = User::query()->create([
                'name' => $googleUser->getName() ?: 'User Google',
                'email' => $email,
                'avatar' => $googleUser->getAvatar(),
                'role' => 'student',
                'provider' => 'google',
                'provider_id' => $googleId,
                'password' => Hash::make('google'),
            ]);
        } else {
            $user->forceFill([
                'avatar' => $googleUser->getAvatar() ?: $user->avatar,
                'provider' => 'google',
                'provider_id' => $googleId,
                'password' => Hash::make('google'),
            ])->save();
        }

        Auth::login($user, true);
        request()->session()->regenerate();

        $targetRoute = in_array($user->role, ['admin', 'mentor', 'coach'], true)
            ? 'filament.admin.pages.dashboard'
            : 'dashboard';

        return redirect()->intended(route($targetRoute));
    }
}
