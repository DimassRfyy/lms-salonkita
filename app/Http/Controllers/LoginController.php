<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login()
    {
        return view('pages.login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();

            if (in_array($user?->role, ['mentor', 'coach'], true)) {
                $hasCompleteMentorProfile = filled($user->whatsapp_number)
                    && filled($user->job_title)
                    && filled($user->instagram_url)
                    && filled($user->city)
                    && filled($user->country);

                if (! $hasCompleteMentorProfile) {
                    return redirect()->route('mentor-coach.profile');
                }

                if (! $user->is_approved) {
                    return redirect()->route('mentor-coach.waiting');
                }

                return redirect()->intended(route('filament.admin.pages.dashboard'));
            }

            $targetRoute = in_array($user?->role, ['admin'], true)
                ? 'filament.admin.pages.dashboard'
                : 'dashboard';

            return redirect()->intended(route($targetRoute));
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }
}
