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

        <!-- Course Selector Bar (if student has multiple active courses) -->
        @if(isset($availableEntitlements) && $availableEntitlements->count() > 1)
            <div class="mb-6 rounded-2xl bg-white p-4 border border-pink-100 shadow-xs flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div class="flex items-center gap-2">
                    <span class="text-xs font-bold text-gray-700">Pilih Topik Kelas:</span>
                    <span class="rounded-full bg-pink-50 border border-pink-200 px-3 py-1 text-xs font-black text-pink-700">
                        {{ $entitlement->course->name ?? 'Kelas Aktif' }}
                    </span>
                </div>
                <div class="flex flex-wrap items-center gap-2">
                    <span class="text-xs text-gray-500">Ganti kelas:</span>
                    @foreach($availableEntitlements as $avail)
                        @if($avail->id !== $entitlement->id)
                            <a href="{{ route('mentoring.book.entitlement', ['entitlement' => $avail->id]) }}"
                                class="rounded-xl border border-gray-200 bg-gray-50 px-3 py-1 text-xs font-semibold text-gray-700 hover:bg-pink-50 hover:text-pink-600 hover:border-pink-200 transition">
                                {{ $avail->course->name ?? 'Kelas Lain' }} ({{ $avail->total_quota - $avail->used_quota }}x)
                            </a>
                        @endif
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Livewire Booking Slot Picker Component -->
        <livewire:mentoring-booking-slot-picker :entitlement="$entitlement" :mentor="$selectedMentor" />
    </main>

    <x-footer />
</x-layout>