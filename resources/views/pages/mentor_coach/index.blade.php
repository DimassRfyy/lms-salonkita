<x-layout>
    <x-navbar />

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-12 py-8"
        x-data="{
            openModal: false,
            user: {
                name: '',
                role_label: '',
                job_title: '',
                location: '',
                avatar: null,
                avatar_letter: '',
                bio: '',
                stat_label: '',
                stat_value: 0,
                instagram: '',
                tiktok: '',
                youtube: ''
            },
            show(data) {
                this.user = data;
                this.openModal = true;
                document.body.style.overflow = 'hidden';
            },
            close() {
                this.openModal = false;
                document.body.style.overflow = '';
            }
        }"
        @keydown.escape.window="close()">

        {{-- BREADCRUMB & ROLE TABS --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <nav class="flex items-center gap-2 text-sm text-gray-500" aria-label="Breadcrumb">
                <a href="{{ route('home') }}" class="hover:text-pink-600 transition">Beranda</a>
                <span>/</span>
                <span class="text-gray-900 font-semibold">Daftar {{ $role === 'mentor' ? 'Mentor' : 'Coach' }}</span>
            </nav>

            {{-- TAB SWITCHER: MENTOR / COACH --}}
            <div class="inline-flex p-1 bg-gray-100 rounded-xl self-start sm:self-auto">
                <a href="{{ route('mentors.index') }}"
                    class="px-4 py-1.5 rounded-lg text-xs sm:text-sm font-bold transition {{ $role === 'mentor' ? 'bg-white text-pink-600 shadow-xs' : 'text-gray-600 hover:text-gray-900' }}">
                    Mentor
                </a>
                <a href="{{ route('coaches.index') }}"
                    class="px-4 py-1.5 rounded-lg text-xs sm:text-sm font-bold transition {{ $role === 'coach' ? 'bg-white text-purple-600 shadow-xs' : 'text-gray-600 hover:text-gray-900' }}">
                    Coach
                </a>
            </div>
        </div>

        {{-- COMPACT BANNER --}}
        <section class="mb-6">
            <div class="rounded-2xl px-6 py-5 text-white shadow-xs flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 {{ $role === 'mentor' ? 'bg-gradient-to-r from-pink-500 to-rose-500' : 'bg-gradient-to-r from-purple-600 to-pink-600' }}">
                <div>
                    <h1 class="text-xl sm:text-2xl font-bold">
                        {{ $role === 'mentor' ? 'Mentor Profesional Salonkita' : 'Coach Ahli Salonkita' }}
                    </h1>
                    <p class="text-xs sm:text-sm mt-0.5 opacity-90">
                        {{ $role === 'mentor' ? 'Bimbingan kecantikan langsung bersama praktisi ahli.' : 'Pengembangan skill dan strategi bisnis bersama coach berpengalaman.' }}
                    </p>
                </div>
                <a href="{{ route('register.mentor-coach', ['role' => $role]) }}"
                    class="self-start sm:self-center px-4 py-2 bg-white font-bold text-xs rounded-xl transition shadow-xs {{ $role === 'mentor' ? 'text-pink-600 hover:bg-pink-50' : 'text-purple-700 hover:bg-purple-50' }}">
                    + Jadi {{ ucfirst($role) }}
                </a>
            </div>
        </section>

        {{-- SEARCH + INFO --}}
        <section class="mb-8">
            <div class="bg-white border border-pink-100 rounded-2xl p-4 md:p-5 shadow-xs flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <form method="GET" action="{{ $role === 'mentor' ? route('mentors.index') : route('coaches.index') }}" class="w-full md:max-w-md relative">
                    <input type="text" name="search" value="{{ $search ?? '' }}"
                        placeholder="Cari nama {{ $role }}, profesi, atau kota..."
                        class="w-full pl-11 pr-24 py-2.5 bg-gray-50 border border-gray-200 text-gray-900 rounded-xl focus:outline-none focus:ring-2 {{ $role === 'mentor' ? 'focus:ring-pink-500' : 'focus:ring-purple-500' }} focus:border-transparent focus:bg-white text-sm transition">
                    <svg class="w-5 h-5 text-gray-400 absolute left-3.5 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m1.85-5.15a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <div class="absolute right-2 top-1/2 -translate-y-1/2 flex items-center gap-1.5">
                        @if(!empty($search))
                            <a href="{{ $role === 'mentor' ? route('mentors.index') : route('coaches.index') }}" class="px-2.5 py-1 rounded-lg text-xs font-medium text-gray-500 hover:bg-gray-200 transition">
                                Reset
                            </a>
                        @endif
                        <button type="submit" class="px-3 py-1 text-white text-xs font-semibold rounded-lg transition {{ $role === 'mentor' ? 'bg-pink-500 hover:bg-pink-600' : 'bg-purple-600 hover:bg-purple-700' }}">
                            Cari
                        </button>
                    </div>
                </form>

                <p class="text-sm text-gray-600">
                    Menampilkan <span class="font-bold {{ $role === 'mentor' ? 'text-pink-600' : 'text-purple-600' }}">{{ $users->count() }}</span> dari <span class="font-bold {{ $role === 'mentor' ? 'text-pink-600' : 'text-purple-600' }}">{{ $users->total() }}</span> {{ ucfirst($role) }}
                </p>
            </div>
        </section>

        {{-- GRID DAFTAR MENTOR / COACH --}}
        <section class="mb-14">
            @if($users->isEmpty())
                <div class="bg-white border border-pink-100 rounded-3xl p-12 text-center max-w-md mx-auto shadow-sm">
                    <div class="w-14 h-14 rounded-2xl flex items-center justify-center mx-auto mb-3 text-2xl font-bold {{ $role === 'mentor' ? 'bg-pink-50 text-pink-500' : 'bg-purple-50 text-purple-600' }}">
                        ✦
                    </div>
                    <h2 class="text-lg font-bold text-gray-900 mb-1">{{ ucfirst($role) }} Tidak Ditemukan</h2>
                    <p class="text-gray-500 text-xs mb-5">
                        @if(!empty($search))
                            Tidak ada {{ $role }} yang cocok dengan kata kunci "{{ $search }}". Silakan coba kata kunci lain.
                        @else
                            Belum ada data {{ $role }} yang tersedia saat ini.
                        @endif
                    </p>
                    @if(!empty($search))
                        <a href="{{ $role === 'mentor' ? route('mentors.index') : route('coaches.index') }}" class="inline-block px-4 py-2 text-white text-xs font-semibold rounded-xl transition {{ $role === 'mentor' ? 'bg-pink-500 hover:bg-pink-600' : 'bg-purple-600 hover:bg-purple-700' }}">
                            Lihat Semua {{ ucfirst($role) }}
                        </a>
                    @endif
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach($users as $item)
                        @php
                            $userData = [
                                'name' => $item->name,
                                'role_label' => ucfirst($role),
                                'job_title' => $item->job_title ?: ($role === 'mentor' ? 'Professional Beauty Mentor' : 'Professional Beauty Coach'),
                                'location' => implode(', ', array_filter([$item->city, $item->country])),
                                'avatar' => $item->avatar_url,
                                'avatar_letter' => strtoupper(substr($item->name, 0, 1)),
                                'bio' => $item->bio ?: 'Belum ada biografi yang ditambahkan.',
                                'stat_label' => $role === 'mentor' ? 'Anak Bimbingan' : 'Total Kelas',
                                'stat_value' => $role === 'mentor' ? ($item->mentees_count ?? 0) : ($item->courses_count ?? 0),
                                'instagram' => $item->instagram_url,
                                'tiktok' => $item->tiktok_url,
                                'youtube' => $item->youtube_url,
                            ];
                        @endphp

                        <div class="bg-white rounded-2xl border border-pink-100 p-5 shadow-xs hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between cursor-pointer group"
                            @click="show(@js($userData))">
                            <div>
                                {{-- Avatar & Basic Info --}}
                                <div class="flex items-center gap-3.5 mb-3">
                                    <div class="relative shrink-0">
                                        @if($item->avatar_url)
                                            <img src="{{ $item->avatar_url }}" alt="{{ $item->name }}"
                                                class="w-14 h-14 rounded-2xl object-cover ring-2 {{ $role === 'mentor' ? 'ring-pink-100' : 'ring-purple-100' }}">
                                        @else
                                            <div class="w-14 h-14 rounded-2xl flex items-center justify-center font-extrabold text-lg ring-2 {{ $role === 'mentor' ? 'bg-pink-100 text-pink-700 ring-pink-100' : 'bg-purple-100 text-purple-700 ring-purple-100' }}">
                                                {{ strtoupper(substr($item->name, 0, 1)) }}
                                            </div>
                                        @endif
                                        <span class="absolute -bottom-1 -right-1 w-4 h-4 rounded-full flex items-center justify-center text-[9px] text-white border border-white {{ $role === 'mentor' ? 'bg-emerald-500' : 'bg-purple-600' }}" title="Verified">
                                            ✓
                                        </span>
                                    </div>

                                    <div class="min-w-0 flex-1">
                                        <h2 class="font-bold text-gray-900 text-sm truncate group-hover:text-pink-600 transition">
                                            {{ $item->name }}
                                        </h2>
                                        <p class="text-xs truncate mt-0.5 {{ $role === 'mentor' ? 'text-pink-600 font-semibold' : 'text-purple-600 font-semibold' }}">
                                            {{ $item->job_title ?: ($role === 'mentor' ? 'Mentor' : 'Coach') }}
                                        </p>
                                        @if($item->city)
                                            <p class="text-[11px] text-gray-400 truncate mt-0.5">
                                                📍 {{ $item->city }}
                                            </p>
                                        @endif
                                    </div>
                                </div>

                                {{-- Bio snippet --}}
                                <p class="text-xs text-gray-500 line-clamp-2 leading-relaxed mb-3">
                                    {{ $item->bio ?: 'Klik untuk melihat profil dan informasi lengkap.' }}
                                </p>

                                {{-- Stat Badge (Mentor: Anak Bimbingan | Coach: Jumlah Kelas) --}}
                                <div class="flex items-center justify-between py-2 px-3 rounded-xl mb-3 text-xs {{ $role === 'mentor' ? 'bg-pink-50/60 text-pink-700' : 'bg-purple-50/60 text-purple-700' }}">
                                    <span class="text-gray-500 font-medium">
                                        {{ $role === 'mentor' ? 'Anak Bimbingan' : 'Total Kelas' }}:
                                    </span>
                                    <span class="font-bold text-sm">
                                        {{ $role === 'mentor' ? ($item->mentees_count ?? 0) : ($item->courses_count ?? 0) }}
                                    </span>
                                </div>
                            </div>

                            {{-- Footer Card: Social Media Icons + Detail Button --}}
                            <div class="pt-3 border-t border-gray-100 flex items-center justify-between gap-2" @click.stop>
                                {{-- Social Media Icons --}}
                                <div class="flex items-center gap-1.5">
                                    @if($item->instagram_url)
                                        <a href="{{ $item->instagram_url }}" target="_blank" rel="noopener noreferrer"
                                            class="w-7 h-7 rounded-lg bg-pink-50 text-pink-600 hover:bg-pink-500 hover:text-white flex items-center justify-center transition p-1.5" title="Instagram">
                                            <svg class="w-full h-full" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                            </svg>
                                        </a>
                                    @endif
                                    @if($item->tiktok_url)
                                        <a href="{{ $item->tiktok_url }}" target="_blank" rel="noopener noreferrer"
                                            class="w-7 h-7 rounded-lg bg-gray-100 text-gray-800 hover:bg-gray-800 hover:text-white flex items-center justify-center transition p-1.5" title="TikTok">
                                            <svg class="w-full h-full" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.24 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/>
                                            </svg>
                                        </a>
                                    @endif
                                    @if($item->youtube_url)
                                        <a href="{{ $item->youtube_url }}" target="_blank" rel="noopener noreferrer"
                                            class="w-7 h-7 rounded-lg bg-red-50 text-red-600 hover:bg-red-600 hover:text-white flex items-center justify-center transition p-1.5" title="YouTube">
                                            <svg class="w-full h-full" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                                            </svg>
                                        </a>
                                    @endif
                                </div>

                                {{-- Detail Trigger Button --}}
                                <button type="button" @click="show(@js($userData))"
                                    class="py-1 px-3 text-xs font-bold rounded-lg transition {{ $role === 'mentor' ? 'bg-pink-50 text-pink-600 hover:bg-pink-500 hover:text-white' : 'bg-purple-50 text-purple-700 hover:bg-purple-600 hover:text-white' }}">
                                    Info Lengkap →
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Pagination Links --}}
                <div class="mt-8">
                    {{ $users->links() }}
                </div>
            @endif
        </section>

        {{-- COMPACT CTA --}}
        <section class="bg-gradient-to-r from-pink-50/80 to-purple-50/80 border border-pink-100 rounded-2xl p-5 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="text-left">
                <h3 class="font-bold text-gray-900 text-sm sm:text-base">
                    Ingin bergabung menjadi {{ $role === 'mentor' ? 'Mentor' : 'Coach' }} di Salonkita?
                </h3>
                <p class="text-xs text-gray-500">
                    Bagikan keahlian Anda dan bimbing talenta kecantikan profesional di Indonesia.
                </p>
            </div>
            <a href="{{ route('register.mentor-coach', ['role' => $role]) }}"
                class="shrink-0 px-4 py-2 text-white font-semibold text-xs rounded-xl shadow-xs transition {{ $role === 'mentor' ? 'bg-pink-600 hover:bg-pink-700' : 'bg-purple-600 hover:bg-purple-700' }}">
                Daftar Sebagai {{ ucfirst($role) }}
            </a>
        </section>

        {{-- MODAL DETAIL CARD (POPUPS ON CLICK) --}}
        <div x-show="openModal"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-xs"
            style="display: none;">

            <div class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-7 shadow-2xl border border-gray-100 relative overflow-hidden max-h-[90vh] overflow-y-auto"
                @click.away="close()"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95">

                {{-- Close Button (X) --}}
                <button type="button" @click="close()"
                    class="absolute top-4 right-4 w-8 h-8 rounded-full bg-gray-100 hover:bg-gray-200 text-gray-500 hover:text-gray-800 flex items-center justify-center text-sm font-bold transition">
                    ✕
                </button>

                {{-- Header Modal: Avatar & Profile --}}
                <div class="flex items-start gap-4 mb-5 pr-8">
                    <div class="relative shrink-0">
                        <template x-if="user.avatar">
                            <img :src="user.avatar" :alt="user.name"
                                class="w-18 h-18 sm:w-20 sm:h-20 rounded-2xl object-cover ring-2 ring-pink-100 shadow-sm">
                        </template>
                        <template x-if="!user.avatar">
                            <div class="w-18 h-18 sm:w-20 sm:h-20 rounded-2xl bg-gradient-to-br from-pink-400 to-purple-500 text-white flex items-center justify-center font-extrabold text-2xl ring-2 ring-pink-100 shadow-sm">
                                <span x-text="user.avatar_letter"></span>
                            </div>
                        </template>
                        <span class="absolute -bottom-1 -right-1 w-5 h-5 bg-emerald-500 border-2 border-white rounded-full flex items-center justify-center text-[10px] text-white" title="Verified">
                            ✓
                        </span>
                    </div>

                    <div class="min-w-0 flex-1">
                        <span class="inline-block px-2.5 py-0.5 rounded-full text-[11px] font-bold uppercase tracking-wider mb-1"
                            :class="user.role_label === 'Mentor' ? 'bg-pink-100 text-pink-700' : 'bg-purple-100 text-purple-700'"
                            x-text="user.role_label + ' Resmi Salonkita'">
                        </span>
                        <h2 class="text-xl font-bold text-gray-900 leading-snug" x-text="user.name"></h2>
                        <p class="text-xs sm:text-sm font-semibold text-pink-600 mt-0.5" x-text="user.job_title"></p>
                        <template x-if="user.location">
                            <p class="text-xs text-gray-400 mt-0.5 flex items-center gap-1">
                                <span>📍</span> <span x-text="user.location"></span>
                            </p>
                        </template>
                    </div>
                </div>

                {{-- Stat Highlight Box (Cukup jumlah anak bimbingan / jumlah kelas) --}}
                <div class="p-3.5 rounded-2xl mb-5 flex items-center justify-between border border-pink-100/80"
                    :class="user.role_label === 'Mentor' ? 'bg-pink-50/50' : 'bg-purple-50/50'">
                    <span class="text-xs font-semibold text-gray-700" x-text="user.stat_label"></span>
                    <span class="text-base font-extrabold"
                        :class="user.role_label === 'Mentor' ? 'text-pink-600' : 'text-purple-600'"
                        x-text="user.stat_value + ' ' + (user.role_label === 'Mentor' ? 'Murid' : 'Kelas')">
                    </span>
                </div>

                {{-- Full Bio --}}
                <div class="mb-5">
                    <h3 class="text-xs font-bold uppercase text-gray-400 tracking-wider mb-1.5">Biografi</h3>
                    <div class="bg-gray-50 rounded-2xl p-4 border border-gray-100">
                        <p class="text-xs sm:text-sm text-gray-700 leading-relaxed whitespace-pre-line" x-text="user.bio"></p>
                    </div>
                </div>

                {{-- Social Media Icons Section --}}
                <div class="mb-6">
                    <h3 class="text-xs font-bold uppercase text-gray-400 tracking-wider mb-2">Media Sosial</h3>
                    <div class="flex items-center gap-2">
                        {{-- Instagram --}}
                        <template x-if="user.instagram">
                            <a :href="user.instagram" target="_blank" rel="noopener noreferrer"
                                class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl bg-pink-50 text-pink-700 hover:bg-pink-600 hover:text-white text-xs font-semibold transition border border-pink-100">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                </svg>
                                <span>Instagram</span>
                            </a>
                        </template>

                        {{-- TikTok --}}
                        <template x-if="user.tiktok">
                            <a :href="user.tiktok" target="_blank" rel="noopener noreferrer"
                                class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl bg-gray-100 text-gray-800 hover:bg-gray-800 hover:text-white text-xs font-semibold transition border border-gray-200">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.24 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/>
                                </svg>
                                <span>TikTok</span>
                            </a>
                        </template>

                        {{-- YouTube --}}
                        <template x-if="user.youtube">
                            <a :href="user.youtube" target="_blank" rel="noopener noreferrer"
                                class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl bg-red-50 text-red-600 hover:bg-red-600 hover:text-white text-xs font-semibold transition border border-red-100">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                                </svg>
                                <span>YouTube</span>
                            </a>
                        </template>

                        <template x-if="!user.instagram && !user.tiktok && !user.youtube">
                            <p class="text-xs text-gray-400 italic">Belum mencantumkan akun media sosial.</p>
                        </template>
                    </div>
                </div>

                {{-- Action Button --}}
                <div class="pt-2">
                    <button type="button" @click="close()"
                        class="w-full py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold rounded-xl transition">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </main>

    <x-footer />
</x-layout>
