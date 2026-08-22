<x-layout>
    <style>
        :root {
            --profile-pink: #ec4899;
            --profile-pink-dark: #db2777;
            --profile-border: rgba(236, 72, 153, 0.15);
        }

        .btn-pink-gradient {
            background: linear-gradient(135deg, var(--profile-pink) 0%, var(--profile-pink-dark) 100%);
            transition: all 0.25s ease;
        }

        .btn-pink-gradient:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 14px rgba(236, 72, 153, 0.25);
        }

        .profile-input {
            border: 1px solid #e5e7eb;
            background: #ffffff;
            transition: all 0.2s ease;
        }

        .profile-input:focus {
            border-color: var(--profile-pink);
            box-shadow: 0 0 0 3px rgba(236, 72, 153, 0.12);
            background: #ffffff;
        }

        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .tab-pill {
            transition: all 0.2s ease;
        }

        .tab-pill.active {
            background-color: #ffffff;
            color: #db2777;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
            font-weight: 700;
        }
    </style>

    <x-navbar />
    <x-breadcrumb :label="'Kembali ke Dashboard'" />

    @php
        $avatarUrl = $user->avatar_url ?: 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=ec4899&color=fff&size=256';
    @endphp

    <div class="w-full max-w-3xl mx-auto px-4 sm:px-6 py-6">
        
        {{-- Flash Alerts --}}
        @if ($errors->any())
            <div class="w-full mb-5 rounded-2xl border border-red-200 bg-red-50 p-3.5 text-xs text-red-700 flex items-start gap-2.5 shadow-sm">
                <svg class="w-4 h-4 text-red-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div>
                    <span class="font-bold">Terdapat beberapa kesalahan:</span>
                    <ul class="mt-1 list-disc list-inside space-y-0.5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        {{-- Profile Header Card (Ultra-Compact & Proportional) --}}
        <div class="w-full bg-white rounded-2xl border border-pink-100/80 shadow-sm p-4 sm:p-5 mb-5 relative overflow-hidden">
            <div class="flex items-center justify-between gap-4">
                <div class="flex items-center gap-3.5 min-w-0">
                    {{-- Compact Avatar with Live Preview Trigger --}}
                    <div class="relative group flex-shrink-0">
                        <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-2xl overflow-hidden border-2 border-pink-200 shadow-xs bg-pink-50 relative">
                            <img id="header-avatar-preview" src="{{ $avatarUrl }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                        </div>
                        <label for="avatar" class="absolute -bottom-1 -right-1 bg-pink-500 hover:bg-pink-600 text-white p-1 rounded-lg shadow-sm cursor-pointer transition transform hover:scale-110" title="Ganti Foto Profil">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </label>
                    </div>

                    {{-- User Identity --}}
                    <div class="min-w-0">
                        <div class="flex items-center gap-2 mb-0.5">
                            <h1 class="text-base sm:text-lg font-bold text-gray-900 truncate">{{ $user->name }}</h1>
                            <span class="inline-flex items-center px-2 py-0.2 rounded-full text-[10px] font-bold bg-pink-50 text-pink-600 border border-pink-100 uppercase tracking-wider">
                                {{ $user->role ?? 'Student' }}
                            </span>
                        </div>
                        <p class="text-gray-500 text-xs truncate">{{ $user->email }}</p>
                        @if($user->job_title || $user->city)
                            <div class="flex items-center gap-2.5 mt-1 text-[11px] text-gray-500">
                                @if($user->job_title)
                                    <span class="truncate">{{ $user->job_title }}</span>
                                @endif
                                @if($user->city)
                                    <span>•</span>
                                    <span class="truncate">{{ $user->city }}</span>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Single Only Save Button (Top Right) --}}
                <div class="flex items-center flex-shrink-0">
                    <button type="submit" form="profile-form" class="btn-pink-gradient px-4 py-2 sm:px-5 sm:py-2.5 rounded-xl text-white font-bold text-xs sm:text-sm shadow-sm flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span>Simpan</span>
                    </button>
                </div>
            </div>

            {{-- Compact Horizontal Stats Ribbon --}}
            <div class="mt-4 pt-3.5 border-t border-gray-100 grid grid-cols-2 sm:grid-cols-4 gap-2">
                <button type="button" onclick="switchTab('my-courses')" class="text-left p-2.5 rounded-xl bg-gray-50 hover:bg-pink-50/50 border border-gray-100 hover:border-pink-100 transition group">
                    <div class="flex items-center gap-2">
                        <div class="w-7 h-7 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center flex-shrink-0">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                        </div>
                        <div>
                            <p class="text-[10px] text-gray-500 font-medium leading-none">Kelas</p>
                            <p class="text-xs sm:text-sm font-bold text-gray-900 group-hover:text-pink-600 mt-0.5">{{ $ownedCourses->count() }}</p>
                        </div>
                    </div>
                </button>

                <button type="button" onclick="switchTab('my-certificates')" class="text-left p-2.5 rounded-xl bg-gray-50 hover:bg-pink-50/50 border border-gray-100 hover:border-pink-100 transition group">
                    <div class="flex items-center gap-2">
                        <div class="w-7 h-7 rounded-lg bg-pink-50 text-pink-600 flex items-center justify-center flex-shrink-0">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                        </div>
                        <div>
                            <p class="text-[10px] text-gray-500 font-medium leading-none">Sertifikat</p>
                            <p class="text-xs sm:text-sm font-bold text-gray-900 group-hover:text-pink-600 mt-0.5">{{ $certificates->count() }}</p>
                        </div>
                    </div>
                </button>

                <button type="button" onclick="switchTab('my-achievements')" class="text-left p-2.5 rounded-xl bg-gray-50 hover:bg-pink-50/50 border border-gray-100 hover:border-pink-100 transition group">
                    <div class="flex items-center gap-2">
                        <div class="w-7 h-7 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center flex-shrink-0">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                        </div>
                        <div>
                            <p class="text-[10px] text-gray-500 font-medium leading-none">Pencapaian</p>
                            <p class="text-xs sm:text-sm font-bold text-gray-900 group-hover:text-pink-600 mt-0.5">6 Badges</p>
                        </div>
                    </div>
                </button>

                <div class="p-2.5 rounded-xl bg-gray-50 border border-gray-100">
                    <div class="flex items-center gap-2">
                        <div class="w-7 h-7 rounded-lg bg-purple-50 text-purple-600 flex items-center justify-center flex-shrink-0">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <p class="text-[10px] text-gray-500 font-medium leading-none">Total Poin</p>
                            <p class="text-xs sm:text-sm font-bold text-gray-900 mt-0.5">{{ number_format($user->points_balance ?? 0) }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Smooth Responsive Tab Bar (Scrollable on Mobile, Uniform Width) --}}
        <div class="w-full mb-5 bg-gray-100/90 p-1 rounded-2xl border border-gray-200/80 shadow-xs">
            <div class="flex items-center overflow-x-auto no-scrollbar gap-1">
                <button type="button" onclick="switchTab('edit-profile')" id="tab-btn-edit-profile" class="tab-pill active flex-1 flex-shrink-0 px-3 py-2 rounded-xl text-xs font-semibold text-gray-600 hover:text-pink-600 flex items-center justify-center gap-1.5 whitespace-nowrap">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    <span>Edit Profil</span>
                </button>

                <button type="button" onclick="switchTab('my-courses')" id="tab-btn-my-courses" class="tab-pill flex-1 flex-shrink-0 px-3 py-2 rounded-xl text-xs font-semibold text-gray-600 hover:text-pink-600 flex items-center justify-center gap-1.5 whitespace-nowrap">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    <span>Kelas Saya</span>
                    <span class="px-1.5 py-0.2 text-[10px] bg-pink-100 text-pink-600 rounded-full font-bold">{{ $ownedCourses->count() }}</span>
                </button>

                <button type="button" onclick="switchTab('my-certificates')" id="tab-btn-my-certificates" class="tab-pill flex-1 flex-shrink-0 px-3 py-2 rounded-xl text-xs font-semibold text-gray-600 hover:text-pink-600 flex items-center justify-center gap-1.5 whitespace-nowrap">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                    <span>Sertifikat</span>
                    <span class="px-1.5 py-0.2 text-[10px] bg-pink-100 text-pink-600 rounded-full font-bold">{{ $certificates->count() }}</span>
                </button>

                <button type="button" onclick="switchTab('my-achievements')" id="tab-btn-my-achievements" class="tab-pill flex-1 flex-shrink-0 px-3 py-2 rounded-xl text-xs font-semibold text-gray-600 hover:text-pink-600 flex items-center justify-center gap-1.5 whitespace-nowrap">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                    <span>Pencapaian</span>
                </button>
            </div>
        </div>

        {{-- TAB 1: EDIT PROFILE FORM --}}
        <div id="tab-content-edit-profile" class="tab-pane w-full">
            <form id="profile-form" method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="w-full">
                @csrf
                @method('PUT')

                <div class="w-full bg-white rounded-2xl border border-gray-200/80 shadow-sm p-5 sm:p-6 mb-5">
                    
                    {{-- Compact Avatar Selector with Feedback --}}
                    <div class="mb-5 pb-4 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-xl overflow-hidden border border-pink-200 bg-pink-50 flex-shrink-0">
                                <img id="form-avatar-preview" src="{{ $avatarUrl }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                            </div>
                            <div>
                                <h3 class="text-xs font-bold text-gray-800">Foto Profil</h3>
                                <div class="flex items-center gap-2 mt-1">
                                    <label for="avatar" class="inline-flex items-center gap-1.5 px-3 py-1 bg-pink-50 hover:bg-pink-100 text-pink-600 text-[11px] font-bold rounded-lg cursor-pointer border border-pink-200 transition">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        Pilih Foto Baru
                                    </label>
                                    <input type="file" id="avatar" name="avatar" accept="image/png,image/jpeg,image/jpg,image/webp" class="hidden" onchange="handleAvatarPreview(this)">

                                    <button type="button" id="btn-reset-avatar" onclick="resetAvatarPreview()" class="hidden text-[11px] text-gray-500 hover:text-red-600 font-semibold px-2 py-1 rounded-lg bg-gray-100 hover:bg-red-50 transition">
                                        Batal
                                    </button>
                                </div>
                            </div>
                        </div>

                        {{-- Live Preview Feedback Status --}}
                        <div id="avatar-feedback" class="hidden">
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-emerald-50 border border-emerald-200 text-emerald-700 text-[11px] rounded-lg font-medium">
                                <svg class="w-3 h-3 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                <span id="avatar-filename">Foto siap diupload</span>
                            </span>
                        </div>
                    </div>

                    {{-- Form Fields --}}
                    <div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                            {{-- Nama Lengkap --}}
                            <div>
                                <label for="name" class="block text-[11px] font-bold text-gray-700 uppercase tracking-wider mb-1">
                                    Nama Lengkap <span class="text-red-500">*</span>
                                </label>
                                <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required
                                    class="profile-input w-full rounded-xl px-3 py-2 text-xs sm:text-sm text-gray-900 focus:outline-none"
                                    placeholder="Masukkan nama lengkap">
                                @error('name')
                                    <p class="mt-1 text-[11px] text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Email --}}
                            <div>
                                <label for="email" class="block text-[11px] font-bold text-gray-700 uppercase tracking-wider mb-1">
                                    Alamat Email <span class="text-red-500">*</span>
                                </label>
                                <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required
                                    class="profile-input w-full rounded-xl px-3 py-2 text-xs sm:text-sm text-gray-900 focus:outline-none"
                                    placeholder="email@example.com">
                                @error('email')
                                    <p class="mt-1 text-[11px] text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Job Title / Profesi --}}
                            <div>
                                <label for="job_title" class="block text-[11px] font-bold text-gray-700 uppercase tracking-wider mb-1">
                                    Pekerjaan / Profesi
                                </label>
                                <input id="job_title" name="job_title" type="text" value="{{ old('job_title', $user->job_title) }}"
                                    class="profile-input w-full rounded-xl px-3 py-2 text-xs sm:text-sm text-gray-900 focus:outline-none"
                                    placeholder="Contoh: Makeup Artist">
                                @error('job_title')
                                    <p class="mt-1 text-[11px] text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- No WhatsApp --}}
                            <div>
                                <label for="whatsapp_number" class="block text-[11px] font-bold text-gray-700 uppercase tracking-wider mb-1">
                                    Nomor WhatsApp
                                </label>
                                <input id="whatsapp_number" name="whatsapp_number" type="text" value="{{ old('whatsapp_number', $user->whatsapp_number) }}"
                                    class="profile-input w-full rounded-xl px-3 py-2 text-xs sm:text-sm text-gray-900 focus:outline-none"
                                    placeholder="+62 812 3456 7890">
                                @error('whatsapp_number')
                                    <p class="mt-1 text-[11px] text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Tanggal Lahir --}}
                            <div>
                                <label for="birth_date" class="block text-[11px] font-bold text-gray-700 uppercase tracking-wider mb-1">
                                    Tanggal Lahir
                                </label>
                                <input id="birth_date" name="birth_date" type="date" value="{{ old('birth_date', $user->birth_date?->format('Y-m-d')) }}"
                                    class="profile-input w-full rounded-xl px-3 py-2 text-xs sm:text-sm text-gray-900 focus:outline-none">
                                @error('birth_date')
                                    <p class="mt-1 text-[11px] text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Kota & Negara --}}
                            <div class="grid grid-cols-2 gap-2.5">
                                <div>
                                    <label for="city" class="block text-[11px] font-bold text-gray-700 uppercase tracking-wider mb-1">
                                        Kota
                                    </label>
                                    <input id="city" name="city" type="text" value="{{ old('city', $user->city) }}"
                                        class="profile-input w-full rounded-xl px-3 py-2 text-xs sm:text-sm text-gray-900 focus:outline-none"
                                        placeholder="Jakarta">
                                    @error('city')
                                        <p class="mt-1 text-[11px] text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="country" class="block text-[11px] font-bold text-gray-700 uppercase tracking-wider mb-1">
                                        Negara
                                    </label>
                                    <input id="country" name="country" type="text" value="{{ old('country', $user->country) }}"
                                        class="profile-input w-full rounded-xl px-3 py-2 text-xs sm:text-sm text-gray-900 focus:outline-none"
                                        placeholder="Indonesia">
                                    @error('country')
                                        <p class="mt-1 text-[11px] text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Bio --}}
                        <div class="mb-4">
                            <label for="bio" class="block text-[11px] font-bold text-gray-700 uppercase tracking-wider mb-1">
                                Bio Singkat
                            </label>
                            <textarea id="bio" name="bio" rows="2"
                                class="profile-input w-full rounded-xl px-3 py-2 text-xs sm:text-sm text-gray-900 focus:outline-none resize-none"
                                placeholder="Ceritakan singkat tentang Anda atau minat Anda di bidang kecantikan...">{{ old('bio', $user->bio) }}</textarea>
                            @error('bio')
                                <p class="mt-1 text-[11px] text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Media Sosial Section --}}
                        <div class="pt-4 border-t border-gray-100">
                            <h3 class="text-xs font-bold text-gray-700 uppercase tracking-wider mb-3">Media Sosial (Opsional)</h3>

                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                                <div>
                                    <label for="instagram_url" class="block text-[11px] font-semibold text-gray-600 mb-1">Instagram URL</label>
                                    <input id="instagram_url" name="instagram_url" type="url" value="{{ old('instagram_url', $user->instagram_url) }}"
                                        class="profile-input w-full rounded-xl px-3 py-2 text-xs text-gray-900 focus:outline-none"
                                        placeholder="https://instagram.com/username">
                                    @error('instagram_url')
                                        <p class="mt-1 text-[11px] text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="tiktok_url" class="block text-[11px] font-semibold text-gray-600 mb-1">TikTok URL</label>
                                    <input id="tiktok_url" name="tiktok_url" type="url" value="{{ old('tiktok_url', $user->tiktok_url) }}"
                                        class="profile-input w-full rounded-xl px-3 py-2 text-xs text-gray-900 focus:outline-none"
                                        placeholder="https://tiktok.com/@username">
                                    @error('tiktok_url')
                                        <p class="mt-1 text-[11px] text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="youtube_url" class="block text-[11px] font-semibold text-gray-600 mb-1">YouTube URL</label>
                                    <input id="youtube_url" name="youtube_url" type="url" value="{{ old('youtube_url', $user->youtube_url) }}"
                                        class="profile-input w-full rounded-xl px-3 py-2 text-xs text-gray-900 focus:outline-none"
                                        placeholder="https://youtube.com/@channel">
                                    @error('youtube_url')
                                        <p class="mt-1 text-[11px] text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            {{-- Danger Zone (Hapus Akun) --}}
            <div class="w-full bg-red-50/50 rounded-2xl border border-red-100 p-4 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
                <div>
                    <h3 class="text-xs font-bold text-red-800">Hapus Akun</h3>
                    <p class="text-[11px] text-red-600 mt-0.5">Tindakan ini akan menghapus akun dan data riwayat pembelajaran secara permanen.</p>
                </div>
                <button type="button" onclick="confirmDeleteAccount()" class="px-3.5 py-1.5 rounded-xl bg-white border border-red-200 text-red-600 hover:bg-red-600 hover:text-white font-bold text-xs transition shadow-xs flex-shrink-0">
                    Hapus Akun
                </button>
            </div>
        </div>

        {{-- TAB 2: MY COURSES --}}
        <div id="tab-content-my-courses" class="tab-pane w-full hidden">
            <div class="w-full bg-white rounded-2xl border border-gray-200/80 shadow-sm p-5 sm:p-6 min-h-[400px]">
                <div class="flex items-center justify-between mb-5 pb-3 border-b border-gray-100">
                    <div>
                        <h2 class="text-sm sm:text-base font-bold text-gray-900">Kelas yang Diambil</h2>
                        <p class="text-xs text-gray-500 mt-0.5">Daftar kelas pembelajaran aktif Anda di Salonkita Academy.</p>
                    </div>
                    <span class="text-xs font-bold px-2.5 py-0.5 bg-pink-50 text-pink-600 rounded-full border border-pink-100 flex-shrink-0">
                        {{ $ownedCourses->count() }} Kelas
                    </span>
                </div>

                @if($ownedCourses->count() > 0)
                    <div class="w-full grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @foreach($ownedCourses as $course)
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

                            <div class="bg-white border border-gray-100 rounded-xl overflow-hidden hover:border-pink-200 hover:shadow-sm transition flex flex-col justify-between">
                                <div class="relative h-36 bg-gray-100 overflow-hidden">
                                    <img src="{{ $thumbnailUrl }}" alt="{{ $course->name }}"
                                        onerror="this.onerror=null;this.src='{{ asset('assets/images/thumbnails/img_placeholder.png') }}';"
                                        class="w-full h-full object-cover">
                                    <span class="absolute top-2 left-2 px-2 py-0.5 rounded-full text-[10px] font-bold bg-black/60 text-white backdrop-blur-sm">
                                        {{ $course->category?->name ?? 'Course' }}
                                    </span>
                                </div>
                                <div class="p-3.5 flex-1 flex flex-col justify-between">
                                    <div>
                                        <h3 class="font-bold text-gray-900 text-xs sm:text-sm line-clamp-1 mb-1.5">{{ $course->name }}</h3>
                                        <div class="w-full bg-gray-100 rounded-full h-1.5 mb-1 overflow-hidden">
                                            <div class="bg-pink-500 h-1.5 rounded-full transition-all duration-300" style="width: {{ $progressPercentage }}%"></div>
                                        </div>
                                        <p class="text-[10px] text-gray-500 font-medium">{{ $progressPercentage }}% Selesai</p>
                                    </div>

                                    <div class="mt-3 pt-2.5 border-t border-gray-50">
                                        <a href="{{ route('course', $course->slug) }}" class="inline-flex items-center justify-center w-full px-3 py-1.5 bg-pink-50 hover:bg-pink-500 text-pink-600 hover:text-white font-bold text-xs rounded-lg transition">
                                            Lanjut Belajar
                                            <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12 border-2 border-dashed border-gray-200 rounded-2xl">
                        <div class="w-10 h-10 mx-auto mb-2 bg-pink-50 text-pink-500 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                        </div>
                        <h3 class="font-bold text-gray-900 text-xs sm:text-sm">Belum ada kelas yang diambil</h3>
                        <p class="text-[11px] text-gray-500 mt-1 max-w-xs mx-auto">Mulai perjalanan keahlian kecantikan Anda dengan mengikuti kelas kami.</p>
                        <a href="{{ route('all-courses') }}" class="inline-flex items-center gap-1 mt-3 px-3.5 py-1.5 rounded-xl bg-pink-500 hover:bg-pink-600 text-white font-bold text-xs shadow-xs transition">
                            Jelajahi Kelas
                        </a>
                    </div>
                @endif
            </div>
        </div>

        {{-- TAB 3: CERTIFICATES --}}
        <div id="tab-content-my-certificates" class="tab-pane w-full hidden">
            <div class="w-full bg-white rounded-2xl border border-gray-200/80 shadow-sm p-5 sm:p-6 min-h-[400px]">
                <div class="flex items-center justify-between mb-5 pb-3 border-b border-gray-100">
                    <div>
                        <h2 class="text-sm sm:text-base font-bold text-gray-900">Sertifikat Kelulusan</h2>
                        <p class="text-xs text-gray-500 mt-0.5">Sertifikat resmi yang telah Anda peroleh dari kelulusan kelas.</p>
                    </div>
                    <span class="text-xs font-bold px-2.5 py-0.5 bg-pink-50 text-pink-600 rounded-full border border-pink-100 flex-shrink-0">
                        {{ $certificates->count() }} Sertifikat
                    </span>
                </div>

                @if($certificates->count() > 0)
                    <div class="w-full grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                        @foreach($certificates as $cert)
                            <div class="w-full border border-pink-100 bg-pink-50/20 hover:bg-pink-50/40 rounded-xl p-3.5 transition shadow-2xs flex flex-col justify-between">
                                <div class="flex items-start gap-3 mb-3">
                                    <div class="w-10 h-10 bg-pink-500 rounded-lg flex items-center justify-center flex-shrink-0 text-white shadow-xs">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 110 2H4a1 1 0 110-2V4z"></path>
                                        </svg>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h3 class="font-bold text-gray-900 text-xs truncate">{{ $cert->course->name }}</h3>
                                        <p class="text-gray-500 text-[11px] mt-0.5">Kredensial: <span class="font-mono font-medium text-gray-800">{{ $cert->certificate_code }}</span></p>
                                        <p class="text-gray-400 text-[10px] mt-0.5">Diterbitkan: {{ $cert->issued_at ? $cert->issued_at->translatedFormat('d F Y') : '-' }}</p>
                                    </div>
                                </div>

                                <div class="flex flex-wrap gap-2 pt-2.5 border-t border-pink-100/60">
                                    <a href="{{ route('certificate.download', ['slug' => $cert->course->slug]) }}"
                                        class="inline-flex items-center text-[11px] font-semibold px-2.5 py-1 bg-pink-500 hover:bg-pink-600 text-white rounded-lg shadow-xs transition">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                        Download PDF
                                    </a>
                                    <a href="{{ route('claim-certificate', ['slug' => $cert->course->slug]) }}"
                                        class="inline-flex items-center text-[11px] font-semibold px-2.5 py-1 bg-white hover:bg-gray-100 text-gray-700 border border-gray-200 rounded-lg transition">
                                        Lihat Sertifikat
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12 border-2 border-dashed border-gray-200 rounded-2xl">
                        <div class="w-10 h-10 mx-auto mb-2 bg-pink-50 text-pink-500 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        </div>
                        <h3 class="font-bold text-gray-900 text-xs sm:text-sm">Belum ada sertifikat</h3>
                        <p class="text-[11px] text-gray-500 mt-1 max-w-xs mx-auto">Selesaikan materi kelas dan kirim ulasan untuk mengklaim sertifikat keahlian Anda.</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- TAB 4: ACHIEVEMENTS & BADGES --}}
        <div id="tab-content-my-achievements" class="tab-pane w-full hidden">
            <div class="w-full bg-white rounded-2xl border border-gray-200/80 shadow-sm p-5 sm:p-6 min-h-[400px]">
                <div class="flex items-center justify-between mb-5 pb-3 border-b border-gray-100">
                    <div>
                        <h2 class="text-sm sm:text-base font-bold text-gray-900">Pencapaian & Lencana</h2>
                        <p class="text-xs text-gray-500 mt-0.5">Lencana keahlian yang diraih melalui pembelajaran.</p>
                    </div>
                    <span class="text-xs font-bold px-2.5 py-0.5 bg-amber-50 text-amber-700 rounded-full border border-amber-200 flex-shrink-0">
                        🏆 4 / 6 Terbuka
                    </span>
                </div>

                <div class="w-full grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3.5">
                    {{-- Badge 1 --}}
                    <div class="border border-amber-200/70 bg-gradient-to-br from-amber-50/40 via-white to-amber-50/20 rounded-xl p-3.5 shadow-2xs flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <div class="w-10 h-10 bg-amber-100 text-xl rounded-xl flex items-center justify-center shadow-2xs">
                                    🌟
                                </div>
                                <span class="px-2 py-0.2 text-[9px] font-extrabold uppercase tracking-wider bg-emerald-100 text-emerald-700 rounded-full">
                                    Selesai
                                </span>
                            </div>
                            <h3 class="font-bold text-gray-900 text-xs">Beauty Novice</h3>
                            <p class="text-[11px] text-gray-500 mt-0.5">Memulai perjalanan belajar di Salonkita Academy.</p>
                        </div>
                        <div class="mt-3 pt-2 border-t border-amber-100/70">
                            <div class="flex items-center justify-between text-[10px] text-gray-500 font-semibold mb-1">
                                <span>Progress</span>
                                <span class="text-emerald-600 font-bold">100%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-1 overflow-hidden">
                                <div class="bg-emerald-500 h-1 rounded-full" style="width: 100%"></div>
                            </div>
                        </div>
                    </div>

                    {{-- Badge 2 --}}
                    <div class="border border-pink-200/70 bg-gradient-to-br from-pink-50/40 via-white to-pink-50/20 rounded-xl p-3.5 shadow-2xs flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <div class="w-10 h-10 bg-pink-100 text-xl rounded-xl flex items-center justify-center shadow-2xs">
                                    💄
                                </div>
                                <span class="px-2 py-0.2 text-[9px] font-extrabold uppercase tracking-wider bg-pink-100 text-pink-700 rounded-full">
                                    Proses
                                </span>
                            </div>
                            <h3 class="font-bold text-gray-900 text-xs">Master of Makeup</h3>
                            <p class="text-[11px] text-gray-500 mt-0.5">Menyelesaikan modul tata rias profesional & pengantin.</p>
                        </div>
                        <div class="mt-3 pt-2 border-t border-pink-100/70">
                            <div class="flex items-center justify-between text-[10px] text-gray-500 font-semibold mb-1">
                                <span>Progress (2/3)</span>
                                <span class="text-pink-600 font-bold">66%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-1 overflow-hidden">
                                <div class="bg-pink-500 h-1 rounded-full" style="width: 66%"></div>
                            </div>
                        </div>
                    </div>

                    {{-- Badge 3 --}}
                    <div class="border border-purple-200/70 bg-gradient-to-br from-purple-50/40 via-white to-purple-50/20 rounded-xl p-3.5 shadow-2xs flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <div class="w-10 h-10 bg-purple-100 text-xl rounded-xl flex items-center justify-center shadow-2xs">
                                    🌿
                                </div>
                                <span class="px-2 py-0.2 text-[9px] font-extrabold uppercase tracking-wider bg-emerald-100 text-emerald-700 rounded-full">
                                    Selesai
                                </span>
                            </div>
                            <h3 class="font-bold text-gray-900 text-xs">Skincare Enthusiast</h3>
                            <p class="text-[11px] text-gray-500 mt-0.5">Analisis jenis kulit dan perawatan wajah intensif.</p>
                        </div>
                        <div class="mt-3 pt-2 border-t border-purple-100/70">
                            <div class="flex items-center justify-between text-[10px] text-gray-500 font-semibold mb-1">
                                <span>Progress</span>
                                <span class="text-emerald-600 font-bold">100%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-1 overflow-hidden">
                                <div class="bg-emerald-500 h-1 rounded-full" style="width: 100%"></div>
                            </div>
                        </div>
                    </div>

                    {{-- Badge 4 --}}
                    <div class="border border-blue-200/70 bg-gradient-to-br from-blue-50/40 via-white to-blue-50/20 rounded-xl p-3.5 shadow-2xs flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <div class="w-10 h-10 bg-blue-100 text-xl rounded-xl flex items-center justify-center shadow-2xs">
                                    ⭐
                                </div>
                                <span class="px-2 py-0.2 text-[9px] font-extrabold uppercase tracking-wider bg-emerald-100 text-emerald-700 rounded-full">
                                    Selesai
                                </span>
                            </div>
                            <h3 class="font-bold text-gray-900 text-xs">Top Reviewer</h3>
                            <p class="text-[11px] text-gray-500 mt-0.5">Memberikan ulasan bintang 5 untuk instruktur.</p>
                        </div>
                        <div class="mt-3 pt-2 border-t border-blue-100/70">
                            <div class="flex items-center justify-between text-[10px] text-gray-500 font-semibold mb-1">
                                <span>Progress</span>
                                <span class="text-emerald-600 font-bold">100%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-1 overflow-hidden">
                                <div class="bg-emerald-500 h-1 rounded-full" style="width: 100%"></div>
                            </div>
                        </div>
                    </div>

                    {{-- Badge 5 --}}
                    <div class="border border-rose-200/70 bg-gradient-to-br from-rose-50/40 via-white to-rose-50/20 rounded-xl p-3.5 shadow-2xs flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <div class="w-10 h-10 bg-rose-100 text-xl rounded-xl flex items-center justify-center shadow-2xs">
                                    📜
                                </div>
                                <span class="px-2 py-0.2 text-[9px] font-extrabold uppercase tracking-wider bg-rose-100 text-rose-700 rounded-full">
                                    Proses
                                </span>
                            </div>
                            <h3 class="font-bold text-gray-900 text-xs">Kolektor Sertifikat</h3>
                            <p class="text-[11px] text-gray-500 mt-0.5">Mengumpulkan minimal 3 sertifikat resmi.</p>
                        </div>
                        <div class="mt-3 pt-2 border-t border-rose-100/70">
                            <div class="flex items-center justify-between text-[10px] text-gray-500 font-semibold mb-1">
                                <span>Progress ({{ $certificates->count() }}/3)</span>
                                <span class="text-rose-600 font-bold">{{ min(100, round(($certificates->count() / 3) * 100)) }}%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-1 overflow-hidden">
                                <div class="bg-rose-500 h-1 rounded-full" style="width: {{ min(100, round(($certificates->count() / 3) * 100)) }}%"></div>
                            </div>
                        </div>
                    </div>

                    {{-- Badge 6 (Locked) --}}
                    <div class="border border-gray-200 bg-gray-50/80 rounded-xl p-3.5 shadow-2xs opacity-75 flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <div class="w-10 h-10 bg-gray-200 text-xl rounded-xl flex items-center justify-center grayscale">
                                    👑
                                </div>
                                <span class="px-2 py-0.2 text-[9px] font-extrabold uppercase tracking-wider bg-gray-200 text-gray-600 rounded-full flex items-center gap-0.5">
                                    <svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/></svg>
                                    Terkunci
                                </span>
                            </div>
                            <h3 class="font-bold text-gray-700 text-xs">Salon Kita Master</h3>
                            <p class="text-[11px] text-gray-500 mt-0.5">Selesaikan 10 kelas dan raih 1.000 XP.</p>
                        </div>
                        <div class="mt-3 pt-2 border-t border-gray-200">
                            <div class="flex items-center justify-between text-[10px] text-gray-400 font-semibold mb-1">
                                <span>Progress (0/10)</span>
                                <span>0%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-1 overflow-hidden">
                                <div class="bg-gray-400 h-1 rounded-full" style="width: 0%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- Hidden Delete Account Form --}}
    <form id="delete-account-form" method="POST" action="{{ route('profile.destroy') }}" class="hidden">
        @csrf
        @method('DELETE')
    </form>

    <x-footer />

    <script>
        const originalAvatarSrc = "{{ $avatarUrl }}";

        // Tab Switcher
        function switchTab(tabId) {
            const tabs = ['edit-profile', 'my-courses', 'my-certificates', 'my-achievements'];
            tabs.forEach(tab => {
                const btn = document.getElementById(`tab-btn-${tab}`);
                const pane = document.getElementById(`tab-content-${tab}`);
                if (btn && pane) {
                    if (tab === tabId) {
                        btn.classList.add('active');
                        pane.classList.remove('hidden');
                    } else {
                        btn.classList.remove('active');
                        pane.classList.add('hidden');
                    }
                }
            });

            // Update URL hash without scrolling
            if (history.replaceState) {
                history.replaceState(null, null, `#${tabId}`);
            }
        }

        // Live Avatar Preview Handler
        function handleAvatarPreview(input) {
            if (input.files && input.files[0]) {
                const file = input.files[0];
                
                // Validate size (max 2MB)
                if (file.size > 2 * 1024 * 1024) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Ukuran file terlalu besar',
                        text: 'Maksimal ukuran foto adalah 2 MB.',
                        confirmButtonColor: '#ec4899'
                    });
                    input.value = '';
                    return;
                }

                const reader = new FileReader();
                reader.onload = function(e) {
                    const previewSrc = e.target.result;
                    const formPreview = document.getElementById('form-avatar-preview');
                    const headerPreview = document.getElementById('header-avatar-preview');
                    
                    if (formPreview) formPreview.src = previewSrc;
                    if (headerPreview) headerPreview.src = previewSrc;

                    // Show filename feedback & reset button
                    const feedback = document.getElementById('avatar-feedback');
                    const filenameSpan = document.getElementById('avatar-filename');
                    const resetBtn = document.getElementById('btn-reset-avatar');
                    
                    if (feedback && filenameSpan) {
                        const fileSizeFormatted = (file.size / 1024).toFixed(0) + ' KB';
                        filenameSpan.textContent = `${file.name} (${fileSizeFormatted})`;
                        feedback.classList.remove('hidden');
                    }
                    if (resetBtn) resetBtn.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            }
        }

        // Reset Avatar Preview
        function resetAvatarPreview() {
            const input = document.getElementById('avatar');
            if (input) input.value = '';

            const formPreview = document.getElementById('form-avatar-preview');
            const headerPreview = document.getElementById('header-avatar-preview');
            if (formPreview) formPreview.src = originalAvatarSrc;
            if (headerPreview) headerPreview.src = originalAvatarSrc;

            const feedback = document.getElementById('avatar-feedback');
            const resetBtn = document.getElementById('btn-reset-avatar');
            if (feedback) feedback.classList.add('hidden');
            if (resetBtn) resetBtn.classList.add('hidden');
        }

        // Delete Account Confirmation
        function confirmDeleteAccount() {
            Swal.fire({
                title: 'Hapus akun Anda?',
                text: 'Akun dan semua data pembelajaran akan dihapus secara permanen.',
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

        // Check hash on page load
        document.addEventListener('DOMContentLoaded', () => {
            const hash = window.location.hash.replace('#', '');
            if (['edit-profile', 'my-courses', 'my-certificates', 'my-achievements'].includes(hash)) {
                switchTab(hash);
            }
        });
    </script>
</x-layout>