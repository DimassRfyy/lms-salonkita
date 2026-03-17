<x-layout>
    <x-navbar />
    <!-- MAIN CONTENT -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-12 py-8">
        <!-- GREETING SECTION -->
        <section class="mb-12">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">
                Tugas Saya
            </h1>
            <p class="text-lg text-gray-600">
                Kelola dan pantau semua tugas kelas Anda!
            </p>
        </section>

        <section class="mb-12 space-y-6">
            @forelse ($taskCourses as $taskCourse)
                <div class="bg-white rounded-xl overflow-hidden shadow-md border border-pink-100 hover:shadow-lg transition">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-0">
                        <div class="h-48 md:h-auto relative overflow-hidden">
                            <img src="{{ $taskCourse->course->thumbnail ? Storage::url($taskCourse->course->thumbnail) : asset('assets/images/thumbnails/img_placeholder.png') }}"
                                alt="Thumbnail {{ $taskCourse->course->name }}"
                                class="w-full h-full object-cover"
                                onerror="this.onerror=null;this.src='{{ asset('assets/images/thumbnails/img_placeholder.png') }}';">
                        </div>
                        <div class="md:col-span-2 p-6 md:p-8">
                            <div class="flex flex-wrap items-center gap-2 mb-2">
                                <span class="text-xs font-semibold px-2.5 py-1 rounded-full {{ $taskCourse->status_badge_class }}">{{ $taskCourse->status_label }}</span>
                                <span class="text-xs text-gray-500">{{ $taskCourse->watched_videos_count }}/{{ $taskCourse->total_videos_count }} video selesai</span>
                                @if (! is_null($taskCourse->score))
                                    <span class="text-xs font-semibold text-sky-700 bg-sky-100 px-2.5 py-1 rounded-full">Nilai {{ $taskCourse->score }}/100</span>
                                @endif
                            </div>

                            <h3 class="text-xl font-bold text-gray-900 mb-1">{{ $taskCourse->course->name }}</h3>
                            <p class="text-sm text-pink-600 font-medium mb-3">{{ $taskCourse->course->category?->name ?? 'Tanpa kategori' }}</p>

                            <div class="mb-3">
                                <div class="flex justify-between items-center mb-2">
                                    <span class="text-sm text-gray-600">Progress</span>
                                    <span class="text-sm font-bold text-gray-900">{{ $taskCourse->progress_percentage }}%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2.5">
                                    <div class="{{ $taskCourse->progress_bar_class }} h-2.5 rounded-full" style="width: {{ $taskCourse->progress_percentage }}%"></div>
                                </div>
                            </div>

                            <p class="text-sm text-gray-600 mb-2">{{ $taskCourse->description }}</p>

                            @if ($taskCourse->submitted_at)
                                <p class="text-xs text-gray-500 mb-1">Dikirim {{ $taskCourse->submitted_at->translatedFormat('d F Y H:i') }}</p>
                            @endif

                            <div class="mb-5"></div>

                            <div class="flex flex-col sm:flex-row gap-3">
                                <a href="{{ $taskCourse->primary_action_url }}"
                                    @if (str_starts_with($taskCourse->primary_action_url, 'http')) rel="noreferrer" @endif
                                    class="px-5 py-2.5 bg-pink-500 text-white font-semibold rounded-lg hover:bg-pink-600 transition w-full sm:w-auto text-center">
                                    {{ $taskCourse->primary_action_label }}
                                </a>

                                @if ($taskCourse->secondary_action_label && $taskCourse->secondary_action_url)
                                    <a href="{{ $taskCourse->secondary_action_url }}"
                                        class="px-5 py-2.5 border border-pink-200 text-pink-600 font-semibold rounded-lg hover:bg-pink-50 transition w-full sm:w-auto text-center">
                                        {{ $taskCourse->secondary_action_label }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-xl border border-pink-100 shadow-md p-8 text-center">
                    <h2 class="text-xl font-bold text-gray-900 mb-2">Belum ada kelas yang dimiliki</h2>
                    <p class="text-gray-600 mb-5">Setelah membeli kelas, progress tugas dan status review akan muncul di halaman ini.</p>
                    <a href="{{ route('all-courses') }}"
                        class="inline-flex items-center justify-center px-5 py-2.5 bg-pink-500 text-white font-semibold rounded-lg hover:bg-pink-600 transition">
                        Jelajahi Kelas
                    </a>
                </div>
            @endforelse
        </section>
    </main>
    <x-footer />
</x-layout>