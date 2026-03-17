<x-layout>
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

        .video-placeholder {
            background: linear-gradient(135deg, #fce7f3 0%, #fbcfe8 100%);
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
    </style>

    <x-navbar />

    <div class="bg-gray-50 border-b border-gray-200 px-4 sm:px-6 lg:px-8 py-4">
        <div class="max-w-7xl mx-auto">
            <a href="{{ route('dashboard') }}"
                class="text-primary font-medium inline-flex items-center gap-2 hover:text-pink-700">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Kembali ke Dashboard
            </a>
        </div>
    </div>

    <div class="bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2">
                    <div class="mb-3 text-sm text-pink-700 bg-pink-50 border border-pink-100 rounded-lg px-4 py-2">
                        Sedang diputar: <span class="font-semibold">{{ $activeVideoTitle }}</span>
                    </div>

                    <div class="video-placeholder rounded-xl overflow-hidden mb-6">
                        <div class="relative w-full" style="padding-bottom: 56.25%;">
                            <iframe class="absolute inset-0 w-full h-full"
                                src="{{ $embedUrl ?? 'https://www.youtube.com/embed/dQw4w9WgXcQ' }}"
                                title="{{ $currentVideo?->title ?? $course->name }}" frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                referrerpolicy="strict-origin-when-cross-origin" allowfullscreen>
                            </iframe>
                        </div>
                    </div>

                    @if($hasCourseAccess)
                    <div class="bg-white rounded-xl p-6 mb-6">
                        <h2 class="text-base font-bold text-gray-900 mb-5">Progress Penyelesaian Kelas</h2>

                        @php
                            $allVideosWatched = $totalVideosCount > 0 && $watchedVideosCount >= $totalVideosCount;
                            $hasSubmission     = ! is_null($taskSubmission);
                            $isPending         = $hasSubmission && $taskSubmission->isPending();
                            $isReviewed        = $hasSubmission && $taskSubmission->isReviewed();

                            $steps = [
                                [
                                    'label'     => 'Tonton Video',
                                    'sublabel'  => $allVideosWatched ? ($totalVideosCount . '/' . $totalVideosCount . ' video') : ($watchedVideosCount . '/' . $totalVideosCount . ' video'),
                                    'done'      => $allVideosWatched,
                                    'active'    => ! $allVideosWatched,
                                    'icon_done' => '<path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>',
                                    'icon_todo' => '<path d="M8 5v14l11-7z"/>',
                                ],
                                [
                                    'label'     => 'Submit Tugas',
                                    'sublabel'  => $hasSubmission ? 'Tugas terkirim' : 'Belum di-submit',
                                    'done'      => $hasSubmission,
                                    'active'    => $allVideosWatched && ! $hasSubmission,
                                    'icon_done' => '<path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>',
                                    'icon_todo' => '<path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>',
                                ],
                                [
                                    'label'     => 'Di Review',
                                    'sublabel'  => $isReviewed ? 'Review selesai' : ($isPending ? 'Sedang direview' : 'Menunggu submit'),
                                    'done'      => $isReviewed,
                                    'active'    => $isPending,
                                    'icon_done' => '<path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>',
                                    'icon_todo' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>',
                                ],
                                [
                                    'label'     => 'Selesai Direview',
                                    'sublabel'  => $isReviewed ? (is_null($taskSubmission->score) ? 'Sudah dinilai' : 'Nilai: ' . $taskSubmission->score . '/100') : 'Belum direview',
                                    'done'      => $isReviewed,
                                    'active'    => false,
                                    'icon_done' => '<path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>',
                                    'icon_todo' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>',
                                ],
                                [
                                    'label'     => 'Dapatkan Sertifikat',
                                    'sublabel'  => $isReviewed ? 'Klik untuk klaim' : 'Selesaikan review dulu',
                                    'done'      => false,
                                    'active'    => $isReviewed,
                                    'url'       => $isReviewed ? route('claim-certificate', ['slug' => $course->slug]) : null,
                                    'icon_done' => '',
                                    'icon_todo' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>',
                                ],
                            ];
                        @endphp

                        <div class="flex items-start gap-0">
                            @foreach ($steps as $i => $step)
                                @php
                                    $isLast      = $i === count($steps) - 1;
                                    $useFilledIcon = $step['done'];
                                    $circleClass = $step['done']
                                        ? 'bg-emerald-500 border-emerald-500 text-white'
                                        : ($step['active'] ? 'bg-pink-500 border-pink-500 text-white' : 'bg-white border-gray-300 text-gray-400');
                                    $labelClass  = $step['done']
                                        ? 'text-emerald-600 font-semibold'
                                        : ($step['active'] ? 'text-pink-600 font-semibold' : 'text-gray-400');
                                    $subClass    = $step['done']
                                        ? 'text-emerald-500'
                                        : ($step['active'] ? 'text-pink-400' : 'text-gray-400');
                                    $lineClass   = $step['done'] ? 'bg-emerald-400' : 'bg-gray-200';
                                @endphp

                                <div class="flex flex-col items-center {{ $isLast ? '' : 'flex-1' }}">
                                    <!-- Circle + icon -->
                                    @if (! $isLast && isset($step['url']) && $step['url'])
                                        <a href="{{ $step['url'] }}" title="{{ $step['label'] }}"
                                            class="w-9 h-9 rounded-full border-2 flex items-center justify-center shrink-0 transition hover:scale-110 {{ $circleClass }}">
                                            <svg class="w-4 h-4" fill="{{ $useFilledIcon ? 'currentColor' : 'none' }}" stroke="{{ $useFilledIcon ? 'none' : 'currentColor' }}" viewBox="0 0 24 24">
                                                {!! $useFilledIcon ? $step['icon_done'] : $step['icon_todo'] !!}
                                            </svg>
                                        </a>
                                    @elseif ($isLast && isset($step['url']) && $step['url'])
                                        <a href="{{ $step['url'] }}" title="{{ $step['label'] }}"
                                            class="w-9 h-9 rounded-full border-2 flex items-center justify-center shrink-0 transition hover:scale-110 {{ $circleClass }}">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                {!! $step['icon_todo'] !!}
                                            </svg>
                                        </a>
                                    @else
                                        <div class="w-9 h-9 rounded-full border-2 flex items-center justify-center shrink-0 {{ $circleClass }}">
                                            <svg class="w-4 h-4" fill="{{ $useFilledIcon ? 'currentColor' : 'none' }}" stroke="{{ $useFilledIcon ? 'none' : 'currentColor' }}" viewBox="0 0 24 24">
                                                {!! $useFilledIcon ? $step['icon_done'] : $step['icon_todo'] !!}
                                            </svg>
                                        </div>
                                    @endif

                                    <!-- Label below circle -->
                                    <p class="mt-1.5 text-center text-xs leading-tight {{ $labelClass }}">{{ $step['label'] }}</p>
                                    <p class="text-center text-[10px] leading-tight mt-0.5 {{ $subClass }}">{{ $step['sublabel'] }}</p>
                                </div>

                                @if (! $isLast)
                                    <!-- Connector line -->
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
                                <button class="btn-tab pb-3 text-gray-600 font-medium hover:text-gray-900" data-tab="tugas"
                                    onclick="switchTab(event, 'tugas')">Tugas</button>
                                <button class="btn-tab pb-3 text-gray-600 font-medium hover:text-gray-900" data-tab="ulasan"
                                    onclick="switchTab(event, 'ulasan')">Ulasan</button>
                                @if($hasCourseAccess)
                                    <button class="btn-tab pb-3 text-gray-600 font-medium hover:text-gray-900" data-tab="diskusi"
                                        onclick="switchTab(event, 'diskusi')">Diskusi</button>
                                @endif
                            </div>
                        </div>

                        <div id="tentang" class="tab-content active">
                            <div class="text-gray-700 leading-relaxed">
                                <p class="text-gray-600 mb-4">
                                    {{ $course->description ?: 'Deskripsi kelas belum tersedia.' }}</p>
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
                                @if (session('success'))
                                    <div class="rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                                        {{ session('success') }}
                                    </div>
                                @endif

                                @if (session('error'))
                                    <div class="rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                                        {{ session('error') }}
                                    </div>
                                @endif

                                @if ($taskSubmission)
                                    <div class="rounded-lg border border-pink-100 bg-pink-50 px-4 py-3 text-sm text-gray-700">
                                        <p class="font-semibold text-gray-900 mb-1">Status Tugas: {{ $taskSubmission->isReviewed() ? 'Selesai Direview' : 'Menunggu Review' }}</p>
                                        @if ($taskSubmission->isReviewed() && ! is_null($taskSubmission->score))
                                            <p class="text-sky-700 font-semibold">Nilai: {{ $taskSubmission->score }}/100</p>
                                        @endif
                                        <p class="text-xs text-gray-500 mt-1">Submit terakhir: {{ $taskSubmission->created_at?->translatedFormat('d F Y H:i') }}</p>
                                    </div>
                                @endif

                                @if (! $hasCourseAccess)
                                    <div class="rounded-lg border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-700">
                                        Daftar kelas ini terlebih dahulu untuk bisa mengirim tugas.
                                    </div>
                                @elseif ($watchedVideosCount < $totalVideosCount || $totalVideosCount === 0)
                                    <div class="rounded-lg border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-700">
                                        Tugas bisa dikirim setelah semua video selesai ditonton.
                                    </div>
                                @elseif ($taskSubmission && $taskSubmission->isReviewed())
                                    <div class="rounded-lg border border-sky-200 bg-sky-50 px-4 py-3 text-sm text-sky-700">
                                        Tugas sudah direview. Saat ini submit ulang belum tersedia.
                                    </div>
                                @else
                                    <form method="POST" action="{{ route('course.task-submission.store', ['slug' => $course->slug]) }}" class="space-y-6">
                                        @csrf

                                        <div>
                                            <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">Subjek Tugas</label>
                                            <input id="subject" name="subject" type="text"
                                                value="{{ old('subject', $taskSubmission?->subject) }}"
                                                placeholder="Masukkan subjek tugas..."
                                                class="w-full px-4 py-2 border {{ $errors->has('subject') ? 'border-red-300' : 'border-gray-300' }} rounded-lg focus:outline-none focus:border-pink-400">
                                            @error('subject')
                                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div>
                                            <label for="google_drive_url" class="block text-sm font-medium text-gray-700 mb-2">Link Google Drive</label>
                                            <input id="google_drive_url" name="google_drive_url" type="url"
                                                value="{{ old('google_drive_url', $taskSubmission?->google_drive_url) }}"
                                                placeholder="https://drive.google.com/..."
                                                class="w-full px-4 py-2 border {{ $errors->has('google_drive_url') ? 'border-red-300' : 'border-gray-300' }} rounded-lg focus:outline-none focus:border-pink-400">
                                            @error('google_drive_url')
                                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <button type="submit"
                                            class="w-full bg-primary hover-primary text-white font-medium py-2.5 rounded-lg transition">
                                            {{ $taskSubmission ? 'Perbarui Tugas' : 'Kirim Tugas' }}
                                        </button>
                                    </form>
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
                                                    {{ $review->student?->name ?? 'Student' }}</h4>
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
                                                    {{ $review->review ?: 'Siswa memberikan rating tanpa komentar.' }}</p>
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
                                <div class="space-y-4">
                                    <div class="flex gap-3">
                                        <img src="https://api.dicebear.com/7.x/avataaars/svg?seed=Student" alt="Avatar"
                                            class="w-10 h-10 rounded-full shrink-0">
                                        <div class="flex-1">
                                            <textarea placeholder="Tulis pertanyaan atau komentar..." rows="3"
                                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-pink-400"></textarea>
                                            <button
                                                class="mt-2 bg-primary hover-primary text-white font-medium px-6 py-2 rounded-lg">Kirim</button>
                                        </div>
                                    </div>

                                    @forelse($course->discussions->take(6) as $discussion)
                                        <div class="bg-gray-50 rounded-lg p-4">
                                            <div class="flex gap-3">
                                                <img src="https://api.dicebear.com/7.x/avataaars/svg?seed={{ urlencode($discussion->student?->name ?? 'User') }}"
                                                    alt="Avatar" class="w-10 h-10 rounded-full shrink-0">
                                                <div class="flex-1">
                                                    <div class="flex justify-between items-start gap-3">
                                                        <div>
                                                            <h4 class="font-semibold text-gray-900">
                                                                {{ $discussion->student?->name ?? 'Student' }}</h4>
                                                            <p class="text-sm text-gray-500">
                                                                {{ $discussion->created_at?->diffForHumans() }}</p>
                                                        </div>
                                                        @if($discussion->student && $discussion->student->id === $course->user_id)
                                                            <span
                                                                class="bg-primary text-white text-xs px-2 py-1 rounded">Mentor</span>
                                                        @endif
                                                    </div>
                                                    <p class="text-gray-700 mt-2">{{ $discussion->message }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="bg-gray-50 rounded-lg p-4 text-gray-500">Belum ada diskusi di kelas ini.
                                        </div>
                                    @endforelse
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
                                <span>Daftar kelas ini untuk membuka semua materi kelas.</span>
                            </div>
                        @endif

                        <div class="space-y-3 max-h-96 overflow-y-auto pr-1">
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

                                    <div
                                        class="dropdown-content {{ $section->has_current_video ? 'active' : '' }}">
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
                        </div>

                        @if(!$hasCourseAccess)
                            <a href="{{ route('transaction', ['course' => $course->slug]) }}"
                                class="block w-full text-center bg-primary hover-primary text-white font-bold py-3 rounded-lg mt-6">
                                Daftar Kelas - Rp {{ number_format((int) $course->price, 0, ',', '.') }}
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-footer />

    <script>
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

        window.addEventListener('load', () => {
            const hasTaskFormError = {{ $errors->has('subject') || $errors->has('google_drive_url') ? 'true' : 'false' }};
            const hashTab = window.location.hash.replace('#', '');

            if (hasTaskFormError || hashTab === 'tugas') {
                activateTab('tugas');
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