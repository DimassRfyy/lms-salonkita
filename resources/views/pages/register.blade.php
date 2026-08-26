<x-layout>
    @php
        $nameInputClass = 'w-full px-4 py-3 bg-gray-50 border rounded-xl text-gray-900 focus:outline-none focus:ring-2 focus:ring-pink-400 transition ' . ($errors->has('name') ? 'border-red-400' : 'border-gray-200');
        $emailInputClass = 'w-full px-4 py-3 bg-gray-50 border rounded-xl text-gray-900 focus:outline-none focus:ring-2 focus:ring-pink-400 transition ' . ($errors->has('email') ? 'border-red-400' : 'border-gray-200');
        $passwordInputClass = 'w-full px-4 py-3 bg-gray-50 border rounded-xl text-gray-900 focus:outline-none focus:ring-2 focus:ring-pink-400 transition ' . ($errors->has('password') ? 'border-red-400' : 'border-gray-200');
    @endphp
    <div
        class="min-h-screen bg-gradient-to-br from-pink-50 via-white to-pink-50 flex flex-col justify-center py-12 px-4 sm:px-6 lg:px-8">

        <!-- Back to Home -->
        <div class="absolute top-6 left-6">
            <a href="/"
                class="flex items-center gap-2 text-gray-500 hover:text-pink-500 transition text-sm font-medium">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Kembali ke Beranda
            </a>
        </div>

        <!-- Card Container -->
        <div class="mx-auto w-full max-w-md">

            <!-- Logo + Heading -->
            <div class="text-center mb-6">
                <a href="/" class="inline-flex justify-center mb-3">
                    <img src="{{ asset('assets/images/logos/logo_skid.webp') }}" alt="Salonkita Logo"
                        class="w-16 h-16 sm:w-20 sm:h-20 object-contain">
                </a>
                
                <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight">Daftar sebagai Siswa</h1>
                <p class="mt-1.5 text-xs sm:text-sm text-gray-500 max-w-xs mx-auto">
                    Mulai belajar skill kecantikan, ikuti kelas video, kuis, dan raih sertifikat resmi.
                </p>
            </div>

            <div class="bg-white rounded-3xl shadow-lg border border-pink-100 px-6 sm:px-8 py-7 sm:py-8">

                <!-- Role Switcher Tabs -->
                <div class="p-1 bg-gray-100/90 rounded-2xl flex items-center gap-1 mb-6 border border-gray-200/50">
                    <div class="flex-1 py-2 px-2.5 rounded-xl text-center text-xs font-bold transition flex items-center justify-center gap-1.5 bg-white text-pink-600 shadow-sm border border-pink-100">
                        <svg class="w-3.5 h-3.5 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222" />
                        </svg>
                        <span>Siswa</span>
                    </div>
                    <a href="{{ route('register.mentor-coach', ['role' => 'mentor']) }}"
                        class="flex-1 py-2 px-2.5 rounded-xl text-center text-xs font-semibold transition flex items-center justify-center gap-1.5 text-gray-500 hover:text-pink-600 hover:bg-white/70">
                        <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        <span>Mentor</span>
                    </a>
                    <a href="{{ route('register.mentor-coach', ['role' => 'coach']) }}"
                        class="flex-1 py-2 px-2.5 rounded-xl text-center text-xs font-semibold transition flex items-center justify-center gap-1.5 text-gray-500 hover:text-pink-600 hover:bg-white/70">
                        <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                        <span>Coach</span>
                    </a>
                </div>

                <!-- Google Register -->
                <a href="{{ route('google.redirect') }}"
                    class="w-full flex items-center justify-center gap-3 px-4 py-3 border-2 border-gray-200 rounded-xl text-gray-700 font-semibold hover:border-pink-300 hover:bg-pink-50/50 transition mb-6 shadow-2xs">
                    <svg class="w-5 h-5" viewBox="0 0 24 24">
                        <path fill="#4285F4"
                            d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" />
                        <path fill="#34A853"
                            d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" />
                        <path fill="#FBBC05"
                            d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l3.66-2.84z" />
                        <path fill="#EA4335"
                            d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" />
                    </svg>
                    <span>Daftar Siswa dengan Google</span>
                </a>

                <!-- Divider -->
                <div class="relative mb-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-200"></div>
                    </div>
                    <div class="relative flex justify-center text-xs uppercase tracking-wider font-semibold">
                        <span class="px-3 bg-white text-gray-400">atau daftar siswa dengan email</span>
                    </div>
                </div>

                <!-- Form -->
                <form method="POST" action="{{ route('register.post') }}" class="space-y-4">
                    @csrf

                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-semibold text-gray-700 mb-1">Nama Lengkap</label>
                        <input id="name" name="name" type="text" placeholder="Nama lengkap kamu"
                            value="{{ old('name') }}" class="{{ $nameInputClass }}" />
                        @error('name')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-1">Email</label>
                        <input id="email" name="email" type="email" placeholder="nama@email.com"
                            value="{{ old('email') }}" class="{{ $emailInputClass }}" />
                        @error('email')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-semibold text-gray-700 mb-1">Password</label>
                        <input id="password" name="password" type="password" placeholder="Minimal 8 karakter"
                            class="{{ $passwordInputClass }}" />
                        @error('password')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label for="password_confirmation"
                            class="block text-sm font-semibold text-gray-700 mb-1">Konfirmasi Password</label>
                        <input id="password_confirmation" name="password_confirmation" type="password"
                            placeholder="Ulangi password kamu"
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 focus:outline-none focus:ring-2 focus:ring-pink-400 focus:border-transparent transition" />
                    </div>

                    <!-- Terms -->
                    <div class="flex items-start gap-2.5 pt-1">
                        <input id="terms" name="terms" type="checkbox"
                            class="mt-1 w-4 h-4 accent-pink-500 rounded border-gray-300 cursor-pointer shrink-0" />
                        <label for="terms" class="text-xs text-gray-500 leading-relaxed">
                            Saya menyetujui
                            <a href="#" class="text-pink-500 font-semibold hover:text-pink-600">Syarat & Ketentuan</a>
                            serta
                            <a href="#" class="text-pink-500 font-semibold hover:text-pink-600">Kebijakan Privasi</a>
                            Salonkita.
                        </label>
                    </div>
                    @error('terms')
                        <p class="text-xs text-red-500">{{ $message }}</p>
                    @enderror

                    <!-- Submit -->
                    <button type="submit"
                        class="w-full py-3.5 bg-gradient-to-r from-pink-500 to-rose-500 hover:from-pink-600 hover:to-rose-600 text-white font-bold rounded-xl transition shadow-md hover:shadow-lg flex items-center justify-center gap-2 mt-2">
                        <span>Daftar sebagai Siswa</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </button>
                </form>

                <!-- Login Link -->
                <p class="text-center text-xs sm:text-sm text-gray-500 mt-6">
                    Sudah punya akun?
                    <a href="/login" class="text-pink-500 font-bold hover:text-pink-600 transition underline decoration-pink-300 underline-offset-2">Masuk di sini</a>
                </p>
            </div>
        </div>
    </div>
</x-layout>