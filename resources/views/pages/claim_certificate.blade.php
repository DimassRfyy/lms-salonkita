<x-layout>
    <style>
        :root {
            --pink-main: #ec4899;
            --pink-dark: #db2777;
        }
        .btn-pink-gradient {
            background: linear-gradient(135deg, var(--pink-main) 0%, var(--pink-dark) 100%);
            transition: all 0.3s ease;
        }
        .btn-pink-gradient:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(236, 72, 153, 0.28);
        }
        .star-rating .star-btn {
            transition: transform 0.2s ease, color 0.2s ease;
        }
        .star-rating .star-btn:hover {
            transform: scale(1.2);
        }
    </style>

    <x-navbar />

    <div class="min-h-screen bg-gradient-to-b from-pink-50/40 via-white to-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            
            <!-- Breadcrumb / Back Link -->
            <div class="mb-8">
                <a href="{{ route('course', ['slug' => $course->slug]) }}" 
                   class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-pink-600 transition">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Kembali ke Kelas {{ $course->name }}
                </a>
            </div>

            @if (! $hasReviewed)
                <!-- STATE 1: FORM ULASAN KELAS -->
                <div class="bg-white rounded-3xl shadow-xl shadow-pink-500/5 border border-pink-100 p-6 sm:p-10 relative overflow-hidden">
                    <div class="absolute top-0 right-0 -mr-16 -mt-16 w-64 h-64 bg-pink-100 rounded-full blur-3xl opacity-50 pointer-events-none"></div>

                    <div class="text-center max-w-xl mx-auto mb-8">
                        <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full text-xs font-semibold uppercase tracking-wider bg-pink-100 text-pink-700 mb-3">
                            <svg class="w-4 h-4 text-pink-600" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            Satu Langkah Lagi
                        </span>
                        <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight">
                            Beri Ulasan untuk Mengklaim Sertifikat
                        </h1>
                        <p class="mt-2 text-sm sm:text-base text-gray-600">
                            Bagikan pengalaman belajarmu di kelas <strong class="text-gray-900 font-semibold">{{ $course->name }}</strong>. Ulasanmu sangat berharga bagi instruktur dan calon siswa lainnya!
                        </p>
                    </div>

                    <form action="{{ route('course.review.store', ['slug' => $course->slug]) }}" method="POST" class="max-w-lg mx-auto space-y-6">
                        @csrf

                        <!-- Rating Stars -->
                        <div class="text-center">
                            <label class="block text-sm font-bold text-gray-800 mb-2">
                                Berikan Rating Kelas
                            </label>
                            
                            <div class="star-rating inline-flex items-center justify-center gap-2 p-2 bg-pink-50/60 rounded-2xl border border-pink-100" id="star-container">
                                @for ($i = 1; $i <= 5; $i++)
                                    <button type="button" 
                                            class="star-btn p-1 text-gray-300 focus:outline-none" 
                                            data-value="{{ $i }}"
                                            onclick="selectRating({{ $i }})">
                                        <svg class="w-9 h-9 fill-current" viewBox="0 0 24 24">
                                            <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                                        </svg>
                                    </button>
                                @endfor
                            </div>
                            <input type="hidden" name="rating" id="rating-input" value="{{ old('rating', 5) }}" required>
                            <p class="text-xs font-semibold text-pink-600 mt-2" id="rating-text">Sangat Memuaskan (5/5)</p>
                            @error('rating')
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Review Text -->
                        <div>
                            <label for="review" class="block text-sm font-semibold text-gray-700 mb-1">
                                Ulasan & Pesan Kesanmu
                            </label>
                            <textarea id="review" name="review" rows="4" required
                                class="w-full rounded-2xl border border-gray-200 p-4 text-sm text-gray-900 focus:border-pink-500 focus:ring-4 focus:ring-pink-500/10 focus:outline-none transition"
                                placeholder="Ceritakan hal menarik yang kamu pelajari, materi favorit, atau masukan untuk kelas ini...">{{ old('review') }}</textarea>
                            @error('review')
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <button type="submit"
                            class="btn-pink-gradient w-full py-3.5 px-6 rounded-2xl text-white font-bold text-base shadow-lg shadow-pink-500/25 flex items-center justify-center gap-2">
                            <span>Kirim Ulasan & Buka Sertifikat</span>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </button>
                    </form>
                </div>

            @else
                <!-- STATE 2: SERTIFIKAT SIAP DIKLAIM / DIUNDUH -->
                <div class="bg-white rounded-3xl shadow-xl shadow-pink-500/5 border border-pink-100 p-6 sm:p-10 relative overflow-hidden">
                    <div class="absolute top-0 right-0 -mr-20 -mt-20 w-80 h-80 bg-gradient-to-br from-pink-200/40 to-purple-200/40 rounded-full blur-3xl pointer-events-none"></div>

                    <!-- Celebration Header -->
                    <div class="text-center max-w-xl mx-auto mb-10">
                        <div class="w-16 h-16 mx-auto mb-4 bg-gradient-to-tr from-pink-500 to-rose-400 rounded-3xl flex items-center justify-center shadow-lg shadow-pink-500/30 text-3xl">
                            🎓
                        </div>
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-emerald-100 text-emerald-700 mb-2">
                            <svg class="w-3.5 h-3.5 text-emerald-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            Sertifikat Telah Terbit
                        </span>
                        <h1 class="text-2xl sm:text-4xl font-black text-gray-900 tracking-tight">
                            Selamat, {{ auth()->user()->name }}!
                        </h1>
                        <p class="mt-2 text-sm sm:text-base text-gray-600">
                            Kamu telah berhasil menyelesaikan kursus <strong class="text-gray-900">{{ $course->name }}</strong>. Sertifikat resmimu telah terbit dan siap diunduh.
                        </p>
                    </div>

                    <!-- Certificate Card Preview (1:1 Replica) -->
                    <div class="max-w-3xl mx-auto mb-8 relative">
                        <div class="bg-[#fff1f2] p-2.5 sm:p-4 rounded-2xl shadow-xl shadow-pink-500/10 border-2 sm:border-4 border-[#db2777]">
                            <div class="bg-white p-6 sm:p-8 rounded-xl border border-dashed border-[#f472b6] text-center relative overflow-hidden">
                                
                                <!-- Corner Ornaments -->
                                <div class="absolute top-0 left-0 w-6 h-6 sm:w-8 sm:h-8 border-t-4 border-l-4 border-[#be185d]"></div>
                                <div class="absolute top-0 right-0 w-6 h-6 sm:w-8 sm:h-8 border-t-4 border-r-4 border-[#be185d]"></div>
                                <div class="absolute bottom-0 left-0 w-6 h-6 sm:w-8 sm:h-8 border-b-4 border-l-4 border-[#be185d]"></div>
                                <div class="absolute bottom-0 right-0 w-6 h-6 sm:w-8 sm:h-8 border-b-4 border-r-4 border-[#be185d]"></div>

                                <!-- Logo -->
                                <img src="{{ asset('assets/images/logos/logo_skid new.png') }}" alt="Salonkita Logo" class="h-9 sm:h-12 mx-auto mb-2 object-contain">

                                <h2 class="text-xl sm:text-2xl font-black text-gray-900 tracking-[0.15em] uppercase">
                                    Sertifikat Kelulusan
                                </h2>
                                <p class="text-[10px] sm:text-xs font-bold text-[#db2777] tracking-[0.2em] uppercase mt-0.5 mb-4 sm:mb-6">
                                    Certificate of Completion
                                </p>

                                <p class="text-xs sm:text-sm text-gray-500 italic mb-1">Diberikan dengan bangga kepada:</p>
                                <p class="text-xl sm:text-3xl font-extrabold text-[#be185d] border-b-2 border-pink-200 inline-block pb-1 px-4 mb-3">
                                    {{ auth()->user()->name }}
                                </p>

                                <p class="text-xs sm:text-sm text-gray-600 max-w-xl mx-auto mb-1">
                                    Atas keberhasilannya dalam menyelesaikan seluruh rangkaian materi modul, praktik, dan evaluasi pada kursus:
                                </p>
                                <p class="text-base sm:text-xl font-bold text-gray-900 mb-6 sm:mb-8">
                                    "{{ $course->name }}"
                                </p>

                                <!-- Footer Metadata & Signature -->
                                <div class="grid grid-cols-1 sm:grid-cols-3 items-end gap-4 pt-4 border-t border-pink-100/80">
                                    <!-- No Kredensial -->
                                    <div class="text-center sm:text-left">
                                        <div class="inline-block bg-pink-50 border border-pink-200/80 rounded-lg px-3 py-1.5 text-center">
                                            <p class="text-[9px] font-bold text-[#9d174d] uppercase tracking-wider">Nomor Kredensial</p>
                                            <p class="font-mono text-xs font-bold text-gray-900 mt-0.5">{{ $certificate->certificate_code }}</p>
                                        </div>
                                    </div>

                                    <!-- Tanggal Terbit -->
                                    <div class="text-center">
                                        <div class="inline-block bg-pink-50 border border-pink-200/80 rounded-lg px-3 py-1.5 text-center">
                                            <p class="text-[9px] font-bold text-[#9d174d] uppercase tracking-wider">Tanggal Terbit</p>
                                            <p class="text-xs font-bold text-gray-900 mt-0.5">{{ $certificate->issued_at ? $certificate->issued_at->translatedFormat('d F Y') : now()->translatedFormat('d F Y') }}</p>
                                        </div>
                                    </div>

                                    <!-- TTD Founder -->
                                    <div class="text-center sm:text-right">
                                        <div class="inline-block text-center">
                                            <img src="{{ asset('assets/images/logos/signature_example.png') }}" alt="Tanda Tangan Founder" class="h-10 sm:h-12 mx-auto -mb-1 object-contain">
                                            <div class="w-32 border-t border-gray-300 mx-auto my-1"></div>
                                            <p class="text-xs font-bold text-gray-900">Hertauli Harianja</p>
                                            <p class="text-[10px] font-semibold text-[#db2777]">Founder Salonkita</p>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="max-w-md mx-auto flex flex-col sm:flex-row gap-3 justify-center">
                        <a href="{{ route('certificate.download', ['slug' => $course->slug]) }}"
                           class="btn-pink-gradient py-3.5 px-6 rounded-2xl text-white font-bold text-sm shadow-lg shadow-pink-500/25 inline-flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                            </svg>
                            <span>Download PDF</span>
                        </a>

                        <a href="{{ route('certificate.view', ['slug' => $course->slug]) }}" target="_blank"
                           class="py-3.5 px-6 rounded-2xl bg-gray-100 hover:bg-gray-200 text-gray-800 font-semibold text-sm transition inline-flex items-center justify-center gap-2">
                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            <span>Lihat Preview</span>
                        </a>
                    </div>

                    <div class="text-center mt-8 pt-6 border-t border-gray-100">
                        <a href="{{ route('profile') }}" class="text-sm font-semibold text-pink-600 hover:text-pink-700">
                            Lihat semua sertifikatmu di Halaman Profil →
                        </a>
                    </div>
                </div>
            @endif

        </div>
    </div>

    <script>
        const ratingLabels = {
            1: 'Kurang Puas (1/5)',
            2: 'Cukup (2/5)',
            3: 'Baik (3/5)',
            4: 'Sangat Baik (4/5)',
            5: 'Sangat Memuaskan (5/5)'
        };

        function selectRating(val) {
            const ratingInput = document.getElementById('rating-input');
            const ratingText = document.getElementById('rating-text');
            if (ratingInput) ratingInput.value = val;
            if (ratingText) ratingText.textContent = ratingLabels[val] || (val + '/5');

            const starButtons = document.querySelectorAll('#star-container .star-btn');
            starButtons.forEach((btn, index) => {
                const btnVal = index + 1;
                if (btnVal <= val) {
                    btn.classList.remove('text-gray-300');
                    btn.classList.add('text-amber-400');
                } else {
                    btn.classList.remove('text-amber-400');
                    btn.classList.add('text-gray-300');
                }
            });
        }

        // Initialize default rating
        document.addEventListener('DOMContentLoaded', () => {
            const currentVal = parseInt(document.getElementById('rating-input')?.value || '5');
            selectRating(currentVal);
        });
    </script>

    @if (session('claimed_now'))
        <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                if (typeof confetti === 'function') {
                    const count = 200;
                    const defaults = {
                        origin: { y: 0.7 },
                        zIndex: 9999
                    };

                    function fire(particleRatio, opts) {
                        confetti(Object.assign({}, defaults, opts, {
                            particleCount: Math.floor(count * particleRatio)
                        }));
                    }

                    fire(0.25, { spread: 26, startVelocity: 55 });
                    fire(0.2, { spread: 60 });
                    fire(0.35, { spread: 100, decay: 0.91, scalar: 0.8 });
                    fire(0.1, { spread: 120, startVelocity: 25, decay: 0.92, scalar: 1.2 });
                    fire(0.1, { spread: 120, startVelocity: 45 });
                }
            });
        </script>
    @endif
</x-layout>
