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
                <h1 class="text-3xl font-bold text-gray-900">Atur Ulang Password</h1>
                <p class="mt-2 text-sm text-gray-500">
                    Buat kata sandi baru yang kuat dan aman untuk akun LMS SalonKita Anda.
                </p>
            </div>

            <div class="bg-white rounded-2xl shadow-md border border-pink-100 px-8 py-8">

                <!-- Form -->
                <form method="POST" action="{{ route('password.update') }}" class="space-y-5">
                    @csrf

                    <!-- Password Reset Token -->
                    <input type="hidden" name="token" value="{{ $token }}">

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-1">Email</label>
                        <input id="email" name="email" type="email"
                            value="{{ old('email', $email) }}" required
                            class="w-full px-4 py-3 bg-gray-50 border @error('email') border-red-400 @else border-gray-200 @enderror rounded-lg text-gray-900 focus:outline-none focus:ring-2 focus:ring-pink-400 focus:border-transparent transition" />
                        @error('email')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password Baru -->
                    <div x-data="{ showPassword: false }">
                        <label for="password" class="block text-sm font-semibold text-gray-700 mb-1">Password Baru</label>
                        <div class="relative">
                            <input id="password"
                                name="password"
                                :type="showPassword ? 'text' : 'password'"
                                placeholder="Minimal 8 karakter"
                                required
                                class="w-full pl-4 pr-11 py-3 bg-gray-50 border @error('password') border-red-400 @else border-gray-200 @enderror rounded-lg text-gray-900 focus:outline-none focus:ring-2 focus:ring-pink-400 focus:border-transparent transition" />
                            <button type="button"
                                @click="showPassword = !showPassword"
                                class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-gray-400 hover:text-pink-600 focus:outline-none transition"
                                aria-label="Toggle password visibility">
                                <svg x-show="!showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                <svg x-show="showPassword" x-cloak class="w-5 h-5 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                                </svg>
                            </button>
                        </div>
                        @error('password')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Konfirmasi Password Baru -->
                    <div x-data="{ showConfirmPassword: false }">
                        <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-1">Ulangi Password Baru</label>
                        <div class="relative">
                            <input id="password_confirmation"
                                name="password_confirmation"
                                :type="showConfirmPassword ? 'text' : 'password'"
                                placeholder="Ulangi password baru"
                                required
                                class="w-full pl-4 pr-11 py-3 bg-gray-50 border border-gray-200 rounded-lg text-gray-900 focus:outline-none focus:ring-2 focus:ring-pink-400 focus:border-transparent transition" />
                            <button type="button"
                                @click="showConfirmPassword = !showConfirmPassword"
                                class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-gray-400 hover:text-pink-600 focus:outline-none transition"
                                aria-label="Toggle password confirmation visibility">
                                <svg x-show="!showConfirmPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                <svg x-show="showConfirmPassword" x-cloak class="w-5 h-5 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Submit -->
                    <button type="submit"
                        class="w-full py-3 bg-pink-500 hover:bg-pink-600 text-white font-bold rounded-lg transition shadow-sm flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Simpan Password Baru
                    </button>
                </form>

                <!-- Back to Login Link -->
                <p class="text-center text-sm text-gray-500 mt-6">
                    Batal mereset password?
                    <a href="{{ route('login') }}" class="text-pink-500 font-bold hover:text-pink-600 transition">Kembali ke Login</a>
                </p>
            </div>
        </div>
    </div>
</x-layout>
