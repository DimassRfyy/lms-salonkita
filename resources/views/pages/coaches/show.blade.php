<x-layout>
    <x-navbar />

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-12 py-8">
        {{-- BREADCRUMB --}}
        <nav class="flex items-center gap-2 text-sm text-gray-500 mb-8" aria-label="Breadcrumb">
            <a href="{{ route('home') }}" class="hover:text-pink-600 transition">Beranda</a>
            <span>/</span>
            <a href="{{ route('coaches.index') }}" class="hover:text-pink-600 transition">Coach</a>
            <span>/</span>
            <span class="text-gray-900 font-semibold truncate">{{ $coach->name }}</span>
        </nav>

        {{-- PROFILE CARD --}}
        <section class="bg-white border border-purple-100 rounded-3xl p-6 sm:p-10 shadow-sm mb-12">
            <div class="flex flex-col md:flex-row items-center md:items-start gap-6 sm:gap-8">
                {{-- Avatar --}}
                <div class="relative shrink-0">
                    @if($coach->avatar_url)
                        <img src="{{ $coach->avatar_url }}" alt="{{ $coach->name }}"
                            class="w-28 h-28 sm:w-36 sm:h-36 rounded-3xl object-cover ring-4 ring-purple-100 shadow-md">
                    @else
                        <div class="w-28 h-28 sm:w-36 sm:h-36 rounded-3xl bg-gradient-to-br from-purple-500 to-pink-500 text-white flex items-center justify-center font-black text-4xl sm:text-5xl ring-4 ring-purple-100 shadow-md">
                            {{ strtoupper(substr($coach->name, 0, 1)) }}
                        </div>
                    @endif
                    <span class="absolute -bottom-2 -right-2 bg-purple-600 text-white p-1.5 rounded-full border-2 border-white shadow-sm flex items-center justify-center text-xs" title="Certified Coach">
                        ★
                    </span>
                </div>

                {{-- Coach Info --}}
                <div class="flex-1 text-center md:text-left">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-2">
                        <div>
                            <span class="inline-block px-3 py-1 bg-purple-100 text-purple-700 rounded-full text-xs font-bold uppercase tracking-wider mb-2">
                                Coach Resmi Salonkita
                            </span>
                            <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900">
                                {{ $coach->name }}
                            </h1>
                            <p class="text-sm sm:text-base font-semibold text-purple-600 mt-0.5">
                                {{ $coach->job_title ?: 'Professional Beauty Coach' }}
                            </p>
                        </div>

                        {{-- Social Links --}}
                        <div class="flex items-center justify-center md:justify-start gap-2.5">
                            @if($coach->instagram_url)
                                <a href="{{ $coach->instagram_url }}" target="_blank" rel="noopener noreferrer"
                                    class="w-9 h-9 rounded-xl bg-purple-50 text-purple-600 hover:bg-purple-600 hover:text-white flex items-center justify-center transition font-semibold text-xs" title="Instagram">
                                    IG
                                </a>
                            @endif
                            @if($coach->tiktok_url)
                                <a href="{{ $coach->tiktok_url }}" target="_blank" rel="noopener noreferrer"
                                    class="w-9 h-9 rounded-xl bg-gray-100 text-gray-800 hover:bg-gray-800 hover:text-white flex items-center justify-center transition font-semibold text-xs" title="TikTok">
                                    TT
                                </a>
                            @endif
                            @if($coach->youtube_url)
                                <a href="{{ $coach->youtube_url }}" target="_blank" rel="noopener noreferrer"
                                    class="w-9 h-9 rounded-xl bg-red-50 text-red-600 hover:bg-red-600 hover:text-white flex items-center justify-center transition font-semibold text-xs" title="YouTube">
                                    YT
                                </a>
                            @endif
                        </div>
                    </div>

                    @if($coach->city || $coach->country)
                        <p class="text-xs sm:text-sm text-gray-500 mb-4 flex items-center justify-center md:justify-start gap-1.5">
                            <span>📍</span> {{ implode(', ', array_filter([$coach->city, $coach->country])) }}
                        </p>
                    @endif

                    <div class="border-t border-gray-100 pt-4 mt-2">
                        <h2 class="text-xs font-bold uppercase text-gray-400 tracking-wider mb-2">Tentang Coach</h2>
                        <p class="text-gray-700 text-sm sm:text-base leading-relaxed whitespace-pre-line">
                            {{ $coach->bio ?: 'Coach ini belum menambahkan biografi ringkas.' }}
                        </p>
                    </div>
                </div>
            </div>
        </section>

        {{-- COURSES SECTION --}}
        <section class="mb-14">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Kelas yang Diasuh</h2>
                    <p class="text-gray-500 text-sm mt-1">Daftar program dan kelas yang dibimbing oleh {{ $coach->name }}</p>
                </div>
                <span class="px-3.5 py-1.5 bg-purple-50 text-purple-700 rounded-full text-xs font-bold border border-purple-100">
                    {{ $courses->total() }} Kelas
                </span>
            </div>

            @if($courses->isEmpty())
                <div class="bg-white border border-purple-100 rounded-2xl p-10 text-center">
                    <p class="text-gray-500 text-sm">Coach ini belum mempublikasikan kelas pembelajaran saat ini.</p>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach($courses as $course)
                        <x-course-card :course="$course" :is-saved="$savedCourseIds->contains($course->id)" :show-save="auth()->check()" />
                    @endforeach
                </div>

                <div class="mt-8">
                    {{ $courses->links() }}
                </div>
            @endif
        </section>

        {{-- BACK BUTTON --}}
        <div class="text-center">
            <a href="{{ route('coaches.index') }}"
                class="inline-flex items-center gap-2 px-6 py-2.5 bg-white border border-gray-200 text-gray-700 font-semibold text-sm rounded-xl hover:bg-gray-50 hover:text-purple-600 transition shadow-xs">
                <span>←</span> Kembali ke Daftar Coach
            </a>
        </div>
    </main>

    <x-footer />
</x-layout>
