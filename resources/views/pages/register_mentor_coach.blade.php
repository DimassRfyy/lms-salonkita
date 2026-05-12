<x-layout>
    @php
        $isAuthenticated = auth()->check();
        $currentUser = $user ?? auth()->user();
        $selectedRole = old('role', $role ?? ($currentUser->role ?? 'mentor'));
        $isCoach = $selectedRole === 'coach';
        $pageTitle = $isAuthenticated ? 'Lengkapi Profil Mentor/Coach' : 'Daftar sebagai ' . ucfirst($selectedRole);
        $pageSubtitle = $isAuthenticated
            ? 'Lengkapi data kontak dan sosial agar akun mentor/coach kamu siap digunakan.'
            : 'Buat akun mentor/coach dan isi data yang dibutuhkan sejak awal.';
        $googleUrl = route('google.redirect', ['role' => $selectedRole]);
        $formAction = $isAuthenticated ? route('mentor-coach.profile.update') : route('register.mentor-coach.store');
    @endphp

    <div
        class="min-h-screen bg-linear-to-br from-pink-50 via-white to-rose-50 flex flex-col justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="absolute top-6 left-6">
            <a href="/"
                class="flex items-center gap-2 text-gray-500 hover:text-pink-500 transition text-sm font-medium">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Kembali ke Beranda
            </a>
        </div>

        <div class="mx-auto w-full max-w-2xl">
            <div class="text-center mb-8">
                <a href="/" class="inline-flex justify-center mb-4">
                    <img src="{{ asset('assets/images/logos/logo_skid.webp') }}" alt="Salonkita Logo"
                        class="w-20 h-20 object-contain">
                </a>
                <h1 class="text-3xl font-bold text-gray-900">{{ $pageTitle }}</h1>
                <p class="mt-2 text-sm text-gray-500">{{ $pageSubtitle }}</p>
            </div>

            <div class="bg-white rounded-3xl shadow-lg border border-pink-100 p-6 sm:p-8">
                @unless($isAuthenticated)
                    <div class="grid gap-3 sm:grid-cols-2 mb-6">
                        <a href="{{ route('register.mentor-coach', ['role' => 'mentor']) }}"
                            class="rounded-2xl border px-4 py-3 text-center font-semibold transition {{ $isCoach ? 'border-gray-200 bg-white text-gray-600 hover:border-pink-300 hover:text-pink-600' : 'border-pink-500 bg-pink-50 text-pink-700' }}">
                            Daftar sebagai Mentor
                        </a>
                        <a href="{{ route('register.mentor-coach', ['role' => 'coach']) }}"
                            class="rounded-2xl border px-4 py-3 text-center font-semibold transition {{ $isCoach ? 'border-pink-500 bg-pink-50 text-pink-700' : 'border-gray-200 bg-white text-gray-600 hover:border-pink-300 hover:text-pink-600' }}">
                            Daftar sebagai Coach
                        </a>
                    </div>
                @endunless

                <a href="{{ $googleUrl }}"
                    class="mb-6 flex w-full items-center justify-center gap-3 rounded-2xl border-2 border-gray-200 px-4 py-3 font-semibold text-gray-700 transition hover:border-pink-300 hover:bg-pink-50">
                    <svg class="h-5 w-5" viewBox="0 0 24 24">
                        <path fill="#4285F4"
                            d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" />
                        <path fill="#34A853"
                            d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" />
                        <path fill="#FBBC05"
                            d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l3.66-2.84z" />
                        <path fill="#EA4335"
                            d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" />
                    </svg>
                    {{ $isAuthenticated ? 'Lanjutkan dengan Google' : 'Daftar dengan Google' }}
                </a>

                <div class="relative mb-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-200"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-3 bg-white text-gray-400">atau
                            {{ $isAuthenticated ? 'lengkapi profil' : 'daftar dengan email' }}</span>
                    </div>
                </div>

                <form method="POST" action="{{ $formAction }}" class="space-y-5">
                    @csrf
                    @unless($isAuthenticated)
                        <input type="hidden" name="role" value="{{ $selectedRole }}">
                    @endunless

                    <div class="grid gap-5 md:grid-cols-2">
                        <div>
                            <label for="name" class="mb-1 block text-sm font-semibold text-gray-700">Nama
                                Lengkap</label>
                            <input id="name" name="name" type="text" placeholder="Nama lengkap kamu"
                                value="{{ old('name', $currentUser->name ?? '') }}"
                                class="w-full rounded-2xl border px-4 py-3 text-gray-900 focus:outline-none focus:ring-2 focus:ring-pink-400 {{ $errors->has('name') ? 'border-red-400' : 'border-gray-200' }}" />
                            @error('name')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="email" class="mb-1 block text-sm font-semibold text-gray-700">Email</label>
                            <input id="email" name="email" type="email" placeholder="nama@email.com"
                                value="{{ old('email', $currentUser->email ?? '') }}"
                                class="w-full rounded-2xl border px-4 py-3 text-gray-900 focus:outline-none focus:ring-2 focus:ring-pink-400 {{ $errors->has('email') ? 'border-red-400' : 'border-gray-200' }}" />
                            @error('email')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    @unless($isAuthenticated)
                        <div class="grid gap-5 md:grid-cols-2">
                            <div>
                                <label for="password"
                                    class="mb-1 block text-sm font-semibold text-gray-700">Password</label>
                                <input id="password" name="password" type="password" placeholder="Minimal 8 karakter"
                                    class="w-full rounded-2xl border px-4 py-3 text-gray-900 focus:outline-none focus:ring-2 focus:ring-pink-400 {{ $errors->has('password') ? 'border-red-400' : 'border-gray-200' }}" />
                                @error('password')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="password_confirmation"
                                    class="mb-1 block text-sm font-semibold text-gray-700">Konfirmasi Password</label>
                                <input id="password_confirmation" name="password_confirmation" type="password"
                                    placeholder="Ulangi password kamu"
                                    class="w-full rounded-2xl border border-gray-200 px-4 py-3 text-gray-900 focus:outline-none focus:ring-2 focus:ring-pink-400" />
                            </div>
                        </div>
                    @endunless

                    <div class="grid gap-5 md:grid-cols-2">
                        <div>
                            <label for="whatsapp_number" class="mb-1 block text-sm font-semibold text-gray-700">No
                                WhatsApp</label>
                            <input id="whatsapp_number" name="whatsapp_number" type="text"
                                value="{{ old('whatsapp_number', $currentUser->whatsapp_number ?? '') }}"
                                placeholder="+62 812 3456 7890"
                                class="w-full rounded-2xl border px-4 py-3 text-gray-900 focus:outline-none focus:ring-2 focus:ring-pink-400 {{ $errors->has('whatsapp_number') ? 'border-red-400' : 'border-gray-200' }}" />
                            @error('whatsapp_number')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="job_title" class="mb-1 block text-sm font-semibold text-gray-700">Job
                                Title</label>
                            <input id="job_title" name="job_title" type="text"
                                value="{{ old('job_title', $currentUser->job_title ?? '') }}"
                                placeholder="Makeup Artist"
                                class="w-full rounded-2xl border px-4 py-3 text-gray-900 focus:outline-none focus:ring-2 focus:ring-pink-400 {{ $errors->has('job_title') ? 'border-red-400' : 'border-gray-200' }}" />
                            @error('job_title')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid gap-5 md:grid-cols-2">
                        <div>
                            <label for="instagram_url" class="mb-1 block text-sm font-semibold text-gray-700">Instagram
                                URL</label>
                            <input id="instagram_url" name="instagram_url" type="url"
                                value="{{ old('instagram_url', $currentUser->instagram_url ?? '') }}"
                                placeholder="https://instagram.com/namakamu"
                                class="w-full rounded-2xl border px-4 py-3 text-gray-900 focus:outline-none focus:ring-2 focus:ring-pink-400 {{ $errors->has('instagram_url') ? 'border-red-400' : 'border-gray-200' }}" />
                            @error('instagram_url')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="city" class="mb-1 block text-sm font-semibold text-gray-700">City</label>
                            <input id="city" name="city" type="text" value="{{ old('city', $currentUser->city ?? '') }}"
                                placeholder="Jakarta"
                                class="w-full rounded-2xl border px-4 py-3 text-gray-900 focus:outline-none focus:ring-2 focus:ring-pink-400 {{ $errors->has('city') ? 'border-red-400' : 'border-gray-200' }}" />
                            @error('city')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label for="country" class="mb-1 block text-sm font-semibold text-gray-700">Country</label>
                        <input id="country" name="country" type="text"
                            value="{{ old('country', $currentUser->country ?? '') }}" placeholder="Indonesia"
                            class="w-full rounded-2xl border px-4 py-3 text-gray-900 focus:outline-none focus:ring-2 focus:ring-pink-400 {{ $errors->has('country') ? 'border-red-400' : 'border-gray-200' }}" />
                        @error('country')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    @unless($isAuthenticated)
                        <div class="flex items-start gap-3">
                            <input id="terms" name="terms" type="checkbox"
                                class="mt-1 h-4 w-4 cursor-pointer rounded border-gray-300 accent-pink-500" />
                            <label for="terms" class="text-sm leading-relaxed text-gray-500">
                                Saya menyetujui
                                <a href="#" class="font-semibold text-pink-500 hover:text-pink-600">Syarat & Ketentuan</a>
                                serta
                                <a href="#" class="font-semibold text-pink-500 hover:text-pink-600">Kebijakan Privasi</a>
                                Salonkita.
                            </label>
                        </div>
                        @error('terms')
                            <p class="text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    @endunless

                    <button type="submit"
                        class="w-full rounded-2xl bg-pink-500 py-3 font-bold text-white shadow-sm transition hover:bg-pink-600">
                        {{ $isAuthenticated ? 'Simpan Profil' : 'Buat Akun ' . ucfirst($selectedRole) }}
                    </button>
                </form>

                @unless($isAuthenticated)
                    <p class="mt-6 text-center text-sm text-gray-500">
                        Sudah punya akun?
                        <a href="/login" class="font-bold text-pink-500 transition hover:text-pink-600">Masuk di sini</a>
                    </p>
                @endunless
            </div>
        </div>
    </div>
</x-layout>