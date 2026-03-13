<x-layout>
    <x-navbar />
    <!-- MAIN CONTENT -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-12 py-8">
        <!-- GREETING SECTION -->
        <section class="mb-12">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">
                Semua Kelas
            </h1>
            <p class="text-lg text-gray-600">
                Jelajahi semua kelas yang tersedia dan temukan yang cocok untuk Anda!
            </p>
        </section>

        <!-- SEARCH + RESULT INFO (UI ONLY) -->
        <section class="mb-8">
            <div class="bg-white border border-pink-100 rounded-2xl p-4 md:p-5 shadow-sm">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div class="w-full md:max-w-md relative">
                        <input type="text" placeholder="Cari nama kelas, kategori, atau instruktur..."
                            class="w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-200 text-gray-900 rounded-xl focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-pink-300 focus:bg-white transition">
                        <svg class="w-5 h-5 text-gray-400 absolute left-3.5 top-1/2 -translate-y-1/2" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-4.35-4.35m1.85-5.15a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <p class="text-sm md:text-base text-gray-600">
                        Menampilkan <span class="font-semibold text-pink-600">8</span> dari <span
                            class="font-semibold text-pink-600">8</span> kelas
                    </p>
                </div>
            </div>
        </section>

        <!-- RECOMMENDATIONS SECTION -->
        <section class="mb-12">

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
    </main>

    <x-footer />

    <!-- JAVASCRIPT -->
    <script>
        // Smooth interactions and mobile menu
        document.addEventListener('DOMContentLoaded', function () {
            console.log('[v0] Dashboard loaded successfully');
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', function (event) {
            const navbar = document.querySelector('nav');
            if (!navbar.contains(event.target)) {
                // Add any additional dropdown close logic here if needed
            }
        });
    </script>
</x-layout>