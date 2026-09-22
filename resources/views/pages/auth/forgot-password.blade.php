<x-layout>
    <div
        class="min-h-screen bg-gradient-to-br from-pink-50 via-white to-pink-50 flex flex-col justify-center py-12 px-4 sm:px-6 lg:px-8">

        <!-- Back to Login -->
        <div class="absolute top-6 left-6">
            <a href="{{ route('login') }}"
                class="flex items-center gap-2 text-gray-500 hover:text-pink-500 transition text-sm font-medium">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Kembali ke Login
            </a>
        </div>

        <!-- Card -->
        <div class="mx-auto w-full max-w-md">

            <!-- Logo + Heading -->
            <div class="text-center mb-8">
                <a href="/" class="inline-flex justify-center mb-4">
                    <img src="{{ asset('assets/images/logos/logo_skid.webp') }}" alt="Salonkita Logo"
                        class="w-20 h-20 object-contain">
                </a>
                <h1 class="text-3xl font-bold text-gray-900">Lupa Password?</h1>
                <p class="mt-2 text-sm text-gray-500">
                    Jangan khawatir! Masukkan alamat email akun Anda, kami akan mengirimkan tautan untuk mengatur ulang kata sandi.
                </p>
            </div>

            <div class="bg-white rounded-2xl shadow-md border border-pink-100 px-8 py-8">

                <!-- Success Alert -->
                @if (session('status'))
                    <div class="mb-6 p-4 rounded-xl bg-green-50 border border-green-200 text-green-800 text-sm flex items-start gap-3">
                        <svg class="w-5 h-5 text-green-600 shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <div>
                            <p class="font-semibold text-green-900">Email Terkirim</p>
                            <p class="mt-0.5">{{ session('status') }}</p>
                        </div>
                    </div>
                @endif

                <!-- Form -->
                <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
                    @csrf

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-1">Email Terdaftar</label>
                        <input id="email" name="email" type="email" placeholder="nama@email.com"
                            value="{{ old('email') }}" required autofocus
                            class="w-full px-4 py-3 bg-gray-50 border @error('email') border-red-400 @else border-gray-200 @enderror rounded-lg text-gray-900 focus:outline-none focus:ring-2 focus:ring-pink-400 focus:border-transparent transition" />
                        @error('email')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit -->
                    <button type="submit"
                        class="w-full py-3 bg-pink-500 hover:bg-pink-600 text-white font-bold rounded-lg transition shadow-sm flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        Kirim Tautan Reset Password
                    </button>
                </form>

                <!-- Back to Login Link -->
                <p class="text-center text-sm text-gray-500 mt-6">
                    Sudah ingat kata sandi Anda?
                    <a href="{{ route('login') }}" class="text-pink-500 font-bold hover:text-pink-600 transition">Masuk kembali</a>
                </p>
            </div>
        </div>
    </div>
</x-layout>
