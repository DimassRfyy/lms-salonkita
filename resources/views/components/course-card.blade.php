@props([
    'course',
    'showSave' => false,
    'isSaved' => false,
    'showDelete' => false,
])

<div {{ $attributes->merge(['class' => 'group relative bg-white rounded-2xl overflow-hidden border border-pink-100/90 shadow-xs hover:shadow-xl hover:border-pink-300 hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between']) }}>
    {{-- Full card clickable link --}}
    <a href="{{ route('course', ['slug' => $course->slug]) }}"
       class="absolute inset-0 z-10 rounded-2xl focus:outline-none focus:ring-2 focus:ring-pink-500 focus:ring-offset-2"
       aria-label="Lihat kelas {{ $course->name }}"></a>

    <div>
        {{-- Thumbnail container --}}
        <div class="relative aspect-[16/10] w-full overflow-hidden bg-gray-100">
            <img src="{{ $course->thumbnail ? Storage::url($course->thumbnail) : asset('assets/images/thumbnails/img_placeholder.png') }}"
                 alt="{{ $course->name }}"
                 onerror="this.onerror=null;this.src='{{ asset('assets/images/thumbnails/img_placeholder.png') }}';"
                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 ease-out">

            {{-- Subtle dark gradient on hover for contrast --}}
            <div class="absolute inset-0 bg-gradient-to-t from-black/25 via-transparent to-black/15 opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none"></div>

            {{-- Level Badge (Top Left) --}}
            <div class="absolute top-2.5 left-2.5 z-20">
                @if($course->level === 'basic' || (int) $course->price === 0)
                    <span class="inline-flex items-center gap-1 bg-emerald-500/95 text-white text-[10px] sm:text-[11px] font-bold px-2.5 py-0.5 rounded-full shadow-xs backdrop-blur-xs">
                        <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path>
                        </svg>
                        <span>Basic</span>
                    </span>
                @elseif($course->level === 'intermediate')
                    <span class="inline-flex items-center gap-1 bg-sky-600/95 text-white text-[10px] sm:text-[11px] font-bold px-2.5 py-0.5 rounded-full shadow-xs backdrop-blur-xs">
                        <svg class="w-3 h-3 text-amber-300 fill-current" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                        <span>Intermediate</span>
                    </span>
                @elseif($course->level === 'advanced')
                    <span class="inline-flex items-center gap-1 bg-purple-600/95 text-white text-[10px] sm:text-[11px] font-bold px-2.5 py-0.5 rounded-full shadow-xs backdrop-blur-xs">
                        <svg class="w-3 h-3 text-amber-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        <span>Advanced</span>
                    </span>
                @endif
            </div>

            {{-- Rating Badge (Top Right) --}}
            <div class="absolute top-2.5 right-2.5 z-20 flex items-center gap-1 bg-white/95 backdrop-blur-xs px-2 py-0.5 rounded-full shadow-xs border border-white/50">
                <svg class="w-3.5 h-3.5 text-yellow-400 fill-current" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                </svg>
                <span class="text-[11px] sm:text-xs font-bold text-gray-800">{{ $course->rating_label }}</span>
            </div>

            {{-- Save / Bookmark Action Button (Bottom Right) --}}
            @if($showSave)
                @if($isSaved)
                    <form method="POST" action="{{ route('saved-courses.destroy', ['course' => $course->id]) }}"
                          class="absolute bottom-2.5 right-2.5 z-20 js-saved-course-form" data-saved-action="unsave"
                          data-course-name="{{ $course->name }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="p-1.5 sm:p-2 bg-white/95 backdrop-blur-xs rounded-full shadow-sm hover:bg-pink-50 text-pink-500 transition-colors cursor-pointer"
                                aria-label="Hapus {{ $course->name }} dari tersimpan">
                            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 fill-current" viewBox="0 0 24 24">
                                <path d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
                            </svg>
                        </button>
                    </form>
                @else
                    <form method="POST" action="{{ route('saved-courses.store', ['course' => $course->id]) }}"
                          class="absolute bottom-2.5 right-2.5 z-20 js-saved-course-form" data-saved-action="save"
                          data-course-name="{{ $course->name }}">
                        @csrf
                        <button type="submit"
                                class="p-1.5 sm:p-2 bg-white/95 backdrop-blur-xs rounded-full shadow-sm hover:bg-pink-50 text-gray-500 hover:text-pink-500 transition-colors cursor-pointer"
                                aria-label="Simpan {{ $course->name }} ke tersimpan">
                            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
                            </svg>
                        </button>
                    </form>
                @endif
            @endif

            {{-- Delete from Saved Action Button (Bottom Right) --}}
            @if($showDelete)
                <form method="POST" action="{{ route('saved-courses.destroy', ['course' => $course->id]) }}"
                      class="absolute bottom-2.5 right-2.5 z-20" data-delete-form data-course-title="{{ $course->name }}">
                    @csrf
                    @method('DELETE')
                    <button type="button" onclick="openDeleteModal(this)"
                            class="p-1.5 sm:p-2 bg-white/95 backdrop-blur-xs rounded-full shadow-sm hover:bg-red-50 text-gray-500 hover:text-red-500 transition-colors cursor-pointer"
                            aria-label="Hapus {{ $course->name }} dari tersimpan">
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                    </button>
                </form>
            @endif
        </div>

        {{-- Card Content --}}
        <div class="p-3.5 sm:p-4 flex-1">
            {{-- Category --}}
            <p class="text-[11px] font-bold text-pink-600 tracking-wider uppercase mb-1 truncate">
                {{ $course->category?->name ?? 'Kecantikan' }}
            </p>

            {{-- Course Title --}}
            <h3 class="text-sm sm:text-base font-bold text-gray-900 line-clamp-2 leading-snug group-hover:text-pink-600 transition-colors mb-2">
                {{ $course->name }}
            </h3>

            {{-- Meta info (Duration) --}}
            <div class="flex items-center gap-2 text-gray-500 text-xs mb-1">
                <svg class="w-3.5 h-3.5 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span class="truncate">{{ $course->duration_label }}</span>
            </div>
        </div>
    </div>

    {{-- Footer with Price & Interactive Arrow Indicator (Replacing "Lihat Detail" button) --}}
    <div class="px-3.5 pb-3.5 sm:px-4 sm:pb-4 pt-2.5 border-t border-pink-50/80 flex items-center justify-between mt-auto">
        <div class="flex flex-col">
            <span class="text-[10px] font-semibold uppercase text-gray-400 tracking-wider">Investasi</span>
            @if($course->level === 'basic' || (int) $course->price === 0)
                <span class="text-base sm:text-lg font-black text-emerald-600">Gratis</span>
            @else
                <span class="text-base sm:text-lg font-black text-pink-600">
                    Rp {{ number_format((int) $course->price, 0, ',', '.') }}
                </span>
            @endif
        </div>

        {{-- Visual Action Indicator --}}
        <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-full bg-pink-50 text-pink-600 flex items-center justify-center group-hover:bg-pink-500 group-hover:text-white group-hover:scale-105 group-hover:translate-x-0.5 transition-all duration-300 shadow-2xs">
            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path>
            </svg>
        </div>
    </div>
</div>
