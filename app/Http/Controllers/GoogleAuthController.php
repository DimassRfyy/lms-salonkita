<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Throwable;

class GoogleAuthController extends Controller
{
    public function redirectToGoogle(Request $request): RedirectResponse
    {
        $role = $request->query('role');

        if (in_array($role, ['mentor', 'coach'], true)) {
            $request->session()->put('google_signup_role', $role);
        }

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

        $requestedRole = session()->pull('google_signup_role');

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
                'role' => in_array($requestedRole, ['mentor', 'coach'], true) ? $requestedRole : 'student',
                'provider' => 'google',
                'provider_id' => $googleId,
                'password' => Hash::make('google'),
            ]);
        } else {
            $existingAvatar = $user->avatar;
            $canSyncGoogleAvatar = ! $existingAvatar
                || str_starts_with($existingAvatar, 'http://')
                || str_starts_with($existingAvatar, 'https://');

            $user->forceFill([
                'avatar' => $canSyncGoogleAvatar
                    ? ($googleUser->getAvatar() ?: $existingAvatar)
                    : $existingAvatar,
                'role' => in_array($requestedRole, ['mentor', 'coach'], true)
                    ? $requestedRole
                    : $user->role,
                'provider' => 'google',
                'provider_id' => $googleId,
                'password' => Hash::make('google'),
            ])->save();
        }

        Auth::login($user, true);
        request()->session()->regenerate();

        $needsMentorCoachProfile = in_array($user->role, ['mentor', 'coach'], true)
            && (! filled($user->whatsapp_number)
                || ! filled($user->job_title)
                || ! filled($user->instagram_url)
                || ! filled($user->city)
                || ! filled($user->country));

        if ($needsMentorCoachProfile) {
            return redirect()->route('mentor-coach.profile');
        }

        $isNewMentorCoach = in_array($user->role, ['mentor', 'coach'], true) && ! $user->is_approved;

        if ($isNewMentorCoach) {
            return redirect()->route('mentor-coach.waiting');
        }

        $targetRoute = in_array($user->role, ['admin', 'mentor', 'coach'], true)
            ? 'filament.admin.pages.dashboard'
            : 'dashboard';

        return redirect()->intended(route($targetRoute));
    }
}
