<x-layout>
    <x-navbar />
    
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-12 py-8">
        {{-- BREADCRUMB --}}
        <nav class="flex items-center gap-2 text-sm text-gray-500 mb-8" aria-label="Breadcrumb">
            <a href="{{ route('home') }}" class="hover:text-pink-600 transition">Beranda</a>
            <span>/</span>
            <span class="text-gray-900 font-semibold">Daftar Mentor</span>
        </nav>

        {{-- COMPACT BANNER --}}
        <section class="mb-6">
            <div class="bg-gradient-to-r from-pink-500 to-rose-500 rounded-2xl px-6 py-5 text-white shadow-xs flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <div>
                    <h1 class="text-xl sm:text-2xl font-bold">Mentor Salonkita</h1>
                    <p class="text-pink-100 text-xs sm:text-sm mt-0.5">Bimbingan kecantikan langsung bersama praktisi ahli.</p>
                </div>
                <a href="{{ route('register.mentor-coach', ['role' => 'mentor']) }}"
                    class="self-start sm:self-center px-4 py-2 bg-white text-pink-600 hover:bg-pink-50 font-bold text-xs rounded-xl transition shadow-xs">
                    + Jadi Mentor
                </a>
            </div>
        </section>

        {{-- SEARCH + INFO --}}
        <section class="mb-8">
            <div class="bg-white border border-pink-100 rounded-2xl p-4 md:p-5 shadow-xs flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <form method="GET" action="{{ route('mentors.index') }}" class="w-full md:max-w-md relative">
                    <input type="text" name="search" value="{{ $search ?? '' }}"
                        placeholder="Cari nama mentor, profesi, atau kota..."
                        class="w-full pl-11 pr-24 py-2.5 bg-gray-50 border border-gray-200 text-gray-900 rounded-xl focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-pink-300 focus:bg-white text-sm transition">
                    <svg class="w-5 h-5 text-gray-400 absolute left-3.5 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m1.85-5.15a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <div class="absolute right-2 top-1/2 -translate-y-1/2 flex items-center gap-1.5">
                        @if(!empty($search))
                            <a href="{{ route('mentors.index') }}" class="px-2.5 py-1 rounded-lg text-xs font-medium text-gray-500 hover:bg-gray-200 transition">
                                Reset
                            </a>
                        @endif
                        <button type="submit" class="px-3 py-1 bg-pink-500 text-white text-xs font-semibold rounded-lg hover:bg-pink-600 transition">
                            Cari
                        </button>
                    </div>
                </form>

                <p class="text-sm text-gray-600">
                    Menampilkan <span class="font-bold text-pink-600">{{ $mentors->count() }}</span> dari <span class="font-bold text-pink-600">{{ $mentors->total() }}</span> Mentor
                </p>
            </div>
        </section>

        {{-- MENTORS GRID --}}
        <section class="mb-14">
            @if($mentors->isEmpty())
                <div class="bg-white border border-pink-100 rounded-3xl p-12 text-center max-w-md mx-auto shadow-sm">
                    <div class="w-16 h-16 bg-pink-50 text-pink-500 rounded-2xl flex items-center justify-center mx-auto mb-4 text-2xl font-bold">
                        ✦
                    </div>
                    <h2 class="text-xl font-bold text-gray-900 mb-2">Mentor Tidak Ditemukan</h2>
                    <p class="text-gray-500 text-sm mb-6">
                        @if(!empty($search))
                            Tidak ada mentor yang cocok dengan kata kunci "{{ $search }}". Silakan coba kata kunci lain.
                        @else
                            Belum ada data mentor yang tersedia saat ini.
                        @endif
                    </p>
                    @if(!empty($search))
                        <a href="{{ route('mentors.index') }}" class="inline-block px-5 py-2.5 bg-pink-500 text-white text-sm font-semibold rounded-xl hover:bg-pink-600 transition">
                            Lihat Semua Mentor
                        </a>
                    @endif
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach($mentors as $mentor)
                        <div class="bg-white rounded-2xl border border-pink-100 p-6 shadow-xs hover:shadow-xl hover:border-pink-300 hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between">
                            <div>
                                {{-- Avatar & Header --}}
                                <div class="flex items-center gap-4 mb-4">
                                    <div class="relative shrink-0">
                                        @if($mentor->avatar_url)
                                            <img src="{{ $mentor->avatar_url }}" alt="{{ $mentor->name }}"
                                                class="w-16 h-16 rounded-2xl object-cover ring-2 ring-pink-100">
                                        @else
                                            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-pink-100 to-rose-200 text-pink-700 flex items-center justify-center font-extrabold text-xl ring-2 ring-pink-100">
                                                {{ strtoupper(substr($mentor->name, 0, 1)) }}
                                            </div>
                                        @endif
                                        <span class="absolute -bottom-1 -right-1 w-5 h-5 bg-emerald-500 border-2 border-white rounded-full flex items-center justify-center text-[10px] text-white" title="Verified Mentor">
                                            ✓
                                        </span>
                                    </div>

                                    <div class="min-w-0 flex-1">
                                        <h2 class="font-bold text-gray-900 text-base truncate hover:text-pink-600 transition">
                                            <a href="{{ route('mentors.show', $mentor->id) }}">{{ $mentor->name }}</a>
                                        </h2>
                                        <p class="text-xs font-semibold text-pink-600 truncate mt-0.5">
                                            {{ $mentor->job_title ?: 'Professional Mentor' }}
                                        </p>
                                        @if($mentor->city)
                                            <p class="text-[11px] text-gray-500 truncate mt-0.5 flex items-center gap-1">
                                                <span>📍</span> {{ $mentor->city }}
                                            </p>
                                        @endif
                                    </div>
                                </div>

                                {{-- Bio snippet --}}
                                <p class="text-xs text-gray-600 line-clamp-3 leading-relaxed mb-4">
                                    {{ $mentor->bio ?: 'Mentor berpengalaman di industri kecantikan yang siap membimbing Anda mencapai potensi terbaik.' }}
                                </p>

                                {{-- Stats badge --}}
                                <div class="flex items-center gap-2 py-2 px-3 bg-pink-50/50 rounded-xl mb-4 text-xs text-gray-700">
                                    <span class="font-bold text-pink-600">{{ $mentor->courses_count }}</span> Kelas Diajar
                                </div>
                            </div>

                            {{-- Action button --}}
                            <a href="{{ route('mentors.show', $mentor->id) }}"
                                class="w-full text-center py-2.5 px-4 bg-pink-50 text-pink-600 font-bold text-xs rounded-xl hover:bg-pink-500 hover:text-white transition duration-200">
                                Lihat Profil & Kelas
                            </a>
                        </div>
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="mt-8">
                    {{ $mentors->links() }}
                </div>
            @endif
        </section>

        {{-- COMPACT CTA --}}
        <section class="bg-pink-50/70 border border-pink-100 rounded-2xl p-5 text-center flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="text-left">
                <h3 class="font-bold text-gray-900 text-sm sm:text-base">Tertarik berbagi ilmu sebagai Mentor?</h3>
                <p class="text-xs text-gray-500">Bergabunglah dan bimbing para calon profesional kecantikan di Salonkita.</p>
            </div>
            <a href="{{ route('register.mentor-coach', ['role' => 'mentor']) }}"
                class="shrink-0 px-4 py-2 bg-pink-600 text-white font-semibold text-xs rounded-xl hover:bg-pink-700 transition shadow-xs">
                Daftar Sebagai Mentor
            </a>
        </section>
    </main>

    <x-footer />
</x-layout>
