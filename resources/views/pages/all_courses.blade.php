<x-layout>
    <x-navbar />
    <x-breadcrumb />
    <!-- MAIN CONTENT -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-12 py-8">
        <!-- GREETING SECTION -->
        <section class="mb-12">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">
                Semua Kelas
            </h1>
            <p class="text-lg text-gray-600">
                Jelajahi semua kelas yang tersedia dan temukan yang cocok untuk Anda!
            </p>
        </section>

        <!-- SEARCH + RESULT INFO (UI ONLY) -->
        <section class="mb-8">
            <div class="bg-white border border-pink-100 rounded-2xl p-4 md:p-5 shadow-sm">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <form method="GET" action="{{ route('all-courses') }}" class="w-full md:max-w-md relative">
                        @if(!empty($activeLevel))
                            <input type="hidden" name="level" value="{{ $activeLevel }}">
                        @endif
                        <input type="text" name="search" value="{{ $search ?? '' }}"
                            placeholder="Cari kelas berdasarkan nama..."
                            class="w-full pl-11 pr-24 py-3 bg-gray-50 border border-gray-200 text-gray-900 rounded-xl focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-pink-300 focus:bg-white transition">
                        <svg class="w-5 h-5 text-gray-400 absolute left-3.5 top-1/2 -translate-y-1/2" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-4.35-4.35m1.85-5.15a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <div class="absolute right-2 top-1/2 -translate-y-1/2 flex items-center gap-2">
                            @if(!empty($search))
                                <a href="{{ route('all-courses', array_filter(['level' => $activeLevel])) }}"
                                    class="px-3 py-1.5 rounded-lg text-sm font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-100 transition">
                                    Reset
                                </a>
                            @endif
                            <button type="submit"
                                class="px-3.5 py-1.5 rounded-lg bg-pink-500 text-white text-sm font-medium hover:bg-pink-600 transition">
                                Cari
                            </button>
                        </div>
                    </form>
                    <p class="text-sm md:text-base text-gray-600">
                        Menampilkan <span class="font-semibold text-pink-600">{{ $courses->count() }}</span> dari <span
                            class="font-semibold text-pink-600">{{ $courses->total() }}</span> kelas
                    </p>
                </div>

                {{-- LEVEL FILTER TABS --}}
                <div class="flex items-center gap-2 pt-4 mt-4 border-t border-gray-100 overflow-x-auto pb-1">
                    <span class="text-xs font-bold text-gray-400 uppercase tracking-wider mr-2 shrink-0">Level:</span>
                    <a href="{{ route('all-courses', array_filter(['search' => $search])) }}"
                        class="px-3.5 py-1.5 rounded-full text-xs font-bold transition shrink-0 {{ empty($activeLevel) ? 'bg-pink-500 text-white shadow-xs' : 'bg-gray-100 text-gray-600 hover:bg-pink-50 hover:text-pink-600' }}">
                        Semua Level
                    </a>
                    <a href="{{ route('all-courses', array_filter(['search' => $search, 'level' => 'basic'])) }}"
                        class="px-3.5 py-1.5 rounded-full text-xs font-bold transition shrink-0 {{ $activeLevel === 'basic' ? 'bg-emerald-500 text-white shadow-xs' : 'bg-gray-100 text-gray-600 hover:bg-emerald-50 hover:text-emerald-600' }}">
                        Basic (Free)
                    </a>
                    <a href="{{ route('all-courses', array_filter(['search' => $search, 'level' => 'intermediate'])) }}"
                        class="px-3.5 py-1.5 rounded-full text-xs font-bold transition shrink-0 {{ $activeLevel === 'intermediate' ? 'bg-sky-600 text-white shadow-xs' : 'bg-gray-100 text-gray-600 hover:bg-sky-50 hover:text-sky-600' }}">
                        Intermediate
                    </a>
                    <a href="{{ route('all-courses', array_filter(['search' => $search, 'level' => 'advanced'])) }}"
                        class="px-3.5 py-1.5 rounded-full text-xs font-bold transition shrink-0 {{ $activeLevel === 'advanced' ? 'bg-purple-600 text-white shadow-xs' : 'bg-gray-100 text-gray-600 hover:bg-purple-50 hover:text-purple-600' }}">
                        Advanced
                    </a>
                </div>
            </div>
        </section>

        @if(!empty($search) || !empty($activeLevel))
            <section class="mb-6 flex flex-wrap items-center gap-2">
                @if(!empty($search))
                    <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-pink-50 text-pink-700 border border-pink-100 text-xs font-semibold">
                        <span>Pencarian: "{{ $search }}"</span>
                        <a href="{{ route('all-courses', array_filter(['level' => $activeLevel])) }}" class="hover:text-pink-900 font-bold ml-1">×</a>
                    </div>
                @endif
                @if(!empty($activeLevel))
                    <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-pink-50 text-pink-700 border border-pink-100 text-xs font-semibold">
                        <span>Level: {{ ucfirst($activeLevel) }}</span>
                        <a href="{{ route('all-courses', array_filter(['search' => $search])) }}" class="hover:text-pink-900 font-bold ml-1">×</a>
                    </div>
                @endif
            </section>
        @endif

        <!-- RECOMMENDATIONS SECTION -->
        <section class="mb-12">

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @forelse($courses as $course)
                    @php($isSaved = ($savedCourseIds ?? collect())->contains($course->id))
                    <x-course-card :course="$course" :show-save="true" :is-saved="$isSaved" />
                @empty
                    <div
                        class="md:col-span-2 lg:col-span-4 bg-white border border-pink-100 rounded-2xl p-8 text-center text-gray-600">
                        Belum ada kelas yang dipublikasikan.
                    </div>
                @endforelse
            </div>

            <div class="mt-10">
                {{ $courses->links() }}
            </div>
        </section>
    </main>

    <x-footer />

    <!-- JAVASCRIPT -->
    <script>
        // Smooth interactions and mobile menu
        document.addEventListener('DOMContentLoaded', function () {
            console.log('[v0] Dashboard loaded successfully');
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', function (event) {
            const navbar = document.querySelector('nav');
            if (!navbar.contains(event.target)) {
                // Add any additional dropdown close logic here if needed
            }
        });
    </script>
</x-layout>