<x-layout>
    <x-navbar />

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-12 py-8">
        {{-- BREADCRUMB --}}
        <nav class="flex items-center gap-2 text-sm text-gray-500 mb-8" aria-label="Breadcrumb">
            <a href="{{ route('home') }}" class="hover:text-pink-600 transition">Beranda</a>
            <span>/</span>
            <a href="{{ route('mentors.index') }}" class="hover:text-pink-600 transition">Mentor</a>
            <span>/</span>
            <span class="text-gray-900 font-semibold truncate">{{ $mentor->name }}</span>
        </nav>

        {{-- PROFILE CARD --}}
        <section class="bg-white border border-pink-100 rounded-3xl p-6 sm:p-10 shadow-sm mb-12">
            <div class="flex flex-col md:flex-row items-center md:items-start gap-6 sm:gap-8">
                {{-- Avatar --}}
                <div class="relative shrink-0">
                    @if($mentor->avatar_url)
                        <img src="{{ $mentor->avatar_url }}" alt="{{ $mentor->name }}"
                            class="w-28 h-28 sm:w-36 sm:h-36 rounded-3xl object-cover ring-4 ring-pink-100 shadow-md">
                    @else
                        <div class="w-28 h-28 sm:w-36 sm:h-36 rounded-3xl bg-gradient-to-br from-pink-400 to-rose-500 text-white flex items-center justify-center font-black text-4xl sm:text-5xl ring-4 ring-pink-100 shadow-md">
                            {{ strtoupper(substr($mentor->name, 0, 1)) }}
                        </div>
                    @endif
                    <span class="absolute -bottom-2 -right-2 bg-emerald-500 text-white p-1.5 rounded-full border-2 border-white shadow-sm flex items-center justify-center text-xs" title="Verified Mentor">
                        ✓
                    </span>
                </div>

                {{-- Mentor Info --}}
                <div class="flex-1 text-center md:text-left">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-2">
                        <div>
                            <span class="inline-block px-3 py-1 bg-pink-100 text-pink-700 rounded-full text-xs font-bold uppercase tracking-wider mb-2">
                                Mentor Resmi Salonkita
                            </span>
                            <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900">
                                {{ $mentor->name }}
                            </h1>
                            <p class="text-sm sm:text-base font-semibold text-pink-600 mt-0.5">
                                {{ $mentor->job_title ?: 'Professional Beauty Mentor' }}
                            </p>
                        </div>

                        {{-- Social Links --}}
                        <div class="flex items-center justify-center md:justify-start gap-2.5">
                            @if($mentor->instagram_url)
                                <a href="{{ $mentor->instagram_url }}" target="_blank" rel="noopener noreferrer"
                                    class="w-9 h-9 rounded-xl bg-pink-50 text-pink-600 hover:bg-pink-500 hover:text-white flex items-center justify-center transition font-semibold text-xs" title="Instagram">
                                    IG
                                </a>
                            @endif
                            @if($mentor->tiktok_url)
                                <a href="{{ $mentor->tiktok_url }}" target="_blank" rel="noopener noreferrer"
                                    class="w-9 h-9 rounded-xl bg-gray-100 text-gray-800 hover:bg-gray-800 hover:text-white flex items-center justify-center transition font-semibold text-xs" title="TikTok">
                                    TT
                                </a>
                            @endif
                            @if($mentor->youtube_url)
                                <a href="{{ $mentor->youtube_url }}" target="_blank" rel="noopener noreferrer"
                                    class="w-9 h-9 rounded-xl bg-red-50 text-red-600 hover:bg-red-600 hover:text-white flex items-center justify-center transition font-semibold text-xs" title="YouTube">
                                    YT
                                </a>
                            @endif
                        </div>
                    </div>

                    @if($mentor->city || $mentor->country)
                        <p class="text-xs sm:text-sm text-gray-500 mb-4 flex items-center justify-center md:justify-start gap-1.5">
                            <span>📍</span> {{ implode(', ', array_filter([$mentor->city, $mentor->country])) }}
                        </p>
                    @endif

                    <div class="border-t border-gray-100 pt-4 mt-2">
                        <h2 class="text-xs font-bold uppercase text-gray-400 tracking-wider mb-2">Tentang Mentor</h2>
                        <p class="text-gray-700 text-sm sm:text-base leading-relaxed whitespace-pre-line">
                            {{ $mentor->bio ?: 'Mentor ini belum menambahkan biografi ringkas.' }}
                        </p>
                    </div>
                </div>
            </div>
        </section>

        {{-- COURSES SECTION --}}
        <section class="mb-14">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Kelas yang Diajarkan</h2>
                    <p class="text-gray-500 text-sm mt-1">Daftar kelas pembelajaran yang dipandu oleh {{ $mentor->name }}</p>
                </div>
                <span class="px-3.5 py-1.5 bg-pink-50 text-pink-700 rounded-full text-xs font-bold border border-pink-100">
                    {{ $courses->total() }} Kelas
                </span>
            </div>

            @if($courses->isEmpty())
                <div class="bg-white border border-pink-100 rounded-2xl p-10 text-center">
                    <p class="text-gray-500 text-sm">Mentor ini belum mempublikasikan kelas pembelajaran saat ini.</p>
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
            <a href="{{ route('mentors.index') }}"
                class="inline-flex items-center gap-2 px-6 py-2.5 bg-white border border-gray-200 text-gray-700 font-semibold text-sm rounded-xl hover:bg-gray-50 hover:text-pink-600 transition shadow-xs">
                <span>←</span> Kembali ke Daftar Mentor
            </a>
        </div>
    </main>

    <x-footer />
</x-layout>
