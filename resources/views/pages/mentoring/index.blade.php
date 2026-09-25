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
        <section
            class="relative overflow-hidden mb-8 rounded-3xl bg-gradient-to-r from-pink-600 via-rose-500 to-amber-500 p-6 md:p-8 text-white shadow-md">
            <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <div class="max-w-2xl space-y-2">
                    <h1 class="text-2xl md:text-3xl font-extrabold tracking-tight">
                        Pilih Mentor Pendamping Anda
                    </h1>
                    <p class="text-xs md:text-sm text-white/90 leading-relaxed">
                        Yuk, ajukan bimbingan ke mentor pilihanmu! Mentor akan memeriksa pengajuanmu terlebih dahulu
                        sebelum kamu memilih jadwal.
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
            <div class="absolute -top-20 -right-20 w-72 h-72 rounded-full bg-white/10 blur-xl pointer-events-none">
            </div>
            <div class="absolute -bottom-20 -left-20 w-72 h-72 rounded-full bg-pink-400/20 blur-xl pointer-events-none">
            </div>
        </section>

        @php
            $currentActiveReq = $pendingMentorship ?? ($activeRequest ?? null);
        @endphp

        <!-- Active Request Status Banner (If Pending) -->
        @if($currentActiveReq && $currentActiveReq->isPending())
            <div class="mb-8 rounded-3xl border border-amber-200 bg-amber-50/80 p-6 text-amber-900 shadow-xs">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div class="flex items-start gap-3.5">
                        <div
                            class="w-10 h-10 rounded-full bg-amber-100 flex items-center justify-center text-amber-700 shrink-0 mt-0.5">
                            <span class="h-3 w-3 rounded-full bg-amber-500 animate-ping"></span>
                        </div>
                        <div>
                            <p class="font-bold text-base">Permohonan Anda Sedang Ditinjau oleh
                                {{ $currentActiveReq->mentor?->name ?? 'Mentor' }}
                            </p>
                            <p class="text-xs text-amber-700 mt-0.5">
                                Anda sudah memiliki pengajuan aktif. Harap tunggu persetujuan mentor sebelum mengajukan ke
                                mentor lain.
                            </p>
                        </div>
                    </div>
                    <a href="{{ route('mentoring.index') }}"
                        class="inline-flex items-center justify-center gap-1.5 rounded-xl bg-amber-600 px-4 py-2.5 text-xs font-bold text-white shadow-xs hover:bg-amber-700 transition shrink-0">
                        <span>Cek Status di Mentoring Center</span>
                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>
        @endif

        <!-- Livewire Search & Filter Mentor Cards List -->
        <livewire:mentor-search-list :active-entitlement-id="$activeEntitlementId" />


        <!-- Modal Pengajuan Mentoring -->
        <div x-show="showModal" x-cloak
            class="fixed inset-0 z-50 flex items-center justify-center p-4 overflow-y-auto"
            style="display: none;"
            @click.self="showModal = false"
            aria-labelledby="modal-title" role="dialog" aria-modal="true">

            <!-- Backdrop Overlay -->
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

            <!-- Modal Card (Centered precisely vertically & horizontally) -->
            <div x-show="showModal"
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                x-transition:leave-end="opacity-0 scale-95 translate-y-2"
                class="relative z-10 w-full max-w-lg bg-white rounded-3xl text-left shadow-2xl transition-all border border-pink-100 overflow-hidden my-auto max-h-[90vh] flex flex-col"
                @click.stop>

                <form method="POST" action="{{ route('mentoring.apply', ['entitlement' => $activeEntitlementId]) }}"
                    id="applyMentorForm" class="flex flex-col max-h-[90vh] overflow-hidden">
                    @csrf
                    <input type="hidden" name="mentor_id" :value="selectedMentor?.id">

                    <div class="bg-white px-6 pt-6 pb-4 overflow-y-auto flex-1">
                        <div class="flex items-center justify-between pb-4 border-b border-gray-100">
                            <div>
                                <h3 class="text-lg font-black text-gray-900" id="modal-title">
                                    Form Permohonan Mentoring
                                </h3>
                                <p class="text-xs text-gray-500 mt-0.5">Kirimkan rencana topik yang ingin kamu
                                    konsultasikan.</p>
                            </div>
                            <button type="button" @click="showModal = false"
                                class="rounded-full p-1 text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition cursor-pointer">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        <div class="mt-4 space-y-4">
                            <!-- Selected Mentor Profile Preview -->
                            <div
                                class="rounded-2xl bg-gradient-to-r from-pink-50 to-rose-50 p-4 border border-pink-100 flex items-center gap-3.5">
                                <div
                                    class="w-12 h-12 rounded-xl bg-pink-600 text-white flex items-center justify-center font-black text-base shadow-xs shrink-0 overflow-hidden">
                                    <template x-if="selectedMentor?.avatar">
                                        <img :src="selectedMentor.avatar" :alt="selectedMentor.name" class="w-full h-full object-cover">
                                    </template>
                                    <template x-if="!selectedMentor?.avatar">
                                        <span x-text="selectedMentor?.name ? selectedMentor.name.charAt(0) : 'M'"></span>
                                    </template>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="text-[10px] text-pink-700 uppercase tracking-wider font-extrabold">
                                        Mentor yang Dipilih</p>
                                    <p class="font-bold text-gray-900 text-sm truncate"
                                        x-text="selectedMentor?.name"></p>
                                    <p class="text-xs text-gray-600 truncate" x-text="selectedMentor?.job_title">
                                    </p>
                                </div>
                            </div>

                            <div>
                                <label for="student_notes" class="block text-xs font-bold text-gray-700 mb-1.5">
                                    Topik / Catatan untuk Mentor <span
                                        class="text-[11px] text-gray-400 font-normal">(Opsional)</span>
                                </label>
                                <textarea id="student_notes" name="student_notes" rows="4"
                                    placeholder="Contoh: Halo Kak, saya ingin konsultasi mengenai teknik blending foundation pada kulit bertekstur dan review tugas riasan saya..."
                                    class="w-full rounded-2xl border border-gray-300 p-3.5 text-xs focus:border-pink-500 focus:ring-2 focus:ring-pink-500/20 focus:outline-hidden leading-relaxed"></textarea>
                                <p class="text-[11px] text-gray-400 mt-1.5 leading-normal">
                                    💡 Memberikan catatan yang jelas membantu mentor menyiapkan materi bimbingan
                                    yang tepat untukmu.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div
                        class="bg-gray-50 px-6 py-4 flex flex-col-reverse sm:flex-row sm:justify-end gap-2.5 border-t border-gray-100 shrink-0">
                        <button type="button" @click="showModal = false"
                            class="w-full sm:w-auto inline-flex justify-center rounded-xl border border-gray-300 bg-white px-5 py-2.5 text-xs font-bold text-gray-700 shadow-xs hover:bg-gray-50 transition cursor-pointer">
                            Batal
                        </button>
                        <button type="submit"
                            class="w-full sm:w-auto inline-flex justify-center rounded-xl bg-pink-600 px-6 py-2.5 text-xs font-bold text-white shadow-md hover:bg-pink-700 transition cursor-pointer">
                            Kirim Permohonan
                        </button>
                    </div>
                </form>
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