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
    <x-breadcrumb />
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
            <div class="bg-white rounded-2xl card-shadow p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.669-0-3.218.51-4.5 1.385A7.968 7.968 0 009 4.804z">
                            </path>
                        </svg>
                    </div>
                    <span class="text-right">
                        <p class="text-gray-600 text-sm">Kelas Terdaftar</p>
                    </span>
                </div>
                <p class="text-4xl font-bold text-gray-900">{{ $ownedCourses->count() }}</p>
            </div>

            <!-- Sertifikat Terbit -->
            <div class="bg-white rounded-2xl card-shadow p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-pink-100 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-pink-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V8z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <span class="text-right">
                        <p class="text-gray-600 text-sm">Sertifikat Resmi</p>
                    </span>
                </div>
                <p class="text-4xl font-bold text-gray-900">{{ $certificates->count() }}</p>
            </div>

            <!-- Total Poin -->
            <div class="bg-white rounded-2xl card-shadow p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center">
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
                <p class="text-4xl font-bold text-gray-900">{{ number_format($user->points_balance ?? 0) }}</p>
            </div>

            <!-- Role Status -->
            <div class="bg-white rounded-2xl card-shadow p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <span class="text-right">
                        <p class="text-gray-600 text-sm">Tipe Akun</p>
                    </span>
                </div>
                <p class="text-2xl font-bold text-gray-900 capitalize">{{ $user->role ?? 'Student' }}</p>
            </div>
        </div>

        <!-- Pencapaian & Sertifikat Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <!-- Pencapaian Terkini -->
            <div class="bg-white rounded-3xl card-shadow p-6 sm:p-8 border border-[var(--profile-border)]">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-pink-500">Badge & Milestones</p>
                        <h2 class="text-2xl font-bold text-gray-900 mt-1">Pencapaian Belajar</h2>
                    </div>
                </div>

                <div class="space-y-4">
                    <div class="flex items-center gap-4 p-4 bg-pink-50/40 rounded-2xl border border-pink-100">
                        <div class="text-3xl">🏆</div>
                        <div class="flex-1">
                            <h3 class="font-bold text-gray-900 text-sm sm:text-base">Pembelajar Aktif</h3>
                            <p class="text-gray-600 text-xs sm:text-sm">Terdaftar di {{ $ownedCourses->count() }} kelas Salonkita Academy</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-4 p-4 bg-purple-50/40 rounded-2xl border border-purple-100">
                        <div class="text-3xl">⭐</div>
                        <div class="flex-1">
                            <h3 class="font-bold text-gray-900 text-sm sm:text-base">Kolektor Sertifikat</h3>
                            <p class="text-gray-600 text-xs sm:text-sm">{{ $certificates->count() }} sertifikat keahlian telah diraih</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sertifikat Terkini -->
            <div class="bg-white rounded-3xl card-shadow p-6 sm:p-8 border border-[var(--profile-border)]">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-pink-500">Verified Credentials</p>
                        <h2 class="text-2xl font-bold text-gray-900 mt-1">Sertifikat Saya</h2>
                    </div>
                    <span class="text-xs font-bold text-pink-600 bg-pink-50 px-3 py-1.5 rounded-full border border-pink-100">
                        {{ $certificates->count() }} Sertifikat
                    </span>
                </div>

                <div class="space-y-4">
                    @forelse($certificates as $cert)
                        <div class="border border-pink-100 hover:border-pink-300 bg-gradient-to-r from-white to-pink-50/20 rounded-2xl p-4 transition-smooth shadow-sm">
                            <div class="flex items-start gap-4">
                                <div class="w-12 h-12 bg-gradient-to-br from-pink-500 to-rose-400 rounded-2xl flex items-center justify-center flex-shrink-0 text-white shadow-md shadow-pink-500/20">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 110 2H4a1 1 0 110-2V4z"></path>
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h3 class="font-bold text-gray-900 text-sm truncate">{{ $cert->course->name }}</h3>
                                    <p class="text-gray-500 text-xs mt-0.5">No. Kredensial: <span class="font-mono font-medium text-gray-800">{{ $cert->certificate_code }}</span></p>
                                    <p class="text-gray-400 text-xs mt-0.5">Diterbitkan: {{ $cert->issued_at ? $cert->issued_at->translatedFormat('d F Y') : '-' }}</p>
                                    <div class="mt-3 flex flex-wrap gap-2">
                                        <a href="{{ route('certificate.download', ['slug' => $cert->course->slug]) }}"
                                            class="inline-flex items-center text-xs font-semibold px-3 py-1.5 bg-pink-500 hover:bg-pink-600 text-white rounded-xl shadow-sm transition">
                                            <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                            Download PDF
                                        </a>
                                        <a href="{{ route('claim-certificate', ['slug' => $cert->course->slug]) }}"
                                            class="inline-flex items-center text-xs font-semibold px-3 py-1.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl transition">
                                            Detail & Preview
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="rounded-2xl border border-dashed border-gray-200 p-8 text-center text-gray-500">
                            <div class="w-12 h-12 mx-auto mb-2 text-gray-300">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            </div>
                            <p class="text-sm font-semibold text-gray-700">Belum ada sertifikat</p>
                            <p class="text-xs text-gray-400 mt-1">Selesaikan kelas dan kirim ulasan untuk mengklaim sertifikat kelulusan.</p>
                        </div>
                    @endforelse
                </div>
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