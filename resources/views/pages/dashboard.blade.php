<x-layout>
    <x-navbar container-class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8" />
    <!-- MAIN CONTENT -->
    <main class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- GREETING SECTION -->
        <section class="mb-6 sm:mb-8 md:mb-10">
            <h1 class="text-lg sm:text-2xl md:text-3xl lg:text-4xl font-bold text-gray-900 mb-1">
                Hai, {{ auth()->user()->name }}! 👋
            </h1>
            <p class="text-xs sm:text-sm md:text-base text-gray-600">
                Waktunya Upgrade Skill Beauty Kamu!
            </p>
        </section>

        @php
            $hasActiveBooking = isset($activeMentoringBooking) && $activeMentoringBooking !== null;
            $hasActiveRequest = isset($currentMentoringRequest) && $currentMentoringRequest !== null;
            $hasUnusedQuota = isset($availableMentoringEntitlement) 
                && $availableMentoringEntitlement !== null 
                && $availableMentoringEntitlement->used_quota < $availableMentoringEntitlement->total_quota;
            $isMentoringVisible = $hasActiveBooking || $hasActiveRequest || $hasUnusedQuota;
        @endphp

        @if($isMentoringVisible)
            <!-- MENTORING NOTICE (RESPONSIVE: SLIM STRIP ON MOBILE, HERO BANNER ON PC) -->
            <section class="mb-6 md:mb-8">
                @if($hasActiveBooking)
                    @php
                        $isLinkReady = filled($activeMentoringBooking->meeting_url);
                        $sessionDateShort = $activeMentoringBooking->starts_at->translatedFormat('d M');
                        $sessionDateLong = $activeMentoringBooking->starts_at->translatedFormat('l, d M Y');
                        $sessionTime = $activeMentoringBooking->starts_at->format('H:i') . ' WIB';
                    @endphp
                    @if($isLinkReady)
                        <!-- STATE 1: LINK MEETING SIAP -->
                        <!-- Mobile View -->
                        <div class="md:hidden rounded-xl bg-gradient-to-r from-pink-500 to-rose-500 p-3 text-white shadow-xs flex items-center justify-between gap-2.5">
                            <div class="flex items-center gap-2 text-xs">
                                <span class="relative flex h-2.5 w-2.5 shrink-0">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-300 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-emerald-400"></span>
                                </span>
                                <p class="leading-tight">
                                    Link mentoring dengan <strong>{{ $activeMentoringBooking->mentor?->name ?? 'Mentor' }}</strong> ({{ $sessionTime }}) sudah siap!
                                </p>
                            </div>
                            <div class="flex items-center gap-1.5 shrink-0">
                                <a href="{{ $activeMentoringBooking->meeting_url }}" target="_blank"
                                    class="inline-flex items-center rounded-lg bg-white px-3 py-1.5 text-xs font-bold text-pink-600 hover:bg-pink-50 transition shadow-2xs">
                                    Gabung ➔
                                </a>
                                <a href="{{ route('mentoring.index') }}"
                                    class="text-xs text-pink-100 hover:text-white px-1 font-medium transition">
                                    Detail
                                </a>
                            </div>
                        </div>

                        <!-- Desktop View -->
                        <div class="hidden md:block relative overflow-hidden rounded-3xl bg-gradient-to-r from-pink-500 via-rose-500 to-pink-600 p-6 lg:p-7 text-white shadow-xl shadow-pink-500/15">
                            <div class="absolute -right-12 -bottom-12 w-48 h-48 bg-white/15 rounded-full blur-2xl pointer-events-none"></div>
                            <div class="absolute -left-10 -top-10 w-36 h-36 bg-white/10 rounded-full blur-xl pointer-events-none"></div>
                            <div class="relative z-10 flex items-center justify-between gap-6">
                                <div class="flex items-center gap-4">
                                    <div class="w-13 h-13 rounded-2xl bg-white/20 backdrop-blur-md flex items-center justify-center text-white border border-white/30 shadow-inner shrink-0">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                    <div class="space-y-1">
                                        <div class="flex items-center gap-2">
                                            <span class="inline-flex items-center gap-1.5 rounded-full bg-white/20 backdrop-blur-md px-3 py-0.5 text-xs font-bold uppercase tracking-wider text-white border border-white/20">
                                                <span class="w-2 h-2 rounded-full bg-emerald-300 animate-ping"></span>
                                                Link Meeting Siap
                                            </span>
                                            <span class="text-xs text-pink-100 font-medium">{{ $sessionDateLong }} • {{ $sessionTime }}</span>
                                        </div>
                                        <h2 class="text-xl lg:text-2xl font-black tracking-tight text-white">
                                            Sesi Mentoring dengan {{ $activeMentoringBooking->mentor?->name ?? 'Mentor' }}
                                        </h2>
                                        <p class="text-sm text-pink-100 max-w-xl">
                                            Link meeting kelas <strong class="text-white font-bold">{{ $activeMentoringBooking->course?->name }}</strong> sudah siap.
                                        </p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-3 shrink-0">
                                    <a href="{{ $activeMentoringBooking->meeting_url }}" target="_blank"
                                        class="inline-flex items-center justify-center gap-2 rounded-2xl bg-white px-6 py-3 font-extrabold text-pink-600 shadow-md shadow-black/10 transition hover:bg-pink-50 hover:scale-105 text-sm">
                                        <svg class="w-4 h-4 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                        </svg>
                                        Gabung Meeting ➔
                                    </a>
                                    <a href="{{ route('mentoring.index') }}"
                                        class="inline-flex items-center justify-center rounded-2xl bg-white/15 hover:bg-white/25 border border-white/30 px-4 py-3 font-semibold text-white transition text-xs">
                                        Detail Sesi
                                    </a>
                                </div>
                            </div>
                        </div>
                    @else
                        <!-- STATE 2: SESI TERJADWAL -->
                        <!-- Mobile View -->
                        <div class="md:hidden rounded-xl bg-gradient-to-r from-pink-500 to-rose-500 p-3 text-white shadow-xs flex items-center justify-between gap-2.5">
                            <div class="flex items-center gap-2 text-xs">
                                <span class="shrink-0 text-sm">📅</span>
                                <p class="leading-tight">
                                    Sesi dengan <strong>{{ $activeMentoringBooking->mentor?->name ?? 'Mentor' }}</strong> terjadwal: <strong>{{ $sessionDateShort }} ({{ $sessionTime }})</strong>.
                                </p>
                            </div>
                            <div class="shrink-0">
                                <a href="{{ route('mentoring.index') }}"
                                    class="inline-flex items-center rounded-lg bg-white px-3 py-1.5 text-xs font-bold text-pink-600 hover:bg-pink-50 transition shadow-2xs">
                                    Lihat Jadwal
                                </a>
                            </div>
                        </div>

                        <!-- Desktop View -->
                        <div class="hidden md:block relative overflow-hidden rounded-3xl bg-gradient-to-r from-pink-500 via-rose-500 to-pink-600 p-6 lg:p-7 text-white shadow-xl shadow-pink-500/15">
                            <div class="absolute -right-12 -bottom-12 w-48 h-48 bg-white/15 rounded-full blur-2xl pointer-events-none"></div>
                            <div class="absolute -left-10 -top-10 w-36 h-36 bg-white/10 rounded-full blur-xl pointer-events-none"></div>
                            <div class="relative z-10 flex items-center justify-between gap-6">
                                <div class="flex items-center gap-4">
                                    <div class="w-13 h-13 rounded-2xl bg-white/20 backdrop-blur-md flex items-center justify-center text-white border border-white/30 shadow-inner shrink-0">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                    <div class="space-y-1">
                                        <div class="flex items-center gap-2">
                                            <span class="inline-flex items-center gap-1.5 rounded-full bg-white/20 backdrop-blur-md px-3 py-0.5 text-xs font-bold uppercase tracking-wider text-white border border-white/20">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                </svg>
                                                Sesi Terjadwal
                                            </span>
                                            <span class="text-xs text-pink-100 font-medium">{{ $sessionDateLong }} • {{ $sessionTime }}</span>
                                        </div>
                                        <h2 class="text-xl lg:text-2xl font-black tracking-tight text-white">
                                            Sesi Mentoring dengan {{ $activeMentoringBooking->mentor?->name ?? 'Mentor' }}
                                        </h2>
                                        <p class="text-sm text-pink-100 max-w-xl">
                                            Jadwal bimbingan kelas <strong class="text-white font-bold">{{ $activeMentoringBooking->course?->name }}</strong> sudah tercatat.
                                        </p>
                                    </div>
                                </div>
                                <div class="shrink-0">
                                    <a href="{{ route('mentoring.index') }}"
                                        class="inline-flex items-center justify-center gap-2 rounded-2xl bg-white px-6 py-3 font-extrabold text-pink-600 shadow-md shadow-black/10 transition hover:bg-pink-50 hover:scale-105 text-sm">
                                        Lihat Jadwal ➔
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endif

                @elseif($hasActiveRequest && $currentMentoringRequest->isApproved())
                    <!-- STATE 3: PERMOHONAN DI-ACC MENTOR -->
                    <!-- Mobile View -->
                    <div class="md:hidden rounded-xl bg-gradient-to-r from-pink-500 to-rose-500 p-3 text-white shadow-xs flex items-center justify-between gap-2.5">
                        <div class="flex items-center gap-2 text-xs">
                            <span class="shrink-0 text-sm">🎉</span>
                            <p class="leading-tight">
                                Permohonan mentoring di-ACC oleh <strong>{{ $currentMentoringRequest->mentor?->name ?? 'Mentor' }}</strong>!
                            </p>
                        </div>
                        <div class="shrink-0">
                            <a href="{{ route('mentoring.book') }}"
                                class="inline-flex items-center rounded-lg bg-white px-3 py-1.5 text-xs font-bold text-pink-600 hover:bg-pink-50 transition shadow-2xs">
                                Pilih Jadwal ➔
                            </a>
                        </div>
                    </div>

                    <!-- Desktop View -->
                    <div class="hidden md:block relative overflow-hidden rounded-3xl bg-gradient-to-r from-pink-500 via-rose-500 to-pink-600 p-6 lg:p-7 text-white shadow-xl shadow-pink-500/15">
                        <div class="absolute -right-12 -bottom-12 w-48 h-48 bg-white/15 rounded-full blur-2xl pointer-events-none"></div>
                        <div class="absolute -left-10 -top-10 w-36 h-36 bg-white/10 rounded-full blur-xl pointer-events-none"></div>
                        <div class="relative z-10 flex items-center justify-between gap-6">
                            <div class="flex items-center gap-4">
                                <div class="w-13 h-13 rounded-2xl bg-white/20 backdrop-blur-md flex items-center justify-center text-white border border-white/30 shadow-inner shrink-0">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </div>
                                <div class="space-y-1">
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-white/20 backdrop-blur-md px-3 py-0.5 text-xs font-bold uppercase tracking-wider text-white border border-white/20">
                                        ✨ Pengajuan Di-ACC
                                    </span>
                                    <h2 class="text-xl lg:text-2xl font-black tracking-tight text-white">
                                        Permohonanmu Di-ACC oleh {{ $currentMentoringRequest->mentor?->name ?? 'Mentor' }}! 🎉
                                    </h2>
                                    <p class="text-sm text-pink-100 max-w-xl">
                                        Mentor siap membimbingmu. Yuk tentukan jam sesi yang cocok!
                                    </p>
                                </div>
                            </div>
                            <div class="shrink-0">
                                <a href="{{ route('mentoring.book') }}"
                                    class="inline-flex items-center justify-center gap-2 rounded-2xl bg-white px-6 py-3 font-extrabold text-pink-600 shadow-md shadow-black/10 transition hover:bg-pink-50 hover:scale-105 text-sm">
                                    Pilih Jadwal Sesi ➔
                                </a>
                            </div>
                        </div>
                    </div>

                @elseif($hasActiveRequest && $currentMentoringRequest->isPending())
                    <!-- STATE 4: PERMOHONAN SEDANG DITINJAU (PENDING) -->
                    <!-- Mobile View -->
                    <div class="md:hidden rounded-xl bg-gradient-to-r from-pink-500 to-rose-500 p-3 text-white shadow-xs flex items-center justify-between gap-2.5">
                        <div class="flex items-center gap-2 text-xs">
                            <span class="shrink-0 text-sm">⏳</span>
                            <p class="leading-tight">
                                Pengajuan bimbingan ke <strong>{{ $currentMentoringRequest->mentor?->name ?? 'Mentor' }}</strong> sedang ditinjau.
                            </p>
                        </div>
                        <div class="shrink-0">
                            <a href="{{ route('mentoring.index') }}"
                                class="inline-flex items-center rounded-lg bg-white px-3 py-1.5 text-xs font-bold text-pink-600 hover:bg-pink-50 transition shadow-2xs">
                                Cek Status
                            </a>
                        </div>
                    </div>

                    <!-- Desktop View -->
                    <div class="hidden md:block relative overflow-hidden rounded-3xl bg-gradient-to-r from-pink-500 via-rose-500 to-pink-600 p-6 lg:p-7 text-white shadow-xl shadow-pink-500/15">
                        <div class="absolute -right-12 -bottom-12 w-48 h-48 bg-white/15 rounded-full blur-2xl pointer-events-none"></div>
                        <div class="absolute -left-10 -top-10 w-36 h-36 bg-white/10 rounded-full blur-xl pointer-events-none"></div>
                        <div class="relative z-10 flex items-center justify-between gap-6">
                            <div class="flex items-center gap-4">
                                <div class="w-13 h-13 rounded-2xl bg-white/20 backdrop-blur-md flex items-center justify-center text-white border border-white/30 shadow-inner shrink-0">
                                    <svg class="w-6 h-6 text-white animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <div class="space-y-1">
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-white/20 backdrop-blur-md px-3 py-0.5 text-xs font-bold uppercase tracking-wider text-white border border-white/20">
                                        ⏳ Sedang Ditinjau
                                    </span>
                                    <h2 class="text-xl lg:text-2xl font-black tracking-tight text-white">
                                        Pengajuan ke {{ $currentMentoringRequest->mentor?->name ?? 'Mentor' }} Sedang Diproses
                                    </h2>
                                    <p class="text-sm text-pink-100 max-w-xl">
                                        Permohonan bimbingan kelas <strong class="text-white font-bold">{{ $currentMentoringRequest->course?->name }}</strong> sedang ditinjau mentor.
                                    </p>
                                </div>
                            </div>
                            <div class="shrink-0">
                                <a href="{{ route('mentoring.index') }}"
                                    class="inline-flex items-center justify-center gap-2 rounded-2xl bg-white px-6 py-3 font-extrabold text-pink-600 shadow-md shadow-black/10 transition hover:bg-pink-50 hover:scale-105 text-sm">
                                    Cek Status ➔
                                </a>
                            </div>
                        </div>
                    </div>

                @elseif($hasUnusedQuota)
                    @php
                        $remainingQuota = $totalRemainingQuota ?? ($availableMentoringEntitlement->total_quota - $availableMentoringEntitlement->used_quota);
                        $hasDedicatedMentor = isset($activeMentorship) && $activeMentorship !== null && $activeMentorship->mentor !== null;
                    @endphp
                    <!-- STATE 5: PUNYA JATAH KUOTA MENTORING BELUM DIPAKAI -->
                    <!-- Mobile View -->
                    <div class="md:hidden rounded-xl bg-gradient-to-r from-pink-500 to-rose-500 p-3 text-white shadow-xs flex items-center justify-between gap-2.5">
                        <div class="flex items-center gap-2 text-xs">
                            <span class="shrink-0 text-sm">🎁</span>
                            <p class="leading-tight">
                                @if($hasDedicatedMentor)
                                    Konsultasi dengan mentor <strong>{{ $activeMentorship->mentor->name }}</strong> (Sisa {{ $remainingQuota }}x sesi).
                                @else
                                    Kamu punya <strong>{{ $remainingQuota }}x jatah mentoring gratis</strong>.
                                @endif
                            </p>
                        </div>
                        <div class="shrink-0">
                            @if($hasDedicatedMentor)
                                <a href="{{ route('mentoring.book') }}"
                                    class="inline-flex items-center rounded-lg bg-white px-3 py-1.5 text-xs font-bold text-pink-600 hover:bg-pink-50 transition shadow-2xs">
                                    Pilih Jadwal ➔
                                </a>
                            @else
                                <a href="{{ route('mentoring.mentors') }}"
                                    class="inline-flex items-center rounded-lg bg-white px-3 py-1.5 text-xs font-bold text-pink-600 hover:bg-pink-50 transition shadow-2xs">
                                    Pilih Mentor ➔
                                </a>
                            @endif
                        </div>
                    </div>

                    <!-- Desktop View -->
                    <div class="hidden md:block relative overflow-hidden rounded-3xl bg-gradient-to-r from-pink-500 via-rose-500 to-pink-600 p-6 lg:p-7 text-white shadow-xl shadow-pink-500/15">
                        <div class="absolute -right-12 -bottom-12 w-48 h-48 bg-white/15 rounded-full blur-2xl pointer-events-none"></div>
                        <div class="absolute -left-10 -top-10 w-36 h-36 bg-white/10 rounded-full blur-xl pointer-events-none"></div>
                        <div class="relative z-10 flex items-center justify-between gap-6">
                            <div class="flex items-center gap-4">
                                <div class="w-13 h-13 rounded-2xl bg-white/20 backdrop-blur-md flex items-center justify-center text-white border border-white/30 shadow-inner shrink-0">
                                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                </div>
                                <div class="space-y-1">
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-white/20 backdrop-blur-md px-3 py-0.5 text-xs font-bold uppercase tracking-wider text-white border border-white/20">
                                        @if($hasDedicatedMentor)
                                            ✨ Dedicated Mentor: {{ $activeMentorship->mentor->name }}
                                        @else
                                            🎁 Jatah Mentoring Aktif
                                        @endif
                                    </span>
                                    <h2 class="text-xl lg:text-2xl font-black tracking-tight text-white">
                                        Kamu Masih Punya {{ $remainingQuota }}x Jatah Mentoring Tersedia!
                                    </h2>
                                    <p class="text-sm text-pink-100 max-w-xl">
                                        @if($hasDedicatedMentor)
                                            Langsung pilih jadwal slot waktu luang dengan mentor Anda untuk konsultasi materi kelas maupun bedah portofolio.
                                        @else
                                            Yuk konsultasi privat 1-on-1 dengan Mentor Ahli untuk seluruh kelas kecantikan Salonkita.
                                        @endif
                                    </p>
                                </div>
                            </div>
                            <div class="shrink-0">
                                @if($hasDedicatedMentor)
                                    <a href="{{ route('mentoring.book') }}"
                                        class="inline-flex items-center justify-center gap-2 rounded-2xl bg-white px-6 py-3 font-extrabold text-pink-600 shadow-md shadow-black/10 transition hover:bg-pink-50 hover:scale-105 text-sm">
                                        Pilih Jadwal Mentoring ➔
                                    </a>
                                @else
                                    <a href="{{ route('mentoring.mentors') }}"
                                        class="inline-flex items-center justify-center gap-2 rounded-2xl bg-white px-6 py-3 font-extrabold text-pink-600 shadow-md shadow-black/10 transition hover:bg-pink-50 hover:scale-105 text-sm">
                                        Pilih Mentor Sekarang ➔
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            </section>
        @endif


        @if($continueWatching)
            <!-- CONTINUE WATCHING SECTION -->
            <section class="mb-6 sm:mb-10 md:mb-12">
                <h2 class="text-base sm:text-xl md:text-2xl font-bold text-gray-900 mb-3 sm:mb-4 md:mb-6">Lanjutkan Menonton</h2>
                <div
                    class="bg-white rounded-2xl overflow-hidden shadow-xs hover:shadow-md border border-pink-100 transition">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-0">
                        <!-- Video Thumbnail -->
                        <div class="h-36 sm:h-44 md:h-auto relative overflow-hidden bg-gray-100">
                            <img src="{{ $continueWatching->course->thumbnail ? Storage::url($continueWatching->course->thumbnail) : asset('assets/images/thumbnails/img_placeholder.png') }}"
                                alt="{{ $continueWatching->course->name }}"
                                onerror="this.onerror=null;this.src='{{ asset('assets/images/thumbnails/img_placeholder.png') }}';"
                                class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent"></div>
                            <div class="absolute inset-0 flex items-center justify-center">
                                <a href="{{ $continueWatching->url }}"
                                    class="w-10 h-10 sm:w-14 sm:h-14 bg-white/95 backdrop-blur-xs rounded-full flex items-center justify-center hover:scale-110 transition shadow-md"
                                    aria-label="Lanjutkan video {{ $continueWatching->video->title }}">
                                    <svg class="w-5 h-5 sm:w-7 sm:h-7 text-pink-500 ml-0.5" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M8 5v14l11-7z"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="md:col-span-2 p-3.5 sm:p-5 md:p-6 lg:p-8 flex flex-col justify-between">
                            <div>
                                <p class="text-xs sm:text-sm text-pink-600 font-semibold mb-1">
                                    {{ $continueWatching->course->name }}
                                </p>
                                <h3 class="text-sm sm:text-lg md:text-xl font-bold text-gray-900 mb-1.5 line-clamp-1">
                                    {{ $continueWatching->video->title }}
                                </h3>
                                <p class="text-xs sm:text-sm text-gray-600 mb-3 line-clamp-2">
                                    {{ \Illuminate\Support\Str::limit($continueWatching->course->description, 120) }}
                                </p>

                                <!-- Progress Bar -->
                                <div class="mb-3 sm:mb-4">
                                    <div class="flex justify-between items-center mb-1">
                                        <span class="text-[11px] sm:text-xs text-gray-500">Progress</span>
                                        <span
                                            class="text-[11px] sm:text-xs font-bold text-gray-900">{{ $continueWatching->progress_label }}</span>
                                    </div>
                                    <div class="w-full bg-gray-100 rounded-full h-1.5 sm:h-2 overflow-hidden">
                                        <div class="bg-pink-500 h-full rounded-full"
                                            style="width: {{ $continueWatching->progress_percentage }}%"></div>
                                    </div>
                                </div>
                            </div>

                            <a href="{{ $continueWatching->url }}"
                                class="inline-flex justify-center items-center px-4 py-2 sm:py-2.5 bg-pink-500 text-white text-xs sm:text-sm font-bold rounded-xl hover:bg-pink-600 transition w-full md:w-auto shadow-2xs">
                                Lanjutkan Video
                            </a>
                        </div>
                    </div>
                </div>
            </section>
        @endif

        @if($ownedCourses->isNotEmpty())
        <!-- OWNED CLASSES SECTION -->
        <section class="mb-6 sm:mb-10 md:mb-12">
            <div class="flex justify-between items-center mb-3 sm:mb-4 md:mb-6 gap-2">
                <h2 class="text-base sm:text-xl md:text-2xl font-bold text-gray-900">Kelas Saya</h2>
                <a href="{{ route('task') }}"
                    class="text-xs sm:text-sm font-semibold text-pink-600 hover:text-pink-700 transition flex items-center gap-1 shrink-0">
                    Tugas & Kelas Saya
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-4 md:gap-6">
                @foreach($ownedCourses->take(4) as $course)
                @php($isSaved = $savedCourseIds->contains($course->id))
                <!-- Course Card -->
                <div
                    class="group relative bg-white rounded-xl sm:rounded-2xl overflow-hidden shadow-xs hover:shadow-md transition border border-pink-100 flex flex-col justify-between">
                    <a href="{{ route('course', ['slug' => $course->slug]) }}" class="absolute inset-0 z-10 rounded-xl"
                        aria-label="Buka kelas {{ $course->name }}"></a>
                    
                    <div>
                        <!-- Thumbnail -->
                        <div class="relative h-28 sm:h-36 md:h-40 overflow-hidden bg-gray-100">
                            <img src="{{ $course->thumbnail ? Storage::url($course->thumbnail) : asset('assets/images/thumbnails/img_placeholder.png') }}"
                                alt="{{ $course->name }}"
                                onerror="this.onerror=null;this.src='{{ asset('assets/images/thumbnails/img_placeholder.png') }}';"
                                class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                            <!-- Rating top-right -->
                            <div
                                class="absolute top-1.5 right-1.5 sm:top-2 sm:right-2 flex items-center gap-0.5 sm:gap-1 bg-white/90 backdrop-blur-xs px-1.5 sm:px-2 py-0.5 rounded-full shadow-xs">
                                <svg class="w-3 h-3 sm:w-3.5 sm:h-3.5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                    </path>
                                </svg>
                                <span class="text-[10px] sm:text-xs font-bold text-gray-700">{{ $course->rating_label }}</span>
                            </div>
                            <!-- Save button bottom-right -->
                            @if($isSaved)
                                <form method="POST" action="{{ route('saved-courses.destroy', ['course' => $course->id]) }}"
                                    class="absolute bottom-1.5 right-1.5 sm:bottom-2 sm:right-2 z-20 js-saved-course-form" data-saved-action="unsave"
                                    data-course-name="{{ $course->name }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="p-1 sm:p-1.5 bg-white/90 backdrop-blur-xs rounded-full shadow-xs hover:bg-pink-50 transition"
                                        aria-label="Hapus {{ $course->name }} dari tersimpan">
                                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-pink-500" fill="currentColor" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
                                        </svg>
                                    </button>
                                </form>
                            @else
                                <form method="POST" action="{{ route('saved-courses.store', ['course' => $course->id]) }}"
                                    class="absolute bottom-1.5 right-1.5 sm:bottom-2 sm:right-2 z-20 js-saved-course-form" data-saved-action="save"
                                    data-course-name="{{ $course->name }}">
                                    @csrf
                                    <button type="submit"
                                        class="p-1 sm:p-1.5 bg-white/90 backdrop-blur-xs rounded-full shadow-xs hover:bg-pink-50 transition"
                                        aria-label="Simpan {{ $course->name }} ke tersimpan">
                                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-gray-500 hover:text-pink-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
                                        </svg>
                                    </button>
                                </form>
                            @endif
                        </div>

                        <!-- Info -->
                        <div class="p-2.5 sm:p-3.5 md:p-4">
                            <h3 class="text-xs sm:text-sm md:text-base font-bold text-gray-900 mb-0.5 sm:mb-1 line-clamp-2 leading-snug">{{ $course->name }}</h3>
                            <p class="text-[11px] sm:text-xs text-pink-600 font-semibold mb-1.5 sm:mb-2 truncate">{{ $course->category->name }}</p>
                            <div class="flex items-center gap-1 text-gray-500 text-[10px] sm:text-xs mb-2 sm:mb-3">
                                <svg class="w-3 h-3 sm:w-3.5 sm:h-3.5 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>{{ $course->duration_label }}</span>
                            </div>
                            <div>
                                <div class="flex items-center justify-between mb-1 sm:mb-1.5">
                                    <span class="text-[10px] sm:text-xs font-medium text-gray-500">Progress</span>
                                    <span class="text-[10px] sm:text-xs font-bold text-pink-600">{{ $course->progress_label }}</span>
                                </div>
                                <div class="w-full bg-gray-100 rounded-full h-1.5 sm:h-2 overflow-hidden">
                                    <div class="h-full rounded-full bg-pink-500"
                                        style="width: {{ $course->progress_percentage }}%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </section>
        @endif

        <!-- RECOMMENDATIONS SECTION -->
        <section>
            <div class="flex justify-between items-center mb-3 sm:mb-4 md:mb-6 gap-2">
                <h2 class="text-base sm:text-xl md:text-2xl font-bold text-gray-900">Rekomendasi Untuk Anda</h2>
                <a href="{{ route('all-courses') }}"
                    class="text-xs sm:text-sm font-semibold text-pink-600 hover:text-pink-700 transition flex items-center gap-1 shrink-0">
                    Jelajahi Kelas
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-4 md:gap-6">
                @forelse($recommendedCourses as $course)
                @php($isSaved = $savedCourseIds->contains($course->id))
                <!-- Course Card -->
                <div
                    class="group relative bg-white rounded-xl sm:rounded-2xl overflow-hidden shadow-xs hover:shadow-md transition border border-pink-100 flex flex-col justify-between">
                    <div>
                        <!-- Thumbnail -->
                        <div class="relative h-28 sm:h-36 md:h-40 overflow-hidden bg-gray-100">
                            <img src="{{ $course->thumbnail ? Storage::url($course->thumbnail) : asset('assets/images/thumbnails/img_placeholder.png') }}"
                                alt="{{ $course->name }}"
                                onerror="this.onerror=null;this.src='{{ asset('assets/images/thumbnails/img_placeholder.png') }}';"
                                class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                            <!-- Rating top-right -->
                            <div
                                class="absolute top-1.5 right-1.5 sm:top-2 sm:right-2 flex items-center gap-0.5 sm:gap-1 bg-white/90 backdrop-blur-xs px-1.5 sm:px-2 py-0.5 rounded-full shadow-xs">
                                <svg class="w-3 h-3 sm:w-3.5 sm:h-3.5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                    </path>
                                </svg>
                                <span class="text-[10px] sm:text-xs font-bold text-gray-700">{{ $course->rating_label }}</span>
                            </div>
                            <!-- Save button bottom-right -->
                            @if($isSaved)
                                <form method="POST" action="{{ route('saved-courses.destroy', ['course' => $course->id]) }}"
                                    class="absolute bottom-1.5 right-1.5 sm:bottom-2 sm:right-2 z-20 js-saved-course-form" data-saved-action="unsave"
                                    data-course-name="{{ $course->name }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="p-1 sm:p-1.5 bg-white/90 backdrop-blur-xs rounded-full shadow-xs hover:bg-pink-50 transition"
                                        aria-label="Hapus {{ $course->name }} dari tersimpan">
                                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-pink-500" fill="currentColor" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
                                        </svg>
                                    </button>
                                </form>
                            @else
                                <form method="POST" action="{{ route('saved-courses.store', ['course' => $course->id]) }}"
                                    class="absolute bottom-1.5 right-1.5 sm:bottom-2 sm:right-2 z-20 js-saved-course-form" data-saved-action="save"
                                    data-course-name="{{ $course->name }}">
                                    @csrf
                                    <button type="submit"
                                        class="p-1 sm:p-1.5 bg-white/90 backdrop-blur-xs rounded-full shadow-xs hover:bg-pink-50 transition"
                                        aria-label="Simpan {{ $course->name }} ke tersimpan">
                                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-gray-500 hover:text-pink-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
                                        </svg>
                                    </button>
                                </form>
                            @endif
                        </div>

                        <!-- Info -->
                        <div class="p-2.5 sm:p-3.5 md:p-4">
                            <h3 class="text-xs sm:text-sm md:text-base font-bold text-gray-900 mb-0.5 sm:mb-1 line-clamp-2 leading-snug">{{ $course->name }}</h3>
                            <p class="text-[11px] sm:text-xs text-pink-600 font-semibold mb-1.5 sm:mb-2 truncate">{{ $course->category->name }}</p>
                            <div class="flex items-center gap-1 text-gray-500 text-[10px] sm:text-xs mb-2 sm:mb-3">
                                <svg class="w-3 h-3 sm:w-3.5 sm:h-3.5 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>{{ $course->duration_label }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Footer / Price & Button -->
                    <div class="px-2.5 pb-2.5 sm:px-3.5 sm:pb-3.5 md:px-4 md:pb-4 pt-0">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-1.5 sm:gap-2">
                            <span class="text-xs sm:text-sm md:text-base font-extrabold text-pink-600">Rp {{ number_format((int) $course->price, 0, ',', '.') }}</span>
                            <a href="{{ route('course', ['slug' => $course->slug]) }}"
                                class="inline-flex items-center justify-center px-2 py-1.5 sm:px-3 sm:py-1.5 bg-pink-500 text-white text-[11px] sm:text-xs font-bold rounded-lg hover:bg-pink-600 transition text-center shadow-2xs">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>

                @empty
                <div class="col-span-2 sm:col-span-2 md:col-span-3 lg:col-span-4 text-center py-8 text-gray-500 text-sm">
                    Belum ada rekomendasi kelas.
                </div>
                @endforelse
            </div>

            <div class="mt-6 sm:mt-8">
                {{ $recommendedCourses->links() }}
            </div>
        </section>
    </main>
    <x-footer container-class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8" />
</x-layout>