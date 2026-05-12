<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function register()
    {
        return view('pages.register');
    }

    public function mentorCoachRegister(Request $request)
    {
        $role = $request->route('role', 'mentor');

        if (! in_array($role, ['mentor', 'coach'], true)) {
            abort(404);
        }

        return view('pages.register_mentor_coach', [
            'role' => $role,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'terms'    => ['accepted'],
        ], [
            'terms.accepted' => 'Kamu harus menyetujui syarat & ketentuan.',
        ]);

        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role'     => 'student',
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('dashboard');
    }

    public function storeMentorCoach(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'role' => ['required', 'in:mentor,coach'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'whatsapp_number' => ['required', 'string', 'max:30'],
            'job_title' => ['required', 'string', 'max:150'],
            'instagram_url' => ['required', 'url', 'max:1000'],
            'city' => ['required', 'string', 'max:100'],
            'country' => ['required', 'string', 'max:100'],
            'terms' => ['accepted'],
        ], [
            'terms.accepted' => 'Kamu harus menyetujui syarat & ketentuan.',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'whatsapp_number' => $validated['whatsapp_number'],
            'job_title' => $validated['job_title'],
            'instagram_url' => $validated['instagram_url'],
            'city' => $validated['city'],
            'country' => $validated['country'],
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('mentor-coach.waiting');
    }
}
