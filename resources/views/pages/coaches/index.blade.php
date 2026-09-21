<x-layout>
    <x-navbar />
    
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-12 py-8">
        {{-- BREADCRUMB --}}
        <nav class="flex items-center gap-2 text-sm text-gray-500 mb-8" aria-label="Breadcrumb">
            <a href="{{ route('home') }}" class="hover:text-pink-600 transition">Beranda</a>
            <span>/</span>
            <span class="text-gray-900 font-semibold">Daftar Coach</span>
        </nav>

        {{-- COMPACT BANNER --}}
        <section class="mb-6">
            <div class="bg-gradient-to-r from-purple-600 to-pink-600 rounded-2xl px-6 py-5 text-white shadow-xs flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <div>
                    <h1 class="text-xl sm:text-2xl font-bold">Coach Salonkita</h1>
                    <p class="text-purple-100 text-xs sm:text-sm mt-0.5">Pengembangan skill dan strategi bisnis bersama coach ahli.</p>
                </div>
                <a href="{{ route('register.mentor-coach', ['role' => 'coach']) }}"
                    class="self-start sm:self-center px-4 py-2 bg-white text-purple-700 hover:bg-purple-50 font-bold text-xs rounded-xl transition shadow-xs">
                    + Jadi Coach
                </a>
            </div>
        </section>

        {{-- SEARCH + INFO --}}
        <section class="mb-8">
            <div class="bg-white border border-pink-100 rounded-2xl p-4 md:p-5 shadow-xs flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <form method="GET" action="{{ route('coaches.index') }}" class="w-full md:max-w-md relative">
                    <input type="text" name="search" value="{{ $search ?? '' }}"
                        placeholder="Cari nama coach, spesialisasi, atau kota..."
                        class="w-full pl-11 pr-24 py-2.5 bg-gray-50 border border-gray-200 text-gray-900 rounded-xl focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-pink-300 focus:bg-white text-sm transition">
                    <svg class="w-5 h-5 text-gray-400 absolute left-3.5 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m1.85-5.15a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <div class="absolute right-2 top-1/2 -translate-y-1/2 flex items-center gap-1.5">
                        @if(!empty($search))
                            <a href="{{ route('coaches.index') }}" class="px-2.5 py-1 rounded-lg text-xs font-medium text-gray-500 hover:bg-gray-200 transition">
                                Reset
                            </a>
                        @endif
                        <button type="submit" class="px-3 py-1 bg-pink-500 text-white text-xs font-semibold rounded-lg hover:bg-pink-600 transition">
                            Cari
                        </button>
                    </div>
                </form>

                <p class="text-sm text-gray-600">
                    Menampilkan <span class="font-bold text-pink-600">{{ $coaches->count() }}</span> dari <span class="font-bold text-pink-600">{{ $coaches->total() }}</span> Coach
                </p>
            </div>
        </section>

        {{-- COACHES GRID --}}
        <section class="mb-14">
            @if($coaches->isEmpty())
                <div class="bg-white border border-pink-100 rounded-3xl p-12 text-center max-w-md mx-auto shadow-sm">
                    <div class="w-16 h-16 bg-purple-50 text-purple-500 rounded-2xl flex items-center justify-center mx-auto mb-4 text-2xl font-bold">
                        ✦
                    </div>
                    <h2 class="text-xl font-bold text-gray-900 mb-2">Coach Tidak Ditemukan</h2>
                    <p class="text-gray-500 text-sm mb-6">
                        @if(!empty($search))
                            Tidak ada coach yang cocok dengan kata kunci "{{ $search }}". Silakan coba kata kunci lain.
                        @else
                            Belum ada data coach yang tersedia saat ini.
                        @endif
                    </p>
                    @if(!empty($search))
                        <a href="{{ route('coaches.index') }}" class="inline-block px-5 py-2.5 bg-pink-500 text-white text-sm font-semibold rounded-xl hover:bg-pink-600 transition">
                            Lihat Semua Coach
                        </a>
                    @endif
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach($coaches as $coach)
                        <div class="bg-white rounded-2xl border border-pink-100 p-6 shadow-xs hover:shadow-xl hover:border-purple-300 hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between">
                            <div>
                                {{-- Avatar & Header --}}
                                <div class="flex items-center gap-4 mb-4">
                                    <div class="relative shrink-0">
                                        @if($coach->avatar_url)
                                            <img src="{{ $coach->avatar_url }}" alt="{{ $coach->name }}"
                                                class="w-16 h-16 rounded-2xl object-cover ring-2 ring-purple-100">
                                        @else
                                            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-purple-100 to-pink-200 text-purple-700 flex items-center justify-center font-extrabold text-xl ring-2 ring-purple-100">
                                                {{ strtoupper(substr($coach->name, 0, 1)) }}
                                            </div>
                                        @endif
                                        <span class="absolute -bottom-1 -right-1 w-5 h-5 bg-purple-600 border-2 border-white rounded-full flex items-center justify-center text-[10px] text-white" title="Certified Coach">
                                            ★
                                        </span>
                                    </div>

                                    <div class="min-w-0 flex-1">
                                        <h2 class="font-bold text-gray-900 text-base truncate hover:text-pink-600 transition">
                                            <a href="{{ route('coaches.show', $coach->id) }}">{{ $coach->name }}</a>
                                        </h2>
                                        <p class="text-xs font-semibold text-purple-600 truncate mt-0.5">
                                            {{ $coach->job_title ?: 'Professional Coach' }}
                                        </p>
                                        @if($coach->city)
                                            <p class="text-[11px] text-gray-500 truncate mt-0.5 flex items-center gap-1">
                                                <span>📍</span> {{ $coach->city }}
                                            </p>
                                        @endif
                                    </div>
                                </div>

                                {{-- Bio snippet --}}
                                <p class="text-xs text-gray-600 line-clamp-3 leading-relaxed mb-4">
                                    {{ $coach->bio ?: 'Coach profesional yang berfokus membimbing pengembangan keahlian dan wirausaha di industri kecantikan.' }}
                                </p>

                                {{-- Stats badge --}}
                                <div class="flex items-center gap-2 py-2 px-3 bg-purple-50/50 rounded-xl mb-4 text-xs text-gray-700">
                                    <span class="font-bold text-purple-600">{{ $coach->courses_count }}</span> Kelas Asuhan
                                </div>
                            </div>

                            {{-- Action button --}}
                            <a href="{{ route('coaches.show', $coach->id) }}"
                                class="w-full text-center py-2.5 px-4 bg-purple-50 text-purple-700 font-bold text-xs rounded-xl hover:bg-purple-600 hover:text-white transition duration-200">
                                Lihat Profil & Kelas
                            </a>
                        </div>
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="mt-8">
                    {{ $coaches->links() }}
                </div>
            @endif
        </section>

        {{-- COMPACT CTA --}}
        <section class="bg-purple-50/70 border border-purple-100 rounded-2xl p-5 text-center flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="text-left">
                <h3 class="font-bold text-gray-900 text-sm sm:text-base">Ingin berbagi pengalaman sebagai Coach?</h3>
                <p class="text-xs text-gray-500">Bergabunglah untuk mencetak talenta beauty terbaik bersama Salonkita.</p>
            </div>
            <a href="{{ route('register.mentor-coach', ['role' => 'coach']) }}"
                class="shrink-0 px-4 py-2 bg-purple-600 text-white font-semibold text-xs rounded-xl hover:bg-purple-700 transition shadow-xs">
                Daftar Sebagai Coach
            </a>
        </section>
    </main>

    <x-footer />
</x-layout>
