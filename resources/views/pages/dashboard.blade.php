<x-layout>
    <x-navbar />
    <!-- MAIN CONTENT -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-12 py-8">
        <!-- GREETING SECTION -->
        <section class="mb-12">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">
                Hai, Jessica Tan! 👋
            </h1>
            <p class="text-lg text-gray-600">
                Waktunya Upgrade Skill Beauty Kamu!
            </p>
        </section>

        <!-- CONTINUE WATCHING SECTION -->
        <section class="mb-12">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Lanjutkan Menonton</h2>

            <div
                class="bg-white rounded-xl overflow-hidden shadow-md border border-pink-100 hover:shadow-lg transition">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-0">
                    <!-- Video Thumbnail -->
                    <div class="h-48 md:h-auto bg-gradient-to-br from-pink-400 to-pink-300 relative overflow-hidden">
                        <div class="absolute inset-0 flex items-center justify-center">
                            <button
                                class="w-16 h-16 bg-white rounded-full flex items-center justify-center hover:scale-110 transition shadow-lg">
                                <svg class="w-8 h-8 text-pink-500 ml-1" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M8 5v14l11-7z"></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="md:col-span-2 p-6 md:p-8 flex flex-col justify-between">
                        <div>
                            <p class="text-sm text-pink-600 font-medium mb-2">Makeup Dasar</p>
                            <h3 class="text-2xl font-bold text-gray-900 mb-2">
                                Teknik Foundation yang Sempurna
                            </h3>
                            <p class="text-gray-600 mb-4">
                                Pelajari cara mengaplikasikan foundation dengan sempurna sesuai dengan jenis kulit Anda
                            </p>

                            <!-- Progress Bar -->
                            <div class="mb-4">
                                <div class="flex justify-between items-center mb-2">
                                    <span class="text-sm text-gray-600">Progress</span>
                                    <span class="text-sm font-bold text-gray-900">65%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-pink-500 h-2 rounded-full" style="width: 65%"></div>
                                </div>
                            </div>
                        </div>

                        <button
                            class="px-6 py-3 bg-pink-500 text-white font-bold rounded-lg hover:bg-pink-600 transition w-full md:w-auto">
                            Lanjutkan Video
                        </button>
                    </div>
                </div>
            </div>
        </section>

        <!-- RECOMMENDATIONS SECTION -->
        <section class="mb-12">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Rekomendasi Untuk Anda</h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                <!-- Recommendation Card 1 -->
                <div
                    class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-lg transition border border-pink-100">
                    <!-- Thumbnail -->
                    <div class="relative h-40">
                        <img src="https://placehold.co/400x160/f9a8d4/ffffff?text=Makeup+Dasar" alt="Makeup Dasar"
                            class="w-full h-full object-cover">
                        <!-- Rating top-right -->
                        <div
                            class="absolute top-2 right-2 flex items-center gap-1 bg-white/80 backdrop-blur-sm px-2 py-1 rounded-full shadow-sm">
                            <svg class="w-3.5 h-3.5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                </path>
                            </svg>
                            <span class="text-xs font-bold text-gray-700">4.8</span>
                        </div>
                        <!-- Save button bottom-right -->
                        <button
                            class="absolute bottom-2 right-2 p-1.5 bg-white/80 backdrop-blur-sm rounded-full shadow-sm hover:bg-pink-50 transition">
                            <svg class="w-4 h-4 text-gray-500 hover:text-pink-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="p-4">
                        <h3 class="text-lg font-bold text-gray-900 mb-1">Makeup Dasar</h3>
                        <p class="text-sm text-pink-600 font-medium mb-2">Makeup</p>
                        <div class="flex items-center gap-1 text-gray-500 text-xs mb-3">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>8 Jam 30 Menit</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-xl font-bold text-pink-500">Rp 299K</span>
                            <button
                                class="px-3 py-1.5 bg-pink-500 text-white text-sm font-medium rounded-lg hover:bg-pink-600 transition">
                                Lihat Detail
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Recommendation Card 2 -->
                <div
                    class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-lg transition border border-pink-100">
                    <!-- Thumbnail -->
                    <div class="relative h-40">
                        <img src="https://placehold.co/400x160/f9a8d4/ffffff?text=Makeup+Dasar" alt="Makeup Dasar"
                            class="w-full h-full object-cover">
                        <!-- Rating top-right -->
                        <div
                            class="absolute top-2 right-2 flex items-center gap-1 bg-white/80 backdrop-blur-sm px-2 py-1 rounded-full shadow-sm">
                            <svg class="w-3.5 h-3.5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                </path>
                            </svg>
                            <span class="text-xs font-bold text-gray-700">4.8</span>
                        </div>
                        <!-- Save button bottom-right -->
                        <button
                            class="absolute bottom-2 right-2 p-1.5 bg-white/80 backdrop-blur-sm rounded-full shadow-sm hover:bg-pink-50 transition">
                            <svg class="w-4 h-4 text-gray-500 hover:text-pink-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="p-4">
                        <h3 class="text-lg font-bold text-gray-900 mb-1">Makeup Dasar</h3>
                        <p class="text-sm text-pink-600 font-medium mb-2">Makeup</p>
                        <div class="flex items-center gap-1 text-gray-500 text-xs mb-3">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>8 Jam 30 Menit</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-xl font-bold text-pink-500">Rp 299K</span>
                            <button
                                class="px-3 py-1.5 bg-pink-500 text-white text-sm font-medium rounded-lg hover:bg-pink-600 transition">
                                Lihat Detail
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Recommendation Card 3 -->
                <div
                    class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-lg transition border border-pink-100">
                    <!-- Thumbnail -->
                    <div class="relative h-40">
                        <img src="https://placehold.co/400x160/f9a8d4/ffffff?text=Makeup+Dasar" alt="Makeup Dasar"
                            class="w-full h-full object-cover">
                        <!-- Rating top-right -->
                        <div
                            class="absolute top-2 right-2 flex items-center gap-1 bg-white/80 backdrop-blur-sm px-2 py-1 rounded-full shadow-sm">
                            <svg class="w-3.5 h-3.5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                </path>
                            </svg>
                            <span class="text-xs font-bold text-gray-700">4.8</span>
                        </div>
                        <!-- Save button bottom-right -->
                        <button
                            class="absolute bottom-2 right-2 p-1.5 bg-white/80 backdrop-blur-sm rounded-full shadow-sm hover:bg-pink-50 transition">
                            <svg class="w-4 h-4 text-gray-500 hover:text-pink-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="p-4">
                        <h3 class="text-lg font-bold text-gray-900 mb-1">Makeup Dasar</h3>
                        <p class="text-sm text-pink-600 font-medium mb-2">Makeup</p>
                        <div class="flex items-center gap-1 text-gray-500 text-xs mb-3">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>8 Jam 30 Menit</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-xl font-bold text-pink-500">Rp 299K</span>
                            <button
                                class="px-3 py-1.5 bg-pink-500 text-white text-sm font-medium rounded-lg hover:bg-pink-600 transition">
                                Lihat Detail
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Recommendation Card 4 -->
                <div
                    class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-lg transition border border-pink-100">
                    <!-- Thumbnail -->
                    <div class="relative h-40">
                        <img src="https://placehold.co/400x160/f9a8d4/ffffff?text=Makeup+Dasar" alt="Makeup Dasar"
                            class="w-full h-full object-cover">
                        <!-- Rating top-right -->
                        <div
                            class="absolute top-2 right-2 flex items-center gap-1 bg-white/80 backdrop-blur-sm px-2 py-1 rounded-full shadow-sm">
                            <svg class="w-3.5 h-3.5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                </path>
                            </svg>
                            <span class="text-xs font-bold text-gray-700">4.8</span>
                        </div>
                        <!-- Save button bottom-right -->
                        <button
                            class="absolute bottom-2 right-2 p-1.5 bg-white/80 backdrop-blur-sm rounded-full shadow-sm hover:bg-pink-50 transition">
                            <svg class="w-4 h-4 text-gray-500 hover:text-pink-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="p-4">
                        <h3 class="text-lg font-bold text-gray-900 mb-1">Makeup Dasar</h3>
                        <p class="text-sm text-pink-600 font-medium mb-2">Makeup</p>
                        <div class="flex items-center gap-1 text-gray-500 text-xs mb-3">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>8 Jam 30 Menit</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-xl font-bold text-pink-500">Rp 299K</span>
                            <button
                                class="px-3 py-1.5 bg-pink-500 text-white text-sm font-medium rounded-lg hover:bg-pink-600 transition">
                                Lihat Detail
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ALL CLASSES SECTION -->
        <section>
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-900">Semua Kelas</h2>
                <a href="#" class="text-pink-500 font-medium hover:text-pink-600 transition flex items-center gap-2">
                    Lihat Semua
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                <!-- Class Card 1 -->
                <div
                    class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-lg transition border border-pink-100">
                    <!-- Thumbnail -->
                    <div class="relative h-40">
                        <img src="https://placehold.co/400x160/f9a8d4/ffffff?text=Makeup+Dasar" alt="Makeup Dasar"
                            class="w-full h-full object-cover">
                        <!-- Rating top-right -->
                        <div
                            class="absolute top-2 right-2 flex items-center gap-1 bg-white/80 backdrop-blur-sm px-2 py-1 rounded-full shadow-sm">
                            <svg class="w-3.5 h-3.5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                </path>
                            </svg>
                            <span class="text-xs font-bold text-gray-700">4.8</span>
                        </div>
                        <!-- Save button bottom-right -->
                        <button
                            class="absolute bottom-2 right-2 p-1.5 bg-white/80 backdrop-blur-sm rounded-full shadow-sm hover:bg-pink-50 transition">
                            <svg class="w-4 h-4 text-gray-500 hover:text-pink-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="p-4">
                        <h3 class="text-lg font-bold text-gray-900 mb-1">Makeup Dasar</h3>
                        <p class="text-sm text-pink-600 font-medium mb-2">Makeup</p>
                        <div class="flex items-center gap-1 text-gray-500 text-xs mb-3">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>8 Jam 30 Menit</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-xl font-bold text-pink-500">Rp 299K</span>
                            <button
                                class="px-3 py-1.5 bg-pink-500 text-white text-sm font-medium rounded-lg hover:bg-pink-600 transition">
                                Lihat Detail
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Class Card 2 -->
                <div
                    class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-lg transition border border-pink-100">
                    <!-- Thumbnail -->
                    <div class="relative h-40">
                        <img src="https://placehold.co/400x160/f9a8d4/ffffff?text=Makeup+Dasar" alt="Makeup Dasar"
                            class="w-full h-full object-cover">
                        <!-- Rating top-right -->
                        <div
                            class="absolute top-2 right-2 flex items-center gap-1 bg-white/80 backdrop-blur-sm px-2 py-1 rounded-full shadow-sm">
                            <svg class="w-3.5 h-3.5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                </path>
                            </svg>
                            <span class="text-xs font-bold text-gray-700">4.8</span>
                        </div>
                        <!-- Save button bottom-right -->
                        <button
                            class="absolute bottom-2 right-2 p-1.5 bg-white/80 backdrop-blur-sm rounded-full shadow-sm hover:bg-pink-50 transition">
                            <svg class="w-4 h-4 text-gray-500 hover:text-pink-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="p-4">
                        <h3 class="text-lg font-bold text-gray-900 mb-1">Makeup Dasar</h3>
                        <p class="text-sm text-pink-600 font-medium mb-2">Makeup</p>
                        <div class="flex items-center gap-1 text-gray-500 text-xs mb-3">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>8 Jam 30 Menit</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-xl font-bold text-pink-500">Rp 299K</span>
                            <button
                                class="px-3 py-1.5 bg-pink-500 text-white text-sm font-medium rounded-lg hover:bg-pink-600 transition">
                                Lihat Detail
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Class Card 3 -->
                <div
                    class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-lg transition border border-pink-100">
                    <!-- Thumbnail -->
                    <div class="relative h-40">
                        <img src="https://placehold.co/400x160/f9a8d4/ffffff?text=Makeup+Dasar" alt="Makeup Dasar"
                            class="w-full h-full object-cover">
                        <!-- Rating top-right -->
                        <div
                            class="absolute top-2 right-2 flex items-center gap-1 bg-white/80 backdrop-blur-sm px-2 py-1 rounded-full shadow-sm">
                            <svg class="w-3.5 h-3.5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                </path>
                            </svg>
                            <span class="text-xs font-bold text-gray-700">4.8</span>
                        </div>
                        <!-- Save button bottom-right -->
                        <button
                            class="absolute bottom-2 right-2 p-1.5 bg-white/80 backdrop-blur-sm rounded-full shadow-sm hover:bg-pink-50 transition">
                            <svg class="w-4 h-4 text-gray-500 hover:text-pink-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="p-4">
                        <h3 class="text-lg font-bold text-gray-900 mb-1">Makeup Dasar</h3>
                        <p class="text-sm text-pink-600 font-medium mb-2">Makeup</p>
                        <div class="flex items-center gap-1 text-gray-500 text-xs mb-3">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>8 Jam 30 Menit</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-xl font-bold text-pink-500">Rp 299K</span>
                            <button
                                class="px-3 py-1.5 bg-pink-500 text-white text-sm font-medium rounded-lg hover:bg-pink-600 transition">
                                Lihat Detail
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Class Card 4 -->
                <div
                    class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-lg transition border border-pink-100">
                    <!-- Thumbnail -->
                    <div class="relative h-40">
                        <img src="https://placehold.co/400x160/f9a8d4/ffffff?text=Makeup+Dasar" alt="Makeup Dasar"
                            class="w-full h-full object-cover">
                        <!-- Rating top-right -->
                        <div
                            class="absolute top-2 right-2 flex items-center gap-1 bg-white/80 backdrop-blur-sm px-2 py-1 rounded-full shadow-sm">
                            <svg class="w-3.5 h-3.5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                </path>
                            </svg>
                            <span class="text-xs font-bold text-gray-700">4.8</span>
                        </div>
                        <!-- Save button bottom-right -->
                        <button
                            class="absolute bottom-2 right-2 p-1.5 bg-white/80 backdrop-blur-sm rounded-full shadow-sm hover:bg-pink-50 transition">
                            <svg class="w-4 h-4 text-gray-500 hover:text-pink-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="p-4">
                        <h3 class="text-lg font-bold text-gray-900 mb-1">Makeup Dasar</h3>
                        <p class="text-sm text-pink-600 font-medium mb-2">Makeup</p>
                        <div class="flex items-center gap-1 text-gray-500 text-xs mb-3">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>8 Jam 30 Menit</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-xl font-bold text-pink-500">Rp 299K</span>
                            <button
                                class="px-3 py-1.5 bg-pink-500 text-white text-sm font-medium rounded-lg hover:bg-pink-600 transition">
                                Lihat Detail
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Load More Button -->
            <div class="text-center mt-8">
                <button
                    class="px-8 py-3 border-2 border-pink-500 text-pink-500 font-bold rounded-lg hover:bg-pink-50 transition">
                    Muat Lebih Banyak
                </button>
            </div>
        </section>
    </main>

    <!-- JAVASCRIPT -->
    <script>
        // Navbar dropdown toggle
        document.addEventListener('DOMContentLoaded', function () {
            // Smooth scroll behavior
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({ behavior: 'smooth' });
                    }
                });
            });
        });

        // Mobile menu toggle (if needed)
        function toggleMobileMenu() {
            const menu = document.getElementById('mobile-menu');
            if (menu) {
                menu.classList.toggle('hidden');
            }
        }
    </script>
    <x-footer />
</x-layout>