<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password as PasswordRule;

class PasswordResetController extends Controller
{
    /**
     * Tampilkan formulir permintaan link reset password (Lupa Password).
     */
    public function create()
    {
        return view('pages.auth.forgot-password');
    }

    /**
     * Kirim email berisi link token reset password kepada pengguna.
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email'    => 'Format email tidak valid.',
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT) {
            return back()->with('status', 'Tautan untuk mereset kata sandi telah dikirim ke email Anda.');
        }

        return back()->withErrors([
            'email' => 'Kami tidak dapat menemukan pengguna dengan alamat email tersebut.',
        ]);
    }

    /**
     * Tampilkan formulir pembuatan password baru dengan token verifikasi.
     */
    public function edit(Request $request, string $token)
    {
        return view('pages.auth.reset-password', [
            'token' => $token,
            'email' => $request->query('email', ''),
        ]);
    }

    /**
     * Simpan password baru setelah token dan email divalidasi.
     */
    public function update(Request $request)
    {
        $request->validate([
            'token'    => ['required'],
            'email'    => ['required', 'email'],
            'password' => ['required', 'confirmed', PasswordRule::min(8)],
        ], [
            'token.required'     => 'Token reset password tidak valid.',
            'email.required'     => 'Email wajib diisi.',
            'email.email'        => 'Format email tidak valid.',
            'password.required'  => 'Password baru wajib diisi.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min'       => 'Password minimal harus 8 karakter.',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password'       => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('login')->with('status', 'Password Anda berhasil diperbarui! Silakan masuk dengan password baru.');
        }

        return back()->withErrors([
            'email' => 'Tautan reset password ini tidak valid atau sudah kedaluwarsa. Silakan minta tautan baru.',
        ]);
    }
}
