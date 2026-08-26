<x-layout>
    <x-navbar />
    <x-breadcrumb />

    @php
        $activeEntitlementId = $activeEntitlement?->id ?? $availableEntitlements->first()?->id;
    @endphp

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-12 py-10" x-data="{
        showModal: false,
        selectedMentor: null,
        openApplyModal(mentor) {
            this.selectedMentor = mentor;
            this.showModal = true;
        }
    }">
        <!-- Header Banner -->
        <section class="relative overflow-hidden mb-8 rounded-3xl bg-gradient-to-r from-pink-600 via-rose-500 to-amber-500 p-6 md:p-8 text-white shadow-md">
            <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <div class="max-w-2xl space-y-2">
                    <span class="inline-flex items-center gap-1.5 rounded-full bg-white/20 px-3 py-1 text-xs font-bold uppercase tracking-wider text-white backdrop-blur-xs">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                        </svg>
                        Daftar Mentor Ahli
                    </span>
                    <h1 class="text-2xl md:text-3xl font-extrabold tracking-tight">
                        Pilih Mentor Pendamping Anda
                    </h1>
                    <p class="text-xs md:text-sm text-white/90 leading-relaxed">
                        Ajukan permohonan bimbingan ke mentor pilihan Anda untuk kelas <strong class="text-white font-bold">{{ $activeEntitlement?->course?->name ?? 'Anda' }}</strong>. Mentor akan me-review pengajuan sebelum jadwal dipilih.
                    </p>
                </div>

                <div class="shrink-0">
                    <a href="{{ route('mentoring.index') }}"
                        class="inline-flex items-center gap-2 rounded-2xl bg-white/20 hover:bg-white/30 backdrop-blur-xs px-4 py-2.5 text-xs font-bold text-white transition border border-white/30 shadow-xs">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                        <span>Mentoring Center</span>
                    </a>
                </div>
            </div>

            <!-- Background Aesthetic Circle Decoration -->
            <div class="absolute -top-20 -right-20 w-72 h-72 rounded-full bg-white/10 blur-xl pointer-events-none"></div>
            <div class="absolute -bottom-20 -left-20 w-72 h-72 rounded-full bg-pink-400/20 blur-xl pointer-events-none"></div>
        </section>

        @php
            $currentActiveReq = $pendingMentorship ?? ($activeRequest ?? null);
        @endphp

        <!-- Active Request Status Banner (If Pending) -->
        @if($currentActiveReq && $currentActiveReq->isPending())
            <div class="mb-8 rounded-3xl border border-amber-200 bg-amber-50/80 p-6 text-amber-900 shadow-xs">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div class="flex items-start gap-3.5">
                        <div class="w-10 h-10 rounded-full bg-amber-100 flex items-center justify-center text-amber-700 shrink-0 mt-0.5">
                            <span class="h-3 w-3 rounded-full bg-amber-500 animate-ping"></span>
                        </div>
                        <div>
                            <p class="font-bold text-base">Permohonan Anda Sedang Ditinjau oleh {{ $currentActiveReq->mentor?->name ?? 'Mentor' }}</p>
                            <p class="text-xs text-amber-700 mt-0.5">
                                Anda sudah memiliki pengajuan aktif. Harap tunggu persetujuan mentor sebelum mengajukan ke mentor lain.
                            </p>
                        </div>
                    </div>
                    <a href="{{ route('mentoring.index') }}" class="inline-flex items-center justify-center gap-1.5 rounded-xl bg-amber-600 px-4 py-2.5 text-xs font-bold text-white shadow-xs hover:bg-amber-700 transition shrink-0">
                        <span>Cek Status di Mentoring Center</span>
                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>
        @endif

        <!-- Mentor Cards Grid -->
        <div class="rounded-3xl border border-pink-100 bg-white p-6 md:p-8 shadow-sm">
            <div class="mb-6 flex flex-col gap-3 md:flex-row md:items-center md:justify-between pb-4 border-b border-gray-100">
                <div>
                    <h2 class="text-xl font-bold text-gray-900">Daftar Mentor Tersedia</h2>
                    <p class="text-xs text-gray-500 mt-0.5">Pilih mentor yang sesuai dengan preferensi dan keahlian yang kamu butuhkan.</p>
                </div>
                <a href="{{ route('mentoring.index') }}"
                    class="inline-flex items-center gap-2 text-xs font-bold text-pink-600 hover:text-pink-700 transition">
                    <span>Kembali ke Mentoring Center</span>
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @forelse($mentorCards as $mentor)
                    <div class="group flex flex-col justify-between rounded-3xl border border-gray-100 bg-gradient-to-b from-white to-gray-50/50 p-6 transition duration-200 hover:border-pink-200 hover:shadow-md">
                        <!-- Top: Profile Biodata -->
                        <div>
                            <div class="flex items-start gap-4">
                                <div class="w-16 h-16 rounded-2xl overflow-hidden bg-pink-100 flex items-center justify-center text-pink-700 font-bold text-xl shrink-0 shadow-xs border border-pink-100">
                                    @if($mentor->avatar)
                                        <img src="{{ $mentor->avatar_url }}" alt="{{ $mentor->name }}" class="w-full h-full object-cover">
                                    @else
                                        {{ substr($mentor->name, 0, 1) }}
                                    @endif
                                </div>
                                <div class="min-w-0 flex-1">
                                    <div class="flex items-center justify-between gap-2">
                                        <h3 class="text-lg font-bold text-gray-900 group-hover:text-pink-600 transition truncate">
                                            {{ $mentor->name }}
                                        </h3>
                                        <span class="rounded-full bg-pink-50 border border-pink-100 px-2.5 py-0.5 text-[11px] font-bold text-pink-700 shrink-0">
                                            {{ (int) ($mentor->available_slots_count ?? 0) }} slot
                                        </span>
                                    </div>
                                    <p class="text-xs font-semibold text-pink-600 mt-0.5">{{ $mentor->job_title ?? 'Mentor Profesional Beauty' }}</p>
                                    @if($mentor->city)
                                        <p class="text-[11px] text-gray-500 mt-0.5 flex items-center gap-1">
                                            <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            </svg>
                                            {{ $mentor->city }}
                                        </p>
                                    @endif
                                </div>
                            </div>

                            <!-- Bio summary -->
                            @if($mentor->bio)
                                <div class="mt-4 rounded-2xl bg-gray-50/80 p-3.5 border border-gray-100 text-xs text-gray-600 leading-relaxed line-clamp-3">
                                    {{ $mentor->bio }}
                                </div>
                            @else
                                <div class="mt-4 rounded-2xl bg-gray-50/50 p-3 text-xs text-gray-400 italic">
                                    Mentor ahli di bidang makeup & beauty treatment di Salonkita.
                                </div>
                            @endif

                            <!-- Social / Badges -->
                            @if($mentor->instagram_url || $mentor->tiktok_url)
                                <div class="mt-3 flex items-center gap-2">
                                    @if($mentor->instagram_url)
                                        <a href="{{ $mentor->instagram_url }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1 text-[11px] font-semibold text-gray-500 hover:text-pink-600">
                                            <span>Instagram</span>
                                        </a>
                                    @endif
                                    @if($mentor->tiktok_url)
                                        <span class="text-gray-300">•</span>
                                        <a href="{{ $mentor->tiktok_url }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1 text-[11px] font-semibold text-gray-500 hover:text-pink-600">
                                            <span>TikTok</span>
                                        </a>
                                    @endif
                                </div>
                            @endif
                        </div>

                        <!-- Action Footer -->
                        <div class="mt-6 pt-4 border-t border-gray-100 flex items-center justify-between">
                            <span class="text-[11px] text-gray-500 font-medium">Bimbingan 1-on-1 Privat</span>
                            <button type="button"
                                @click="openApplyModal({
                                    id: {{ $mentor->id }},
                                    name: '{{ addslashes($mentor->name) }}',
                                    job_title: '{{ addslashes($mentor->job_title ?? 'Mentor Profesional') }}',
                                    avatar: '{{ $mentor->avatar_url }}',
                                    city: '{{ addslashes($mentor->city ?? '') }}'
                                })"
                                class="inline-flex items-center gap-1.5 rounded-xl bg-pink-600 px-4 py-2.5 text-xs font-bold text-white shadow-xs transition hover:bg-pink-700 hover:scale-105 transform">
                                <span>Ajukan Bimbingan</span>
                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="md:col-span-2 rounded-3xl border border-dashed border-gray-200 bg-gray-50 p-12 text-gray-500 text-center">
                        <p class="font-semibold text-gray-700">Belum ada mentor yang aktif saat ini.</p>
                        <p class="text-xs text-gray-400 mt-1">Silakan cek kembali beberapa saat lagi.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Modal Pengajuan Mentoring -->
        <div x-show="showModal"
            x-cloak
            class="fixed inset-0 z-50 overflow-y-auto"
            style="display: none;"
            aria-labelledby="modal-title"
            role="dialog"
            aria-modal="true">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div x-show="showModal"
                    x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100"
                    x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    class="fixed inset-0 bg-gray-900/60 backdrop-blur-xs transition-opacity"
                    @click="showModal = false"
                    aria-hidden="true"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div x-show="showModal"
                    x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    class="inline-block align-bottom bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-pink-100">
                    
                    <form method="POST" action="{{ route('mentoring.apply', ['entitlement' => $activeEntitlementId]) }}" id="applyMentorForm">
                        @csrf
                        <input type="hidden" name="mentor_id" :value="selectedMentor?.id">

                        <div class="bg-white px-6 pt-6 pb-4">
                            <div class="flex items-center justify-between pb-4 border-b border-gray-100">
                                <div>
                                    <h3 class="text-lg font-black text-gray-900" id="modal-title">
                                        Form Permohonan Mentoring
                                    </h3>
                                    <p class="text-xs text-gray-500 mt-0.5">Kirimkan rencana topik yang ingin kamu konsultasikan.</p>
                                </div>
                                <button type="button" @click="showModal = false" class="rounded-full p-1 text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>

                            <div class="mt-4 space-y-4">
                                <!-- Selected Mentor Profile Preview -->
                                <div class="rounded-2xl bg-gradient-to-r from-pink-50 to-rose-50 p-4 border border-pink-100 flex items-center gap-3.5">
                                    <div class="w-12 h-12 rounded-xl bg-pink-600 text-white flex items-center justify-center font-black text-base shadow-xs shrink-0">
                                        <span x-text="selectedMentor?.name ? selectedMentor.name.charAt(0) : 'M'"></span>
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <p class="text-[10px] text-pink-700 uppercase tracking-wider font-extrabold">Mentor yang Dipilih</p>
                                        <p class="font-bold text-gray-900 text-sm truncate" x-text="selectedMentor?.name"></p>
                                        <p class="text-xs text-gray-600 truncate" x-text="selectedMentor?.job_title"></p>
                                    </div>
                                </div>

                                <div>
                                    <label for="student_notes" class="block text-xs font-bold text-gray-700 mb-1.5">
                                        Topik / Catatan untuk Mentor <span class="text-[11px] text-gray-400 font-normal">(Opsional)</span>
                                    </label>
                                    <textarea id="student_notes"
                                        name="student_notes"
                                        rows="4"
                                        placeholder="Contoh: Halo Kak, saya ingin konsultasi mengenai teknik blending foundation pada kulit bertekstur dan review tugas riasan saya..."
                                        class="w-full rounded-2xl border border-gray-300 p-3.5 text-xs focus:border-pink-500 focus:ring-2 focus:ring-pink-500/20 focus:outline-hidden leading-relaxed"></textarea>
                                    <p class="text-[11px] text-gray-400 mt-1.5 leading-normal">
                                        💡 Memberikan catatan yang jelas membantu mentor menyiapkan materi bimbingan yang tepat untukmu.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-50 px-6 py-4 flex flex-col-reverse sm:flex-row sm:justify-end gap-2.5 border-t border-gray-100">
                            <button type="button"
                                @click="showModal = false"
                                class="w-full sm:w-auto inline-flex justify-center rounded-xl border border-gray-300 bg-white px-5 py-2.5 text-xs font-bold text-gray-700 shadow-xs hover:bg-gray-50 transition">
                                Batal
                            </button>
                            <button type="submit"
                                class="w-full sm:w-auto inline-flex justify-center rounded-xl bg-pink-600 px-6 py-2.5 text-xs font-bold text-white shadow-md hover:bg-pink-700 transition">
                                Kirim Permohonan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <x-footer />

    <!-- SweetAlert2 Handlers -->
    <script>
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                confirmButtonColor: '#db2777',
                timer: 4500,
                customClass: { popup: 'rounded-3xl font-sans' }
            });
        @endif

        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Perhatian',
                text: '{{ session('error') }}',
                confirmButtonColor: '#db2777',
                customClass: { popup: 'rounded-3xl font-sans' }
            });
        @endif

        @if(session('info'))
            Swal.fire({
                icon: 'info',
                title: 'Informasi',
                text: '{{ session('info') }}',
                confirmButtonColor: '#db2777',
                customClass: { popup: 'rounded-3xl font-sans' }
            });
        @endif
    </script>
</x-layout>