<x-layout>
    <x-navbar />

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-12 py-10">
        @if(session('success'))
            <div class="mb-6 rounded-2xl border border-emerald-100 bg-emerald-50 px-4 py-3 text-emerald-700">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 rounded-2xl border border-red-100 bg-red-50 px-4 py-3 text-red-700">
                {{ session('error') }}
            </div>
        @endif

        <section class="mb-8 rounded-3xl border border-pink-100 bg-gradient-to-r from-pink-500 via-rose-500 to-orange-400 p-6 text-white shadow-lg md:p-8">
            <div class="flex flex-col gap-6 md:flex-row md:items-center md:justify-between">
                <div class="max-w-2xl space-y-3">
                    <span class="inline-flex items-center rounded-full bg-white/20 px-3 py-1 text-xs font-semibold uppercase tracking-[0.2em]">Mentoring Center</span>
                    <h1 class="text-2xl font-bold md:text-4xl">Detail mentoring dan riwayat sesi kamu.</h1>
                    <p class="text-sm text-white/90 md:text-base">
                        Pantau jadwal, platform meeting, link, dan catatan mentor dalam satu halaman.
                    </p>
                </div>
                @if($availableMentoringEntitlement)
                    <a href="{{ route('mentoring.mentors') }}"
                        class="inline-flex items-center justify-center gap-2 rounded-2xl bg-white px-5 py-3 font-bold text-pink-600 shadow-sm transition hover:bg-pink-50">
                        Lihat Daftar Mentor
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                @endif
            </div>
        </section>

        @if(! $hasMentoringAccess)
            <section class="rounded-3xl border border-gray-200 bg-white p-8 text-center shadow-sm">
                <h2 class="text-2xl font-bold text-gray-900">Belum ada akses mentoring</h2>
                <p class="mt-2 text-gray-600">Beli kelas untuk mendapatkan jatah mentoring, lalu jadwalkan sesi bersama mentor.</p>
            </section>
        @else
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
                <section class="lg:col-span-2 rounded-2xl border border-pink-100 bg-white p-5 shadow-sm">
                    <div class="flex items-start justify-between gap-4 mb-4">
                        <div>
                            <h2 class="text-lg font-bold text-gray-900">Detail Mentoring Terbaru</h2>
                            <p class="text-sm text-gray-500">Sesi yang paling terakhir kamu booking.</p>
                        </div>
                    </div>

                    @if($latestMentoringBooking)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-sm">
                            <div class="rounded-xl bg-gray-50 p-4 border border-gray-100">
                                <p class="text-gray-500">Mentor</p>
                                <p class="font-semibold text-gray-900 mt-1">{{ $latestMentoringBooking->mentor->name ?? '-' }}</p>
                            </div>
                            <div class="rounded-xl bg-gray-50 p-4 border border-gray-100">
                                <p class="text-gray-500">Kelas</p>
                                <p class="font-semibold text-gray-900 mt-1">{{ $latestMentoringBooking->course->name ?? '-' }}</p>
                            </div>
                            <div class="rounded-xl bg-gray-50 p-4 border border-gray-100">
                                <p class="text-gray-500">Jadwal</p>
                                <p class="font-semibold text-gray-900 mt-1">{{ $latestMentoringBooking->starts_at?->format('d M Y, H:i') }} - {{ $latestMentoringBooking->ends_at?->format('H:i') }}</p>
                            </div>
                            <div class="rounded-xl bg-gray-50 p-4 border border-gray-100">
                                <p class="text-gray-500">Status</p>
                                <p class="font-semibold text-gray-900 mt-1">{{ ucfirst(str_replace('_', ' ', (string) $latestMentoringBooking->status)) }}</p>
                            </div>
                        </div>

                        <div class="mt-3 grid grid-cols-1 md:grid-cols-2 gap-3 text-sm">
                            <div class="rounded-xl bg-gray-50 p-4 border border-gray-100">
                                <p class="text-gray-500">Platform</p>
                                <p class="font-semibold text-gray-900 mt-1">{{ $latestMentoringBooking->meeting_platform ? ucfirst(str_replace('_', ' ', $latestMentoringBooking->meeting_platform)) : 'Belum ditentukan' }}</p>
                            </div>
                            <div class="rounded-xl bg-gray-50 p-4 border border-gray-100">
                                <p class="text-gray-500">Meeting Link</p>
                                @if($latestMentoringBooking->meeting_url)
                                    <a href="{{ $latestMentoringBooking->meeting_url }}" target="_blank" rel="noopener noreferrer" class="mt-1 inline-flex items-center gap-1 font-semibold text-pink-600 hover:text-pink-700">
                                        Buka Link Meeting
                                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 3h7m0 0v7m0-7L10 14" />
                                        </svg>
                                    </a>
                                @else
                                    <p class="font-semibold text-gray-900 mt-1">Belum ada link meeting</p>
                                @endif
                            </div>
                        </div>

                        <div class="mt-3 rounded-xl bg-gray-50 p-4 border border-gray-100 text-sm">
                            <p class="text-gray-500">Catatan Mentor</p>
                            <p class="mt-1 text-gray-900">{{ $latestMentoringBooking->notes ?: 'Belum ada catatan dari mentor.' }}</p>
                        </div>
                    @else
                        <div class="rounded-xl border border-dashed border-gray-200 bg-gray-50 p-4 text-sm text-gray-500">
                            Belum ada jadwal mentoring yang diambil.
                        </div>
                    @endif
                </section>

                <aside class="rounded-2xl border border-pink-100 bg-white p-5 shadow-sm">
                    <h2 class="text-lg font-bold text-gray-900 mb-4">Riwayat Mentoring</h2>
                    <div class="space-y-3">
                        @forelse($mentoringHistory as $booking)
                            <div class="rounded-xl border border-gray-100 bg-gray-50 p-3">
                                <p class="text-sm font-semibold text-gray-900">{{ $booking->mentor->name ?? '-' }}</p>
                                <p class="text-xs text-gray-500 mt-1">{{ $booking->starts_at?->format('d M Y, H:i') }}</p>
                                <p class="text-xs mt-1 text-pink-700 font-semibold">{{ ucfirst(str_replace('_', ' ', (string) $booking->status)) }}</p>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500">Belum ada riwayat mentoring.</p>
                        @endforelse
                    </div>
                </aside>
            </div>
        @endif
    </main>

    <x-footer />
</x-layout>
