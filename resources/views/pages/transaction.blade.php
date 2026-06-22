<x-layout>
    <x-navbar />

    <!-- Back Button -->
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

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-20 py-10">
        <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mb-8">Pembayaran</h1>

        <form method="POST" action="{{ route('transaction.store') }}"
            class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
            @csrf
            <input type="hidden" name="course_id" value="{{ $course->id }}">

            <div class="lg:col-span-2 space-y-6">
                @if ($errors->any())
                    <div class="bg-red-50 border border-red-100 text-red-600 rounded-xl p-4 text-sm">
                        <ul class="space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="bg-white rounded-2xl shadow-sm border border-pink-100 p-6">
                    <h2 class="text-lg font-bold text-gray-900 mb-5 flex items-center gap-2">
                        <span
                            class="w-7 h-7 rounded-full bg-pink-500 text-white text-sm font-bold flex items-center justify-center">1</span>
                        Checkout via Midtrans
                    </h2>

                    <div class="space-y-4 text-sm text-gray-700">
                        <p class="rounded-xl bg-pink-50 border border-pink-100 p-4">
                            Kamu akan diarahkan ke halaman pembayaran Midtrans (Snap) untuk memilih metode pembayaran
                            seperti VA, e-wallet, QRIS, dan metode lain yang aktif di akun Midtrans kamu.
                        </p>
                        <ul class="space-y-2 list-disc pl-5 text-gray-600">
                            <li>Pembayaran diproses otomatis tanpa upload bukti transfer manual.</li>
                            <li>Status transaksi akan diupdate melalui webhook Midtrans.</li>
                            <li>Akses kelas aktif otomatis setelah status pembayaran settlement/capture.</li>
                        </ul>
                    </div>

                    <div class="mt-5 rounded-xl border border-pink-100 bg-pink-50 p-4">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-pink-500 mt-0.5 shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M12 18h.01M12 6a9 9 0 100 18 9 9 0 000-18z"></path>
                            </svg>
                            <div class="text-sm">
                                <p class="font-semibold text-gray-800">Informasi pembayaran</p>
                                <p class="text-gray-600 mt-1">Setelah klik tombol konfirmasi, popup Midtrans akan
                                    terbuka.
                                    Selesaikan pembayaran sesuai instruksi yang muncul.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-1 space-y-6">
                <div class="bg-white rounded-2xl shadow-sm border border-pink-100 p-6">
                    <h2 class="text-lg font-bold text-gray-900 mb-5">Ringkasan Pesanan</h2>

                    <!-- Course Item -->
                    <div class="flex gap-3 mb-5 pb-5 border-b border-gray-100">
                        <div class="w-20 h-16 rounded-lg overflow-hidden shrink-0 bg-pink-100">
                            <img src="{{ $course->thumbnail ? Storage::url($course->thumbnail) : asset('assets/images/thumbnails/img_placeholder.png') }}"
                                alt="Thumbnail Kelas"
                                onerror="this.onerror=null;this.src='{{ asset('assets/images/thumbnails/img_placeholder.png') }}';"
                                class="w-full h-full object-cover">
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-bold text-gray-800 leading-snug">{{ $course->name }}</p>
                            <p class="text-xs text-pink-500 font-medium mt-1">{{ $course->category->name }}</p>
                            <div class="flex items-center gap-1 mt-1">
                                <svg class="w-3 h-3 text-yellow-400 fill-yellow-400" viewBox="0 0 20 20">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <span class="text-xs text-gray-500">{{ $course->rating_label }} · Kelas Premium</span>
                            </div>
                        </div>
                    </div>

                    <livewire:transaction-promo-code :course-price="(int) $course->price"
                        :initial-promo-code="old('promo_code', '')" />

                    <!-- Security Note -->
                    <div class="flex items-center gap-2 mt-5 p-3 bg-gray-50 rounded-lg">
                        <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                            </path>
                        </svg>
                        <p class="text-xs text-gray-400">Pembayaran kamu aman & terenkripsi</p>
                    </div>
                </div>

                <button type="submit"
                    class="w-full py-4 bg-pink-500 hover:bg-pink-600 active:bg-pink-700 text-white font-bold text-lg rounded-xl transition shadow-sm flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Lanjut ke Midtrans
                </button>
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