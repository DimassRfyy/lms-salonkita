<x-layout>
    <x-navbar />

    <div class="bg-white border-b border-pink-100 px-4 sm:px-6 lg:px-20 py-4">
        <div class="max-w-7xl mx-auto">
            <a href="javascript:history.back()"
                class="text-pink-500 font-medium inline-flex items-center gap-2 hover:text-pink-700 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Kembali
            </a>
        </div>
    </div>

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
                    <div class="flex items-center gap-3 mb-5">
                        <span
                            class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-pink-50 text-pink-500">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </span>
                        <div>
                            <h2 class="text-lg font-bold text-gray-900">Detail Kelas</h2>
                            <p class="text-sm text-gray-500">Ringkasan materi sebelum checkout.</p>
                        </div>
                    </div>

                    <div class="flex gap-3 pb-5 border-b border-gray-100">
                        <div class="w-20 h-16 rounded-lg overflow-hidden shrink-0 bg-pink-100">
                            <img src="{{ $course->thumbnail ? Storage::url($course->thumbnail) : asset('assets/images/thumbnails/img_placeholder.png') }}"
                                alt="Thumbnail Kelas"
                                onerror="this.onerror=null;this.src='{{ asset('assets/images/thumbnails/img_placeholder.png') }}';"
                                class="w-full h-full object-cover">
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-bold text-gray-800 leading-snug">{{ $course->name }}</p>
                            <p class="text-xs text-pink-500 font-medium mt-1">{{ $course->category->name }}</p>
                            <div class="flex items-center gap-1 mt-2">
                                <svg class="w-3 h-3 text-yellow-400 fill-yellow-400 shrink-0" viewBox="0 0 20 20" aria-hidden="true">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <p class="text-xs text-gray-500">{{ $course->rating_label }} · Kelas Premium</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 rounded-2xl border border-gray-100 bg-gray-50 p-5">
                        <div class="flex items-center gap-3 mb-4">
                            <span
                                class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-white text-pink-500 shadow-sm border border-pink-100">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6M7 4h10a2 2 0 012 2v14l-4-2-4 2-4-2-4 2V6a2 2 0 012-2z" />
                                </svg>
                            </span>
                            <h3 class="text-sm font-bold text-gray-900">Course Content</h3>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 text-sm">
                            <div class="rounded-xl bg-white border border-gray-100 p-4">
                                <p class="text-xs uppercase tracking-wide text-gray-500">Video</p>
                                <p class="mt-2 font-semibold text-gray-900">
                                    {{ number_format((int) ($course->videos_count ?? 0)) }} video</p>
                            </div>
                            <div class="rounded-xl bg-white border border-gray-100 p-4">
                                <p class="text-xs uppercase tracking-wide text-gray-500">Total Durasi</p>
                                <p class="mt-2 font-semibold text-gray-900">{{ $durationLabel }}</p>
                            </div>
                            <div class="rounded-xl bg-white border border-gray-100 p-4">
                                <p class="text-xs uppercase tracking-wide text-gray-500">Format</p>
                                <p class="mt-2 font-semibold text-gray-900">Video + Quiz</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 rounded-2xl border border-pink-100 bg-pink-50 p-5">
                        <div class="flex items-center gap-3 mb-4">
                            <span
                                class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-white text-pink-500 shadow-sm border border-pink-100">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13.828 10.172a4 4 0 00-5.656 0l-1.415 1.414a4 4 0 105.657 5.657l.707-.707m2.828-2.828l1.414-1.414a4 4 0 10-5.657-5.657l-.707.707" />
                                </svg>
                            </span>
                            <h3 class="text-sm font-bold text-gray-900">Special Benefits</h3>
                        </div>
                        <ul class="space-y-3 text-sm text-gray-700">
                            <li class="flex items-start gap-3">
                                <span
                                    class="mt-1 inline-flex h-6 w-6 items-center justify-center rounded-full bg-white text-pink-500 shadow-sm border border-pink-100 shrink-0">
                                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                </span>
                                <span>Sertifikat kelulusan setelah kelas dan tugas selesai.</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <span
                                    class="mt-1 inline-flex h-6 w-6 items-center justify-center rounded-full bg-white text-pink-500 shadow-sm border border-pink-100 shrink-0">
                                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                </span>
                                <span>Free 1x bimbingan mentor untuk konsultasi materi atau progres belajar.</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <span
                                    class="mt-1 inline-flex h-6 w-6 items-center justify-center rounded-full bg-white text-pink-500 shadow-sm border border-pink-100 shrink-0">
                                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                </span>
                                <span>+100 poin yang nanti bisa ditukar dengan benefit lain.</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-1 space-y-6">
                <div class="bg-white rounded-2xl shadow-sm border border-pink-100 p-6 sm:p-8 sticky top-6">
                    <h2 class="text-lg font-bold text-gray-900 mb-5">Ringkasan Pembayaran</h2>

                    <livewire:transaction-promo-code :course-price="(int) $course->price"
                        :initial-promo-code="old('promo_code', '')" />

                    <div class="mt-5 rounded-xl border border-pink-100 bg-pink-50 p-4 text-sm text-gray-700">
                        Setelah kamu klik bayar, popup akan muncul untuk
                        memilih metode pembayaran.
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

    @if (session('snap_token'))
        <script
            src="{{ config('services.midtrans.is_production') ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js' }}"
            data-client-key="{{ config('services.midtrans.client_key') }}"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const snapToken = @json(session('snap_token'));
                if (!snapToken || typeof window.snap === 'undefined') {
                    return;
                }

                window.snap.pay(snapToken, {
                    onSuccess: function () {
                        window.location.href = @json(route('payments.midtrans.finish', ['order_id' => (string) session('trx_id')]));
                    },
                    onPending: function () {
                        window.location.href = @json(route('payments.midtrans.unfinish', ['order_id' => (string) session('trx_id')]));
                    },
                    onError: function () {
                        window.location.href = @json(route('payments.midtrans.error', ['order_id' => (string) session('trx_id')]));
                    },
                    onClose: function () {
                        window.location.href = @json(route('payments.midtrans.unfinish', ['order_id' => (string) session('trx_id')]));
                    }
                });
            });
        </script>
    @endif
</x-layout>