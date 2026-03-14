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

        <form method="POST" action="{{ url('/transaction') }}" enctype="multipart/form-data"
            class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
            @csrf
            <input type="hidden" name="course_id" value="{{ $course->id }}">

            <!-- ===== LEFT: Payment Form ===== -->
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

                <!-- Step 1: Pilih Metode Pembayaran -->
                <div class="bg-white rounded-2xl shadow-sm border border-pink-100 p-6">
                    <h2 class="text-lg font-bold text-gray-900 mb-5 flex items-center gap-2">
                        <span
                            class="w-7 h-7 rounded-full bg-pink-500 text-white text-sm font-bold flex items-center justify-center">1</span>
                        Pilih Metode Pembayaran
                    </h2>

                    <div class="space-y-3">
                        <label
                            class="flex items-center gap-4 p-4 rounded-xl border-2 border-pink-400 bg-pink-50 cursor-pointer transition hover:border-pink-400">
                            <input type="radio" name="payment_method" value="bank_transfer" class="accent-pink-500 w-4 h-4" checked>
                            <div class="flex items-center gap-3 flex-1">
                                <div
                                    class="w-14 h-8 bg-blue-700 rounded-md flex items-center justify-center text-white text-xs font-extrabold tracking-wide">
                                    BANK</div>
                                <div>
                                    <p class="font-semibold text-gray-800 text-sm">Bank Transfer</p>
                                    <p class="text-xs text-gray-500">Transfer manual ke rekening admin</p>
                                </div>
                            </div>
                        </label>

                        <label
                            class="flex items-center gap-4 p-4 rounded-xl border-2 border-gray-200 cursor-pointer transition hover:border-pink-300">
                            <input type="radio" name="payment_method" value="e_wallet" class="accent-pink-500 w-4 h-4">
                            <div class="flex items-center gap-3 flex-1">
                                <div
                                    class="w-14 h-8 bg-teal-500 rounded-md flex items-center justify-center text-white text-xs font-extrabold">
                                    EWALLET</div>
                                <div>
                                    <p class="font-semibold text-gray-800 text-sm">E-Wallet</p>
                                    <p class="text-xs text-gray-500">Bayar lewat dompet digital</p>
                                </div>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Step 2: Upload Bukti Pembayaran -->
                <div class="bg-white rounded-2xl shadow-sm border border-pink-100 p-6">
                    <h2 class="text-lg font-bold text-gray-900 mb-1 flex items-center gap-2">
                        <span
                            class="w-7 h-7 rounded-full bg-pink-500 text-white text-sm font-bold flex items-center justify-center">2</span>
                        Upload Bukti Pembayaran
                    </h2>
                    <p class="text-sm text-gray-400 mb-5 ml-9">Transfer ke rekening yang dipilih, lalu upload screenshot
                        bukti transfer kamu.</p>

                    <!-- Upload Area -->
                    <label for="bukti-upload"
                        class="group flex flex-col items-center justify-center gap-3 border-2 border-dashed border-pink-300 rounded-xl p-8 cursor-pointer hover:bg-pink-50 hover:border-pink-400 transition">
                        <div
                            class="w-14 h-14 rounded-full bg-pink-100 flex items-center justify-center group-hover:bg-pink-200 transition">
                            <svg class="w-7 h-7 text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                            </svg>
                        </div>
                        <div class="text-center">
                            <p class="font-semibold text-gray-700 text-sm">Klik untuk upload atau drag & drop</p>
                            <p class="text-xs text-gray-400 mt-1">PNG, JPG, JPEG — maks. 5 MB</p>
                        </div>
                        <input id="bukti-upload" name="proof_of_payment" type="file" accept="image/*" class="hidden"
                            onchange="previewFile(this)">
                    </label>

                    <!-- Preview -->
                    <div id="file-preview"
                        class="hidden mt-4 items-center gap-3 p-3 bg-pink-50 border border-pink-200 rounded-xl">
                        <svg class="w-8 h-8 text-pink-400 shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                        <div class="flex-1 min-w-0">
                            <p id="file-name" class="text-sm font-semibold text-gray-700 truncate">nama-file.png</p>
                            <p id="file-size" class="text-xs text-gray-400">2.1 MB</p>
                        </div>
                        <button onclick="clearFile()" class="text-gray-400 hover:text-red-500 transition" type="button">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Step 3: Konfirmasi & Bayar -->
                <button type="submit"
                    class="w-full py-4 bg-pink-500 hover:bg-pink-600 active:bg-pink-700 text-white font-bold text-lg rounded-xl transition shadow-sm flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Konfirmasi Pembayaran
                </button>
            </div>

            <!-- ===== RIGHT: Ringkasan Pesanan ===== -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-sm border border-pink-100 p-6 sticky top-24">
                    <h2 class="text-lg font-bold text-gray-900 mb-5">Ringkasan Pesanan</h2>

                    <!-- Course Item -->
                    <div class="flex gap-3 mb-5 pb-5 border-b border-gray-100">
                        <div class="w-20 h-16 rounded-lg overflow-hidden shrink-0 bg-pink-100">
                            <img src="{{ $course->thumbnail ? Storage::url($course->thumbnail) : asset('assets/images/thumbnails/img_placeholder.png') }}" alt="Thumbnail Kelas"
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

                    <!-- Price Detail -->
                    <div class="space-y-3 mb-5 pb-5 border-b border-gray-100 text-sm">
                        <div class="flex justify-between text-gray-600">
                            <span>Harga kelas</span>
                            <span>Rp {{ number_format((int) $course->price, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-gray-600">
                            <span>Biaya admin</span>
                            <span>Rp 0</span>
                        </div>
                    </div>

                    <!-- Total -->
                    <div class="flex justify-between items-center mb-6">
                        <span class="font-bold text-gray-900">Total Pembayaran</span>
                        <span class="text-xl font-extrabold text-pink-500">Rp {{ number_format((int) $course->price, 0, ',', '.') }}</span>
                    </div>

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
            </div>

        </form>
    </main>

    <x-footer />

    <script>
        function previewFile(input) {
            const preview = document.getElementById('file-preview');
            const fileName = document.getElementById('file-name');
            const fileSize = document.getElementById('file-size');

            if (input.files && input.files[0]) {
                const file = input.files[0];
                fileName.textContent = file.name;
                fileSize.textContent = (file.size / 1024 / 1024).toFixed(2) + ' MB';
                preview.classList.remove('hidden');
                preview.classList.add('flex');
            }
        }

        function clearFile() {
            document.getElementById('bukti-upload').value = '';
            const preview = document.getElementById('file-preview');
            preview.classList.add('hidden');
            preview.classList.remove('flex');
        }

        // Highlight selected payment method border
        document.querySelectorAll('input[name="payment_method"]').forEach(radio => {
            radio.addEventListener('change', function () {
                document.querySelectorAll('input[name="payment_method"]').forEach(r => {
                    r.closest('label').classList.remove('border-pink-400', 'bg-pink-50');
                    r.closest('label').classList.add('border-gray-200');
                });
                this.closest('label').classList.add('border-pink-400', 'bg-pink-50');
                this.closest('label').classList.remove('border-gray-200');
            });
        });
    </script>
</x-layout>