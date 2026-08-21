<x-layout>
    <x-navbar />
    <x-breadcrumb :url="route('mentoring.index')" label="Kembali ke Mentoring Center" />

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-12 py-10">
        <!-- Header Banner -->
        <section class="relative overflow-hidden mb-8 rounded-3xl bg-gradient-to-r from-pink-600 via-rose-500 to-amber-500 p-6 md:p-8 text-white shadow-md">
            <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <div class="max-w-2xl space-y-2">
                    <span class="inline-flex items-center gap-1.5 rounded-full bg-white/20 px-3 py-1 text-xs font-bold uppercase tracking-wider text-white backdrop-blur-xs">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        Langkah Terakhir: Pilih Waktu
                    </span>
                    <h1 class="text-2xl md:text-3xl font-extrabold tracking-tight">
                        Tentukan Jadwal Mentoring Anda
                    </h1>
                    <p class="text-xs md:text-sm text-white/90 leading-relaxed">
                        Permohonan bimbingan telah disetujui. Pilih salah satu slot waktu di bawah ini untuk mengunci jadwal sesi privat.
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

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
            <section class="lg:col-span-2 space-y-6">
                <!-- Card Mentor yang Disetujui -->
                <div class="rounded-3xl border border-emerald-100 bg-gradient-to-r from-emerald-50/50 via-white to-pink-50/30 p-6 shadow-sm">
                    <div class="flex items-start justify-between gap-4">
                        <div class="flex items-center gap-4">
                            <div class="w-16 h-16 rounded-2xl overflow-hidden bg-pink-100 flex items-center justify-center text-pink-700 font-bold text-xl shrink-0 shadow-xs border border-pink-100">
                                @if($selectedMentor->avatar)
                                    <img src="{{ $selectedMentor->avatar_url }}" alt="{{ $selectedMentor->name }}" class="w-full h-full object-cover">
                                @else
                                    {{ substr($selectedMentor->name, 0, 1) }}
                                @endif
                            </div>
                            <div>
                                <div class="flex items-center gap-2">
                                    <h3 class="text-xl font-bold text-gray-900">{{ $selectedMentor->name }}</h3>
                                    <span class="inline-flex items-center gap-1 rounded-full bg-emerald-100 px-2.5 py-0.5 text-xs font-bold text-emerald-800">
                                        <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Disetujui
                                    </span>
                                </div>
                                <p class="text-xs font-semibold text-pink-600 mt-0.5">{{ $selectedMentor->job_title ?? 'Mentor Profesional' }}</p>
                                <p class="text-xs text-gray-500 mt-0.5">Kelas: <strong class="text-gray-700">{{ $entitlement->course->name ?? '-' }}</strong></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pemilihan Tanggal -->
                <div class="rounded-3xl border border-pink-100 bg-white p-6 md:p-8 shadow-sm">
                    <h2 class="text-lg font-bold text-gray-900 mb-4">1. Pilih Tanggal</h2>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                        @foreach($availableDates as $dateItem)
                            <a href="{{ route('mentoring.book', ['entitlement' => $entitlement->id, 'date' => $dateItem['date_key']]) }}"
                                class="rounded-2xl border px-4 py-3.5 text-center transition duration-150 {{ $dateItem['date_key'] === $selectedDate ? 'border-pink-500 bg-pink-50 ring-2 ring-pink-400/20 shadow-xs' : 'border-gray-100 bg-gray-50 hover:border-pink-200 hover:bg-pink-50/50' }} {{ ! $dateItem['is_available'] ? 'opacity-40 pointer-events-none' : '' }}">
                                <p class="text-xs font-bold text-gray-900">{{ $dateItem['label'] }}</p>
                                <p class="mt-1 text-[11px] font-semibold {{ $dateItem['slots_count'] > 0 ? 'text-emerald-600' : 'text-gray-400' }}">
                                    {{ $dateItem['slots_count'] }} slot
                                </p>
                            </a>
                        @endforeach
                    </div>
                </div>

                <!-- Slot yang Tersedia -->
                <div class="rounded-3xl border border-pink-100 bg-white p-6 md:p-8 shadow-sm">
                    <div class="flex items-center justify-between gap-4 mb-5 pb-3 border-b border-gray-100">
                        <div>
                            <h2 class="text-lg font-bold text-gray-900">2. Pilih Jam Sesi</h2>
                            <p class="text-xs text-gray-500 mt-0.5">Tanggal: {{ \Carbon\Carbon::parse($selectedDate)->translatedFormat('l, d F Y') }}</p>
                        </div>
                        <span class="rounded-full bg-pink-100 px-3 py-1 text-xs font-bold text-pink-700">{{ $availableSlots->count() }} slot aktif</span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @forelse($availableSlots as $slot)
                            <div class="flex items-center justify-between rounded-2xl border border-gray-100 bg-gray-50/70 p-4 transition hover:border-pink-200 hover:bg-pink-50/30">
                                <div>
                                    <p class="text-base font-black text-gray-900">
                                        {{ $slot->starts_at?->format('H:i') }} - {{ $slot->ends_at?->format('H:i') }} WIB
                                    </p>
                                    <p class="text-[11px] text-gray-500 mt-0.5">Sesi 1-on-1 Online</p>
                                </div>
                                <button type="button"
                                    onclick="confirmSelectSlot('{{ $slot->id }}', '{{ $slot->starts_at?->translatedFormat('l, d F Y') }} pukul {{ $slot->starts_at?->format('H:i') }} - {{ $slot->ends_at?->format('H:i') }} WIB')"
                                    class="rounded-xl bg-pink-600 px-4 py-2.5 text-xs font-bold text-white shadow-xs hover:bg-pink-700 transition">
                                    Pilih Slot
                                </button>
                            </div>
                        @empty
                            <div class="sm:col-span-2 rounded-2xl border border-dashed border-gray-200 bg-gray-50/50 p-8 text-center text-gray-500">
                                <p class="text-xs font-semibold text-gray-600">Tidak ada slot jadwal yang tersedia pada tanggal ini.</p>
                                <p class="text-[11px] text-gray-400 mt-0.5">Silakan klik tanggal lain di atas untuk melihat ketersediaan jadwal mentor.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </section>

            <aside class="space-y-6">
                <!-- Ringkasan Kuota -->
                <div class="rounded-3xl border border-pink-100 bg-white p-6 shadow-sm space-y-4">
                    <h3 class="text-base font-bold text-gray-900 pb-3 border-b border-gray-100">Ringkasan Kuota</h3>
                    
                    <div class="space-y-3 text-xs">
                        <div class="flex items-center justify-between text-gray-600">
                            <span>Total Jatah:</span>
                            <span class="font-bold text-gray-900">{{ $entitlement->total_quota }}x Sesi</span>
                        </div>
                        <div class="flex items-center justify-between text-gray-600">
                            <span>Sisa Kuota:</span>
                            <span class="font-black text-pink-600 text-sm">{{ $entitlement->total_quota - $entitlement->used_quota }}x Sesi</span>
                        </div>
                        <div class="flex items-center justify-between text-gray-600">
                            <span>Kelas:</span>
                            <span class="font-bold text-gray-900 text-right line-clamp-1 max-w-[140px]">{{ $entitlement->course->name ?? '-' }}</span>
                        </div>
                    </div>

                    <div class="rounded-2xl bg-amber-50 p-4 border border-amber-100 text-xs text-amber-900 space-y-1">
                        <p class="font-bold">Informasi Sesi:</p>
                        <p class="text-[11px] text-amber-800 leading-relaxed">
                            Setelah slot dipilih, jadwal akan otomatis terkunci. Tautan Google Meet/Zoom akan disediakan mentor pada halaman Mentoring Center.
                        </p>
                    </div>
                </div>
            </aside>
        </div>
    </main>

    <!-- Hidden Form for Booking Slot -->
    <form id="bookSlotForm" method="POST" action="{{ route('mentoring.store', ['entitlement' => $entitlement->id]) }}" style="display: none;">
        @csrf
        <input type="hidden" name="slot_id" id="selectedSlotIdInput">
    </form>

    <x-footer />

    <!-- SweetAlert2 Handlers -->
    <script>
        function confirmSelectSlot(slotId, timeLabel) {
            Swal.fire({
                title: 'Konfirmasi Jadwal Mentoring',
                html: `<div class="text-left text-sm text-gray-600 space-y-2 mt-2">
                    <p>Anda akan memilih jadwal bimbingan pada:</p>
                    <div class="p-3 bg-pink-50 rounded-xl border border-pink-100 font-bold text-pink-900 text-center">
                        ${timeLabel}
                    </div>
                    <p class="text-xs text-gray-500">Pastikan Anda siap menghadiri sesi online tepat waktu.</p>
                </div>`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#db2777',
                cancelButtonColor: '#9ca3af',
                confirmButtonText: 'Ya, Kunci Jadwal',
                cancelButtonText: 'Pilih Waktu Lain',
                reverseButtons: true,
                customClass: {
                    popup: 'rounded-3xl p-6 font-sans',
                    confirmButton: 'rounded-xl px-5 py-2.5 font-bold',
                    cancelButton: 'rounded-xl px-5 py-2.5 font-bold'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('selectedSlotIdInput').value = slotId;
                    document.getElementById('bookSlotForm').submit();
                }
            });
        }

        @if($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Gagal Memilih Jadwal',
                html: '<ul class="text-left text-xs space-y-1 text-red-600">@foreach($errors->all() as $error)<li>• {{ $error }}</li>@endforeach</ul>',
                confirmButtonColor: '#db2777',
                customClass: { popup: 'rounded-3xl font-sans' }
            });
        @endif

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
    </script>
</x-layout>