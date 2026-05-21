<div class="relative w-full" x-data="{ open: false }" @click.away="open = false">
    <form wire:submit.prevent="searchCourses" class="relative">
        <input type="search" wire:model.live.debounce.300ms="search" placeholder="Cari kelas..."
            class="w-full rounded-xl border border-gray-200 bg-gray-50 py-2.5 pl-11 pr-24 text-sm text-gray-900 transition focus:border-pink-300 focus:bg-white focus:outline-none focus:ring-2 focus:ring-pink-500"
            @focus="open = true"
            @input="open = true">

        <svg class="absolute left-3.5 top-1/2 h-5 w-5 -translate-y-1/2 text-gray-400" fill="none"
            stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M21 21l-4.35-4.35m1.85-5.15a7 7 0 11-14 0 7 7 0 0114 0z"></path>
        </svg>

        <div class="absolute right-2 top-1/2 flex -translate-y-1/2 items-center gap-2">
            @if(trim($search) !== '')
                <button type="button" wire:click="$set('search', '')"
                    class="rounded-lg px-2.5 py-1.5 text-xs font-medium text-gray-500 hover:bg-gray-100 hover:text-gray-900 transition">
                    Hapus
                </button>
            @endif
            <button type="submit"
                class="rounded-lg bg-pink-500 px-3.5 py-1.5 text-xs font-semibold text-white transition hover:bg-pink-600">
                Cari
            </button>
        </div>
    </form>

    @php
        $searchTerm = trim($search);
    @endphp

    @if($searchTerm !== '' && $this->suggestions->isNotEmpty())
        <div class="absolute left-0 right-0 z-50 mt-2 overflow-hidden rounded-2xl border border-pink-100 bg-white shadow-xl">
            <div class="border-b border-pink-50 px-4 py-3 text-xs font-semibold uppercase tracking-wide text-gray-400">
                Saran kelas
            </div>
            <div class="max-h-80 overflow-y-auto">
                @foreach($this->suggestions as $course)
                    <a href="{{ route('course', ['slug' => $course->slug]) }}" wire:key="course-search-{{ $course->id }}"
                        class="flex items-center gap-3 px-4 py-3 transition hover:bg-pink-50">
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-pink-100 text-pink-600">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8V7m0 1V5m0 12v-2m0 2v2"></path>
                            </svg>
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="truncate text-sm font-semibold text-gray-900">{{ $course->name }}</p>
                            <p class="text-xs text-gray-500">Buka detail kelas</p>
                        </div>
                    </a>
                @endforeach
            </div>
            <div class="border-t border-pink-50 px-4 py-3">
                <button type="button" wire:click="searchCourses"
                    class="text-sm font-semibold text-pink-600 hover:text-pink-700">
                    Lihat semua hasil untuk "{{ $searchTerm }}"
                </button>
            </div>
        </div>
    @elseif($searchTerm !== '' && mb_strlen($searchTerm) >= 2)
        <div class="absolute left-0 right-0 z-50 mt-2 rounded-2xl border border-pink-100 bg-white px-4 py-4 text-sm text-gray-600 shadow-xl">
            Tidak ada kelas yang cocok dengan "{{ $searchTerm }}".
        </div>
    @endif
</div>