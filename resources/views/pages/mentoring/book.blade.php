<x-layout>
    <x-navbar />

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-12 py-10">
        <section class="mb-8 rounded-3xl border border-pink-100 bg-white p-6 md:p-8 shadow-sm">
            <div class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
                <div>
                    <p class="inline-flex items-center rounded-full bg-pink-100 px-3 py-1 text-xs font-bold uppercase tracking-[0.2em] text-pink-700">Booking Slot</p>
                    <h1 class="mt-3 text-3xl md:text-4xl font-bold text-gray-900">Pilih tanggal dan jam mentoring</h1>
                    <p class="mt-2 text-gray-600">Pilih mentor, lalu klik slot yang masih tersedia untuk mengunci jadwal mentoring kamu.</p>
                </div>
                <a href="{{ route('mentoring.mentors') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-pink-600 hover:text-pink-700">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Kembali ke mentor
                </a>
            </div>
        </section>

        @if($errors->any())
            <div class="mb-6 rounded-2xl border border-red-100 bg-red-50 px-4 py-3 text-sm text-red-700">
                <ul class="space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
            <section class="lg:col-span-2 space-y-6">
                <div class="rounded-3xl border border-pink-100 bg-white p-6 shadow-sm">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">Pilih mentor</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @forelse($mentors as $mentor)
                            <a href="{{ route('mentoring.book', ['entitlement' => $entitlement->id, 'mentor_id' => $mentor->id, 'date' => $selectedDate]) }}"
                                class="rounded-2xl border p-5 transition {{ $selectedMentor && $selectedMentor->id === $mentor->id ? 'border-pink-300 bg-pink-50' : 'border-gray-100 bg-gray-50 hover:border-pink-200 hover:bg-pink-50' }}">
                                <div class="flex items-start justify-between gap-4">
                                    <div>
                                        <h3 class="text-lg font-bold text-gray-900">{{ $mentor->name }}</h3>
                                        <p class="mt-1 text-sm text-gray-600">{{ $mentor->job_title ?? 'Mentor Beauty' }}</p>
                                    </div>
                                    <span class="rounded-full bg-white px-3 py-1 text-xs font-semibold text-pink-600 shadow-sm">
                                        {{ (int) ($mentor->available_slots_count ?? 0) }} slot
                                    </span>
                                </div>
                            </a>
                        @empty
                            <div class="md:col-span-2 rounded-2xl border border-dashed border-gray-200 bg-gray-50 p-6 text-gray-500">
                                Tidak ada mentor yang tersedia.
                            </div>
                        @endforelse
                    </div>
                </div>

                <div class="rounded-3xl border border-pink-100 bg-white p-6 shadow-sm">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">Pilih tanggal</h2>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                        @foreach($availableDates as $dateItem)
                            <a href="{{ route('mentoring.book', ['entitlement' => $entitlement->id, 'mentor_id' => $selectedMentor?->id, 'date' => $dateItem['date_key']]) }}"
                                class="rounded-2xl border px-4 py-3 text-center transition {{ $dateItem['date_key'] === $selectedDate ? 'border-pink-300 bg-pink-50' : 'border-gray-100 bg-gray-50 hover:border-pink-200 hover:bg-pink-50' }} {{ ! $dateItem['is_available'] ? 'opacity-50' : '' }}">
                                <p class="text-sm font-semibold text-gray-900">{{ $dateItem['label'] }}</p>
                                <p class="mt-1 text-xs text-gray-500">{{ $dateItem['slots_count'] }} slot</p>
                            </a>
                        @endforeach
                    </div>
                </div>

                <div class="rounded-3xl border border-pink-100 bg-white p-6 shadow-sm">
                    <div class="flex items-center justify-between gap-4 mb-4">
                        <div>
                            <h2 class="text-xl font-bold text-gray-900">Slot tersedia</h2>
                            <p class="text-sm text-gray-500">Tanggal {{ \Carbon\Carbon::parse($selectedDate)->translatedFormat('D, d M Y') }}</p>
                        </div>
                        <span class="rounded-full bg-pink-100 px-3 py-1 text-xs font-semibold text-pink-700">{{ $availableSlots->count() }} slot</span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @forelse($availableSlots as $slot)
                            <form method="POST" action="{{ route('mentoring.store', ['entitlement' => $entitlement->id]) }}" class="rounded-2xl border border-gray-100 bg-gray-50 p-5">
                                @csrf
                                <input type="hidden" name="slot_id" value="{{ $slot->id }}">
                                <div class="flex items-start justify-between gap-4">
                                    <div>
                                        <p class="text-lg font-bold text-gray-900">{{ $slot->starts_at?->format('H:i') }} - {{ $slot->ends_at?->format('H:i') }}</p>
                                        <p class="mt-1 text-sm text-gray-600">{{ $slot->mentor->name ?? 'Mentor' }}</p>
                                    </div>
                                    <button type="submit"
                                        class="rounded-2xl bg-pink-500 px-4 py-3 text-sm font-bold text-white transition hover:bg-pink-600">
                                        Ambil Jadwal
                                    </button>
                                </div>
                            </form>
                        @empty
                            <div class="md:col-span-2 rounded-2xl border border-dashed border-gray-200 bg-gray-50 p-6 text-gray-500">
                                Slot pada tanggal ini belum tersedia.
                            </div>
                        @endforelse
                    </div>
                </div>
            </section>

            <aside class="lg:col-span-1">
                <div class="sticky top-24 rounded-3xl border border-pink-100 bg-white p-6 shadow-sm">
                    <h2 class="text-lg font-bold text-gray-900">Detail jatah</h2>
                    <div class="mt-4 space-y-4 text-sm text-gray-600">
                        <div class="rounded-2xl bg-pink-50 p-4">
                            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-pink-700">Kelas</p>
                            <p class="mt-1 font-semibold text-gray-900">{{ $entitlement->course->name ?? '-' }}</p>
                        </div>
                        <div class="rounded-2xl bg-gray-50 p-4">
                            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-gray-500">Sisa kuota</p>
                            <p class="mt-1 font-semibold text-gray-900">{{ max(0, (int) $entitlement->total_quota - (int) $entitlement->used_quota) }} sesi</p>
                        </div>
                        <div class="rounded-2xl bg-gray-50 p-4">
                            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-gray-500">Catatan</p>
                            <p class="mt-1">Setelah jadwal diambil, slot akan langsung terkunci untuk siswa lain.</p>
                        </div>
                    </div>
                </div>
            </aside>
        </div>
    </main>

    <x-footer />
</x-layout>