<x-layout>
    @push('styles')
        <style>
            .text-primary {
                color: #ec4899;
            }

            .bg-primary {
                background-color: #ec4899;
            }

            .border-primary {
                border-color: #ec4899;
            }

            .hover-primary:hover {
                background-color: #db2777;
            }

            .dropdown-content {
                display: none;
                padding: 0.55rem;
                background: linear-gradient(180deg, #fff7fb 0%, #fff1f7 100%);
                border-top: 1px solid #fbcfe8;
            }

            .dropdown-content.active {
                display: block;
            }

            .tab-content {
                display: none;
            }

            .tab-content.active {
                display: block;
            }

            .btn-tab {
                transition: all 0.3s ease;
            }

            .btn-tab.active {
                border-bottom: 3px solid #ec4899;
                color: #ec4899;
            }

            .task-rich-text {
                font-size: 0.875rem;
                line-height: 1.625;
                color: #374151;
            }

            .task-rich-text p {
                margin-bottom: 0.75rem;
            }

            .task-rich-text p:last-child {
                margin-bottom: 0;
            }

            .task-rich-text ul {
                list-style-type: disc;
                margin-left: 1.25rem;
                margin-bottom: 0.75rem;
            }

            .task-rich-text ol {
                list-style-type: decimal;
                margin-left: 1.25rem;
                margin-bottom: 0.75rem;
            }

            .task-rich-text li {
                margin-bottom: 0.25rem;
            }

            .task-rich-text h1,
            .task-rich-text h2,
            .task-rich-text h3,
            .task-rich-text h4 {
                font-weight: 700;
                color: #111827;
                margin-top: 1rem;
                margin-bottom: 0.5rem;
            }

            .task-rich-text h1 { font-size: 1.25rem; }
            .task-rich-text h2 { font-size: 1.125rem; }
            .task-rich-text h3 { font-size: 1rem; }

            .task-rich-text a {
                color: #db2777;
                text-decoration: underline;
            }

            .task-rich-text blockquote {
                border-left: 3px solid #ec4899;
                padding-left: 0.75rem;
                font-style: italic;
                color: #4b5563;
                margin-bottom: 0.75rem;
            }

            .task-rich-text code {
                background-color: #f3f4f6;
                padding: 0.15rem 0.35rem;
                border-radius: 0.25rem;
                font-size: 0.8em;
                color: #be185d;
            }

            .video-placeholder {
                background: linear-gradient(135deg, #fce7f3 0%, #fbcfe8 100%);
            }

            .presentation-placeholder {
                background: linear-gradient(135deg, #ffffff 0%, #fff7fb 100%);
            }

            .video-item {
                display: flex;
                align-items: center;
                gap: 0.5rem;
                padding: 0.65rem 0.85rem;
                margin: 0.4rem;
                border-radius: 0.75rem;
                border: 1px solid transparent;
                background: #ffffff;
                text-decoration: none;
                transition: all 0.2s ease;
            }

            .video-item:hover {
                background-color: #fdf2f8;
                border-color: #fbcfe8;
                transform: translateY(-1px);
            }

            .video-item.watched {
                color: #6b7280;
            }

            .video-item.watched .video-icon {
                color: #10b981;
            }

            .video-item.unwatched {
                color: #374151;
            }

            .video-item.unwatched .video-icon {
                color: #f472b6;
            }

            .video-item.now-playing {
                background: linear-gradient(90deg, #fdf2f8 0%, #fce7f3 100%);
                border: 1px solid #f9a8d4;
                box-shadow: 0 6px 14px rgba(236, 72, 153, 0.12);
                color: #be185d;
                font-weight: 600;
            }

            .video-item.now-playing .video-icon {
                color: #ec4899;
            }

            .video-item .video-title {
                flex: 1;
                font-size: 0.875rem;
                line-height: 1.25rem;
            }

            .video-item .video-duration {
                font-size: 0.75rem;
                color: #9ca3af;
                white-space: nowrap;
                flex-shrink: 0;
                padding: 0.15rem 0.45rem;
                border-radius: 9999px;
                background: #fdf2f8;
            }

            .video-item.now-playing .video-duration {
                color: #be185d;
                background: #fbcfe8;
            }

            .video-item.presentation-item {
                background: linear-gradient(90deg, #fdf2f8 0%, #fce7f3 100%);
                border: 1px solid #f9a8d4;
                box-shadow: 0 6px 14px rgba(236, 72, 153, 0.12);
                color: #be185d;
                font-weight: 600;
            }

            .video-item.presentation-item .video-icon {
                color: #ec4899;
            }

            .video-item.presentation-item .video-duration {
                color: #be185d;
                background: #fbcfe8;
            }

            .video-item.locked {
                color: #9ca3af;
                background-color: #fdf4f7;
                border-color: #fce7f3;
                cursor: not-allowed;
            }

            .video-item.locked .video-icon {
                color: #9ca3af;
            }

            .section-header {
                width: 100%;
                padding: 0.9rem 1rem;
                display: flex;
                justify-content: space-between;
                align-items: center;
                background: linear-gradient(135deg, #ffffff 0%, #fff1f7 100%);
                transition: all 0.2s ease;
            }

            .section-header:hover {
                background: linear-gradient(135deg, #fdf2f8 0%, #fce7f3 100%);
            }

            .section-header .section-info {
                display: flex;
                flex-direction: column;
                align-items: flex-start;
                gap: 0.1rem;
            }

            .section-header .section-count {
                font-size: 0.7rem;
                color: #be185d;
                font-weight: 600;
                background: #fce7f3;
                border: 1px solid #fbcfe8;
                padding: 0.1rem 0.5rem;
                border-radius: 9999px;
                margin-top: 0.2rem;
            }

            .quiz-modal-backdrop {
                position: fixed;
                inset: 0;
                background: rgba(17, 24, 39, 0.55);
                display: none;
                align-items: center;
                justify-content: center;
                z-index: 60;
                padding: 1rem;
            }

            .quiz-modal-backdrop.active {
                display: flex;
            }

            .quiz-modal-card {
                width: 100%;
                max-width: 42rem;
                max-height: 90vh;
                overflow-y: auto;
                background: #ffffff;
                border-radius: 1rem;
                border: 1px solid #fbcfe8;
                box-shadow: 0 20px 40px rgba(15, 23, 42, 0.2);
            }
        </style>
    @endpush

    <x-navbar />

    <x-breadcrumb />

    <div class="bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2">
                    @php
                        $showPresentation = $hasCourseAccess && filled($presentationEmbedUrl) && request()->boolean('presentation');
                    @endphp

                    <div class="mb-3 text-sm text-pink-700 bg-pink-50 border border-pink-100 rounded-lg px-4 py-2">
                        Sedang diputar: <span
                            class="font-semibold">{{ $showPresentation ? 'Materi Pembelajaran (PDF / Slide)' : $activeVideoTitle }}</span>
                    </div>

                    <div id="video-container" class="video-placeholder rounded-xl overflow-hidden mb-6 select-none relative" oncontextmenu="return false;">
                        <div class="relative w-full" style="padding-bottom: 56.25%;">
                            @if($showPresentation)
                                <iframe class="absolute inset-0 w-full h-full"
                                    src="{{ $presentationEmbedUrl }}"
                                    title="Materi Pembelajaran {{ $course->name }}"
                                    frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share; fullscreen"
                                    referrerpolicy="strict-origin-when-cross-origin" allowfullscreen>
                                </iframe>
                                {{-- Overlay transparan untuk memblokir tombol 'Lepas / Pop-out' Google Drive di pojok kanan atas --}}
                                <div class="absolute top-0 right-0 w-16 h-14 z-20 cursor-default bg-transparent" onclick="event.preventDefault(); event.stopPropagation();"></div>
                            @elseif($embedUrl)
                                <iframe class="absolute inset-0 w-full h-full"
                                    src="{{ $embedUrl }}"
                                    title="{{ $currentVideo?->title ?? $course->name }}"
                                    frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share; fullscreen"
                                    referrerpolicy="strict-origin-when-cross-origin" allowfullscreen>
                                </iframe>
                            @else
                                <img class="absolute inset-0 w-full h-full object-cover"
                                    src="{{ $course->thumbnail ? Storage::url($course->thumbnail) : asset('assets/images/thumbnails/img_placeholder.png') }}"
                                    alt="Thumbnail {{ $course->name }}"
                                    onerror="this.onerror=null;this.src='{{ asset('assets/images/thumbnails/img_placeholder.png') }}';">
                            @endif
                        </div>
                    </div>

                    @if($hasCourseAccess)
                        <div class="bg-white rounded-xl p-4 md:p-6 mb-6">
                            <h2 class="text-sm md:text-base font-bold text-gray-900 mb-3 md:mb-5">Progress Penyelesaian
                                Kelas</h2>

                            @php
                                $allVideosWatched = $totalVideosCount > 0 && $watchedVideosCount >= $totalVideosCount;
                                $hasSubmission = !is_null($taskSubmission);
                                $isPending = $hasSubmission && $taskSubmission->isPending();
                                $isReviewed = $hasSubmission && $taskSubmission->isReviewed();

                                $steps = [
                                    [
                                        'label' => 'Tonton Video',
                                        'sublabel' => $allVideosWatched ? ($totalVideosCount . '/' . $totalVideosCount . ' video') : ($watchedVideosCount . '/' . $totalVideosCount . ' video'),
                                        'done' => $allVideosWatched,
                                        'active' => !$allVideosWatched,
                                        'action' => 'scrollToVideo()',
                                        'icon_done' => '<path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>',
                                        'icon_todo' => '<path d="M8 5v14l11-7z"/>',
                                    ],
                                    [
                                        'label' => 'Submit Tugas',
                                        'sublabel' => $hasSubmission ? 'Tugas terkirim' : 'Belum di-submit',
                                        'done' => $hasSubmission,
                                        'active' => $allVideosWatched && !$hasSubmission,
                                        'action' => 'goToTaskTab()',
                                        'icon_done' => '<path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>',
                                        'icon_todo' => '<path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>',
                                    ],
                                    [
                                        'label' => 'Di Review',
                                        'sublabel' => $isReviewed ? 'Review selesai' : ($isPending ? 'Sedang direview' : 'Menunggu submit'),
                                        'done' => $isReviewed,
                                        'active' => $isPending,
                                        'action' => 'goToTaskTab()',
                                        'icon_done' => '<path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>',
                                        'icon_todo' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>',
                                    ],
                                    [
                                        'label' => 'Selesai Direview',
                                        'sublabel' => $isReviewed ? (is_null($taskSubmission->score) ? 'Sudah dinilai' : 'Nilai: ' . $taskSubmission->score . '/100') : 'Belum direview',
                                        'done' => $isReviewed,
                                        'active' => false,
                                        'action' => 'goToTaskTab()',
                                        'icon_done' => '<path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>',
                                        'icon_todo' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>',
                                    ],
                                    [
                                        'label' => 'Dapatkan Sertifikat',
                                        'sublabel' => $isReviewed ? 'Klik untuk klaim' : 'Selesaikan review dulu',
                                        'done' => false,
                                        'active' => $isReviewed,
                                        'url' => $isReviewed ? route('claim-certificate', ['slug' => $course->slug]) : null,
                                        'action' => !$isReviewed ? 'goToTaskTab()' : null,
                                        'icon_done' => '',
                                        'icon_todo' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>',
                                    ],
                                ];
                            @endphp

                            <!-- Mobile Version (< md) -->
                            <div class="md:hidden grid grid-cols-3 gap-2">
                                @foreach ($steps as $i => $step)
                                    @php
                                        $useFilledIcon = $step['done'];
                                        $circleClass = $step['done']
                                            ? 'bg-emerald-500 border-emerald-500 text-white'
                                            : ($step['active'] ? 'bg-pink-500 border-pink-500 text-white' : 'bg-white border-gray-300 text-gray-400');
                                        $labelClass = $step['done']
                                            ? 'text-emerald-600 font-semibold'
                                            : ($step['active'] ? 'text-pink-600 font-semibold' : 'text-gray-400');
                                        $hasUrl = !empty($step['url']);
                                        $hasAction = !empty($step['action']);
                                    @endphp
                                    @if ($hasUrl)
                                        <a href="{{ $step['url'] }}" title="{{ $step['label'] }}"
                                            class="flex flex-col items-center group cursor-pointer transition hover:opacity-90">
                                            <div class="w-8 h-8 rounded-full border-2 flex items-center justify-center shrink-0 transition group-hover:scale-110 {{ $circleClass }}">
                                                <svg class="w-3.5 h-3.5" fill="{{ $useFilledIcon ? 'currentColor' : 'none' }}"
                                                    stroke="{{ $useFilledIcon ? 'none' : 'currentColor' }}" viewBox="0 0 24 24">
                                                    {!! $useFilledIcon ? $step['icon_done'] : $step['icon_todo'] !!}
                                                </svg>
                                            </div>
                                            <p class="mt-1.5 text-center text-[11px] leading-tight group-hover:underline {{ $labelClass }}">
                                                {{ $step['label'] }}
                                            </p>
                                        </a>
                                    @elseif ($hasAction)
                                        <button type="button" onclick="{{ $step['action'] }}" title="{{ $step['label'] }}"
                                            class="flex flex-col items-center group cursor-pointer transition hover:opacity-90">
                                            <div class="w-8 h-8 rounded-full border-2 flex items-center justify-center shrink-0 transition group-hover:scale-110 {{ $circleClass }}">
                                                <svg class="w-3.5 h-3.5" fill="{{ $useFilledIcon ? 'currentColor' : 'none' }}"
                                                    stroke="{{ $useFilledIcon ? 'none' : 'currentColor' }}" viewBox="0 0 24 24">
                                                    {!! $useFilledIcon ? $step['icon_done'] : $step['icon_todo'] !!}
                                                </svg>
                                            </div>
                                            <p class="mt-1.5 text-center text-[11px] leading-tight group-hover:underline {{ $labelClass }}">
                                                {{ $step['label'] }}
                                            </p>
                                        </button>
                                    @else
                                        <div class="flex flex-col items-center">
                                            <div
                                                class="w-8 h-8 rounded-full border-2 flex items-center justify-center shrink-0 {{ $circleClass }}">
                                                <svg class="w-3.5 h-3.5" fill="{{ $useFilledIcon ? 'currentColor' : 'none' }}"
                                                    stroke="{{ $useFilledIcon ? 'none' : 'currentColor' }}" viewBox="0 0 24 24">
                                                    {!! $useFilledIcon ? $step['icon_done'] : $step['icon_todo'] !!}
                                                </svg>
                                            </div>
                                            <p class="mt-1.5 text-center text-[11px] leading-tight {{ $labelClass }}">
                                                {{ $step['label'] }}
                                            </p>
                                        </div>
                                    @endif
                                @endforeach
                            </div>

                            <!-- Desktop Version (>= md) -->
                            <div class="hidden md:flex items-start gap-0">
                                @foreach ($steps as $i => $step)
                                    @php
                                        $isLast = $i === count($steps) - 1;
                                        $useFilledIcon = $step['done'];
                                        $circleClass = $step['done']
                                            ? 'bg-emerald-500 border-emerald-500 text-white'
                                            : ($step['active'] ? 'bg-pink-500 border-pink-500 text-white' : 'bg-white border-gray-300 text-gray-400');
                                        $labelClass = $step['done']
                                            ? 'text-emerald-600 font-semibold'
                                            : ($step['active'] ? 'text-pink-600 font-semibold' : 'text-gray-400');
                                        $subClass = $step['done']
                                            ? 'text-emerald-500'
                                            : ($step['active'] ? 'text-pink-400' : 'text-gray-400');
                                        $lineClass = $step['done'] ? 'bg-emerald-400' : 'bg-gray-200';
                                        $hasUrl = !empty($step['url']);
                                        $hasAction = !empty($step['action']);
                                    @endphp

                                    <div class="flex flex-col items-center {{ $isLast ? '' : 'flex-1' }}">
                                        @if ($hasUrl)
                                            <a href="{{ $step['url'] }}" title="{{ $step['label'] }}"
                                                class="flex flex-col items-center group cursor-pointer transition hover:opacity-90 w-full">
                                                <div class="w-9 h-9 rounded-full border-2 flex items-center justify-center shrink-0 transition group-hover:scale-110 {{ $circleClass }}">
                                                    <svg class="w-4 h-4" fill="{{ $useFilledIcon ? 'currentColor' : 'none' }}"
                                                        stroke="{{ $useFilledIcon ? 'none' : 'currentColor' }}" viewBox="0 0 24 24">
                                                        {!! $useFilledIcon ? $step['icon_done'] : $step['icon_todo'] !!}
                                                    </svg>
                                                </div>
                                                <p class="mt-1.5 text-center text-xs leading-tight group-hover:underline {{ $labelClass }}">
                                                    {{ $step['label'] }}
                                                </p>
                                                <p class="text-center text-[10px] leading-tight mt-0.5 {{ $subClass }}">
                                                    {{ $step['sublabel'] }}
                                                </p>
                                            </a>
                                        @elseif ($hasAction)
                                            <button type="button" onclick="{{ $step['action'] }}" title="{{ $step['label'] }}"
                                                class="flex flex-col items-center group cursor-pointer transition hover:opacity-90 w-full">
                                                <div class="w-9 h-9 rounded-full border-2 flex items-center justify-center shrink-0 transition group-hover:scale-110 {{ $circleClass }}">
                                                    <svg class="w-4 h-4" fill="{{ $useFilledIcon ? 'currentColor' : 'none' }}"
                                                        stroke="{{ $useFilledIcon ? 'none' : 'currentColor' }}" viewBox="0 0 24 24">
                                                        {!! $useFilledIcon ? $step['icon_done'] : $step['icon_todo'] !!}
                                                    </svg>
                                                </div>
                                                <p class="mt-1.5 text-center text-xs leading-tight group-hover:underline {{ $labelClass }}">
                                                    {{ $step['label'] }}
                                                </p>
                                                <p class="text-center text-[10px] leading-tight mt-0.5 {{ $subClass }}">
                                                    {{ $step['sublabel'] }}
                                                </p>
                                            </button>
                                        @else
                                            <div class="flex flex-col items-center w-full">
                                                <div
                                                    class="w-9 h-9 rounded-full border-2 flex items-center justify-center shrink-0 {{ $circleClass }}">
                                                    <svg class="w-4 h-4" fill="{{ $useFilledIcon ? 'currentColor' : 'none' }}"
                                                        stroke="{{ $useFilledIcon ? 'none' : 'currentColor' }}" viewBox="0 0 24 24">
                                                        {!! $useFilledIcon ? $step['icon_done'] : $step['icon_todo'] !!}
                                                    </svg>
                                                </div>
                                                <p class="mt-1.5 text-center text-xs leading-tight {{ $labelClass }}">
                                                    {{ $step['label'] }}
                                                </p>
                                                <p class="text-center text-[10px] leading-tight mt-0.5 {{ $subClass }}">
                                                    {{ $step['sublabel'] }}
                                                </p>
                                            </div>
                                        @endif
                                    </div>

                                    @if (!$isLast)
                                        <div class="flex-1 mt-4 mx-1">
                                            <div class="h-0.5 w-full {{ $lineClass }} rounded-full"></div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <div class="bg-white rounded-xl p-6 mb-6">
                        <h1 class="text-2xl lg:text-3xl font-bold text-gray-900 mb-4">{{ $course->name }}</h1>

                        <div class="flex flex-wrap gap-6 mb-6 text-gray-700">
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z">
                                    </path>
                                </svg>
                                <span>{{ $averageRating }} ({{ $course->reviews->count() }} ulasan) &bull;
                                    {{ number_format($studentsCount, 0, ',', '.') }} student</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-primary" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M12 8a1 1 0 011 1v3.38l2.45 1.42a1 1 0 11-1 1.74l-2.95-1.7A1 1 0 0111 13V9a1 1 0 011-1zm0-6a10 10 0 100 20 10 10 0 000-20z">
                                    </path>
                                </svg>
                                <span>{{ $course->duration_label }}</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-primary" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M4 6a2 2 0 012-2h12a2 2 0 012 2v9a2 2 0 01-2 2H9l-5 4V6zm4 3a1 1 0 100 2h8a1 1 0 100-2H8zm0 4a1 1 0 100 2h5a1 1 0 100-2H8z">
                                    </path>
                                </svg>
                                <span>{{ $course->sections->count() }} section</span>
                            </div>
                        </div>

                        <div class="border-b border-gray-200 mb-6">
                            <div class="flex gap-8">
                                <button class="btn-tab active pb-3 text-gray-900 font-medium" data-tab="tentang"
                                    onclick="switchTab(event, 'tentang')">Tentang</button>
                                <button class="btn-tab pb-3 text-gray-600 font-medium hover:text-gray-900"
                                    data-tab="tugas" onclick="switchTab(event, 'tugas')">Tugas</button>
                                <button class="btn-tab pb-3 text-gray-600 font-medium hover:text-gray-900"
                                    data-tab="ulasan" onclick="switchTab(event, 'ulasan')">Ulasan</button>
                                @if($hasCourseAccess)
                                    <button class="btn-tab pb-3 text-gray-600 font-medium hover:text-gray-900"
                                        data-tab="diskusi" onclick="switchTab(event, 'diskusi')">Diskusi</button>
                                @endif
                            </div>
                        </div>

                        <div id="tentang" class="tab-content active">
                            <div class="text-gray-700 leading-relaxed">
                                <p class="text-gray-600 mb-4 whitespace-pre-line">{{ trim($course->description ?? '') ?: 'Deskripsi kelas belum tersedia.' }}</p>
                                <h3 class="text-lg font-semibold text-gray-900 mb-3">Apa yang akan Anda pelajari?</h3>
                                <ul class="space-y-2 mb-6">
                                    @forelse($course->keypoints as $keypoint)
                                        <li class="flex gap-3">
                                            <svg class="w-5 h-5 text-primary shrink-0 mt-0.5" fill="currentColor"
                                                viewBox="0 0 24 24">
                                                <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"></path>
                                            </svg>
                                            <span>{{ $keypoint->point }}</span>
                                        </li>
                                    @empty
                                        <li class="text-gray-500">Key point belum ditambahkan oleh admin.</li>
                                    @endforelse
                                </ul>
                            </div>
                        </div>

                        <div id="tugas" class="tab-content">
                            <div class="space-y-6">
                                @if (session('error'))
                                    <div class="rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                                        {{ session('error') }}
                                    </div>
                                @endif

                                @if (!$hasCourseAccess)
                                    <div class="rounded-xl border border-amber-200 bg-amber-50 p-5 text-center sm:text-left">
                                        <div class="flex flex-col sm:flex-row items-center gap-3.5">
                                            <div class="w-10 h-10 rounded-full bg-amber-100 text-amber-600 flex items-center justify-center shrink-0">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                                </svg>
                                            </div>
                                            <div>
                                                <h4 class="font-bold text-gray-900 text-sm">Instruksi & Pengumpulan Tugas Terkunci</h4>
                                                <p class="text-xs text-gray-600 mt-0.5">Daftar kelas ini terlebih dahulu untuk membuka instruksi tugas dan mengunggah hasil kerja Anda.</p>
                                            </div>
                                        </div>
                                    </div>
                                @elseif (($watchedVideosCount < $totalVideosCount || $totalVideosCount === 0) && !$taskSubmission)
                                    <div class="rounded-xl border border-amber-200 bg-amber-50 p-5 text-center sm:text-left">
                                        <div class="flex flex-col sm:flex-row items-center gap-3.5">
                                            <div class="w-10 h-10 rounded-full bg-amber-100 text-amber-600 flex items-center justify-center shrink-0">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            </div>
                                            <div>
                                                <h4 class="font-bold text-gray-900 text-sm">Selesaikan Semua Video Terlebih Dahulu</h4>
                                                <p class="text-xs text-gray-600 mt-0.5">Instruksi dan form pengumpulan tugas akan terbuka setelah semua video materi kelas selesai ditonton (Progress saat ini: {{ $watchedVideosCount }}/{{ $totalVideosCount }} video selesai ditonton).</p>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    {{-- Petunjuk / Deskripsi Tugas --}}
                                    <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
                                        <div class="flex items-center gap-3 mb-3 pb-3 border-b border-gray-100">
                                            <div class="w-9 h-9 rounded-lg bg-pink-50 text-pink-600 flex items-center justify-center shrink-0">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                </svg>
                                            </div>
                                            <div>
                                                <h3 class="font-bold text-gray-900 text-base">Instruksi Tugas</h3>
                                                <p class="text-xs text-gray-500">Pahami panduan pengerjaan tugas berikut sebelum mengunggah hasil kerja Anda.</p>
                                            </div>
                                        </div>
                                        
                                        @if (!empty(trim(strip_tags($course->task_description ?? ''))))
                                            <div class="task-rich-text leading-relaxed bg-gray-50 rounded-lg p-4 border border-gray-100">
                                                {!! $course->task_description !!}
                                            </div>
                                        @else
                                            <div class="rounded-lg bg-gray-50 p-4 text-sm text-gray-500 text-center">
                                                Instruksi tugas khusus belum ditambahkan oleh instruktur. Silakan selesaikan proyek sesuai materi kelas.
                                            </div>
                                        @endif
                                    </div>

                                    {{-- Status Pengumpulan & Umpan Balik --}}
                                    @if ($taskSubmission)
                                        <div
                                            class="rounded-xl border {{ $taskSubmission->isReviewed() ? 'border-emerald-200 bg-emerald-50/40' : 'border-amber-200 bg-amber-50/40' }} p-5">
                                            <div class="flex flex-wrap items-center justify-between gap-2 mb-3">
                                                <div class="flex items-center gap-2">
                                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold {{ $taskSubmission->isReviewed() ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                                                        <span class="w-2 h-2 rounded-full {{ $taskSubmission->isReviewed() ? 'bg-emerald-500' : 'bg-amber-500' }}"></span>
                                                        {{ $taskSubmission->isReviewed() ? 'Tugas Selesai Direview' : 'Tugas Menunggu Review Coach' }}
                                                    </span>
                                                    @if ($taskSubmission->isReviewed() && !is_null($taskSubmission->score))
                                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-sky-100 text-sky-800">
                                                            Nilai: {{ $taskSubmission->score }}/100
                                                        </span>
                                                    @endif
                                                </div>
                                                <span class="text-xs text-gray-500">
                                                    Disubmit: {{ $taskSubmission->created_at?->translatedFormat('d F Y H:i') }}
                                                </span>
                                            </div>

                                            <div class="text-sm text-gray-800 space-y-1.5 mb-3 bg-white/90 rounded-lg p-3.5 border border-gray-100">
                                                <p><strong class="font-medium text-gray-600">Subjek Tugas:</strong> {{ $taskSubmission->subject }}</p>
                                                <p class="flex items-center gap-2">
                                                    <strong class="font-medium text-gray-600">Link Jawaban:</strong>
                                                    <a href="{{ $taskSubmission->google_drive_url }}" target="_blank" rel="noopener noreferrer" class="text-primary hover:underline inline-flex items-center gap-1 text-xs font-semibold">
                                                        Buka Google Drive
                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                                    </a>
                                                </p>
                                            </div>

                                            @if ($taskSubmission->isReviewed())
                                                <div class="mt-4 pt-3 border-t border-emerald-200/70">
                                                    <h4 class="text-xs font-bold uppercase tracking-wider text-emerald-900 mb-1.5 flex items-center gap-1.5">
                                                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                                                        </svg>
                                                        Umpan Balik & Catatan Evaluasi Coach:
                                                    </h4>
                                                    @if (!empty(trim($taskSubmission->feedback ?? '')))
                                                        <div class="bg-white rounded-lg p-3.5 border border-emerald-200 text-sm text-gray-800 leading-relaxed whitespace-pre-line">
                                                            {{ $taskSubmission->feedback }}
                                                        </div>
                                                    @else
                                                        <p class="text-xs text-gray-500 italic">Coach memberikan penilaian tanpa catatan tertulis tambahan.</p>
                                                    @endif
                                                </div>
                                            @endif
                                        </div>
                                    @endif

                                    @if (!$taskSubmission || !$taskSubmission->isReviewed())
                                        <form id="taskSubmissionForm" method="POST"
                                            action="{{ route('course.task-submission.store', ['slug' => $course->slug]) }}"
                                            class="space-y-6"
                                            onsubmit="return handleTaskSubmit(event, this);">
                                            @csrf

                                            <div>
                                                <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">Subjek
                                                    Tugas</label>
                                                <input id="subject" name="subject" type="text"
                                                    value="{{ old('subject', $taskSubmission?->subject) }}"
                                                    placeholder="Masukkan subjek tugas..."
                                                    required
                                                    class="w-full px-4 py-2 border {{ $errors->has('subject') ? 'border-red-300' : 'border-gray-300' }} rounded-lg focus:outline-none focus:border-pink-400">
                                                @error('subject')
                                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            <div>
                                                <label for="google_drive_url"
                                                    class="block text-sm font-medium text-gray-700 mb-2">Link Google
                                                    Drive</label>
                                                <input id="google_drive_url" name="google_drive_url" type="url"
                                                    value="{{ old('google_drive_url', $taskSubmission?->google_drive_url) }}"
                                                    placeholder="https://drive.google.com/..."
                                                    required
                                                    class="w-full px-4 py-2 border {{ $errors->has('google_drive_url') ? 'border-red-300' : 'border-gray-300' }} rounded-lg focus:outline-none focus:border-pink-400">
                                                @error('google_drive_url')
                                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            <button type="submit" id="btnTaskSubmit"
                                                class="w-full bg-primary hover-primary text-white font-medium py-2.5 rounded-lg transition shadow-sm hover:shadow">
                                                {{ $taskSubmission ? 'Perbarui Tugas' : 'Kirim Tugas' }}
                                            </button>
                                        </form>
                                    @endif
                                @endif
                            </div>
                        </div>

                        <div id="ulasan" class="tab-content">
                            <div class="space-y-4">
                                @forelse($course->reviews->take(6) as $review)
                                    <div class="bg-gray-50 rounded-lg p-4">
                                        <div class="flex items-start gap-3 mb-2">
                                            <img src="https://api.dicebear.com/7.x/avataaars/svg?seed={{ urlencode($review->student?->name ?? 'Student') }}"
                                                alt="Avatar" class="w-10 h-10 rounded-full">
                                            <div class="flex-1">
                                                <h4 class="font-semibold text-gray-900">
                                                    {{ $review->student?->name ?? 'Student' }}
                                                </h4>
                                                <div class="flex gap-1 mb-2">
                                                    @for($star = 1; $star <= 5; $star++)
                                                        <svg class="w-4 h-4 {{ $star <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}"
                                                            fill="currentColor" viewBox="0 0 24 24">
                                                            <path
                                                                d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z">
                                                            </path>
                                                        </svg>
                                                    @endfor
                                                </div>
                                                <p class="text-gray-700">
                                                    {{ $review->review ?: 'Siswa memberikan rating tanpa komentar.' }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="bg-gray-50 rounded-lg p-4 text-gray-500">Belum ada ulasan untuk kelas ini.
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        @if($hasCourseAccess)
                            <div id="diskusi" class="tab-content">
                                <div class="space-y-6">
                                    {{-- Form Buat Diskusi Baru --}}
                                    <div class="bg-white border border-gray-100 rounded-xl p-4 shadow-sm">
                                        <form method="POST" action="{{ route('course.discussion.store', $course->slug) }}">
                                            @csrf
                                            <div class="flex gap-3">
                                                <img src="{{ auth()->user()?->profile_photo_url ?? ('https://api.dicebear.com/7.x/avataaars/svg?seed=' . urlencode(auth()->user()?->name ?? 'Student')) }}"
                                                    alt="Avatar" class="w-10 h-10 rounded-full shrink-0 object-cover">
                                                <div class="flex-1">
                                                    <textarea name="message" rows="3" required
                                                        placeholder="Tulis pertanyaan atau komentar mengenai materi kelas..."
                                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:border-pink-400 focus:ring-1 focus:ring-pink-400">{{ old('message') }}</textarea>
                                                    
                                                    @error('message')
                                                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                                    @enderror

                                                    <div class="mt-2 flex justify-end">
                                                        <button type="submit"
                                                            class="bg-primary hover-primary text-white font-medium px-5 py-2 rounded-lg text-sm transition-colors duration-200">
                                                            Kirim Diskusi
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>

                                    {{-- Daftar Thread Diskusi --}}
                                    <div class="space-y-4">
                                        @forelse($course->discussions as $discussion)
                                            <div class="bg-gray-50 border border-gray-100 rounded-xl p-4 sm:p-5">
                                                <div class="flex gap-3">
                                                    <img src="{{ $discussion->student?->profile_photo_url ?? ('https://api.dicebear.com/7.x/avataaars/svg?seed=' . urlencode($discussion->student?->name ?? 'User')) }}"
                                                        alt="Avatar" class="w-10 h-10 rounded-full shrink-0 object-cover">
                                                    <div class="flex-1 min-w-0">
                                                        <div class="flex justify-between items-start gap-2">
                                                            <div>
                                                                <div class="flex items-center gap-2 flex-wrap">
                                                                    <h4 class="font-semibold text-gray-900 text-sm">
                                                                        {{ $discussion->student?->name ?? 'Student' }}
                                                                    </h4>
                                                                    @if($discussion->student && $discussion->student->id === $course->user_id)
                                                                        <span class="bg-primary text-white text-[10px] font-semibold px-2 py-0.5 rounded-full">Mentor</span>
                                                                    @endif
                                                                </div>
                                                                <p class="text-xs text-gray-500 mt-0.5">
                                                                    {{ $discussion->created_at?->diffForHumans() }}
                                                                </p>
                                                            </div>
                                                        </div>

                                                        <p class="text-gray-700 text-sm mt-2.5 whitespace-pre-line leading-relaxed">{{ $discussion->message }}</p>

                                                        {{-- Daftar Balasan (Replies dari Coach/Admin) --}}
                                                        @if($discussion->replies && $discussion->replies->isNotEmpty())
                                                            <div class="mt-4 space-y-3 pl-3 sm:pl-4 border-l-2 border-pink-200">
                                                                @foreach($discussion->replies as $reply)
                                                                    <div class="bg-white border border-gray-100 rounded-lg p-3">
                                                                        <div class="flex gap-2.5">
                                                                            <img src="{{ $reply->student?->profile_photo_url ?? ('https://api.dicebear.com/7.x/avataaars/svg?seed=' . urlencode($reply->student?->name ?? 'User')) }}"
                                                                                alt="Avatar" class="w-8 h-8 rounded-full shrink-0 object-cover">
                                                                            <div class="flex-1 min-w-0">
                                                                                <div class="flex items-center gap-2 flex-wrap">
                                                                                    <h5 class="font-semibold text-gray-900 text-xs">
                                                                                        {{ $reply->student?->name ?? 'Student' }}
                                                                                    </h5>
                                                                                    @if($reply->student && $reply->student->id === $course->user_id)
                                                                                        <span class="bg-primary text-white text-[9px] font-semibold px-1.5 py-0.5 rounded-full">Mentor</span>
                                                                                    @endif
                                                                                    <span class="text-[11px] text-gray-400">
                                                                                        {{ $reply->created_at?->diffForHumans() }}
                                                                                    </span>
                                                                                </div>
                                                                                <p class="text-gray-700 text-xs mt-1.5 whitespace-pre-line leading-relaxed">{{ $reply->message }}</p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="bg-gray-50 rounded-xl p-6 text-center text-gray-500 text-sm">
                                                <svg class="w-10 h-10 mx-auto text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                                </svg>
                                                Belum ada diskusi di kelas ini. Jadilah yang pertama bertanya!
                                            </div>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="lg:col-span-1">
                    <div class="bg-white rounded-xl p-6 sticky top-24">
                        <h2 class="text-lg font-bold text-gray-900 mb-4">Daftar Kelas</h2>

                        @if($hasCourseAccess)
                                            <div class="mb-5 rounded-xl border border-pink-100 bg-pink-50 p-4">
                                                <div class="flex items-center justify-between gap-3 mb-3">
                                                    <div>
                                                        <p class="text-sm font-semibold text-gray-900">Progress Belajar</p>
                                                        <p class="text-xs text-gray-600">{{ $watchedVideosCount }}/{{ $totalVideosCount }}
                                                            video selesai</p>
                                                    </div>
                                                    <span class="text-sm font-bold text-pink-600">{{ $progressPercentage }}%</span>
                                                </div>

                                                <div class="w-full h-2 rounded-full bg-pink-100 overflow-hidden">
                                                    <div class="h-full bg-pink-500 rounded-full transition-all duration-300"
                                                        style="width: {{ $progressPercentage }}%;"></div>
                                                </div>

                                                <p class="mt-3 text-xs text-gray-600">
                                                    {{ $watchedVideosCount === $totalVideosCount && $totalVideosCount > 0
                            ? 'Semua video di kelas ini sudah selesai ditonton.'
                            : 'Ayo tambah progress belajar mu.' }}
                                                </p>
                                            </div>
                        @endif

                        @if(!$hasCourseAccess)
                            <div
                                class="mb-4 bg-amber-50 border border-amber-200 text-amber-700 text-sm rounded-lg px-3 py-2 flex items-start gap-2">
                                <svg class="w-4 h-4 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                    </path>
                                </svg>
                                <span>Daftar kelas ini untuk membuka semua materi.</span>
                            </div>
                        @endif

                        <div class="space-y-3 max-h-96 overflow-y-auto pr-1">
                            @if($presentationEmbedUrl)
                                @if($hasCourseAccess)
                                    <a href="{{ route('course', ['slug' => $course->slug, 'presentation' => 1]) }}"
                                        class="video-item presentation-item {{ $showPresentation ? 'now-playing' : '' }}">
                                        <svg class="video-icon w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M4 5a2 2 0 012-2h12a2 2 0 012 2v10a2 2 0 01-2 2H9l-5 4V5zm5 3a1 1 0 000 2h6a1 1 0 100-2H9zm0 4a1 1 0 000 2h6a1 1 0 100-2H9z">
                                            </path>
                                        </svg>
                                        <span class="video-title">Materi Pembelajaran</span>
                                        <span class="video-duration">PDF / Slide</span>
                                    </a>
                                @else
                                    <div class="video-item locked">
                                        <svg class="video-icon w-4 h-4 shrink-0" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                            </path>
                                        </svg>
                                        <span class="video-title">Materi Pembelajaran</span>
                                        <span class="video-duration">Terkunci</span>
                                    </div>
                                @endif
                            @endif

                            @forelse($courseSections as $section)

                                <div
                                    class="group border border-pink-100 rounded-2xl overflow-hidden bg-white shadow-sm hover:shadow-md transition">
                                    <button class="section-header w-full font-medium text-gray-900"
                                        onclick="toggleDropdown(this)">
                                        <div class="section-info">
                                            <span class="font-semibold">{{ $section->title }}</span>
                                            <span class="section-count">{{ $section->videos_count }} video &bull;
                                                {{ $section->duration_label }}</span>
                                        </div>
                                        <svg class="w-5 h-5 text-pink-400 transform transition-transform duration-300 shrink-0"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                            style="transform: rotate({{ $section->has_current_video ? '180deg' : '0deg' }});">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                                        </svg>
                                    </button>

                                    <div class="dropdown-content {{ $section->has_current_video ? 'active' : '' }}">
                                        @foreach($section->videos as $video)
                                            @if($video->is_locked)
                                                <div class="video-item locked">
                                                    <svg class="video-icon w-4 h-4 shrink-0" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                                        </path>
                                                    </svg>
                                                    <span class="video-title">{{ $video->title }}</span>
                                                    <span class="video-duration">Terkunci</span>
                                                </div>
                                            @else
                                                <a href="{{ $video->url }}" class="video-item {{ $video->state_class }}">
                                                    @if($video->is_watched)
                                                        <svg class="video-icon w-4 h-4 shrink-0" fill="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"></path>
                                                        </svg>
                                                    @else
                                                        <svg class="video-icon w-4 h-4 shrink-0" fill="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path d="M8 5v14l11-7z"></path>
                                                        </svg>
                                                    @endif
                                                    <span class="video-title">{{ $video->title }}</span>
                                                    <span class="video-duration">{{ $video->duration_label }}</span>
                                                </a>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @empty
                                <div class="text-sm text-gray-500">Belum ada section di kelas ini.</div>
                            @endforelse

                            @if($hasCourseAccess && $currentVideo && !$showPresentation)
                                <div class="mt-4 mb-4 space-y-2.5">
                                    @if ($hasCurrentVideoQuiz && !$isCurrentVideoQuizCompleted)
                                        <button type="button" onclick="openQuizModal()"
                                            class="w-full bg-primary hover-primary text-white font-bold py-3 rounded-xl transition shadow-sm flex items-center justify-center gap-2">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                                            </svg>
                                            <span>Kerjakan Quiz</span>
                                        </button>
                                    @elseif ($nextVideoUrl)
                                        <a href="{{ $nextVideoUrl }}"
                                            class="w-full inline-flex items-center justify-center gap-2 bg-primary hover-primary text-white font-bold py-3 rounded-xl transition shadow-sm">
                                            <span>Next Video</span>
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                            </svg>
                                        </a>
                                        @if ($hasCurrentVideoQuiz)
                                            <button type="button" onclick="openQuizModal()"
                                                class="w-full py-2.5 px-4 bg-pink-50 hover:bg-pink-100 border border-pink-200 text-pink-700 font-semibold text-xs sm:text-sm rounded-xl transition flex items-center justify-center gap-2">
                                                <svg class="w-4 h-4 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                                </svg>
                                                <span>Ulangi Quiz (Skor: {{ $currentVideoQuizCompletion?->score ?? 0 }}/100)</span>
                                            </button>
                                        @endif
                                    @else
                                        <button type="button" onclick="goToTaskTab()"
                                            class="w-full inline-flex items-center justify-center gap-2 bg-primary hover-primary text-white font-bold py-3 rounded-xl transition shadow-sm">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                            <span>Kerjakan Tugas</span>
                                        </button>
                                        @if ($hasCurrentVideoQuiz)
                                            <button type="button" onclick="openQuizModal()"
                                                class="w-full py-2.5 px-4 bg-pink-50 hover:bg-pink-100 border border-pink-200 text-pink-700 font-semibold text-xs sm:text-sm rounded-xl transition flex items-center justify-center gap-2">
                                                <svg class="w-4 h-4 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                                </svg>
                                                <span>Ulangi Quiz (Skor: {{ $currentVideoQuizCompletion?->score ?? 0 }}/100)</span>
                                            </button>
                                        @endif
                                    @endif
                                </div>
                            @endif
                        </div>

                        @if(!$hasCourseAccess)
                            @if($hasPendingTransaction)
                                <div
                                    class="block w-full text-center bg-gray-200 text-gray-600 font-bold py-3 rounded-lg mt-6 cursor-not-allowed">
                                    Menunggu Konfirmasi Bayar
                                </div>
                            @else
                                <a href="{{ route('transaction', ['course' => $course->slug]) }}"
                                    class="block w-full text-center bg-primary hover-primary text-white font-bold py-3 rounded-lg mt-6">
                                    Daftar Kelas - Rp {{ number_format((int) $course->price, 0, ',', '.') }}
                                </a>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-footer />

    @if($hasCourseAccess && $currentVideo && $hasCurrentVideoQuiz)
        <div id="quizModal" class="quiz-modal-backdrop" onclick="handleQuizBackdropClick(event)">
            <div class="quiz-modal-card">
                <!-- View 1: Pengerjaan Soal (Question Step View) -->
                <div id="quizQuestionView">
                    <div class="px-5 sm:px-6 py-4 border-b border-pink-100 flex items-center justify-between gap-3 bg-pink-50/50">
                        <div>
                            <div class="flex items-center gap-2">
                                <span class="bg-pink-100 text-pink-600 text-[11px] font-bold px-2 py-0.5 rounded-full uppercase tracking-wider">Quiz Video</span>
                                <span class="text-xs text-gray-500 font-medium">Soal <span id="quizStepCurrentText" class="font-bold text-gray-800">1</span> dari {{ $currentVideoQuiz->questions->count() }}</span>
                            </div>
                            <h3 class="text-base sm:text-lg font-bold text-gray-900 mt-1">{{ $currentVideoQuiz->title }}</h3>
                        </div>
                        <button type="button" onclick="closeQuizModal()"
                            class="w-8 h-8 rounded-full bg-white border border-gray-200 text-gray-400 hover:text-gray-600 flex items-center justify-center text-lg leading-none transition">&times;</button>
                    </div>

                    <!-- Progress Bar -->
                    <div class="w-full bg-gray-100 h-1.5 overflow-hidden">
                        <div id="quizProgressBar" class="bg-pink-500 h-full transition-all duration-300" style="width: {{ 100 / max($currentVideoQuiz->questions->count(), 1) }}%;"></div>
                    </div>

                    <form id="quizForm" method="POST" action="{{ route('course.quiz.submit', ['slug' => $course->slug]) }}"
                        onsubmit="submitQuizForm(event)" class="px-5 sm:px-6 py-5 space-y-6">
                        @csrf
                        <input type="hidden" name="video_id" value="{{ $currentVideo->id }}">

                        @foreach ($currentVideoQuiz->questions as $questionIndex => $question)
                            <div class="quiz-question-step {{ $questionIndex === 0 ? 'block' : 'hidden' }}" data-step="{{ $questionIndex + 1 }}">
                                <div class="mb-4">
                                    <span class="text-xs font-bold text-pink-500 uppercase tracking-wider">Pertanyaan #{{ $questionIndex + 1 }}</span>
                                    <p class="font-bold text-base sm:text-lg text-gray-900 mt-1 leading-snug">{{ $question->question }}</p>
                                </div>

                                <div class="space-y-2.5">
                                    @foreach ($question->options as $optionIndex => $option)
                                        @php
                                            $optionLabels = ['A', 'B', 'C', 'D', 'E', 'F'];
                                            $optionLabel = $optionLabels[$optionIndex] ?? ($optionIndex + 1);
                                        @endphp
                                        <label onclick="selectQuizOption(this)"
                                            class="quiz-option-item flex items-center gap-3 p-3.5 sm:p-4 rounded-xl border border-gray-200 hover:border-pink-300 hover:bg-pink-50/40 cursor-pointer transition">
                                            <input type="radio" name="answers[{{ $question->id }}]" value="{{ $option->id }}" required
                                                onchange="onQuizOptionSelected({{ $questionIndex + 1 }})"
                                                class="sr-only">
                                            <div class="option-indicator w-7 h-7 rounded-lg border border-gray-300 text-xs font-bold text-gray-600 flex items-center justify-center shrink-0 transition bg-white">
                                                {{ $optionLabel }}
                                            </div>
                                            <span class="text-sm font-medium text-gray-800 flex-1 leading-normal">{{ $option->option_text }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach

                        <div class="flex items-center justify-between pt-4 border-t border-pink-100">
                            <button type="button" id="btnQuizPrev" onclick="prevQuizQuestion()"
                                class="px-4 py-2.5 rounded-xl border border-gray-200 text-gray-600 font-semibold text-sm hover:bg-gray-50 transition hidden">
                                ← Sebelumnya
                            </button>
                            <div class="flex items-center gap-2 ml-auto">
                                <button type="button" id="btnQuizNext" onclick="nextQuizQuestion()"
                                    class="px-6 py-2.5 rounded-xl bg-pink-500 hover:bg-pink-600 active:bg-pink-700 text-white font-bold text-sm transition shadow-sm flex items-center gap-1.5">
                                    <span>Selanjutnya</span>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </button>
                                <button type="submit" id="btnQuizSubmit"
                                    class="px-6 py-2.5 rounded-xl bg-emerald-500 hover:bg-emerald-600 active:bg-emerald-700 text-white font-bold text-sm transition shadow-sm hidden flex items-center gap-1.5">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span>Kirim Jawaban</span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- View 2: Hasil & Pembahasan (Result & Review View) -->
                <div id="quizResultView" class="hidden">
                    <div class="px-5 sm:px-6 py-4 border-b border-pink-100 flex items-center justify-between gap-3 bg-pink-50/50">
                        <div class="flex items-center gap-2">
                            <span class="bg-pink-100 text-pink-600 text-[11px] font-bold px-2 py-0.5 rounded-full uppercase tracking-wider">Hasil Quiz</span>
                            <h3 class="text-base sm:text-lg font-bold text-gray-900">{{ $currentVideoQuiz->title }}</h3>
                        </div>
                        <button type="button" onclick="closeQuizModal()"
                            class="w-8 h-8 rounded-full bg-white border border-gray-200 text-gray-400 hover:text-gray-600 flex items-center justify-center text-lg leading-none transition">&times;</button>
                    </div>

                    <div class="px-5 sm:px-6 py-6 space-y-6 max-h-[65vh] overflow-y-auto">
                        <!-- Score Header Card -->
                        <div class="p-6 rounded-2xl bg-gradient-to-br from-pink-50 via-white to-pink-50/40 border border-pink-100 text-center flex flex-col items-center shadow-xs">
                            <div id="quizResultBadgeIcon" class="w-14 h-14 rounded-full flex items-center justify-center text-2xl mb-2.5 shadow-inner bg-emerald-100 text-emerald-600">
                                🏆
                            </div>
                            <div class="flex items-baseline justify-center gap-1">
                                <span id="quizResultScoreText" class="text-4xl font-extrabold text-gray-900">100</span>
                                <span class="text-lg font-bold text-gray-400">/ 100</span>
                            </div>
                            <p id="quizResultStatusText" class="font-bold text-base mt-2 text-emerald-600">Selamat! Kamu Lulus Quiz</p>
                            <p id="quizResultSummaryText" class="text-xs sm:text-sm text-gray-500 mt-1">4 dari 5 pertanyaan dijawab dengan benar</p>
                        </div>

                        <!-- Review Detail Soal -->
                        <div>
                            <h4 class="font-bold text-sm text-gray-900 mb-3 flex items-center gap-2">
                                <span>Pembahasan Soal</span>
                                <span class="text-xs font-normal text-gray-500">(Review Benar / Salah)</span>
                            </h4>

                            <div id="quizReviewList" class="space-y-3.5">
                                <!-- Generated by JS dynamically -->
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row items-center justify-between gap-3 px-5 sm:px-6 py-4 border-t border-pink-100 bg-gray-50 rounded-b-2xl">
                        <button type="button" onclick="restartQuiz()"
                            class="w-full sm:w-auto px-4 py-2.5 rounded-xl border border-gray-300 bg-white hover:bg-gray-100 text-gray-700 font-semibold text-sm transition flex items-center justify-center gap-2">
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                            <span>Ulangi Quiz</span>
                        </button>
                        
                        @if ($nextVideoUrl)
                            <a href="{{ $nextVideoUrl }}"
                                class="w-full sm:w-auto px-6 py-2.5 rounded-xl bg-pink-500 hover:bg-pink-600 text-white font-bold text-sm transition shadow-sm flex items-center justify-center gap-2">
                                <span>Lanjut Video Berikutnya</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        @else
                            <button type="button" onclick="closeQuizModal(); window.location.reload();"
                                class="w-full sm:w-auto px-6 py-2.5 rounded-xl bg-pink-500 hover:bg-pink-600 text-white font-bold text-sm transition shadow-sm">
                                Selesai
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif

    <script>
        const sessionSuccessMessage = @json(session('success'));
        const sessionErrorMessage = @json(session('error'));
        const quizSuccessGifUrl = @json(asset('assets/congratulations.gif'));
        const tryAgainGifUrl = @json(asset('assets/tryagain.gif'));
        const nextVideoUrl = @json($nextVideoUrl ?? null);

        function showCourseAlert(type, message) {
            if (!message) return;

            const isQuizSuccess = type === 'success' && message.toLowerCase().includes('quiz');
            const shouldGoNext = isQuizSuccess && !!nextVideoUrl;
            const options = {
                title: type === 'success' ? 'Berhasil' : 'Perhatian',
                text: message,
                confirmButtonColor: '#ec4899',
                background: '#fff',
                imageWidth: 220,
            };

            if (type === 'error') {
                options.title = 'Coba lagi';
                options.imageUrl = tryAgainGifUrl;
                options.imageAlt = 'Try again gif';
            } else if (isQuizSuccess) {
                options.title = 'Quiz selesai';
                options.imageUrl = quizSuccessGifUrl;
                options.imageAlt = 'Quiz success gif';
                options.confirmButtonText = 'Lanjut belajar';
            } else {
                options.imageUrl = quizSuccessGifUrl;
                options.imageAlt = 'Success gif';
            }

            Swal.fire(options).then((result) => {
                if (result.isConfirmed && shouldGoNext) {
                    window.location.href = nextVideoUrl;
                }
            });
        }

        function openQuizModal() {
            const modal = document.getElementById('quizModal');
            if (!modal) return;
            restartQuiz();
            modal.classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeQuizModal() {
            const modal = document.getElementById('quizModal');
            if (!modal) return;
            modal.classList.remove('active');
            document.body.style.overflow = '';
        }

        function handleQuizBackdropClick(event) {
            if (event.target.id === 'quizModal') {
                closeQuizModal();
            }
        }

        let currentQuizStep = 1;
        const totalQuizQuestions = {{ $hasCurrentVideoQuiz ? $currentVideoQuiz->questions->count() : 0 }};

        function updateQuizStepView() {
            const steps = document.querySelectorAll('.quiz-question-step');
            steps.forEach((step, idx) => {
                if (idx + 1 === currentQuizStep) {
                    step.classList.remove('hidden');
                    step.classList.add('block');
                } else {
                    step.classList.remove('block');
                    step.classList.add('hidden');
                }
            });

            const currentText = document.getElementById('quizStepCurrentText');
            if (currentText) currentText.innerText = currentQuizStep;

            const progressBar = document.getElementById('quizProgressBar');
            if (progressBar && totalQuizQuestions > 0) {
                const percent = (currentQuizStep / totalQuizQuestions) * 100;
                progressBar.style.width = percent + '%';
            }

            const btnPrev = document.getElementById('btnQuizPrev');
            if (btnPrev) {
                if (currentQuizStep > 1) {
                    btnPrev.classList.remove('hidden');
                } else {
                    btnPrev.classList.add('hidden');
                }
            }

            const btnNext = document.getElementById('btnQuizNext');
            const btnSubmit = document.getElementById('btnQuizSubmit');

            if (currentQuizStep === totalQuizQuestions) {
                if (btnNext) btnNext.classList.add('hidden');
                if (btnSubmit) btnSubmit.classList.remove('hidden');
            } else {
                if (btnNext) btnNext.classList.remove('hidden');
                if (btnSubmit) btnSubmit.classList.add('hidden');
            }
        }

        function selectQuizOption(labelElement) {
            const stepContainer = labelElement.closest('.quiz-question-step');
            if (!stepContainer) return;

            stepContainer.querySelectorAll('.quiz-option-item').forEach(el => {
                el.classList.remove('border-pink-500', 'bg-pink-50', 'ring-1', 'ring-pink-400');
                el.classList.add('border-gray-200');
                const indicator = el.querySelector('.option-indicator');
                if (indicator) {
                    indicator.classList.remove('bg-pink-500', 'border-pink-500', 'text-white');
                    indicator.classList.add('border-gray-300', 'text-gray-600', 'bg-white');
                }
            });

            labelElement.classList.remove('border-gray-200');
            labelElement.classList.add('border-pink-500', 'bg-pink-50', 'ring-1', 'ring-pink-400');
            const indicator = labelElement.querySelector('.option-indicator');
            if (indicator) {
                indicator.classList.remove('border-gray-300', 'text-gray-600', 'bg-white');
                indicator.classList.add('bg-pink-500', 'border-pink-500', 'text-white');
            }

            const radio = labelElement.querySelector('input[type="radio"]');
            if (radio) radio.checked = true;
        }

        function onQuizOptionSelected(stepNumber) {
            // Callback placeholder if needed
        }

        function isCurrentStepAnswered() {
            const currentStepEl = document.querySelector(`.quiz-question-step[data-step="${currentQuizStep}"]`);
            if (!currentStepEl) return true;
            const checkedRadio = currentStepEl.querySelector('input[type="radio"]:checked');
            return checkedRadio !== null;
        }

        function nextQuizQuestion() {
            if (!isCurrentStepAnswered()) {
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'info',
                        title: 'Pilih Jawaban',
                        text: 'Silakan pilih salah satu jawaban terlebih dahulu.',
                        confirmButtonColor: '#ec4899',
                        confirmButtonText: 'Mengerti',
                        customClass: { popup: 'rounded-2xl', confirmButton: 'rounded-xl font-bold' }
                    });
                } else {
                    alert('Silakan pilih salah satu jawaban terlebih dahulu.');
                }
                return;
            }

            if (currentQuizStep < totalQuizQuestions) {
                currentQuizStep++;
                updateQuizStepView();
            }
        }

        function prevQuizQuestion() {
            if (currentQuizStep > 1) {
                currentQuizStep--;
                updateQuizStepView();
            }
        }

        function restartQuiz() {
            currentQuizStep = 1;
            const form = document.getElementById('quizForm');
            if (form) {
                form.reset();
                form.querySelectorAll('.quiz-option-item').forEach(el => {
                    el.classList.remove('border-pink-500', 'bg-pink-50', 'ring-1', 'ring-pink-400');
                    el.classList.add('border-gray-200');
                    const indicator = el.querySelector('.option-indicator');
                    if (indicator) {
                        indicator.classList.remove('bg-pink-500', 'border-pink-500', 'text-white');
                        indicator.classList.add('border-gray-300', 'text-gray-600', 'bg-white');
                    }
                });
            }

            document.getElementById('quizQuestionView')?.classList.remove('hidden');
            document.getElementById('quizResultView')?.classList.add('hidden');
            updateQuizStepView();
        }

        async function submitQuizForm(event) {
            event.preventDefault();

            if (!isCurrentStepAnswered()) {
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'info',
                        title: 'Pilih Jawaban',
                        text: 'Silakan pilih jawaban untuk soal ini terlebih dahulu.',
                        confirmButtonColor: '#ec4899',
                        confirmButtonText: 'Mengerti'
                    });
                } else {
                    alert('Silakan pilih jawaban untuk soal ini terlebih dahulu.');
                }
                return;
            }

            const form = event.target;
            const submitBtn = document.getElementById('btnQuizSubmit');
            const originalBtnText = submitBtn ? submitBtn.innerHTML : 'Kirim Jawaban';

            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<span>Memeriksa Jawaban...</span>';
            }

            const formData = new FormData(form);

            try {
                const response = await fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                    }
                });

                if (!response.ok) {
                    throw new Error('Gagal mengirim jawaban.');
                }

                const data = await response.json();
                renderQuizResult(data);
            } catch (error) {
                console.error(error);
                form.submit();
            } finally {
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalBtnText;
                }
            }
        }

        function renderQuizResult(data) {
            document.getElementById('quizQuestionView')?.classList.add('hidden');
            const resultView = document.getElementById('quizResultView');
            if (!resultView) return;

            resultView.classList.remove('hidden');

            const scoreText = document.getElementById('quizResultScoreText');
            if (scoreText) scoreText.innerText = data.score;

            const badgeIcon = document.getElementById('quizResultBadgeIcon');
            const statusText = document.getElementById('quizResultStatusText');
            const summaryText = document.getElementById('quizResultSummaryText');

            if (data.is_passed) {
                if (badgeIcon) {
                    badgeIcon.className = 'w-14 h-14 rounded-full flex items-center justify-center text-2xl mb-2.5 shadow-inner bg-emerald-100 text-emerald-600';
                    badgeIcon.innerText = '🏆';
                }
                if (statusText) {
                    statusText.className = 'font-bold text-base mt-2 text-emerald-600';
                    statusText.innerText = 'Selamat! Kamu Lulus Quiz';
                }
            } else {
                if (badgeIcon) {
                    badgeIcon.className = 'w-14 h-14 rounded-full flex items-center justify-center text-2xl mb-2.5 shadow-inner bg-amber-100 text-amber-600';
                    badgeIcon.innerText = '📖';
                }
                if (statusText) {
                    statusText.className = 'font-bold text-base mt-2 text-amber-600';
                    statusText.innerText = `Nilai Belum Mencapai Target (Min. ${data.passing_score}%)`;
                }
            }

            if (summaryText) {
                summaryText.innerText = `${data.correct_count} dari ${data.total_questions} pertanyaan dijawab dengan benar`;
            }

            const reviewContainer = document.getElementById('quizReviewList');
            if (reviewContainer && Array.isArray(data.results)) {
                reviewContainer.innerHTML = '';

                data.results.forEach((item, index) => {
                    const card = document.createElement('div');
                    card.className = `p-4 rounded-xl border ${item.is_correct ? 'border-emerald-200 bg-emerald-50/40' : 'border-red-200 bg-red-50/40'}`;

                    card.innerHTML = `
                        <div class="flex items-start gap-3">
                            <div class="w-6 h-6 rounded-full flex items-center justify-center shrink-0 mt-0.5 ${item.is_correct ? 'bg-emerald-500 text-white' : 'bg-red-500 text-white'}">
                                ${item.is_correct
                                    ? '<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>'
                                    : '<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>'
                                }
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs font-bold ${item.is_correct ? 'text-emerald-700' : 'text-red-700'}">Soal #${index + 1}</p>
                                <p class="text-sm font-semibold text-gray-900 mt-0.5">${item.question_text}</p>
                                
                                <div class="mt-2 text-xs">
                                    <div class="flex items-start gap-1.5">
                                        <span class="text-gray-500 shrink-0">Jawaban Kamu:</span>
                                        <span class="font-medium ${item.is_correct ? 'text-emerald-700' : 'text-red-700'}">${item.selected_option_text}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;

                    reviewContainer.appendChild(card);
                });
            }
        }

        function activateTab(tabName) {
            document.querySelectorAll('.tab-content').forEach(el => {
                el.classList.remove('active');
            });

            document.querySelectorAll('.btn-tab').forEach(btn => {
                btn.classList.remove('active');
            });

            const tabContent = document.getElementById(tabName);
            const tabButton = document.querySelector(`.btn-tab[data-tab="${tabName}"]`);

            if (tabContent && tabButton) {
                tabContent.classList.add('active');
                tabButton.classList.add('active');
            }
        }

        function toggleDropdown(button) {
            const dropdown = button.nextElementSibling;
            const svg = button.querySelector('svg');

            document.querySelectorAll('.dropdown-content.active').forEach(el => {
                if (el !== dropdown) {
                    el.classList.remove('active');
                    el.previousElementSibling.querySelector('svg').style.transform = 'rotate(0deg)';
                }
            });

            dropdown.classList.toggle('active');
            svg.style.transform = dropdown.classList.contains('active') ? 'rotate(180deg)' : 'rotate(0deg)';
        }

        function switchTab(event, tabName) {
            event.preventDefault();
            activateTab(tabName);
        }

        function scrollToVideo() {
            const videoEl = document.getElementById('video-container') || document.querySelector('.video-placeholder');
            if (videoEl) {
                videoEl.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        }

        function goToTaskTab() {
            activateTab('tugas');
            const taskTabEl = document.getElementById('tugas');
            if (taskTabEl) {
                taskTabEl.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        }

        function handleTaskSubmit(event, form) {
            event.preventDefault();

            const subjectInput = form.querySelector('#subject');
            const driveUrlInput = form.querySelector('#google_drive_url');

            const subject = subjectInput ? subjectInput.value.trim() : '';
            const driveUrl = driveUrlInput ? driveUrlInput.value.trim() : '';

            if (!subject) {
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Subjek Tugas Kosong',
                        text: 'Silakan isi subjek tugas terlebih dahulu.',
                        confirmButtonColor: '#ec4899',
                        confirmButtonText: 'Mengerti',
                        customClass: { popup: 'rounded-2xl', confirmButton: 'rounded-xl font-bold px-5 py-2' }
                    });
                } else {
                    alert('Silakan isi subjek tugas terlebih dahulu.');
                }
                subjectInput?.focus();
                return false;
            }

            if (!driveUrl) {
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Link Drive Kosong',
                        text: 'Silakan masukkan URL link Google Drive tugas Anda.',
                        confirmButtonColor: '#ec4899',
                        confirmButtonText: 'Mengerti',
                        customClass: { popup: 'rounded-2xl', confirmButton: 'rounded-xl font-bold px-5 py-2' }
                    });
                } else {
                    alert('Silakan masukkan link Google Drive tugas Anda.');
                }
                driveUrlInput?.focus();
                return false;
            }

            const isUpdate = {{ $taskSubmission ? 'true' : 'false' }};

            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    title: isUpdate ? 'Perbarui Tugas?' : 'Kirim Tugas?',
                    text: 'Pastikan link Google Drive sudah benar dan dapat diakses publik.',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#ec4899',
                    cancelButtonColor: '#9ca3af',
                    confirmButtonText: isUpdate ? 'Ya, Perbarui' : 'Ya, Kirim',
                    cancelButtonText: 'Batal',
                    reverseButtons: true,
                    customClass: {
                        popup: 'rounded-2xl',
                        confirmButton: 'rounded-xl font-bold px-5 py-2.5 text-sm',
                        cancelButton: 'rounded-xl font-semibold px-5 py-2.5 text-sm'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        const submitBtn = form.querySelector('#btnTaskSubmit') || form.querySelector('button[type="submit"]');
                        if (submitBtn) {
                            submitBtn.disabled = true;
                            submitBtn.innerHTML = '<span class="inline-flex items-center justify-center gap-2"><svg class="animate-spin h-4 w-4 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Memproses...</span>';
                        }
                        form.submit();
                    }
                });
            } else {
                if (confirm(isUpdate ? 'Perbarui tugas ini?' : 'Kirim tugas ini?')) {
                    form.submit();
                }
            }

            return false;
        }

        window.addEventListener('load', () => {
            showCourseAlert('success', sessionSuccessMessage);
            showCourseAlert('error', sessionErrorMessage);

            const hasTaskFormError = {{ $errors->has('subject') || $errors->has('google_drive_url') ? 'true' : 'false' }};
            const hasDiscussionError = {{ $errors->has('message') ? 'true' : 'false' }};
            const hashTab = window.location.hash.replace('#', '');

            if (hasTaskFormError || hashTab === 'tugas') {
                activateTab('tugas');
            } else if (hasDiscussionError || hashTab === 'diskusi') {
                activateTab('diskusi');
            }

            const activeDropdown = document.querySelector('.dropdown-content.active');
            if (!activeDropdown) {
                const firstDropdown = document.querySelector('.dropdown-content');
                if (firstDropdown) {
                    firstDropdown.classList.add('active');
                    firstDropdown.previousElementSibling.querySelector('svg').style.transform = 'rotate(180deg)';
                }
            }
        });
    </script>
</x-layout>