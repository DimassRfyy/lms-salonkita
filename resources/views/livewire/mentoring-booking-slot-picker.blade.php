<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
    <section class="lg:col-span-2 space-y-6">
        <!-- Error Alert -->
        @if ($errorMessage)
            <div class="rounded-2xl border border-red-200 bg-red-50 p-4 text-sm text-red-700 flex items-start gap-3 shadow-xs">
                <svg class="w-5 h-5 text-red-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div class="flex-1">
                    <p class="font-bold text-red-800">Perhatian</p>
                    <p class="text-xs mt-0.5 text-red-700 leading-relaxed">{{ $errorMessage }}</p>
                </div>
            </div>
        @endif

        <!-- Card Mentor yang Disetujui -->
        <div class="rounded-3xl border border-emerald-100 bg-gradient-to-r from-emerald-50/50 via-white to-pink-50/30 p-6 shadow-sm">
            <div class="flex items-start justify-between gap-4">
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 rounded-2xl overflow-hidden bg-pink-100 flex items-center justify-center text-pink-700 font-bold text-xl shrink-0 shadow-xs border border-pink-100">
                        @if($mentor->avatar)
                            <img src="{{ $mentor->avatar_url }}" alt="{{ $mentor->name }}" class="w-full h-full object-cover">
                        @else
                            {{ substr($mentor->name, 0, 1) }}
                        @endif
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <h3 class="text-xl font-bold text-gray-900">{{ $mentor->name }}</h3>
                            <span class="inline-flex items-center gap-1 rounded-full bg-emerald-100 px-2.5 py-0.5 text-xs font-bold text-emerald-800">
                                <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Disetujui
                            </span>
                        </div>
                        <p class="text-xs font-semibold text-pink-600 mt-0.5">{{ $mentor->job_title ?? 'Mentor Profesional' }}</p>
                        <p class="text-xs text-gray-500 mt-0.5">Kelas: <strong class="text-gray-700">{{ $entitlement->course->name ?? '-' }}</strong></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pemilihan Tanggal (Semua Jadwal Tersedia) -->
        <div class="rounded-3xl border border-pink-100 bg-white p-6 md:p-8 shadow-sm">
            <div class="flex items-center justify-between gap-4 mb-4 pb-2 border-b border-gray-100">
                <div>
                    <h2 class="text-lg font-bold text-gray-900">1. Pilih Tanggal</h2>
                    <p class="text-xs text-gray-500 mt-0.5">Pilih tanggal di bawah ini untuk melihat jam yang tersedia.</p>
                </div>
                <span class="rounded-full bg-pink-50 border border-pink-200 px-3 py-1 text-xs font-bold text-pink-700">
                    Total {{ $totalAvailableSlots }} slot aktif
                </span>
            </div>

            @if($availableDates->isNotEmpty())
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3 max-h-[340px] overflow-y-auto pr-1">
                    @foreach($availableDates as $dateItem)
                        <button type="button"
                            wire:key="date-btn-{{ $dateItem['date_key'] }}"
                            wire:click="selectDate('{{ $dateItem['date_key'] }}')"
                            class="rounded-2xl border px-4 py-3.5 text-center transition duration-150 relative cursor-pointer {{ $dateItem['is_active'] ? 'border-pink-500 bg-pink-50 ring-2 ring-pink-400/30 shadow-xs' : 'border-gray-100 bg-gray-50/70 hover:border-pink-200 hover:bg-pink-50/40' }}">
                            <p class="text-xs font-bold {{ $dateItem['is_active'] ? 'text-pink-900' : 'text-gray-900' }}">
                                {{ $dateItem['day_name'] }}, {{ $dateItem['day_number'] }} {{ $dateItem['month_name'] }}
                            </p>
                            <p class="mt-1 text-[11px] font-semibold {{ $dateItem['is_active'] ? 'text-pink-700' : 'text-emerald-600' }}">
                                {{ $dateItem['slots_count'] }} slot tersedia
                            </p>
                        </button>
                    @endforeach
                </div>
            @else
                <div class="rounded-2xl border border-dashed border-gray-200 bg-gray-50/50 p-8 text-center text-gray-500">
                    <p class="text-xs font-semibold text-gray-600">Mentor belum membuka slot jadwal bimbingan aktif.</p>
                    <p class="text-[11px] text-gray-400 mt-0.5">Silakan cek kembali secara berkala atau hubungi pihak admin.</p>
                </div>
            @endif
        </div>

        <!-- Slot yang Tersedia -->
        <div class="rounded-3xl border border-pink-100 bg-white p-6 md:p-8 shadow-sm relative">
            {{-- Loading overlay --}}
            <div wire:loading.flex wire:target="selectDate" class="absolute inset-0 bg-white/70 backdrop-blur-xs rounded-3xl z-10 items-center justify-center">
                <div class="flex items-center gap-2.5 px-4 py-2 bg-pink-600 text-white rounded-full text-xs font-bold shadow-md">
                    <svg class="animate-spin h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span>Memuat jam sesi...</span>
                </div>
            </div>

            <div class="flex items-center justify-between gap-4 mb-5 pb-3 border-b border-gray-100">
                <div>
                    <h2 class="text-lg font-bold text-gray-900">2. Pilih Jam Sesi</h2>
                    <p class="text-xs text-gray-500 mt-0.5">
                        Tanggal: <strong class="text-pink-600">{{ \Carbon\Carbon::parse($selectedDate)->translatedFormat('l, d F Y') }}</strong>
                    </p>
                </div>
                <span class="rounded-full bg-pink-100 px-3 py-1 text-xs font-bold text-pink-700">
                    {{ $slots->count() }} sesi tersedia
                </span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                @forelse($slots as $slot)
                    <div wire:key="slot-card-{{ $slot->id }}"
                        class="flex items-center justify-between rounded-2xl border border-gray-100 bg-gray-50/70 p-4 transition hover:border-pink-200 hover:bg-pink-50/30">
                        <div>
                            <p class="text-base font-black text-gray-900">
                                {{ $slot->starts_at?->format('H:i') }} - {{ $slot->ends_at?->format('H:i') }} WIB
                            </p>
                            <p class="text-[11px] text-gray-500 mt-0.5">Sesi 1-on-1 Online</p>
                        </div>
                        <button type="button"
                            wire:click="confirmSlot({{ $slot->id }})"
                            class="rounded-xl bg-pink-600 px-4 py-2.5 text-xs font-bold text-white shadow-xs hover:bg-pink-700 transition cursor-pointer">
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

    <!-- Sidebar Info Kuota -->
    <aside class="space-y-6">
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

    <!-- Livewire Confirmation Modal -->
    @if($showConfirmModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-900/60 backdrop-blur-xs">
            <div class="bg-white rounded-3xl max-w-md w-full p-6 shadow-2xl border border-pink-100 space-y-5 animate-in fade-in zoom-in-95 duration-150">
                <div class="flex items-center gap-3 pb-3 border-b border-gray-100">
                    <div class="w-10 h-10 rounded-2xl bg-pink-100 text-pink-600 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-base font-bold text-gray-900">Konfirmasi Jadwal Mentoring</h4>
                        <p class="text-xs text-gray-500">Pastikan waktu sesuai dengan ketersediaan Anda.</p>
                    </div>
                </div>

                <div class="space-y-2 text-sm text-gray-600">
                    <p class="text-xs text-gray-500">Anda akan mengunci sesi bimbingan pada:</p>
                    <div class="p-3.5 bg-gradient-to-r from-pink-50 to-rose-50 rounded-2xl border border-pink-100 font-bold text-pink-900 text-center text-sm">
                        {{ $selectedSlotLabel }}
                    </div>
                    <p class="text-[11px] text-gray-400 text-center">Mentor: <strong>{{ $mentor->name }}</strong> (1 Kuota akan digunakan)</p>
                </div>

                <div class="flex items-center gap-3 pt-2">
                    <button type="button"
                        wire:click="closeModal"
                        class="flex-1 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold text-xs rounded-xl transition cursor-pointer">
                        Pilih Waktu Lain
                    </button>
                    <button type="button"
                        wire:click="executeBooking"
                        wire:loading.attr="disabled"
                        class="flex-1 py-3 bg-pink-600 hover:bg-pink-700 text-white font-bold text-xs rounded-xl transition shadow-md shadow-pink-600/20 flex items-center justify-center gap-2 cursor-pointer">
                        <span wire:loading.remove wire:target="executeBooking">Ya, Kunci Jadwal</span>
                        <span wire:loading wire:target="executeBooking" class="flex items-center gap-1.5">
                            <svg class="animate-spin h-3.5 w-3.5 text-white" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span>Mengunci...</span>
                        </span>
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
