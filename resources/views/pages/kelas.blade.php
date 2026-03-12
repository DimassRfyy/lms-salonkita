<x-layout>
     <style>
        * {
            font-family: 'Nunito', sans-serif;
        }

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
    </style>
    <x-navbar />
    <!-- Back Button -->
    <div class="bg-gray-50 border-b border-gray-200 px-4 sm:px-6 lg:px-8 py-4">
        <div class="max-w-7xl mx-auto">
            <a href="dashboard.html"
                class="text-primary font-medium inline-flex items-center gap-2 hover:text-pink-700">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Kembali ke Dashboard
            </a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <!-- Video Section and Sidebar -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left: Video Player -->
                <div class="lg:col-span-2">
                    <!-- Video Player (YouTube Embed) -->
                    <div class="video-placeholder rounded-xl overflow-hidden mb-6">
                        <div class="relative w-full" style="padding-bottom: 56.25%;">
                            <iframe class="absolute inset-0 w-full h-full"
                                src="https://www.youtube.com/embed/RY3AvEGKfZ0?si=-dVHYnlwhyUzDdnS"
                                title="YouTube video player" frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                referrerpolicy="strict-origin-when-cross-origin" allowfullscreen>
                            </iframe>
                        </div>
                    </div>

                    <!-- Class Info -->
                    <div class="bg-white rounded-xl p-6 mb-6">
                        <h1 class="text-3xl font-bold text-gray-900 mb-4">Beauty Makeup Profesional untuk Pemula</h1>

                        <!-- Stats -->
                        <div class="flex flex-wrap gap-6 mb-6 text-gray-700">
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-primary" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm3.5-9c.83 0 1.5-.67 1.5-1.5S16.33 8 15.5 8 14 8.67 14 9.5s.67 1.5 1.5 1.5zm-7 0c.83 0 1.5-.67 1.5-1.5S9.33 8 8.5 8 7 8.67 7 9.5 7.67 11 8.5 11zm3.5 6.5c2.33 0 4.31-1.46 5.11-3.5H6.89c.8 2.04 2.78 3.5 5.11 3.5z">
                                    </path>
                                </svg>
                                <span>2,450 Siswa</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z">
                                    </path>
                                </svg>
                                <span>4.9 (1,240 ulasan)</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-primary" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M11 17h2v-4h-2v4zm1-9C6.48 8 2 11.58 2 16s4.48 8 10 8 10-3.58 10-8-4.48-8-10-8zm0-2c5.55 0 10-4.45 10-10S17.55 0 12 0 2 4.45 2 10s4.45 10 10 10z">
                                    </path>
                                </svg>
                                <span>12 Jam 30 Menit</span>
                            </div>
                        </div>

                        <!-- Tabs -->
                        <div class="border-b border-gray-200 mb-6">
                            <div class="flex gap-8">
                                <button class="btn-tab active pb-3 text-gray-900 font-medium"
                                    onclick="switchTab(event, 'tentang')">
                                    Tentang
                                </button>
                                <button class="btn-tab pb-3 text-gray-600 font-medium hover:text-gray-900"
                                    onclick="switchTab(event, 'tugas')">
                                    Tugas
                                </button>
                                <button class="btn-tab pb-3 text-gray-600 font-medium hover:text-gray-900"
                                    onclick="switchTab(event, 'ulasan')">
                                    Ulasan
                                </button>
                                <button class="btn-tab pb-3 text-gray-600 font-medium hover:text-gray-900"
                                    onclick="switchTab(event, 'diskusi')">
                                    Diskusi
                                </button>
                            </div>
                        </div>

                        <!-- Tab Content -->
                        <!-- Tab: Tentang -->
                        <div id="tentang" class="tab-content active">
                            <div class="text-gray-700 leading-relaxed">
                                <p class="text-gray-600 mb-4">Kelas ini dirancang untuk membantu Anda memahami fondasi
                                    makeup profesional secara bertahap, mulai dari persiapan kulit, pemilihan produk
                                    yang sesuai, hingga teknik aplikasi yang rapi dan tahan lama untuk berbagai
                                    kebutuhan sehari-hari maupun acara khusus.</p>
                                <h3 class="text-lg font-semibold text-gray-900 mb-3">Apa yang akan Anda pelajari?</h3>
                                <ul class="space-y-2 mb-6">
                                    <li class="flex gap-3">
                                        <svg class="w-5 h-5 text-primary flex-shrink-0 mt-0.5" fill="currentColor"
                                            viewBox="0 0 24 24">
                                            <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"></path>
                                        </svg>
                                        <span>Teknik makeup dasar untuk pemula</span>
                                    </li>
                                    <li class="flex gap-3">
                                        <svg class="w-5 h-5 text-primary flex-shrink-0 mt-0.5" fill="currentColor"
                                            viewBox="0 0 24 24">
                                            <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"></path>
                                        </svg>
                                        <span>Pemilihan produk makeup yang tepat untuk jenis kulit</span>
                                    </li>
                                    <li class="flex gap-3">
                                        <svg class="w-5 h-5 text-primary flex-shrink-0 mt-0.5" fill="currentColor"
                                            viewBox="0 0 24 24">
                                            <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"></path>
                                        </svg>
                                        <span>Makeup untuk acara special dan sehari-hari</span>
                                    </li>
                                    <li class="flex gap-3">
                                        <svg class="w-5 h-5 text-primary flex-shrink-0 mt-0.5" fill="currentColor"
                                            viewBox="0 0 24 24">
                                            <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"></path>
                                        </svg>
                                        <span>Tips dan trik dari makeup artist profesional</span>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <!-- Tab: Tugas -->
                        <div id="tugas" class="tab-content">
                            <div class="space-y-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Subjek Tugas</label>
                                    <input type="text" placeholder="Masukkan subjek tugas..."
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-pink-400">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Link Google
                                        Drive</label>
                                    <input type="url" placeholder="https://drive.google.com/..."
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-pink-400">
                                </div>
                                <button
                                    class="w-full bg-primary hover-primary text-white font-medium py-2.5 rounded-lg transition">
                                    Kirim Tugas
                                </button>
                            </div>
                        </div>

                        <!-- Tab: Ulasan -->
                        <div id="ulasan" class="tab-content">
                            <div class="space-y-4">
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <div class="flex items-start gap-3 mb-2">
                                        <img src="https://api.dicebear.com/7.x/avataaars/svg?seed=Sarah" alt="Avatar"
                                            class="w-10 h-10 rounded-full">
                                        <div class="flex-1">
                                            <h4 class="font-semibold text-gray-900">Sarah Wijaya</h4>
                                            <div class="flex gap-1 mb-2">
                                                <svg class="w-4 h-4 text-yellow-400" fill="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path
                                                        d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z">
                                                    </path>
                                                </svg>
                                                <svg class="w-4 h-4 text-yellow-400" fill="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path
                                                        d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z">
                                                    </path>
                                                </svg>
                                                <svg class="w-4 h-4 text-yellow-400" fill="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path
                                                        d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z">
                                                    </path>
                                                </svg>
                                                <svg class="w-4 h-4 text-yellow-400" fill="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path
                                                        d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z">
                                                    </path>
                                                </svg>
                                                <svg class="w-4 h-4 text-yellow-400" fill="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path
                                                        d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z">
                                                    </path>
                                                </svg>
                                            </div>
                                            <p class="text-gray-700">Kursus ini sangat membantu! Instruktur menjelaskan
                                                dengan detail dan mudah dipahami. Saya sudah bisa membuat makeup untuk
                                                berbagai acara.</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="bg-gray-50 rounded-lg p-4">
                                    <div class="flex items-start gap-3 mb-2">
                                        <img src="https://api.dicebear.com/7.x/avataaars/svg?seed=Dina" alt="Avatar"
                                            class="w-10 h-10 rounded-full">
                                        <div class="flex-1">
                                            <h4 class="font-semibold text-gray-900">Dina Kartika</h4>
                                            <div class="flex gap-1 mb-2">
                                                <svg class="w-4 h-4 text-yellow-400" fill="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path
                                                        d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z">
                                                    </path>
                                                </svg>
                                                <svg class="w-4 h-4 text-yellow-400" fill="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path
                                                        d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z">
                                                    </path>
                                                </svg>
                                                <svg class="w-4 h-4 text-yellow-400" fill="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path
                                                        d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z">
                                                    </path>
                                                </svg>
                                                <svg class="w-4 h-4 text-yellow-400" fill="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path
                                                        d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z">
                                                    </path>
                                                </svg>
                                                <svg class="w-4 h-4 text-gray-300" fill="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path
                                                        d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z">
                                                    </path>
                                                </svg>
                                            </div>
                                            <p class="text-gray-700">Sangat merekomendasikan! Harganya terjangkau dan
                                                materi sangat berkualitas. Sudah ada hasil nyata dalam pekerjaan saya.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tab: Diskusi -->
                        <div id="diskusi" class="tab-content">
                            <div class="space-y-4">
                                <div class="flex gap-3">
                                    <img src="https://api.dicebear.com/7.x/avataaars/svg?seed=Jessica" alt="Avatar"
                                        class="w-10 h-10 rounded-full flex-shrink-0">
                                    <div class="flex-1">
                                        <textarea placeholder="Tulis pertanyaan atau komentar..." rows="3"
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-pink-400"></textarea>
                                        <button
                                            class="mt-2 bg-primary hover-primary text-white font-medium px-6 py-2 rounded-lg">Kirim</button>
                                    </div>
                                </div>

                                <div class="bg-gray-50 rounded-lg p-4 mt-6">
                                    <div class="flex gap-3">
                                        <img src="https://api.dicebear.com/7.x/avataaars/svg?seed=Budi" alt="Avatar"
                                            class="w-10 h-10 rounded-full flex-shrink-0">
                                        <div class="flex-1">
                                            <div class="flex justify-between items-start">
                                                <div>
                                                    <h4 class="font-semibold text-gray-900">Budi Santoso</h4>
                                                    <p class="text-sm text-gray-500">2 hari yang lalu</p>
                                                </div>
                                            </div>
                                            <p class="text-gray-700 mt-2">Apakah ada rekomendasi brand makeup yang
                                                terjangkau tapi berkualitas untuk pemula?</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="bg-gray-50 rounded-lg p-4">
                                    <div class="flex gap-3">
                                        <img src="https://api.dicebear.com/7.x/avataaars/svg?seed=Mentor" alt="Avatar"
                                            class="w-10 h-10 rounded-full flex-shrink-0">
                                        <div class="flex-1">
                                            <div class="flex justify-between items-start">
                                                <div>
                                                    <h4 class="font-semibold text-gray-900">Mentor Kelas</h4>
                                                    <p class="text-sm text-gray-500">1 hari yang lalu</p>
                                                </div>
                                                <span
                                                    class="bg-primary text-white text-xs px-2 py-1 rounded">Mentor</span>
                                            </div>
                                            <p class="text-gray-700 mt-2">Halo Budi! Saya merekomendasikan Wardah,
                                                Emina, atau Implora. Produk lokal dengan harga terjangkau dan sudah
                                                teruji. Coba dulu di toko untuk melihat shade yang cocok dengan kulit
                                                Anda.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right: Course Sidebar -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-xl p-6 sticky top-24">
                        <h2 class="text-lg font-bold text-gray-900 mb-4">Daftar Kelas</h2>

                        <!-- Course List -->
                        <div class="space-y-3 max-h-96 overflow-y-auto">
                            <!-- Module 1 -->
                            <div class="border border-gray-200 rounded-lg">
                                <button
                                    class="w-full px-4 py-3 flex justify-between items-center hover:bg-gray-50 font-medium text-gray-900"
                                    onclick="toggleDropdown(this)">
                                    <span>Persiapan Awal</span>
                                    <svg class="w-5 h-5 transform transition-transform duration-300" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                                    </svg>
                                </button>
                                <div class="dropdown-content bg-gray-50">
                                    <a href="#"
                                        class="block px-6 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-primary">
                                        <svg class="w-4 h-4 inline mr-2" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M8 5v14l11-7z"></path>
                                        </svg>
                                        Pengenalan Salonkita
                                    </a>
                                    <a href="#"
                                        class="block px-6 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-primary">
                                        <svg class="w-4 h-4 inline mr-2" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M8 5v14l11-7z"></path>
                                        </svg>
                                        Tools dan Alat Makeup
                                    </a>
                                    <a href="#"
                                        class="block px-6 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-primary">
                                        <svg class="w-4 h-4 inline mr-2" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M8 5v14l11-7z"></path>
                                        </svg>
                                        Analisis Jenis Kulit
                                    </a>
                                    <a href="#"
                                        class="block px-6 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-primary">
                                        <svg class="w-4 h-4 inline mr-2" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M8 5v14l11-7z"></path>
                                        </svg>
                                        Skincare Sebelum Makeup
                                    </a>
                                    <a href="#"
                                        class="block px-6 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-primary">
                                        <svg class="w-4 h-4 inline mr-2" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M8 5v14l11-7z"></path>
                                        </svg>
                                        Persiapan Makeup Lengkap
                                    </a>
                                    <a href="#"
                                        class="block px-6 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-primary">
                                        <svg class="w-4 h-4 inline mr-2" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M8 5v14l11-7z"></path>
                                        </svg>
                                        Quiz: Persiapan Awal
                                    </a>
                                </div>
                            </div>

                            <!-- Module 2 -->
                            <div class="border border-gray-200 rounded-lg">
                                <button
                                    class="w-full px-4 py-3 flex justify-between items-center hover:bg-gray-50 font-medium text-gray-900"
                                    onclick="toggleDropdown(this)">
                                    <span>Teknik Dasar Makeup</span>
                                    <svg class="w-5 h-5 transform transition-transform duration-300" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                                    </svg>
                                </button>
                                <div class="dropdown-content bg-gray-50">
                                    <a href="#"
                                        class="block px-6 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-primary">
                                        <svg class="w-4 h-4 inline mr-2" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M8 5v14l11-7z"></path>
                                        </svg>
                                        Foundation Base Perfect
                                    </a>
                                    <a href="#"
                                        class="block px-6 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-primary">
                                        <svg class="w-4 h-4 inline mr-2" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M8 5v14l11-7z"></path>
                                        </svg>
                                        Kontur dan Highlight
                                    </a>
                                    <a href="#"
                                        class="block px-6 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-primary">
                                        <svg class="w-4 h-4 inline mr-2" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M8 5v14l11-7z"></path>
                                        </svg>
                                        Blush dan Bronzer
                                    </a>
                                    <a href="#"
                                        class="block px-6 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-primary">
                                        <svg class="w-4 h-4 inline mr-2" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M8 5v14l11-7z"></path>
                                        </svg>
                                        Eye Shadow Basics
                                    </a>
                                </div>
                            </div>

                            <!-- Module 3 -->
                            <div class="border border-gray-200 rounded-lg">
                                <button
                                    class="w-full px-4 py-3 flex justify-between items-center hover:bg-gray-50 font-medium text-gray-900"
                                    onclick="toggleDropdown(this)">
                                    <span>Makeup Mata Profesional</span>
                                    <svg class="w-5 h-5 transform transition-transform duration-300" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                                    </svg>
                                </button>
                                <div class="dropdown-content bg-gray-50">
                                    <a href="#"
                                        class="block px-6 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-primary">
                                        <svg class="w-4 h-4 inline mr-2" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M8 5v14l11-7z"></path>
                                        </svg>
                                        Eyeliner Techniques
                                    </a>
                                    <a href="#"
                                        class="block px-6 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-primary">
                                        <svg class="w-4 h-4 inline mr-2" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M8 5v14l11-7z"></path>
                                        </svg>
                                        Mascara dan Brow
                                    </a>
                                    <a href="#"
                                        class="block px-6 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-primary">
                                        <svg class="w-4 h-4 inline mr-2" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M8 5v14l11-7z"></path>
                                        </svg>
                                        False Lashes Application
                                    </a>
                                </div>
                            </div>

                            <!-- Module 4 -->
                            <div class="border border-gray-200 rounded-lg">
                                <button
                                    class="w-full px-4 py-3 flex justify-between items-center hover:bg-gray-50 font-medium text-gray-900"
                                    onclick="toggleDropdown(this)">
                                    <span>Makeup untuk Berbagai Acara</span>
                                    <svg class="w-5 h-5 transform transition-transform duration-300" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                                    </svg>
                                </button>
                                <div class="dropdown-content bg-gray-50">
                                    <a href="#"
                                        class="block px-6 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-primary">
                                        <svg class="w-4 h-4 inline mr-2" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M8 5v14l11-7z"></path>
                                        </svg>
                                        Makeup Sehari-hari
                                    </a>
                                    <a href="#"
                                        class="block px-6 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-primary">
                                        <svg class="w-4 h-4 inline mr-2" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M8 5v14l11-7z"></path>
                                        </svg>
                                        Makeup untuk Pernikahan
                                    </a>
                                    <a href="#"
                                        class="block px-6 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-primary">
                                        <svg class="w-4 h-4 inline mr-2" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M8 5v14l11-7z"></path>
                                        </svg>
                                        Makeup untuk Pesta
                                    </a>
                                    <a href="#"
                                        class="block px-6 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-primary">
                                        <svg class="w-4 h-4 inline mr-2" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M8 5v14l11-7z"></path>
                                        </svg>
                                        Makeup untuk Photoshoot
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Enroll Button -->
                        <button class="w-full bg-primary hover-primary text-white font-bold py-3 rounded-lg mt-6">
                            Daftar Kelas - Rp 499.000
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-footer />
    <script>
        // Toggle Dropdown
        function toggleDropdown(button) {
            const dropdown = button.nextElementSibling;
            const svg = button.querySelector('svg');

            // Close other dropdowns
            document.querySelectorAll('.dropdown-content.active').forEach(el => {
                if (el !== dropdown) {
                    el.classList.remove('active');
                    el.previousElementSibling.querySelector('svg').style.transform = 'rotate(0deg)';
                }
            });

            dropdown.classList.toggle('active');
            if (dropdown.classList.contains('active')) {
                svg.style.transform = 'rotate(180deg)';
            } else {
                svg.style.transform = 'rotate(0deg)';
            }
        }

        // Switch Tabs
        function switchTab(event, tabName) {
            event.preventDefault();

            // Hide all tab contents
            document.querySelectorAll('.tab-content').forEach(el => {
                el.classList.remove('active');
            });

            // Remove active class from all buttons
            document.querySelectorAll('.btn-tab').forEach(btn => {
                btn.classList.remove('active');
            });

            // Show selected tab
            document.getElementById(tabName).classList.add('active');
            event.target.classList.add('active');
        }

        // Open first dropdown by default
        window.addEventListener('load', () => {
            const firstButton = document.querySelector('.dropdown-content').previousElementSibling;
            firstButton.click();
        });
    </script>
</x-layout>