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
            padding: 0.5rem 1rem 0.5rem 1.5rem;
            text-decoration: none;
            transition: background 0.15s;
        }

        .video-item:hover {
            background-color: #f3f4f6;
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
            color: #9ca3af;
        }

        .video-item.now-playing {
            background-color: #fdf2f8;
            border-left: 3px solid #ec4899;
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
        }

        .video-item.now-playing .video-duration {
            color: #f472b6;
        }

        .video-item.locked {
            color: #9ca3af;
            background-color: #f9fafb;
            cursor: not-allowed;
        }

        .video-item.locked .video-icon {
            color: #9ca3af;
        }

        .section-header {
            width: 100%;
            padding: 0.75rem 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .section-header .section-info {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            gap: 0.1rem;
        }

        .section-header .section-count {
            font-size: 0.7rem;
            color: #9ca3af;
            font-weight: 400;
        }
    </style>

    <x-navbar />

    <div class="bg-gray-50 border-b border-gray-200 px-4 sm:px-6 lg:px-8 py-4">
        <div class="max-w-7xl mx-auto">
            <a href="{{ route('dashboard') }}" class="text-primary font-medium inline-flex items-center gap-2 hover:text-pink-700">
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
                            <iframe class="absolute inset-0 w-full h-full" src="{{ $embedUrl ?? 'https://www.youtube.com/embed/dQw4w9WgXcQ' }}"
                                title="{{ $currentVideo?->title ?? $course->name }}" frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                referrerpolicy="strict-origin-when-cross-origin" allowfullscreen>
                            </iframe>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl p-6 mb-6">
                        <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $course->name }}</h1>

                        <div class="flex flex-wrap gap-6 mb-6 text-gray-700">
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"></path>
                                </svg>
                                <span>{{ $averageRating }} ({{ $course->reviews->count() }} ulasan) &bull; {{ number_format($studentsCount, 0, ',', '.') }} siswa</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-primary" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 8a1 1 0 011 1v3.38l2.45 1.42a1 1 0 11-1 1.74l-2.95-1.7A1 1 0 0111 13V9a1 1 0 011-1zm0-6a10 10 0 100 20 10 10 0 000-20z"></path>
                                </svg>
                                <span>{{ $course->duration_label }}</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-primary" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M4 6a2 2 0 012-2h12a2 2 0 012 2v9a2 2 0 01-2 2H9l-5 4V6zm4 3a1 1 0 100 2h8a1 1 0 100-2H8zm0 4a1 1 0 100 2h5a1 1 0 100-2H8z"></path>
                                </svg>
                                <span>{{ $course->sections->count() }} section</span>
                            </div>
                        </div>

                        <div class="border-b border-gray-200 mb-6">
                            <div class="flex gap-8">
                                <button class="btn-tab active pb-3 text-gray-900 font-medium" onclick="switchTab(event, 'tentang')">Tentang</button>
                                <button class="btn-tab pb-3 text-gray-600 font-medium hover:text-gray-900" onclick="switchTab(event, 'tugas')">Tugas</button>
                                <button class="btn-tab pb-3 text-gray-600 font-medium hover:text-gray-900" onclick="switchTab(event, 'ulasan')">Ulasan</button>
                                <button class="btn-tab pb-3 text-gray-600 font-medium hover:text-gray-900" onclick="switchTab(event, 'diskusi')">Diskusi</button>
                            </div>
                        </div>

                        <div id="tentang" class="tab-content active">
                            <div class="text-gray-700 leading-relaxed">
                                <p class="text-gray-600 mb-4">{{ $course->description ?: 'Deskripsi kelas belum tersedia.' }}</p>
                                <h3 class="text-lg font-semibold text-gray-900 mb-3">Apa yang akan Anda pelajari?</h3>
                                <ul class="space-y-2 mb-6">
                                    @forelse($course->keypoints as $keypoint)
                                        <li class="flex gap-3">
                                            <svg class="w-5 h-5 text-primary shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 24 24">
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
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Subjek Tugas</label>
                                    <input type="text" placeholder="Masukkan subjek tugas..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-pink-400">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Link Google Drive</label>
                                    <input type="url" placeholder="https://drive.google.com/..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-pink-400">
                                </div>
                                <button class="w-full bg-primary hover-primary text-white font-medium py-2.5 rounded-lg transition">Kirim Tugas</button>
                            </div>
                        </div>

                        <div id="ulasan" class="tab-content">
                            <div class="space-y-4">
                                @forelse($course->reviews->take(6) as $review)
                                    <div class="bg-gray-50 rounded-lg p-4">
                                        <div class="flex items-start gap-3 mb-2">
                                            <img src="https://api.dicebear.com/7.x/avataaars/svg?seed={{ urlencode($review->student?->name ?? 'Student') }}" alt="Avatar" class="w-10 h-10 rounded-full">
                                            <div class="flex-1">
                                                <h4 class="font-semibold text-gray-900">{{ $review->student?->name ?? 'Student' }}</h4>
                                                <div class="flex gap-1 mb-2">
                                                    @for($star = 1; $star <= 5; $star++)
                                                        <svg class="w-4 h-4 {{ $star <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 24 24">
                                                            <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"></path>
                                                        </svg>
                                                    @endfor
                                                </div>
                                                <p class="text-gray-700">{{ $review->review ?: 'Siswa memberikan rating tanpa komentar.' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="bg-gray-50 rounded-lg p-4 text-gray-500">Belum ada ulasan untuk kelas ini.</div>
                                @endforelse
                            </div>
                        </div>

                        <div id="diskusi" class="tab-content">
                            <div class="space-y-4">
                                <div class="flex gap-3">
                                    <img src="https://api.dicebear.com/7.x/avataaars/svg?seed=Student" alt="Avatar" class="w-10 h-10 rounded-full shrink-0">
                                    <div class="flex-1">
                                        <textarea placeholder="Tulis pertanyaan atau komentar..." rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-pink-400"></textarea>
                                        <button class="mt-2 bg-primary hover-primary text-white font-medium px-6 py-2 rounded-lg">Kirim</button>
                                    </div>
                                </div>

                                @forelse($course->discussions->take(6) as $discussion)
                                    <div class="bg-gray-50 rounded-lg p-4">
                                        <div class="flex gap-3">
                                            <img src="https://api.dicebear.com/7.x/avataaars/svg?seed={{ urlencode($discussion->student?->name ?? 'User') }}" alt="Avatar" class="w-10 h-10 rounded-full shrink-0">
                                            <div class="flex-1">
                                                <div class="flex justify-between items-start gap-3">
                                                    <div>
                                                        <h4 class="font-semibold text-gray-900">{{ $discussion->student?->name ?? 'Student' }}</h4>
                                                        <p class="text-sm text-gray-500">{{ $discussion->created_at?->diffForHumans() }}</p>
                                                    </div>
                                                    @if($discussion->student && $discussion->student->id === $course->user_id)
                                                        <span class="bg-primary text-white text-xs px-2 py-1 rounded">Mentor</span>
                                                    @endif
                                                </div>
                                                <p class="text-gray-700 mt-2">{{ $discussion->message }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="bg-gray-50 rounded-lg p-4 text-gray-500">Belum ada diskusi di kelas ini.</div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-1">
                    <div class="bg-white rounded-xl p-6 sticky top-24">
                        <h2 class="text-lg font-bold text-gray-900 mb-4">Daftar Kelas</h2>

                        @if(! $hasCourseAccess)
                            <div class="mb-4 bg-amber-50 border border-amber-200 text-amber-700 text-sm rounded-lg px-3 py-2 flex items-start gap-2">
                                <svg class="w-4 h-4 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                                <span>Video materi masih terkunci. Kamu hanya bisa menonton video perkenalan sampai membeli kelas ini.</span>
                            </div>
                        @endif

                        <div class="space-y-3 max-h-96 overflow-y-auto pr-1">
                            @forelse($courseSections as $section)

                                <div class="border border-gray-200 rounded-lg overflow-hidden">
                                    <button class="section-header w-full hover:bg-gray-50 font-medium text-gray-900" onclick="toggleDropdown(this)">
                                        <div class="section-info">
                                            <span>{{ $section->title }}</span>
                                            <span class="section-count">{{ $section->videos_count }} video &bull; {{ $section->duration_label }}</span>
                                        </div>
                                        <svg class="w-5 h-5 transform transition-transform duration-300 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="transform: rotate({{ $section->has_current_video ? '180deg' : '0deg' }});">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                                        </svg>
                                    </button>

                                    <div class="dropdown-content bg-gray-50 {{ $section->has_current_video ? 'active' : '' }}">
                                        @foreach($section->videos as $video)
                                            @if($video->is_locked)
                                                <div class="video-item locked">
                                                    <svg class="video-icon w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                                    </svg>
                                                    <span class="video-title">{{ $video->title }}</span>
                                                    <span class="video-duration">Terkunci</span>
                                                </div>
                                            @else
                                                <a href="{{ $video->url }}" class="video-item {{ $video->state_class }}">
                                                    @if($video->is_watched)
                                                        <svg class="video-icon w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 24 24">
                                                            <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"></path>
                                                        </svg>
                                                    @else
                                                        <svg class="video-icon w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 24 24">
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

                        @if(! $hasCourseAccess)
                            <a href="{{ route('transaction', ['course' => $course->slug]) }}" class="block w-full text-center bg-primary hover-primary text-white font-bold py-3 rounded-lg mt-6">
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

            document.querySelectorAll('.tab-content').forEach(el => {
                el.classList.remove('active');
            });

            document.querySelectorAll('.btn-tab').forEach(btn => {
                btn.classList.remove('active');
            });

            document.getElementById(tabName).classList.add('active');
            event.target.classList.add('active');
        }

        window.addEventListener('load', () => {
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
