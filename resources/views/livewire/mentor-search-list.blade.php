<div class="rounded-3xl border border-pink-100 bg-white p-6 md:p-8 shadow-sm">
    <!-- Header Section -->
    <div class="mb-6 flex flex-col gap-3 md:flex-row md:items-center md:justify-between pb-5 border-b border-gray-100">
        <div>
            <div class="flex items-center gap-2.5">
                <h2 class="text-xl md:text-2xl font-black text-gray-900 tracking-tight">Daftar Mentor Tersedia</h2>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-extrabold bg-pink-100 text-pink-700">
                    {{ $mentors->total() }} Mentor
                </span>
            </div>
            <p class="text-xs text-gray-500 mt-1">Pilih mentor yang sesuai dengan preferensi, keahlian, dan jadwal yang kamu butuhkan.</p>
        </div>
        <a href="{{ route('mentoring.index') }}"
            class="inline-flex items-center gap-2 text-xs font-bold text-pink-600 hover:text-pink-700 transition">
            <span>Kembali ke Mentoring Center</span>
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </a>
    </div>

    <!-- Search & Filter Controls -->
    <div class="mb-8 space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-3.5">
            <!-- Search Input -->
            <div class="md:col-span-6 relative">
                <div class="relative">
                    <input type="search" wire:model.live.debounce.350ms="search"
                        placeholder="Cari mentor, keahlian (makeup, haircut...), kota..."
                        class="w-full rounded-2xl border border-gray-200 bg-gray-50/70 py-3 pl-11 pr-24 text-xs md:text-sm text-gray-900 transition placeholder:text-gray-400 focus:border-pink-400 focus:bg-white focus:outline-none focus:ring-4 focus:ring-pink-500/10 shadow-xs">
                    
                    <svg class="absolute left-3.5 top-1/2 h-5 w-5 -translate-y-1/2 text-gray-400 pointer-events-none" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-4.35-4.35m1.85-5.15a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>

                    @if(trim($search) !== '')
                        <button type="button" wire:click="$set('search', '')"
                            class="absolute right-3 top-1/2 -translate-y-1/2 rounded-lg bg-gray-200/70 px-2 py-1 text-[11px] font-bold text-gray-600 hover:bg-gray-300 transition">
                            Hapus
                        </button>
                    @endif
                </div>
            </div>

            <!-- Filter Lokasi / Kota -->
            <div class="md:col-span-3">
                <div class="relative">
                    <select wire:model.live="city"
                        class="w-full rounded-2xl border border-gray-200 bg-gray-50/70 py-3 pl-3.5 pr-8 text-xs md:text-sm text-gray-800 transition focus:border-pink-400 focus:bg-white focus:outline-none focus:ring-4 focus:ring-pink-500/10 shadow-xs appearance-none">
                        <option value="">Semua Lokasi / Kota</option>
                        @foreach($cities as $c)
                            <option value="{{ $c }}">{{ $c }}</option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Sort By Selector -->
            <div class="md:col-span-3">
                <div class="relative">
                    <select wire:model.live="sortBy"
                        class="w-full rounded-2xl border border-gray-200 bg-gray-50/70 py-3 pl-3.5 pr-8 text-xs md:text-sm text-gray-800 transition focus:border-pink-400 focus:bg-white focus:outline-none focus:ring-4 focus:ring-pink-500/10 shadow-xs appearance-none">
                        <option value="popular">Paling Populer (Mentees)</option>
                        <option value="slots">Slot Terbanyak</option>
                        <option value="name_asc">Nama (A - Z)</option>
                        <option value="name_desc">Nama (Z - A)</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Pills & Active State Bar -->
        <div class="flex flex-wrap items-center justify-between gap-3 pt-2">
            <div class="flex flex-wrap items-center gap-2">
                <!-- Toggle Slot Aktif -->
                <button type="button" wire:click="$toggle('hasSlots')"
                    class="inline-flex items-center gap-2 rounded-xl px-3 py-1.5 text-xs font-bold transition shadow-2xs border {{ $hasSlots ? 'bg-pink-600 text-white border-pink-600 shadow-pink-200' : 'bg-gray-100/90 text-gray-600 border-gray-200 hover:bg-gray-200/80' }}">
                    <span class="w-2 h-2 rounded-full {{ $hasSlots ? 'bg-white animate-pulse' : 'bg-gray-400' }}"></span>
                    <span>Tersedia Slot Kosong</span>
                    @if($hasSlots)
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    @endif
                </button>

                <!-- Status Filter Info Tags -->
                @if(trim($search) !== '')
                    <span class="inline-flex items-center gap-1.5 rounded-xl bg-pink-50 border border-pink-200/70 px-3 py-1.5 text-xs font-semibold text-pink-700">
                        Pencarian: "{{ $search }}"
                        <button type="button" wire:click="$set('search', '')" class="hover:text-pink-900 transition">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </span>
                @endif

                @if($city !== '')
                    <span class="inline-flex items-center gap-1.5 rounded-xl bg-pink-50 border border-pink-200/70 px-3 py-1.5 text-xs font-semibold text-pink-700">
                        Kota: {{ $city }}
                        <button type="button" wire:click="$set('city', '')" class="hover:text-pink-900 transition">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </span>
                @endif

                @if(trim($search) !== '' || $city !== '' || $hasSlots || $sortBy !== 'popular')
                    <button type="button" wire:click="resetFilters"
                        class="inline-flex items-center gap-1 text-xs font-bold text-gray-500 hover:text-pink-600 transition px-2 py-1 rounded-lg hover:bg-pink-50">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        <span>Reset Semua Filter</span>
                    </button>
                @endif
            </div>

            <!-- Loading indicator -->
            <div wire:loading class="text-xs font-bold text-pink-600 flex items-center gap-1.5">
                <svg class="animate-spin h-3.5 w-3.5 text-pink-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                </svg>
                <span>Memuat mentor...</span>
            </div>
        </div>
    </div>

    <!-- Mentor Cards Grid -->
    <div wire:loading.class="opacity-60 transition duration-200" class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @forelse($mentors as $mentor)
            <div wire:key="mentor-card-{{ $mentor->id }}"
                class="group flex flex-col justify-between rounded-3xl border border-gray-100 bg-gradient-to-b from-white to-gray-50/50 p-6 transition duration-200 hover:border-pink-200 hover:shadow-md hover:-translate-y-0.5">
                <!-- Top: Profile Biodata -->
                <div>
                    <div class="flex items-start gap-4">
                        <div
                            class="w-16 h-16 rounded-2xl overflow-hidden bg-pink-100 flex items-center justify-center text-pink-700 font-extrabold text-xl shrink-0 shadow-xs border border-pink-100 ring-2 ring-pink-50">
                            @if($mentor->avatar)
                                <img src="{{ $mentor->avatar_url }}" alt="{{ $mentor->name }}"
                                    class="w-full h-full object-cover">
                            @else
                                {{ substr($mentor->name, 0, 1) }}
                            @endif
                        </div>
                        <div class="min-w-0 flex-1">
                            <div class="flex items-center justify-between gap-2">
                                <h3 class="text-lg font-bold text-gray-900 group-hover:text-pink-600 transition truncate">
                                    {{ $mentor->name }}
                                </h3>
                                <span
                                    class="inline-flex items-center gap-1 rounded-full bg-pink-50 border border-pink-100 px-2.5 py-0.5 text-[11px] font-bold text-pink-700 shrink-0"
                                    title="Total student aktif">
                                    <svg class="w-3 h-3 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                    </svg>
                                    {{ (int) ($mentor->total_students_count ?? 0) }} student
                                </span>
                            </div>
                            <p class="text-xs font-semibold text-pink-600 mt-0.5 line-clamp-1">
                                {{ $mentor->job_title ?? 'Mentor Profesional Beauty' }}
                            </p>
                            <div class="flex flex-wrap items-center gap-2 mt-1.5">
                                @if($mentor->city)
                                    <span class="inline-flex items-center gap-1 text-[11px] font-medium text-gray-500">
                                        <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                            </path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        {{ $mentor->city }}
                                    </span>
                                @endif

                                @if(($mentor->available_slots_count ?? 0) > 0)
                                    <span class="inline-flex items-center gap-1 rounded-full bg-emerald-50 border border-emerald-100 px-2 py-0.5 text-[10px] font-bold text-emerald-700">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        {{ $mentor->available_slots_count }} slot jadwal
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 rounded-full bg-gray-100 border border-gray-200 px-2 py-0.5 text-[10px] font-medium text-gray-500">
                                        Belum ada jadwal buka
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Bio summary -->
                    @if($mentor->bio)
                        <div class="mt-4 rounded-2xl bg-gray-50/80 p-3.5 border border-gray-100 text-xs text-gray-600 leading-relaxed line-clamp-3">
                            {{ $mentor->bio }}
                        </div>
                    @else
                        <div class="mt-4 rounded-2xl bg-gray-50/50 p-3 text-xs text-gray-400 italic">
                            Mentor ahli di bidang makeup & beauty treatment di Salonkita.
                        </div>
                    @endif

                    <!-- Social / Badges -->
                    @if($mentor->instagram_url || $mentor->tiktok_url)
                        <div class="mt-3 flex items-center gap-2">
                            @if($mentor->instagram_url)
                                <a href="{{ $mentor->instagram_url }}" target="_blank" rel="noopener noreferrer"
                                    aria-label="Instagram {{ $mentor->name }}" title="Instagram"
                                    class="inline-flex items-center justify-center text-gray-400 hover:text-pink-600 transition">
                                    <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path
                                            d="M12 2.163c3.204 0 3.584.012 4.85.07 1.366.062 2.633.334 3.608 1.308.975.975 1.246 2.242 1.308 3.608.058 1.266.07 1.646.07 4.85s-.012 3.584-.07 4.85c-.062 1.366-.334 2.633-1.308 3.608-.975.975-2.242 1.246-3.608 1.308-1.266.058-1.646.07-4.85.07s-3.584-.012-4.85-.07c-1.366-.062-2.633-.334-3.608-1.308-.975-.975-1.246-2.242-1.308-3.608C2.175 15.584 2.163 15.204 2.163 12s.012-3.584.07-4.85c.062-1.366.334-2.633 1.308-3.608C4.516 2.497 5.783 2.226 7.149 2.163 8.415 2.105 8.795 2.163 12 2.163zm0-2.163C8.741 0 8.332.013 7.052.072 5.197.157 3.355.673 2.014 2.014.673 3.355.157 5.197.072 7.052.013 8.332 0 8.741 0 12c0 3.259.013 3.668.072 4.948.085 1.855.601 3.697 1.942 5.038 1.341 1.341 3.183 1.857 5.038 1.942C8.332 23.987 8.741 24 12 24c3.259 0 3.668-.013 4.948-.072 1.855-.085 3.697-.601 5.038-1.942 1.341-1.341 1.857-3.183 1.942-5.038.059-1.28.072-1.689.072-4.948 0-3.259-.013-3.668-.072-4.948-.085-1.855-.601-3.697-1.942-5.038C20.645.673 18.803.157 16.948.072 15.668.013 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zm0 10.162a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z" />
                                    </svg>
                                </a>
                            @endif
                            @if($mentor->tiktok_url)
                                <a href="{{ $mentor->tiktok_url }}" target="_blank" rel="noopener noreferrer"
                                    aria-label="TikTok {{ $mentor->name }}" title="TikTok"
                                    class="inline-flex items-center justify-center text-gray-400 hover:text-pink-600 transition">
                                    <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path
                                            d="M19.59 6.69a4.83 4.83 0 01-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 01-2.88 2.5 2.89 2.89 0 01-2.89-2.89 2.89 2.89 0 012.89-2.89c.28 0 .54.04.79.1V9.01a6.33 6.33 0 00-.79-.05 6.34 6.34 0 006.34 6.34 6.34 0 006.33-6.34V8.69a8.18 8.18 0 004.78 1.52V6.75a4.85 4.85 0 01-1.01-.06z" />
                                    </svg>
                                </a>
                            @endif
                        </div>
                    @endif
                </div>

                <!-- Action Footer -->
                <div class="mt-6 pt-4 border-t border-gray-100 flex items-center justify-between">
                    <span class="text-[11px] text-gray-500 font-medium">Bimbingan 1-on-1 Privat</span>
                    <button type="button" @click="openApplyModal({
                                        id: {{ $mentor->id }},
                                        name: '{{ addslashes($mentor->name) }}',
                                        job_title: '{{ addslashes($mentor->job_title ?? 'Mentor Profesional') }}',
                                        avatar: '{{ $mentor->avatar_url }}',
                                        city: '{{ addslashes($mentor->city ?? '') }}'
                                    })"
                        class="inline-flex items-center gap-1.5 rounded-xl bg-pink-600 px-4 py-2.5 text-xs font-bold text-white shadow-xs transition hover:bg-pink-700 hover:scale-105 transform cursor-pointer">
                        <span>Ajukan Bimbingan</span>
                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </button>
                </div>
            </div>
        @empty
            <div class="md:col-span-2 rounded-3xl border border-dashed border-gray-200 bg-gray-50/80 p-12 text-gray-500 text-center">
                <div class="w-16 h-16 mx-auto mb-3 rounded-full bg-pink-50 flex items-center justify-center text-pink-500">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <p class="font-bold text-gray-800 text-base">Tidak ada mentor yang cocok</p>
                <p class="text-xs text-gray-500 mt-1 max-w-sm mx-auto">
                    Coba sesuaikan kata kunci pencarian atau ubah pengaturan filter untuk menemukan mentor lainnya.
                </p>
                <button type="button" wire:click="resetFilters"
                    class="mt-4 inline-flex items-center gap-2 rounded-xl bg-pink-600 px-4 py-2 text-xs font-bold text-white shadow-xs hover:bg-pink-700 transition">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    <span>Reset Filter</span>
                </button>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($mentors->hasPages())
        <div class="mt-8 border-t border-gray-100 pt-6">
            {{ $mentors->links() }}
        </div>
    @endif
</div>
