<x-layout>
    <x-navbar />

    @php
        $activeEntitlementId = $availableEntitlements->first()?->id;
    @endphp

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-12 py-10">
        <section
            class="mb-10 rounded-3xl border border-pink-100 bg-linear-to-br from-pink-50 via-white to-rose-50 p-6 md:p-10 shadow-sm">
            <div class="max-w-3xl space-y-4">
                <p
                    class="inline-flex items-center rounded-full bg-pink-100 px-3 py-1 text-xs font-bold uppercase tracking-[0.2em] text-pink-700">
                    Daftar Mentor</p>
                <h1 class="text-3xl md:text-5xl font-bold text-gray-900">Pilih mentor untuk booking mentoring.</h1>
                <p class="text-base md:text-lg text-gray-600">
                    Halaman ini khusus untuk memilih mentor yang tersedia. Detail sesi dan riwayat mentoring ada di
                    halaman mentoring utama.
                </p>
            </div>
        </section>

        @if(session('success'))
            <div class="mb-6 rounded-2xl border border-emerald-100 bg-emerald-50 px-4 py-3 text-emerald-700">
                {{ session('success') }}
            </div>
        @endif

        <div class="rounded-3xl border border-pink-100 bg-white p-6 md:p-8 shadow-sm">
            <div class="mb-5 flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                <h2 class="text-xl font-bold text-gray-900">Mentor tersedia</h2>
                <a href="{{ route('mentoring.index') }}"
                    class="inline-flex items-center gap-2 text-sm font-semibold text-pink-600 hover:text-pink-700">
                    Lihat Detail Mentoring
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @forelse($mentorCards as $mentor)
                    <a href="{{ route('mentoring.book', ['entitlement' => $activeEntitlementId, 'mentor_id' => $mentor->id]) }}"
                        class="group rounded-2xl border border-gray-100 bg-gray-50 p-5 transition hover:border-pink-200 hover:bg-pink-50">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <h3 class="text-lg font-bold text-gray-900 group-hover:text-pink-700">{{ $mentor->name }}
                                </h3>
                                <p class="mt-1 text-sm text-gray-600">{{ $mentor->job_title ?? 'Mentor Beauty' }}</p>
                            </div>
                            <span class="rounded-full bg-white px-3 py-1 text-xs font-semibold text-pink-600 shadow-sm">
                                {{ (int) ($mentor->available_slots_count ?? 0) }} slot
                            </span>
                        </div>
                        <div class="mt-4 flex items-center gap-2 text-sm text-gray-500">
                            <svg class="h-4 w-4 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            Klik untuk pilih jadwal
                        </div>
                    </a>
                @empty
                    <div
                        class="md:col-span-2 rounded-2xl border border-dashed border-gray-200 bg-gray-50 p-6 text-gray-500">
                        Belum ada mentor yang aktif atau slot tersedia.
                    </div>
                @endforelse
            </div>
        </div>
    </main>

    <x-footer />
</x-layout>