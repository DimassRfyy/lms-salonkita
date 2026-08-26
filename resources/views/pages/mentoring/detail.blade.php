<x-layout>
    <x-navbar />
    <x-breadcrumb />

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-12 py-10" x-data="{
        showTerminateModal: false,
        terminateReason: ''
    }">
        <!-- Header Banner -->
        <section class="relative overflow-hidden mb-8 rounded-3xl bg-gradient-to-r from-pink-600 via-rose-500 to-amber-500 p-6 md:p-8 text-white shadow-md">
            <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <div class="max-w-2xl space-y-2">
                    <span class="inline-flex items-center gap-1.5 rounded-full bg-white/20 px-3 py-1 text-xs font-bold uppercase tracking-wider backdrop-blur-xs">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"/>
                        </svg>
                        Mentoring Center • Dedicated 1-on-1
                    </span>
                    <h1 class="text-2xl md:text-3xl font-extrabold tracking-tight">
                        Pusat Bimbingan Privat Mentor Ahli
                    </h1>
                    <p class="text-xs md:text-sm text-white/90 leading-relaxed">
                        Konsultasikan materi kelas, evaluasi teknik kecantikan, bedah portofolio, dan konsultasi karir secara eksklusif bersama Mentor Pendamping Anda.
                    </p>
                </div>

                <div class="shrink-0 flex flex-wrap items-center gap-3">
                    @if($activeMentorship && $totalRemainingQuota > 0)
                        <a href="{{ route('mentoring.book') }}"
                            class="inline-flex items-center gap-2 rounded-2xl bg-white px-5 py-3 text-xs md:text-sm font-extrabold text-pink-600 shadow-md transition hover:bg-pink-50 hover:scale-105 transform">
                            <span>Pilih Jadwal Mentoring</span>
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                            </svg>
                        </a>
                    @elseif(! $activeMentorship && ! $pendingMentorship && $totalRemainingQuota > 0)
                        <a href="{{ route('mentoring.mentors') }}"
                            class="inline-flex items-center gap-2 rounded-2xl bg-white px-5 py-3 text-xs md:text-sm font-extrabold text-pink-600 shadow-md transition hover:bg-pink-50 hover:scale-105 transform">
                            <span>Cari & Ajukan Mentor</span>
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                            </svg>
                        </a>
                    @endif
                </div>
            </div>

            <!-- Background Aesthetic Circle Decoration -->
            <div class="absolute -top-20 -right-20 w-72 h-72 rounded-full bg-white/10 blur-xl pointer-events-none"></div>
            <div class="absolute -bottom-20 -left-20 w-72 h-72 rounded-full bg-pink-400/20 blur-xl pointer-events-none"></div>
        </section>

        @if(! $hasMentoringAccess && $totalRemainingQuota === 0)
            <!-- No Mentoring Quota State -->
            <section class="rounded-3xl border border-gray-200 bg-white p-12 text-center shadow-sm max-w-2xl mx-auto">
                <div class="w-16 h-16 rounded-full bg-pink-100 text-pink-600 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-900">Belum Ada Kuota Mentoring</h2>
                <p class="mt-2 text-gray-600 text-sm">
                    Beli kelas bersertifikat yang dilengkapi fasilitas bimbingan mentor untuk membuka akses konsultasi privat 1-on-1 ini.
                </p>
                <div class="mt-6">
                    <a href="{{ route('all-courses') }}" class="inline-flex items-center gap-2 rounded-2xl bg-pink-600 px-6 py-3 font-bold text-white shadow-md hover:bg-pink-700 transition">
                        Eksplor Kelas Salonkita
                    </a>
                </div>
            </section>
        @else
            <!-- 1. DEDICATED MENTOR SECTION (IF HAS ACTIVE MENTOR) -->
            @if($activeMentorship && $activeMentorship->mentor)
                <div class="mb-8 rounded-3xl border border-pink-200 bg-gradient-to-br from-pink-50/60 via-white to-rose-50/40 p-6 md:p-8 shadow-sm">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                        <!-- Mentor Profile Details -->
                        <div class="flex items-start gap-4 md:gap-5">
                            <div class="w-16 h-16 md:w-20 md:h-20 rounded-2xl overflow-hidden bg-pink-100 flex items-center justify-center text-pink-700 font-black text-2xl shrink-0 shadow-xs border-2 border-pink-200">
                                @if($activeMentorship->mentor->avatar)
                                    <img src="{{ $activeMentorship->mentor->avatar_url }}" alt="{{ $activeMentorship->mentor->name }}" class="w-full h-full object-cover">
                                @else
                                    {{ substr($activeMentorship->mentor->name, 0, 1) }}
                                @endif
                            </div>
                            <div class="space-y-1">
                                <div class="flex flex-wrap items-center gap-2">
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-100 px-3 py-0.5 text-xs font-bold text-emerald-800">
                                        <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                                        Mentor Pendamping Aktif
                                    </span>
                                </div>
                                <h2 class="text-xl md:text-2xl font-black text-gray-900">
                                    {{ $activeMentorship->mentor->name }}
                                </h2>
                                <p class="text-xs md:text-sm font-semibold text-pink-600">
                                    {{ $activeMentorship->mentor->job_title ?? 'Mentor Profesional Salonkita' }}
                                    @if($activeMentorship->mentor->city)
                                        <span class="text-gray-400 font-normal">• {{ $activeMentorship->mentor->city }}</span>
                                    @endif
                                </p>
                                <p class="text-xs text-gray-500 pt-1 leading-relaxed max-w-xl">
                                    Kamu resmi menjadi anak bimbingan {{ $activeMentorship->mentor->name }} dan bisa langsung konsultasikan semua kelasmu dengan mentor ini.
                                </p>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex flex-col sm:flex-row lg:flex-col items-stretch sm:items-center lg:items-end gap-3 shrink-0">
                            @if($totalRemainingQuota > 0)
                                <a href="{{ route('mentoring.book') }}"
                                    class="inline-flex items-center justify-center gap-2 rounded-2xl bg-pink-600 px-6 py-3.5 text-xs md:text-sm font-bold text-white shadow-md transition hover:bg-pink-700 hover:scale-105 transform">
                                    <span>Pilih Jadwal Sesi</span>
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                    </svg>
                                </a>
                            @else
                                <span class="inline-flex items-center justify-center rounded-2xl bg-gray-100 px-4 py-2.5 text-xs font-semibold text-gray-500">
                                    Kuota Mentoring Habis
                                </span>
                            @endif

                            <button type="button"
                                @click="showTerminateModal = true"
                                class="inline-flex items-center justify-center gap-1.5 rounded-2xl border border-gray-300 bg-white px-4 py-2.5 text-xs font-bold text-gray-700 shadow-xs transition hover:bg-red-50 hover:text-red-600 hover:border-red-200">
                                <svg class="w-3.5 h-3.5 text-gray-400 group-hover:text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                </svg>
                                <span>Ganti Mentor / Putus Hubungan</span>
                            </button>
                        </div>
                    </div>
                </div>
            @elseif($pendingMentorship && $pendingMentorship->mentor)
                <!-- 2. PENDING MENTORSHIP REQUEST CARD -->
                <div class="mb-8 rounded-3xl border border-amber-200 bg-gradient-to-br from-amber-50/80 via-white to-amber-50/40 p-6 md:p-8 shadow-sm">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                        <div class="space-y-2.5 max-w-2xl">
                            <span class="inline-flex items-center gap-1.5 rounded-full bg-amber-100 px-3.5 py-1 text-xs font-bold text-amber-800">
                                <span class="h-2 w-2 rounded-full bg-amber-500 animate-ping"></span>
                                Menunggu Persetujuan Mentor
                            </span>
                            <h3 class="text-xl md:text-2xl font-black text-gray-900">
                                Permohonan Sedang Ditinjau oleh {{ $pendingMentorship->mentor->name }}
                            </h3>
                            <p class="text-xs md:text-sm text-gray-600 leading-relaxed">
                                Anda telah mengajukan permohonan bimbingan. Setelah mentor menyetujui, Anda akan resmi menjadi anak bimbingan beliau dan dapat langsung memilih jadwal sesi.
                            </p>
                            @if($pendingMentorship->student_notes)
                                <div class="rounded-xl bg-white p-3.5 border border-amber-200 text-xs text-gray-700 shadow-xs">
                                    <strong class="text-gray-900 block mb-0.5">Catatan/Topik Anda:</strong>
                                    {{ $pendingMentorship->student_notes }}
                                </div>
                            @endif
                        </div>
                        <div class="shrink-0">
                            <button type="button"
                                onclick="confirmCancelRequest('{{ route('mentoring.request.cancel', $pendingMentorship) }}')"
                                class="w-full sm:w-auto rounded-2xl border border-gray-300 bg-white px-5 py-3 text-xs font-bold text-gray-700 shadow-xs transition hover:bg-red-50 hover:text-red-600 hover:border-red-200">
                                Batalkan Pengajuan
                            </button>
                        </div>
                    </div>
                </div>
            @elseif(! $activeMentorship)
                <!-- 3. NO ACTIVE MENTOR / AFTER TERMINATION STATE -->
                <div class="mb-8 rounded-3xl border border-pink-100 bg-gradient-to-r from-pink-50 via-rose-50 to-white p-6 md:p-8 shadow-sm">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                        <div class="space-y-2 max-w-2xl">
                            <span class="inline-flex items-center gap-1.5 rounded-full bg-pink-100 px-3 py-1 text-xs font-bold text-pink-700">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                                Pilih Mentor Anda
                            </span>
                            <h3 class="text-xl md:text-2xl font-black text-gray-900">
                                Anda Belum Memiliki Mentor Pendamping
                            </h3>
                            <p class="text-xs md:text-sm text-gray-600 leading-relaxed">
                                Anda memiliki <strong>{{ $totalRemainingQuota }}x jatah kuota sesi</strong> mentoring. Pilih mentor ahli favorit Anda untuk memulai bimbingan privat 1-on-1.
                            </p>
                        </div>
                        <div class="shrink-0">
                            <a href="{{ route('mentoring.mentors') }}"
                                class="inline-flex items-center justify-center gap-2 rounded-2xl bg-pink-600 px-6 py-3.5 text-xs md:text-sm font-bold text-white shadow-md transition hover:bg-pink-700 hover:scale-105 transform">
                                <span>Pilih Mentor Sekarang</span>
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Main Grid: Jadwal Sesi Terjadwal & Kuota + History -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
                <section class="lg:col-span-2 space-y-6">
                    <div class="rounded-3xl border border-pink-100 bg-white p-6 md:p-8 shadow-sm">
                        <div class="flex items-center justify-between gap-4 mb-6 pb-4 border-b border-gray-100">
                            <div>
                                <h2 class="text-xl font-bold text-gray-900">Sesi Mentoring Terjadwal</h2>
                                <p class="text-xs text-gray-500 mt-0.5">Sesi bimbingan aktif yang sudah Anda jadwalkan.</p>
                            </div>
                            @if($activeMentoringBooking)
                                <span class="inline-flex items-center rounded-full bg-pink-100 px-3 py-1 text-xs font-bold text-pink-700">
                                    {{ ucfirst(str_replace('_', ' ', (string) $activeMentoringBooking->status)) }}
                                </span>
                            @endif
                        </div>

                        @if($activeMentoringBooking)
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div class="rounded-2xl bg-gray-50 p-4 border border-gray-100">
                                    <p class="text-xs text-gray-500 font-semibold uppercase tracking-wider">Mentor Pembimbing</p>
                                    <p class="font-bold text-gray-900 text-base mt-1">{{ $activeMentoringBooking->mentor->name ?? '-' }}</p>
                                    <p class="text-xs text-gray-500 mt-0.5">{{ $activeMentoringBooking->mentor->job_title ?? 'Mentor Beauty' }}</p>
                                </div>

                                <div class="rounded-2xl bg-gray-50 p-4 border border-gray-100">
                                    <p class="text-xs text-gray-500 font-semibold uppercase tracking-wider">Topik Kelas</p>
                                    <p class="font-bold text-gray-900 text-base mt-1 line-clamp-1">{{ $activeMentoringBooking->course->name ?? '-' }}</p>
                                    <p class="text-xs text-pink-600 font-semibold mt-0.5">Sesi 1-on-1 Online</p>
                                </div>

                                <div class="rounded-2xl bg-gray-50 p-4 border border-gray-100">
                                    <p class="text-xs text-gray-500 font-semibold uppercase tracking-wider">Waktu & Tanggal</p>
                                    <p class="font-bold text-gray-900 text-base mt-1">
                                        {{ $activeMentoringBooking->starts_at?->translatedFormat('l, d M Y') }}
                                    </p>
                                    <p class="text-xs text-gray-600 mt-0.5 font-medium">
                                        Pukul {{ $activeMentoringBooking->starts_at?->format('H:i') }} - {{ $activeMentoringBooking->ends_at?->format('H:i') }} WIB
                                    </p>
                                </div>

                                <div class="rounded-2xl bg-gray-50 p-4 border border-gray-100">
                                    <p class="text-xs text-gray-500 font-semibold uppercase tracking-wider">Tautan Meeting</p>
                                    @if($activeMentoringBooking->meeting_url)
                                        <div class="mt-2">
                                            <a href="{{ $activeMentoringBooking->meeting_url }}" target="_blank" rel="noopener noreferrer"
                                                class="inline-flex items-center gap-2 rounded-xl bg-pink-600 px-4 py-2 text-xs font-bold text-white shadow-xs hover:bg-pink-700 transition">
                                                <span>Buka Ruang Meeting</span>
                                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                                </svg>
                                            </a>
                                        </div>
                                    @else
                                        <p class="text-xs font-semibold text-amber-700 mt-1">Link meeting akan dicantumkan mentor sebelum sesi dimulai.</p>
                                    @endif
                                </div>
                            </div>

                            @if($activeMentoringBooking->notes)
                                <div class="mt-4 rounded-2xl bg-pink-50/60 p-4 border border-pink-100 text-xs text-gray-700">
                                    <span class="font-bold text-pink-900 block mb-0.5">Catatan Persiapan dari Mentor:</span>
                                    {{ $activeMentoringBooking->notes }}
                                </div>
                            @endif
                        @else
                            <div class="rounded-2xl border border-dashed border-gray-200 bg-gray-50/50 p-8 text-center">
                                <p class="text-sm font-semibold text-gray-700">Belum ada jadwal sesi yang aktif.</p>
                                <p class="text-xs text-gray-500 mt-1">
                                    @if($activeMentorship)
                                        Klik tombol "Pilih Jadwal Mentoring" untuk memilih jam konsultasi dengan {{ $activeMentorship->mentor->name }}.
                                    @else
                                        Pilih mentor pembimbing terlebih dahulu untuk membuka pemilihan jadwal.
                                    @endif
                                </p>
                            </div>
                        @endif
                    </div>
                </section>

                <!-- Sidebar: Informasi Kuota Mentoring & Riwayat -->
                <aside class="space-y-6">
                    <!-- Kuota Card -->
                    <div class="rounded-3xl border border-pink-100 bg-gradient-to-br from-pink-50 via-white to-rose-50 p-6 shadow-sm">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-base font-bold text-gray-900">Hak Kuota Mentoring</h3>
                            <span class="rounded-full bg-pink-600 px-3 py-1 text-xs font-extrabold text-white">
                                Total Sisa: {{ $totalRemainingQuota }}x
                            </span>
                        </div>

                        <div class="space-y-3">
                            @forelse($availableMentoringEntitlements as $entitlement)
                                <div class="rounded-2xl bg-white p-3.5 border border-pink-100/80 shadow-2xs">
                                    <p class="font-bold text-gray-900 text-xs line-clamp-1">{{ $entitlement->course->name ?? 'Kelas' }}</p>
                                    <div class="flex justify-between items-center text-[11px] text-gray-500 mt-1">
                                        <span>Kuota: {{ $entitlement->total_quota }}x Sesi</span>
                                        <span class="font-bold text-pink-600">Sisa: {{ $entitlement->total_quota - $entitlement->used_quota }}x</span>
                                    </div>
                                </div>
                            @empty
                                <p class="text-xs text-gray-400">Tidak ada paket kuota aktif.</p>
                            @endforelse
                        </div>
                    </div>

                    <!-- Riwayat Sesi Card -->
                    <div class="rounded-3xl border border-pink-100 bg-white p-6 shadow-sm">
                        <h3 class="text-base font-bold text-gray-900 mb-4">Riwayat Sesi Mentoring</h3>
                        <div class="space-y-3">
                            @forelse($mentoringHistory as $booking)
                                <div class="rounded-2xl border border-gray-100 bg-gray-50/70 p-3.5">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <p class="text-xs font-bold text-gray-900">{{ $booking->mentor->name ?? '-' }}</p>
                                            <p class="text-[11px] text-gray-500 mt-0.5">{{ $booking->course->name ?? 'Kelas' }}</p>
                                            <p class="text-[10px] text-gray-400 mt-0.5">{{ $booking->starts_at?->format('d M Y, H:i') }} WIB</p>
                                        </div>
                                        <span class="rounded-full bg-white px-2 py-0.5 text-[10px] font-bold text-pink-600 border border-pink-100">
                                            {{ ucfirst((string) $booking->status) }}
                                        </span>
                                    </div>
                                </div>
                            @empty
                                <p class="text-xs text-gray-400 text-center py-4">Belum ada riwayat sesi sebelumnya.</p>
                            @endforelse
                        </div>
                    </div>
                </aside>
            </div>
        @endif

        <!-- MODAL PUTUS HUBUNGAN DENGAN MENTOR (TERMINATE MENTORSHIP) -->
        <div x-show="showTerminateModal"
            x-cloak
            class="fixed inset-0 z-50 overflow-y-auto"
            style="display: none;"
            aria-labelledby="modal-title"
            role="dialog"
            aria-modal="true">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div x-show="showTerminateModal"
                    x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100"
                    x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    class="fixed inset-0 bg-gray-900/60 backdrop-blur-xs transition-opacity"
                    @click="showTerminateModal = false"
                    aria-hidden="true"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div x-show="showTerminateModal"
                    x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    class="inline-block align-bottom bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-pink-100">
                    
                    <form method="POST" action="{{ route('mentoring.terminate') }}" id="terminateMentorshipForm">
                        @csrf

                        <div class="bg-white px-6 pt-6 pb-4">
                            <div class="flex items-start justify-between pb-4 border-b border-gray-100">
                                <div>
                                    <h3 class="text-lg font-black text-gray-900" id="modal-title">
                                        Ganti Mentor / Putus Hubungan
                                    </h3>
                                    <p class="text-xs text-gray-500 mt-0.5">Akhiri hubungan bimbingan dengan mentor saat ini.</p>
                                </div>
                                <button type="button" @click="showTerminateModal = false" class="rounded-full p-1 text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>

                            <div class="mt-4 space-y-4">
                                <div class="rounded-2xl bg-amber-50 p-4 border border-amber-200 text-xs text-amber-900 space-y-1">
                                    <p class="font-bold flex items-center gap-1.5 text-amber-800">
                                        <svg class="w-4 h-4 text-amber-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        Jatah Kuota Mentoring Anda Tetap Aman 100%
                                    </p>
                                    <p class="text-amber-700 leading-relaxed">
                                        Setelah memutus hubungan dengan <strong>{{ $activeMentorship?->mentor?->name ?? 'Mentor' }}</strong>, Anda dapat langsung memilih mentor baru dari daftar mentor Salonkita.
                                    </p>
                                </div>

                                <div>
                                    <label for="termination_reason" class="block text-xs font-bold text-gray-700 mb-1.5">
                                        Alasan Pembatalan / Evaluasi <span class="text-red-500">*</span>
                                    </label>
                                    <textarea id="termination_reason"
                                        name="termination_reason"
                                        x-model="terminateReason"
                                        required
                                        rows="4"
                                        placeholder="Contoh: Jadwal sesi mentor sering tidak cocok dengan waktu saya / Ingin belajar teknik yang lebih spesifik dengan mentor lain..."
                                        class="w-full rounded-2xl border border-gray-300 p-3.5 text-xs focus:border-pink-500 focus:ring-2 focus:ring-pink-500/20 focus:outline-hidden leading-relaxed"></textarea>
                                    <p class="text-[11px] text-gray-400 mt-1.5">
                                        Alasan ini akan ditinjau secara rahasia oleh Admin untuk menjaga standar kualitas bimbingan.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-50 px-6 py-4 flex flex-col-reverse sm:flex-row sm:justify-end gap-2.5 border-t border-gray-100">
                            <button type="button"
                                @click="showTerminateModal = false"
                                class="w-full sm:w-auto inline-flex justify-center rounded-xl border border-gray-300 bg-white px-5 py-2.5 text-xs font-bold text-gray-700 shadow-xs hover:bg-gray-50 transition">
                                Batal
                            </button>
                            <button type="submit"
                                :disabled="terminateReason.trim().length < 5"
                                class="w-full sm:w-auto inline-flex justify-center rounded-xl bg-red-600 px-6 py-2.5 text-xs font-bold text-white shadow-md hover:bg-red-700 transition disabled:opacity-50 disabled:cursor-not-allowed">
                                Ya, Putus Hubungan & Pilih Mentor Baru
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <!-- Hidden Form for Canceling Mentoring Request -->
    <form id="cancelRequestForm" method="POST" style="display: none;">
        @csrf
    </form>

    <x-footer />

    <!-- SweetAlert2 Handlers -->
    <script>
        function confirmCancelRequest(actionUrl) {
            Swal.fire({
                title: 'Batalkan Pengajuan?',
                text: 'Permohonan bimbingan ke mentor ini akan dibatalkan dan Anda dapat mengajukan ke mentor lain.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#db2777',
                cancelButtonColor: '#9ca3af',
                confirmButtonText: 'Ya, Batalkan',
                cancelButtonText: 'Kembali',
                reverseButtons: true,
                customClass: {
                    popup: 'rounded-3xl p-6 font-sans',
                    confirmButton: 'rounded-xl px-5 py-2.5 font-bold',
                    cancelButton: 'rounded-xl px-5 py-2.5 font-bold'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.getElementById('cancelRequestForm');
                    form.action = actionUrl;
                    form.submit();
                }
            });
        }

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
