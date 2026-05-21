<x-layout>
    <style>
        :root {
            --profile-pink: #ec4899;
            --profile-pink-dark: #db2777;
            --profile-border: rgba(236, 72, 153, 0.14);
        }

        .navbar-shadow {
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .card-shadow {
            box-shadow: 0 12px 30px rgba(236, 72, 153, 0.08);
        }

        .btn-pink-gradient {
            background: linear-gradient(135deg, var(--profile-pink) 0%, var(--profile-pink-dark) 100%);
            transition: all 0.3s ease;
        }

        .btn-pink-gradient:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(236, 72, 153, 0.24);
        }

        .badge-achievement {
            background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
        }

        .tab-active {
            color: var(--profile-pink);
            border-bottom: 3px solid var(--profile-pink);
        }

        .transition-smooth {
            transition: all 0.3s ease;
        }

        .profile-cover {
            min-height: 220px;
            background:
                radial-gradient(circle at top left, rgba(255, 255, 255, 0.22), transparent 30%),
                linear-gradient(135deg, var(--profile-pink) 0%, #c026d3 45%, var(--profile-pink-dark) 100%);
        }

        .medal-icon {
            font-size: 32px;
        }

        .profile-input {
            border: 1px solid rgba(156, 163, 175, 0.28);
            background: rgba(255, 255, 255, 0.95);
        }

        .profile-input:focus {
            border-color: var(--profile-pink);
            box-shadow: 0 0 0 4px rgba(236, 72, 153, 0.12);
        }
    </style>
    <x-navbar />
    <!-- Profile Cover Section -->
    <div class="profile-cover"></div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-12 -mt-16 relative z-10 pb-16">
        @php
            $avatarUrl = $user->avatar_url ?: 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=ec4899&color=fff&size=256';
        @endphp

        @if ($errors->any())
            <div class="mb-8 rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-red-700">
                Please review the highlighted fields and try again.
            </div>
        @endif

        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-8">
            @csrf
            @method('PUT')

            <div
                class="bg-white/95 rounded-3xl card-shadow p-6 sm:p-8 border border-[var(--profile-border)] backdrop-blur-sm">
                <div class="flex flex-col md:flex-row md:items-end gap-6">
                    <div class="relative self-start">
                        <img src="{{ $avatarUrl }}" alt="{{ $user->name }}"
                            class="w-32 h-32 rounded-3xl border-4 border-white object-cover bg-pink-50">
                        <label
                            class="absolute -bottom-2 -right-2 inline-flex cursor-pointer items-center rounded-full bg-white px-3 py-1 text-xs font-semibold text-gray-700 shadow-md ring-1 ring-gray-200 hover:text-pink-600">
                            Change
                            <input type="file" name="avatar" accept="image/*" class="hidden">
                        </label>
                    </div>

                    <div class="flex-1 space-y-4">
                        <div>
                            <p
                                class="inline-flex items-center rounded-full bg-pink-50 px-3 py-1 text-xs font-semibold uppercase tracking-[0.2em] text-pink-600">
                                Profile Settings
                            </p>
                            <h1 class="mt-3 text-3xl font-bold text-gray-900 sm:text-4xl">Update your profile</h1>
                            <p class="mt-2 max-w-2xl text-gray-600">Keep your profile details current so your learners,
                                instructors, and future collaborations can find the right information.</p>
                        </div>

                        <div class="grid gap-4 md:grid-cols-2">
                            <div>
                                <label class="mb-2 block text-sm font-semibold text-gray-700" for="name">Full
                                    Name</label>
                                <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}"
                                    class="profile-input w-full rounded-2xl px-4 py-3 text-gray-900 focus:outline-none"
                                    placeholder="Your full name">
                                @error('name')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="mb-2 block text-sm font-semibold text-gray-700" for="email">Email
                                    Address</label>
                                <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}"
                                    class="profile-input w-full rounded-2xl px-4 py-3 text-gray-900 focus:outline-none"
                                    placeholder="name@example.com">
                                @error('email')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-semibold text-gray-700" for="bio">Bio</label>
                            <textarea id="bio" name="bio" rows="4"
                                class="profile-input w-full rounded-2xl px-4 py-3 text-gray-900 focus:outline-none"
                                placeholder="Tell people a bit about yourself">{{ old('bio', $user->bio) }}</textarea>
                            @error('bio')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">
                <div class="space-y-8 lg:col-span-2">
                    <div class="bg-white rounded-3xl card-shadow p-6 sm:p-8 border border-[var(--profile-border)]">
                        <div class="mb-6 flex items-center justify-between">
                            <div>
                                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-pink-500">Personal
                                    Information</p>
                                <h2 class="mt-2 text-2xl font-bold text-gray-900">Contact & Location</h2>
                            </div>
                        </div>

                        <div class="grid gap-6 md:grid-cols-2">
                            <div>
                                <label class="mb-2 block text-sm font-semibold text-gray-700"
                                    for="whatsapp_number">WhatsApp Number</label>
                                <input id="whatsapp_number" name="whatsapp_number" type="text"
                                    value="{{ old('whatsapp_number', $user->whatsapp_number) }}"
                                    class="profile-input w-full rounded-2xl px-4 py-3 text-gray-900 focus:outline-none"
                                    placeholder="+62 812 3456 7890">
                                @error('whatsapp_number')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="mb-2 block text-sm font-semibold text-gray-700" for="birth_date">Birth
                                    Date</label>
                                <input id="birth_date" name="birth_date" type="date"
                                    value="{{ old('birth_date', $user->birth_date?->format('Y-m-d')) }}"
                                    class="profile-input w-full rounded-2xl px-4 py-3 text-gray-900 focus:outline-none">
                                @error('birth_date')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="mb-2 block text-sm font-semibold text-gray-700" for="city">City</label>
                                <input id="city" name="city" type="text" value="{{ old('city', $user->city) }}"
                                    class="profile-input w-full rounded-2xl px-4 py-3 text-gray-900 focus:outline-none"
                                    placeholder="Jakarta">
                                @error('city')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="mb-2 block text-sm font-semibold text-gray-700"
                                    for="country">Country</label>
                                <input id="country" name="country" type="text"
                                    value="{{ old('country', $user->country) }}"
                                    class="profile-input w-full rounded-2xl px-4 py-3 text-gray-900 focus:outline-none"
                                    placeholder="Indonesia">
                                @error('country')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label class="mb-2 block text-sm font-semibold text-gray-700" for="job_title">Job
                                    Title</label>
                                <input id="job_title" name="job_title" type="text"
                                    value="{{ old('job_title', $user->job_title) }}"
                                    class="profile-input w-full rounded-2xl px-4 py-3 text-gray-900 focus:outline-none"
                                    placeholder="Makeup Artist">
                                @error('job_title')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-3xl card-shadow p-6 sm:p-8 border border-[var(--profile-border)]">
                        <div class="mb-6">
                            <p class="text-sm font-semibold uppercase tracking-[0.2em] text-pink-500">Social Presence
                            </p>
                            <h2 class="mt-2 text-2xl font-bold text-gray-900">Social Links</h2>
                        </div>

                        <div class="grid gap-6 md:grid-cols-2">
                            <div>
                                <label class="mb-2 block text-sm font-semibold text-gray-700"
                                    for="instagram_url">Instagram Link</label>
                                <input id="instagram_url" name="instagram_url" type="url"
                                    value="{{ old('instagram_url', $user->instagram_url) }}"
                                    class="profile-input w-full rounded-2xl px-4 py-3 text-gray-900 focus:outline-none"
                                    placeholder="https://instagram.com/yourname">
                                @error('instagram_url')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="mb-2 block text-sm font-semibold text-gray-700" for="tiktok_url">TikTok
                                    Link</label>
                                <input id="tiktok_url" name="tiktok_url" type="url"
                                    value="{{ old('tiktok_url', $user->tiktok_url) }}"
                                    class="profile-input w-full rounded-2xl px-4 py-3 text-gray-900 focus:outline-none"
                                    placeholder="https://tiktok.com/@yourname">
                                @error('tiktok_url')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label class="mb-2 block text-sm font-semibold text-gray-700" for="youtube_url">YouTube
                                    Link</label>
                                <input id="youtube_url" name="youtube_url" type="url"
                                    value="{{ old('youtube_url', $user->youtube_url) }}"
                                    class="profile-input w-full rounded-2xl px-4 py-3 text-gray-900 focus:outline-none"
                                    placeholder="https://youtube.com/@yourchannel">
                                @error('youtube_url')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="space-y-8">
                    <div
                        class="sticky top-6 rounded-3xl border border-[var(--profile-border)] bg-white p-6 sm:p-8 card-shadow">
                        <p class="text-sm font-semibold uppercase tracking-[0.2em] text-pink-500">Account Summary</p>
                        <h2 class="mt-2 text-2xl font-bold text-gray-900">Profile Status</h2>

                        <div class="mt-6 space-y-4 rounded-2xl bg-pink-50 p-4">
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-pink-500">Member Since
                                </p>
                                <p class="mt-1 text-sm font-semibold text-gray-900">
                                    {{ $user->created_at?->format('d F Y') ?? '-' }}
                                </p>
                            </div>
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-pink-500">Current Email
                                </p>
                                <p class="mt-1 wrap-break-word text-sm font-semibold text-gray-900">{{ $user->email }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-pink-500">Profile Image
                                </p>
                                <p class="mt-1 text-sm font-semibold text-gray-900">
                                    {{ $user->avatar ? 'Custom avatar uploaded' : 'Using default avatar' }}
                                </p>
                            </div>
                        </div>

                        <button type="submit"
                            class="btn-pink-gradient mt-6 inline-flex w-full items-center justify-center rounded-2xl px-5 py-3 text-base font-semibold text-white">
                            Save Changes
                        </button>

                        <button type="button" onclick="confirmDeleteAccount()"
                            class="mt-3 inline-flex w-full items-center justify-center rounded-2xl border border-red-200 bg-red-50 px-5 py-3 text-base font-semibold text-red-600 transition hover:bg-red-100 hover:border-red-300">
                            Delete Account
                        </button>

                        <p class="mt-4 text-sm text-gray-500">Upload a new avatar to replace the current one. Changes
                            will apply as soon as you save.</p>
                    </div>
                </div>
            </div>
        </form>

        <form id="delete-account-form" method="POST" action="{{ route('profile.destroy') }}" class="hidden">
            @csrf
            @method('DELETE')
        </form>

        <!-- Stats Section -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8 mt-8">
            <!-- Kelas Terdaftar -->
            <div class="bg-white rounded-lg card-shadow p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.669 0-3.218.51-4.5 1.385A7.968 7.968 0 009 4.804z">
                            </path>
                        </svg>
                    </div>
                    <span class="text-right">
                        <p class="text-gray-600 text-sm">Kelas Terdaftar</p>
                    </span>
                </div>
                <p class="text-4xl font-bold text-gray-900">8</p>
            </div>

            <!-- Kelas Selesai -->
            <div class="bg-white rounded-lg card-shadow p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <span class="text-right">
                        <p class="text-gray-600 text-sm">Kelas Selesai</p>
                    </span>
                </div>
                <p class="text-4xl font-bold text-gray-900">5</p>
            </div>

            <!-- Total Pencapaian -->
            <div class="bg-white rounded-lg card-shadow p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                            </path>
                        </svg>
                    </div>
                    <span class="text-right">
                        <p class="text-gray-600 text-sm">Total Pencapaian</p>
                    </span>
                </div>
                <p class="text-4xl font-bold text-gray-900">23</p>
            </div>

            <!-- Poin -->
            <div class="bg-white rounded-lg card-shadow p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M9.167 4.5a.75.75 0 01.75.75v7.08l1.465-1.465a.75.75 0 11-1.06-1.06l-2.5 2.5a.75.75 0 001.06 1.06l1.465-1.465v1.465a.75.75 0 01-.75.75h-7.5a.75.75 0 01-.75-.75V10a.75.75 0 111.5 0v2.917h5.25V5.25a.75.75 0 01.75-.75z">
                            </path>
                        </svg>
                    </div>
                    <span class="text-right">
                        <p class="text-gray-600 text-sm">Total Poin</p>
                    </span>
                </div>
                <p class="text-4xl font-bold text-gray-900">2,850</p>
            </div>
        </div>

        <!-- Pencapaian & Sertifikat Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <!-- Pencapaian Terkini -->
            <div class="bg-white rounded-lg card-shadow p-6">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Pencapaian Terkini</h2>
                <div class="space-y-4">
                    <!-- Achievement 1 -->
                    <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-smooth">
                        <div class="medal-icon">🏆</div>
                        <div class="flex-1">
                            <h3 class="font-bold text-gray-900">Master Makeup Artist</h3>
                            <p class="text-gray-600 text-sm">Selesaikan semua kelas makeup</p>
                            <p class="text-gray-500 text-xs mt-1">Diraih pada 15 Januari 2025</p>
                        </div>
                        <div class="text-right">
                            <p class="text-pink-600 font-bold">+500 poin</p>
                        </div>
                    </div>

                    <!-- Achievement 2 -->
                    <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-smooth">
                        <div class="medal-icon">⭐</div>
                        <div class="flex-1">
                            <h3 class="font-bold text-gray-900">5 Bintang Evaluasi</h3>
                            <p class="text-gray-600 text-sm">Dapatkan rating 5 bintang di 5 kelas</p>
                            <p class="text-gray-500 text-xs mt-1">Diraih pada 10 Januari 2025</p>
                        </div>
                        <div class="text-right">
                            <p class="text-pink-600 font-bold">+300 poin</p>
                        </div>
                    </div>

                    <!-- Achievement 3 -->
                    <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-smooth">
                        <div class="medal-icon">🎯</div>
                        <div class="flex-1">
                            <h3 class="font-bold text-gray-900">Fokus Belajar</h3>
                            <p class="text-gray-600 text-sm">Belajar minimal 7 hari berturut-turut</p>
                            <p class="text-gray-500 text-xs mt-1">Diraih pada 05 Januari 2025</p>
                        </div>
                        <div class="text-right">
                            <p class="text-pink-600 font-bold">+250 poin</p>
                        </div>
                    </div>

                    <!-- Achievement 4 -->
                    <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-smooth">
                        <div class="medal-icon">🚀</div>
                        <div class="flex-1">
                            <h3 class="font-bold text-gray-900">Cepat Belajar</h3>
                            <p class="text-gray-600 text-sm">Menyelesaikan kelas dalam 2 minggu</p>
                            <p class="text-gray-500 text-xs mt-1">Diraih pada 02 Januari 2025</p>
                        </div>
                        <div class="text-right">
                            <p class="text-pink-600 font-bold">+200 poin</p>
                        </div>
                    </div>
                </div>
                <a href="#" class="inline-block mt-6 text-pink-600 font-semibold hover:text-pink-700">Lihat Semua
                    Pencapaian →</a>
            </div>

            <!-- Sertifikat Terkini -->
            <div class="bg-white rounded-lg card-shadow p-6">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Sertifikat Terkini</h2>
                <div class="space-y-4">
                    <!-- Certificate 1 -->
                    <div class="border-2 border-pink-200 rounded-lg p-4 hover:border-pink-400 transition-smooth">
                        <div class="flex items-start gap-4">
                            <div
                                class="w-16 h-16 bg-gradient-to-br from-yellow-300 to-yellow-500 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 110 2H4a1 1 0 110-2V4z"></path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h3 class="font-bold text-gray-900">Certified Makeup Artist Professional</h3>
                                <p class="text-gray-600 text-sm">Dari Salonkita</p>
                                <p class="text-gray-500 text-xs mt-2">Diraih pada 15 Januari 2025</p>
                                <div class="mt-3 flex gap-2">
                                    <button class="text-pink-600 text-sm font-semibold hover:text-pink-700">Lihat
                                        Sertifikat</button>
                                    <button
                                        class="text-gray-600 text-sm font-semibold hover:text-gray-700">Bagikan</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Certificate 2 -->
                    <div class="border-2 border-pink-200 rounded-lg p-4 hover:border-pink-400 transition-smooth">
                        <div class="flex items-start gap-4">
                            <div
                                class="w-16 h-16 bg-gradient-to-br from-pink-300 to-pink-500 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 110 2H4a1 1 0 110-2V4z"></path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h3 class="font-bold text-gray-900">Eyeshadow Techniques Master</h3>
                                <p class="text-gray-600 text-sm">Dari Salonkita</p>
                                <p class="text-gray-500 text-xs mt-2">Diraih pada 10 Januari 2025</p>
                                <div class="mt-3 flex gap-2">
                                    <button class="text-pink-600 text-sm font-semibold hover:text-pink-700">Lihat
                                        Sertifikat</button>
                                    <button
                                        class="text-gray-600 text-sm font-semibold hover:text-gray-700">Bagikan</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Certificate 3 -->
                    <div class="border-2 border-pink-200 rounded-lg p-4 hover:border-pink-400 transition-smooth">
                        <div class="flex items-start gap-4">
                            <div
                                class="w-16 h-16 bg-gradient-to-br from-purple-300 to-purple-500 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 110 2H4a1 1 0 110-2V4z"></path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h3 class="font-bold text-gray-900">Event Makeup Specialist</h3>
                                <p class="text-gray-600 text-sm">Dari Salonkita</p>
                                <p class="text-gray-500 text-xs mt-2">Diraih pada 05 Januari 2025</p>
                                <div class="mt-3 flex gap-2">
                                    <button class="text-pink-600 text-sm font-semibold hover:text-pink-700">Lihat
                                        Sertifikat</button>
                                    <button
                                        class="text-gray-600 text-sm font-semibold hover:text-gray-700">Bagikan</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <a href="#" class="inline-block mt-6 text-pink-600 font-semibold hover:text-pink-700">Lihat Semua
                    Sertifikat →</a>
            </div>
        </div>

        <!-- Kelas Terdaftar Section -->
        <div class="bg-white rounded-lg card-shadow p-6 mb-8">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-gray-900">Kelas yang Saat Ini Diambil</h2>
                <span class="text-sm text-gray-500">{{ $ownedCourses->count() }} kelas</span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @forelse($ownedCourses as $course)
                    @php
                        $thumbnailUrl = $course->thumbnail
                            ? Storage::url($course->thumbnail)
                            : asset('assets/images/thumbnails/img_placeholder.png');
                        $totalVideos = (int) ($course->videos_count ?? $course->videos()->count());
                        $watchedVideos = auth()->user()->courseVideoWatches()
                            ->where('course_id', $course->id)
                            ->distinct('course_video_id')
                            ->count('course_video_id');
                        $progressPercentage = $totalVideos > 0 ? (int) round(($watchedVideos / $totalVideos) * 100) : 0;
                    @endphp

                    <div class="border border-gray-200 rounded-lg overflow-hidden hover:shadow-lg transition-smooth">
                        <img src="{{ $thumbnailUrl }}" alt="{{ $course->name }}"
                            onerror="this.onerror=null;this.src='{{ asset('assets/images/thumbnails/img_placeholder.png') }}';"
                            class="w-full h-40 object-cover">
                        <div class="p-4">
                            <h3 class="font-bold text-gray-900 mb-2">{{ $course->name }}</h3>
                            <p class="text-gray-600 text-sm mb-3">{{ $course->category?->name ?? 'General Course' }}</p>
                            <div class="bg-gray-100 rounded-full h-2 mb-2">
                                <div class="bg-pink-600 h-2 rounded-full" style="width: {{ $progressPercentage }}%">
                                </div>
                            </div>
                            <p class="text-gray-600 text-xs">{{ $progressPercentage }}% Selesai</p>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full rounded-lg border border-dashed border-gray-300 p-8 text-center text-gray-500">
                        Belum ada kelas yang diambil.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
    <x-footer />

    <script>
        function confirmDeleteAccount() {
            Swal.fire({
                title: 'Hapus akun?',
                text: 'Akun akan dihapus permanen dan tidak bisa dipulihkan.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, hapus akun',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-account-form').submit();
                }
            });
        }
    </script>
</x-layout>