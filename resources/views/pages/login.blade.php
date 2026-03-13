<x-layout>
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

        <!-- Card -->
        <div class="mx-auto w-full max-w-md">

            <!-- Logo + Heading -->
            <div class="text-center mb-8">
                <a href="/" class="inline-flex justify-center mb-4">
                    <img src="{{ asset('assets/images/logos/logo_skid.webp') }}" alt="Salonkita Logo"
                        class="w-20 h-20 object-contain">
                </a>
                <h1 class="text-3xl font-bold text-gray-900">Masuk ke Akun</h1>
                <p class="mt-2 text-sm text-gray-500">Selamat datang kembali! Masuk ke akun kamu.</p>
            </div>

            <div class="bg-white rounded-2xl shadow-md border border-pink-100 px-8 py-8">

                <!-- Google Login -->
                <button
                    class="w-full flex items-center justify-center gap-3 px-4 py-3 border-2 border-gray-200 rounded-lg text-gray-700 font-semibold hover:border-pink-300 hover:bg-pink-50 transition mb-6">
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
                    Masuk dengan Google
                </button>

                <!-- Divider -->
                <div class="relative mb-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-200"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-3 bg-white text-gray-400">atau masuk dengan email</span>
                    </div>
                </div>

                <!-- Form -->
                <form method="POST" action="{{ route('login.post') }}" class="space-y-5">
                    @csrf

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-1">Email</label>
                        <input id="email" name="email" type="email" placeholder="nama@email.com"
                            value="{{ old('email') }}"
                            class="w-full px-4 py-3 bg-gray-50 border @error('email') border-red-400 @else border-gray-200 @enderror rounded-lg text-gray-900 focus:outline-none focus:ring-2 focus:ring-pink-400 focus:border-transparent transition" />
                        @error('email')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <div class="flex justify-between items-center mb-1">
                            <label for="password" class="block text-sm font-semibold text-gray-700">Password</label>
                            <a href="#" class="text-xs text-pink-500 hover:text-pink-600 font-medium">Lupa password?</a>
                        </div>
                        <input id="password" name="password" type="password" placeholder="Masukkan password"
                            class="w-full px-4 py-3 bg-gray-50 border @error('password') border-red-400 @else border-gray-200 @enderror rounded-lg text-gray-900 focus:outline-none focus:ring-2 focus:ring-pink-400 focus:border-transparent transition" />
                        @error('password')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit -->
                    <button type="submit"
                        class="w-full py-3 bg-pink-500 hover:bg-pink-600 text-white font-bold rounded-lg transition shadow-sm">
                        Masuk
                    </button>
                </form>

                <!-- Register Link -->
                <p class="text-center text-sm text-gray-500 mt-6">
                    Belum punya akun?
                    <a href="/register" class="text-pink-500 font-bold hover:text-pink-600 transition">Daftar
                        sekarang</a>
                </p>
            </div>
        </div>
    </div>
</x-layout>