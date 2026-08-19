<x-layout>
    <x-navbar />

    <x-breadcrumb url="javascript:history.back()" label="Kembali" />

    <main class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mb-8">Pembayaran</h1>

        @php
            $totalDurationSeconds = (int) ($course->total_duration_seconds ?? 0);
            $hours = intdiv($totalDurationSeconds, 3600);
            $minutes = intdiv($totalDurationSeconds % 3600, 60);
            $durationLabel = $totalDurationSeconds > 0
                ? trim(($hours > 0 ? $hours . ' jam ' : '') . max($minutes, 1) . ' menit')
                : 'Durasi belum tersedia';
        @endphp

        <form method="POST" action="{{ route('transaction.store') }}"
            class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
            @csrf
            <input type="hidden" name="course_id" value="{{ $course->id }}">

            @if ($errors->any())
                <div class="lg:col-span-3 bg-red-50 border border-red-100 text-red-600 rounded-xl p-4 text-sm">
                    <ul class="space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-2xl shadow-sm border border-pink-100 p-6 sm:p-8">
                    <!-- Detail Kelas -->
                    <div class="flex flex-col sm:flex-row gap-4 pb-6 border-b border-gray-100">
                        <div class="w-full sm:w-28 h-28 sm:h-20 rounded-xl overflow-hidden shrink-0 bg-pink-100 border border-pink-100 shadow-xs">
                            <img src="{{ $course->thumbnail ? Storage::url($course->thumbnail) : asset('assets/images/thumbnails/img_placeholder.png') }}"
                                alt="Thumbnail Kelas"
                                onerror="this.onerror=null;this.src='{{ asset('assets/images/thumbnails/img_placeholder.png') }}';"
                                class="w-full h-full object-cover">
                        </div>
                        <div class="flex-1 min-w-0 flex flex-col justify-between">
                            <div>
                                <span class="text-xs text-pink-500 font-semibold uppercase tracking-wider">{{ $course->category->name }}</span>
                                <h2 class="text-base sm:text-lg font-bold text-gray-900 leading-snug mt-1">{{ $course->name }}</h2>
                            </div>
                            <div class="flex flex-wrap items-center gap-3 text-xs text-gray-600 font-medium mt-3">
                                <span class="inline-flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5 text-yellow-400 fill-yellow-400 shrink-0" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    {{ $course->rating_label }}
                                </span>
                                <span>•</span>
                                <span>{{ number_format((int) ($course->videos_count ?? 0)) }} Video</span>
                                <span>•</span>
                                <span>{{ $durationLabel }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Benefit -->
                    <div class="mt-6">
                        <h3 class="text-sm font-bold text-gray-900 mb-3">Keuntungan yang Didapatkan</h3>
                        <ul class="space-y-2.5 text-sm text-gray-600">
                            <li class="flex items-center gap-2.5">
                                <svg class="w-4 h-4 text-pink-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <span>Akses materi selamanya (Lifetime Access)</span>
                            </li>
                            <li class="flex items-center gap-2.5">
                                <svg class="w-4 h-4 text-pink-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <span>Sertifikat kelulusan setelah menyelesaikan materi & tugas</span>
                            </li>
                            <li class="flex items-center gap-2.5">
                                <svg class="w-4 h-4 text-pink-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <span>Free 1x bimbingan mentor</span>
                            </li>
                        </ul>
                    </div>

                    <!-- Pemberitahuan Hak Cipta -->
                    <div class="mt-6 rounded-xl border border-amber-200 bg-amber-50 p-4 text-xs sm:text-sm text-amber-900 flex items-start gap-3">
                        <svg class="w-5 h-5 text-amber-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        <div>
                            <p class="font-bold text-amber-900">Pemberitahuan Sebelum Membeli</p>
                            <p class="mt-0.5 text-amber-800 text-xs sm:text-sm leading-relaxed">
                                Dilarang menyebarluaskan, merekam, atau membagikan materi kelas ini kepada pihak lain karena melanggar hak cipta.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-1 space-y-6">
                <div class="bg-white rounded-2xl shadow-sm border border-pink-100 p-6 sm:p-8 sticky top-6">
                    <h2 class="text-lg font-bold text-gray-900 mb-5">Ringkasan Pembayaran</h2>

                    <livewire:transaction-promo-code :course-price="(int) $course->price"
                        :initial-promo-code="(string) (old('promo_code') ?? '')" />

                    <div class="mt-5 rounded-xl border border-pink-100 bg-pink-50 p-4 text-sm text-gray-700">
                        Setelah kamu klik bayar, kamu akan diarahkan ke halaman pembayaran.
                    </div>

                    <button type="submit"
                        class="mt-6 w-full py-4 bg-pink-500 hover:bg-pink-600 active:bg-pink-700 text-white font-bold text-lg rounded-xl transition shadow-sm flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Bayar Sekarang
                    </button>
                </div>
            </div>
        </form>
    </main>

    <x-footer />
</x-layout>