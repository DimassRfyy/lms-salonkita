<x-layout>
    <x-navbar />
    <x-breadcrumb />

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-12 py-10">
        <!-- Header Banner -->
        <section class="relative overflow-hidden mb-8 rounded-3xl bg-gradient-to-r from-pink-600 via-rose-500 to-amber-500 p-6 md:p-8 text-white shadow-md">
            <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <div class="max-w-2xl space-y-2">
                    <span class="inline-flex items-center gap-1.5 rounded-full bg-white/20 px-3 py-1 text-xs font-bold uppercase tracking-wider backdrop-blur-xs">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"/>
                        </svg>
                        Mentoring Center
                    </span>
                    <h1 class="text-2xl md:text-3xl font-extrabold tracking-tight">
                        Bimbingan Privat Bersama Mentor Ahli
                    </h1>
                    <p class="text-xs md:text-sm text-white/90 leading-relaxed">
                        Dapatkan evaluasi teknik kecantikan, bedah portofolio, dan konsultasi karir secara eksklusif 1-on-1 melalui sesi video meeting.
                    </p>
                </div>

                @if($availableMentoringEntitlement && (! $currentMentoringRequest || ! $currentMentoringRequest->isPending()))
                    <div class="shrink-0">
                        @if($currentMentoringRequest && $currentMentoringRequest->isApproved())
                            <a href="{{ route('mentoring.book', ['entitlement' => $availableMentoringEntitlement->id]) }}"
                                class="inline-flex items-center gap-2 rounded-2xl bg-white px-5 py-3 text-xs md:text-sm font-extrabold text-pink-600 shadow-md transition hover:bg-pink-50">
                                <span>Pilih Jadwal Mentoring</span>
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                </svg>
                            </a>
                        @else
                            <a href="{{ route('mentoring.mentors') }}"
                                class="inline-flex items-center gap-2 rounded-2xl bg-white px-5 py-3 text-xs md:text-sm font-extrabold text-pink-600 shadow-md transition hover:bg-pink-50">
                                <span>Cari & Ajukan Mentor</span>
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                </svg>
                            </a>
                        @endif
                    </div>
                @endif
            </div>

            <!-- Background Aesthetic Circle Decoration -->
            <div class="absolute -top-20 -right-20 w-72 h-72 rounded-full bg-white/10 blur-xl pointer-events-none"></div>
            <div class="absolute -bottom-20 -left-20 w-72 h-72 rounded-full bg-pink-400/20 blur-xl pointer-events-none"></div>
        </section>

        <!-- 3-Langkah Alur Mentoring (Educational Guide) -->
        <section class="mb-10 rounded-3xl border border-pink-100 bg-white p-6 md:p-8 shadow-sm">
            <div class="mb-6">
                <h2 class="text-xl font-bold text-gray-900">Cara Kerja Mentoring</h2>
                <p class="text-sm text-gray-500 mt-1">3 langkah mudah untuk mulai sesi konsultasi privat dengan mentormu.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="flex items-start gap-4 p-4 rounded-2xl bg-pink-50/50 border border-pink-100/60">
                    <div class="w-10 h-10 rounded-xl bg-pink-600 text-white font-black text-base flex items-center justify-center shrink-0 shadow-xs">
                        1
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-900 text-base">Pilih & Ajukan Mentor</h3>
                        <p class="text-xs text-gray-600 mt-1 leading-relaxed">
                            Pilih mentor yang sesuai dengan materi kelasmu dan tulis catatan topik yang ingin kamu tanyakan.
                        </p>
                    </div>
                </div>

                <div class="flex items-start gap-4 p-4 rounded-2xl bg-amber-50/50 border border-amber-100/60">
                    <div class="w-10 h-10 rounded-xl bg-amber-500 text-white font-black text-base flex items-center justify-center shrink-0 shadow-xs">
                        2
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-900 text-base">Tunggu Persetujuan</h3>
                        <p class="text-xs text-gray-600 mt-1 leading-relaxed">
                            Mentor akan memeriksa permohonan bimbinganmu di dashboard mereka untuk memastikan ketersediaan.
                        </p>
                    </div>
                </div>

                <div class="flex items-start gap-4 p-4 rounded-2xl bg-emerald-50/50 border border-emerald-100/60">
                    <div class="w-10 h-10 rounded-xl bg-emerald-600 text-white font-black text-base flex items-center justify-center shrink-0 shadow-xs">
                        3
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-900 text-base">Pilih Jadwal & Meeting</h3>
                        <p class="text-xs text-gray-600 mt-1 leading-relaxed">
                            Setelah disetujui, pilih jam yang cocok dan masuk ke link meeting saat sesi dimulai!
                        </p>
                    </div>
                </div>
            </div>
        </section>

        @if(! $hasMentoringAccess)
            <section class="rounded-3xl border border-gray-200 bg-white p-12 text-center shadow-sm max-w-2xl mx-auto">
                <div class="w-16 h-16 rounded-full bg-pink-100 text-pink-600 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-900">Belum Ada Kuota Mentoring</h2>
                <p class="mt-2 text-gray-600 text-sm">
                    Beli kelas bersertifikat yang dilengkapi fasilitas bimbingan mentor untuk membuka akses mentoring privat ini.
                </p>
                <div class="mt-6">
                    <a href="{{ route('all-courses') }}" class="inline-flex items-center gap-2 rounded-2xl bg-pink-600 px-6 py-3 font-bold text-white shadow-md hover:bg-pink-700 transition">
                        Eksplor Kelas Salonkita
                    </a>
                </div>
            </section>
        @else
            <!-- Status Card Permohonan Aktif -->
            @if($currentMentoringRequest)
                <div class="mb-10">
                    @if($currentMentoringRequest->isPending())
                        <div class="rounded-3xl border border-amber-200 bg-gradient-to-br from-amber-50/80 via-white to-amber-50/40 p-6 md:p-8 shadow-sm">
                            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                                <div class="space-y-3 max-w-2xl">
                                    <div class="flex items-center gap-2">
                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-amber-100 px-3.5 py-1 text-xs font-bold text-amber-800">
                                            <span class="h-2 w-2 rounded-full bg-amber-500 animate-ping"></span>
                                            Menunggu Persetujuan Mentor
                                        </span>
                                    </div>
                                    <h3 class="text-xl md:text-2xl font-black text-gray-900">
                                        Permohonan Anda Sedang Ditinjau
                                    </h3>
                                    <p class="text-sm text-gray-600 leading-relaxed">
                                        Anda mengajukan bimbingan kepada <strong class="text-gray-900">{{ $currentMentoringRequest->mentor->name }}</strong> untuk kelas <strong class="text-gray-900">{{ $currentMentoringRequest->course->name ?? '-' }}</strong>. Mentor akan segera memeriksa pengajuan Anda.
                                    </p>
                                    @if($currentMentoringRequest->student_notes)
                                        <div class="rounded-xl bg-white p-3.5 border border-amber-200/80 text-xs text-gray-700 shadow-xs">
                                            <span class="font-bold text-gray-900 block mb-0.5">Topik yang diajukan:</span>
                                            {{ $currentMentoringRequest->student_notes }}
                                        </div>
                                    @endif
                                </div>
                                <div class="flex flex-col sm:flex-row items-center gap-3 shrink-0">
                                    <button type="button"
                                        onclick="confirmCancelRequest('{{ route('mentoring.request.cancel', $currentMentoringRequest) }}')"
                                        class="w-full sm:w-auto rounded-2xl border border-gray-300 bg-white px-5 py-3 text-xs font-bold text-gray-700 shadow-xs transition hover:bg-red-50 hover:text-red-600 hover:border-red-200">
                                        Batalkan Permohonan
                                    </button>
                                </div>
                            </div>
                        </div>
                    @elseif($currentMentoringRequest->isApproved())
                        <div class="rounded-3xl border border-emerald-200 bg-gradient-to-br from-emerald-50/80 via-white to-emerald-50/40 p-6 md:p-8 shadow-sm">
                            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                                <div class="space-y-2 max-w-2xl">
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-100 px-3.5 py-1 text-xs font-bold text-emerald-800">
                                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Permohonan Telah Disetujui!
                                    </span>
                                    <h3 class="text-xl md:text-2xl font-black text-gray-900">
                                        {{ $currentMentoringRequest->mentor->name }} Siap Membimbing Anda 🎉
                                    </h3>
                                    <p class="text-sm text-gray-600 leading-relaxed">
                                        Mentor telah menyetujui topik bimbingan Anda. Silakan pilih slot tanggal dan jam yang cocok untuk melaksanakan sesi privat.
                                    </p>
                                </div>
                                @if($availableMentoringEntitlement)
                                    <a href="{{ route('mentoring.book', ['entitlement' => $availableMentoringEntitlement->id]) }}"
                                        class="inline-flex items-center justify-center gap-2 rounded-2xl bg-pink-600 px-6 py-3.5 font-bold text-white shadow-md transition hover:bg-pink-700 shrink-0 hover:scale-105 transform">
                                        Pilih Slot Jadwal
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </a>
                                @endif
                            </div>
                        </div>
                    @elseif($currentMentoringRequest->isRejected())
                        <div class="rounded-3xl border border-rose-200 bg-gradient-to-br from-rose-50/80 via-white to-rose-50/40 p-6 md:p-8 shadow-sm">
                            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                                <div class="space-y-2 max-w-2xl">
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-rose-100 px-3.5 py-1 text-xs font-bold text-rose-800">
                                        Permohonan Belum Diterima
                                    </span>
                                    <h3 class="text-xl md:text-2xl font-black text-gray-900">
                                        Mentor Belum Dapat Menerima Permohonan
                                    </h3>
                                    <p class="text-sm text-gray-600">
                                        Mentor <strong class="text-gray-900">{{ $currentMentoringRequest->mentor->name }}</strong> berhalangan saat ini.
                                    </p>
                                    @if($currentMentoringRequest->rejection_reason)
                                        <div class="rounded-xl bg-white p-3.5 border border-rose-200 text-xs text-gray-700 shadow-xs">
                                            <span class="font-bold text-gray-900 block mb-0.5">Catatan dari mentor:</span>
                                            {{ $currentMentoringRequest->rejection_reason }}
                                        </div>
                                    @endif
                                    <p class="text-xs text-gray-500 mt-1">Kuota bimbingan Anda tetap utuh (100%). Anda dapat langsung mengajukan ke mentor lain.</p>
                                </div>
                                @if($availableMentoringEntitlement)
                                    <a href="{{ route('mentoring.mentors') }}"
                                        class="inline-flex items-center justify-center gap-2 rounded-2xl bg-pink-600 px-6 py-3.5 font-bold text-white shadow-md transition hover:bg-pink-700 shrink-0">
                                        Pilih Mentor Lain
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            @endif

            <!-- Main Workspace: Latest Sesi & History -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
                <section class="lg:col-span-2 space-y-6">
                    <div class="rounded-3xl border border-pink-100 bg-white p-6 md:p-8 shadow-sm">
                        <div class="flex items-center justify-between gap-4 mb-6 pb-4 border-b border-gray-100">
                            <div>
                                <h2 class="text-xl font-bold text-gray-900">Sesi Mentoring Terjadwal</h2>
                                <p class="text-xs text-gray-500 mt-0.5">Sesi bimbingan yang paling terakhir Anda booking.</p>
                            </div>
                            @if($latestMentoringBooking)
                                <span class="inline-flex items-center rounded-full bg-pink-100 px-3 py-1 text-xs font-bold text-pink-700">
                                    {{ ucfirst(str_replace('_', ' ', (string) $latestMentoringBooking->status)) }}
                                </span>
                            @endif
                        </div>

                        @if($latestMentoringBooking)
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div class="rounded-2xl bg-gray-50 p-4 border border-gray-100">
                                    <p class="text-xs text-gray-500 font-semibold uppercase tracking-wider">Mentor Pembimbing</p>
                                    <p class="font-bold text-gray-900 text-base mt-1">{{ $latestMentoringBooking->mentor->name ?? '-' }}</p>
                                    <p class="text-xs text-gray-500 mt-0.5">{{ $latestMentoringBooking->mentor->job_title ?? 'Mentor Beauty' }}</p>
                                </div>

                                <div class="rounded-2xl bg-gray-50 p-4 border border-gray-100">
                                    <p class="text-xs text-gray-500 font-semibold uppercase tracking-wider">Kelas</p>
                                    <p class="font-bold text-gray-900 text-base mt-1 line-clamp-1">{{ $latestMentoringBooking->course->name ?? '-' }}</p>
                                    <p class="text-xs text-pink-600 font-semibold mt-0.5">Sesi 1-on-1 Online</p>
                                </div>

                                <div class="rounded-2xl bg-gray-50 p-4 border border-gray-100">
                                    <p class="text-xs text-gray-500 font-semibold uppercase tracking-wider">Waktu & Tanggal</p>
                                    <p class="font-bold text-gray-900 text-base mt-1">
                                        {{ $latestMentoringBooking->starts_at?->translatedFormat('l, d M Y') }}
                                    </p>
                                    <p class="text-xs text-gray-600 mt-0.5 font-medium">
                                        Pukul {{ $latestMentoringBooking->starts_at?->format('H:i') }} - {{ $latestMentoringBooking->ends_at?->format('H:i') }} WIB
                                    </p>
                                </div>

                                <div class="rounded-2xl bg-gray-50 p-4 border border-gray-100">
                                    <p class="text-xs text-gray-500 font-semibold uppercase tracking-wider">Tautan Meeting</p>
                                    @if($latestMentoringBooking->meeting_url)
                                        <div class="mt-2">
                                            <a href="{{ $latestMentoringBooking->meeting_url }}" target="_blank" rel="noopener noreferrer"
                                                class="inline-flex items-center gap-2 rounded-xl bg-pink-600 px-4 py-2 text-xs font-bold text-white shadow-xs hover:bg-pink-700 transition">
                                                <span>Buka Ruang Meeting</span>
                                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                                </svg>
                                            </a>
                                        </div>
                                    @else
                                        <p class="text-sm font-semibold text-amber-700 mt-1">Link meeting akan disiapkan mentor sebelum sesi dimulai.</p>
                                    @endif
                                </div>
                            </div>

                            @if($latestMentoringBooking->notes)
                                <div class="mt-4 rounded-2xl bg-pink-50/60 p-4 border border-pink-100 text-xs text-gray-700">
                                    <span class="font-bold text-pink-900 block mb-0.5">Catatan Persiapan dari Mentor:</span>
                                    {{ $latestMentoringBooking->notes }}
                                </div>
                            @endif
                        @else
                            <div class="rounded-2xl border border-dashed border-gray-200 bg-gray-50/50 p-8 text-center">
                                <p class="text-sm font-semibold text-gray-700">Belum ada jadwal sesi yang dikonfirmasi.</p>
                                <p class="text-xs text-gray-500 mt-1">Ajukan permohonan ke mentor terlebih dahulu untuk membuka pemilihan jadwal.</p>
                            </div>
                        @endif
                    </div>
                </section>

                <aside class="space-y-6">
                    <!-- Kuota Card -->
                    @if($availableMentoringEntitlement)
                        <div class="rounded-3xl border border-pink-100 bg-gradient-to-br from-pink-50 via-white to-rose-50 p-6 shadow-sm">
                            <h3 class="text-base font-bold text-gray-900 mb-3">Informasi Kuota Mentoring</h3>
                            <div class="space-y-2.5 text-xs">
                                <div class="flex justify-between items-center text-gray-600">
                                    <span>Kelas:</span>
                                    <span class="font-bold text-gray-900 text-right line-clamp-1 max-w-[150px]">{{ $availableMentoringEntitlement->course->name ?? '-' }}</span>
                                </div>
                                <div class="flex justify-between items-center text-gray-600">
                                    <span>Total Hak Sesi:</span>
                                    <span class="font-bold text-gray-900">{{ $availableMentoringEntitlement->total_quota }}x Sesi</span>
                                </div>
                                <div class="flex justify-between items-center text-gray-600">
                                    <span>Sisa Sesi Tersedia:</span>
                                    <span class="font-bold text-pink-600 text-sm">{{ $availableMentoringEntitlement->total_quota - $availableMentoringEntitlement->used_quota }}x Sesi</span>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Riwayat Sesi Card -->
                    <div class="rounded-3xl border border-pink-100 bg-white p-6 shadow-sm">
                        <h3 class="text-base font-bold text-gray-900 mb-4">Riwayat Mentoring</h3>
                        <div class="space-y-3">
                            @forelse($mentoringHistory as $booking)
                                <div class="rounded-2xl border border-gray-100 bg-gray-50/70 p-3.5">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <p class="text-xs font-bold text-gray-900">{{ $booking->mentor->name ?? '-' }}</p>
                                            <p class="text-[11px] text-gray-500 mt-0.5">{{ $booking->starts_at?->format('d M Y, H:i') }} WIB</p>
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
                title: 'Batalkan Permohonan?',
                text: 'Permohonan bimbingan ke mentor ini akan dibatalkan dan kuota Anda dapat digunakan untuk mentor lain.',
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
                timer: 4000,
                customClass: { popup: 'rounded-3xl font-sans' }
            });
        @endif

        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
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
