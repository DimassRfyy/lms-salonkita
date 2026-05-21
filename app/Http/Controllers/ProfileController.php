<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use SweetAlert2\Laravel\Swal;

class ProfileController extends Controller
{
    public function mentorCoachProfile(Request $request)
    {
        if (! in_array($request->user()->role, ['mentor', 'coach'], true)) {
            abort(403);
        }

        return view('pages.register_mentor_coach', [
            'role' => $request->user()->role === 'coach' ? 'coach' : 'mentor',
            'user' => $request->user(),
        ]);
    }

    public function mentorCoachWaiting(Request $request)
    {
        if (! in_array($request->user()->role, ['mentor', 'coach'], true)) {
            abort(403);
        }

        return view('pages.mentor_coach_waiting', [
            'user' => $request->user(),
        ]);
    }

    public function edit(Request $request)
    {
        $user = $request->user();
        $ownedCourses = $user->ownedCourses()
            ->with('category')
            ->withSum('videos as total_duration_seconds', 'duration_seconds')
            ->orderByPivot('created_at', 'desc')
            ->take(8)
            ->get();

        return view('pages.profile', compact('user', 'ownedCourses'));
    }

    public function update(Request $request)
    {
        $user = $request->user();
        $isMentorCoachCompletion = $request->routeIs('mentor-coach.profile.update');

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'avatar' => ['nullable', 'image', 'max:2048'],
            'whatsapp_number' => [$isMentorCoachCompletion ? 'required' : 'nullable', 'string', 'max:30'],
            'birth_date' => ['nullable', 'date'],
            'city' => [$isMentorCoachCompletion ? 'required' : 'nullable', 'string', 'max:100'],
            'country' => [$isMentorCoachCompletion ? 'required' : 'nullable', 'string', 'max:100'],
            'job_title' => [$isMentorCoachCompletion ? 'required' : 'nullable', 'string', 'max:150'],
            'bio' => ['nullable', 'string', 'max:1000'],
            'instagram_url' => [$isMentorCoachCompletion ? 'required' : 'nullable', 'url', 'max:1000'],
            'tiktok_url' => ['nullable', 'url', 'max:1000'],
            'youtube_url' => ['nullable', 'url', 'max:1000'],
        ], [
            'whatsapp_number.required' => 'No WhatsApp wajib diisi untuk mentor/coach.',
            'job_title.required' => 'Job title wajib diisi untuk mentor/coach.',
            'instagram_url.required' => 'Instagram URL wajib diisi untuk mentor/coach.',
            'city.required' => 'City wajib diisi untuk mentor/coach.',
            'country.required' => 'Country wajib diisi untuk mentor/coach.',
        ]);

        if ($request->hasFile('avatar')) {
            if ($user->avatar && ! str_starts_with($user->avatar, 'http://') && ! str_starts_with($user->avatar, 'https://')) {
                Storage::disk('public')->delete($user->avatar);
            }

            $validated['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        try {
            $user->fill($validated);
            $user->save();

            if ($isMentorCoachCompletion) {
                Swal::toastSuccess([
                    'title' => 'Profil berhasil disimpan. Tunggu persetujuan admin.',
                    'position' => 'top-end',
                    'showConfirmButton' => false,
                    'timer' => 3000,
                    'timerProgressBar' => true,
                    'didOpen' => '(toast) => { toast.onmouseenter = Swal.stopTimer; toast.onmouseleave = Swal.resumeTimer; }',
                ]);

                return redirect()->route('mentor-coach.waiting');
            }

            Swal::toastSuccess([
                'title' => 'Profil berhasil diperbarui.',
                'position' => 'top-end',
                'showConfirmButton' => false,
                'timer' => 3000,
                'timerProgressBar' => true,
                'didOpen' => '(toast) => { toast.onmouseenter = Swal.stopTimer; toast.onmouseleave = Swal.resumeTimer; }',
            ]);

            return redirect()->route('profile');
        } catch (\Throwable $throwable) {
            report($throwable);

            Swal::toastError([
                'title' => 'Gagal memperbarui profil. Silakan coba lagi.',
                'position' => 'top-end',
                'showConfirmButton' => false,
                'timer' => 3000,
                'timerProgressBar' => true,
                'didOpen' => '(toast) => { toast.onmouseenter = Swal.stopTimer; toast.onmouseleave = Swal.resumeTimer; }',
            ]);

            return back()->withInput();
        }
    }

    public function destroy(Request $request)
    {
        $user = $request->user();

        Auth::logout();
        DB::table('users')->where('id', $user->id)->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}