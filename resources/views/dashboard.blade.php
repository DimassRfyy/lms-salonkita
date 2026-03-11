<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Salonkita</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Arimo:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Arimo', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- NAVBAR -->
    <nav class="sticky top-0 z-50 bg-white border-b border-pink-100 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 bg-pink-500 rounded-lg flex items-center justify-center">
                            <span class="text-white font-bold text-lg">S</span>
                        </div>
                        <span class="text-xl font-bold text-gray-800">Salonkita</span>
                    </div>
                </div>

                <!-- Search Bar -->
                <div class="hidden md:flex flex-1 max-w-xs mx-8">
                    <div class="w-full relative">
                        <input type="text" placeholder="Cari kelas..." class="w-full px-4 py-2 bg-gray-100 text-gray-900 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:bg-white transition">
                        <svg class="w-5 h-5 text-gray-400 absolute right-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>

                <!-- Right Side Menu -->
                <div class="flex items-center gap-4">
                    <!-- Mobile Search -->
                    <button class="md:hidden p-2">
                        <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </button>

                    <!-- Profile Dropdown -->
                    <div class="relative group">
                        <button class="flex items-center gap-2 p-2 hover:bg-pink-50 rounded-lg transition">
                            <div class="w-8 h-8 bg-gradient-to-br from-pink-400 to-pink-300 rounded-full flex items-center justify-center text-white font-bold text-sm">
                                JT
                            </div>
                            <span class="hidden sm:inline text-sm font-medium text-gray-700">Jessica Tan</span>
                            <svg class="w-4 h-4 text-gray-500 group-hover:text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                            </svg>
                        </button>
                        <div class="hidden group-hover:block absolute right-0 mt-2 w-48 bg-white border border-pink-200 rounded-lg shadow-lg overflow-hidden">
                            <a href="#" class="block px-4 py-3 text-gray-700 hover:bg-pink-50 flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Profile
                            </a>
                            <a href="#" class="block px-4 py-3 text-gray-700 hover:bg-pink-50 flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C6.5 6.253 2 10.998 2 17s4.5 10.747 10 10.747c5.5 0 10-4.998 10-10.747S17.5 6.253 12 6.253z"></path>
                                </svg>
                                Kelas
                            </a>
                            <a href="#" class="block px-4 py-3 text-gray-700 hover:bg-pink-50 flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                                </svg>
                                Pencapaian
                            </a>
                            <a href="#" class="block px-4 py-3 text-gray-700 hover:bg-pink-50 flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Tugas
                            </a>
                            <a href="#" class="block px-4 py-3 text-gray-700 hover:bg-pink-50 flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h6a2 2 0 012 2v12a2 2 0 01-2 2H7a2 2 0 01-2-2V5z"></path>
                                </svg>
                                Kelas Tersimpan
                            </a>
                            <div class="border-t border-pink-200"></div>
                            <a href="#" class="block px-4 py-3 text-gray-700 hover:bg-pink-50 flex items-center gap-2 font-medium text-red-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                </svg>
                                Logout
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- MAIN CONTENT -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
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
            
            <div class="bg-white rounded-xl overflow-hidden shadow-md border border-pink-100 hover:shadow-lg transition">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-0">
                    <!-- Video Thumbnail -->
                    <div class="h-48 md:h-auto bg-gradient-to-br from-pink-400 to-pink-300 relative overflow-hidden">
                        <div class="absolute inset-0 flex items-center justify-center">
                            <button class="w-16 h-16 bg-white rounded-full flex items-center justify-center hover:scale-110 transition shadow-lg">
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

                        <button class="px-6 py-3 bg-pink-500 text-white font-bold rounded-lg hover:bg-pink-600 transition w-full md:w-auto">
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
                <div class="bg-white rounded-xl overflow-hidden shadow-md border border-pink-100 hover:shadow-lg transition group">
                    <div class="h-40 bg-gradient-to-br from-pink-400 to-pink-300 relative overflow-hidden">
                        <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition bg-black bg-opacity-30">
                            <button class="w-12 h-12 bg-white rounded-full flex items-center justify-center hover:scale-110 transition">
                                <svg class="w-6 h-6 text-pink-500 ml-1" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M8 5v14l11-7z"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div class="p-4">
                        <p class="text-xs text-pink-600 font-medium mb-1">Makeup</p>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Eyeshadow Blending</h3>
                        <p class="text-sm text-gray-600 mb-4">Belajar teknik blending eyeshadow profesional</p>
                        <div class="flex items-center justify-between">
                            <span class="text-lg font-bold text-pink-500">Rp 199K</span>
                            <button class="p-2 hover:bg-pink-50 rounded-lg transition">
                                <svg class="w-6 h-6 text-gray-400 hover:text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h6a2 2 0 012 2v12a2 2 0 01-2 2H7a2 2 0 01-2-2V5z"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Recommendation Card 2 -->
                <div class="bg-white rounded-xl overflow-hidden shadow-md border border-pink-100 hover:shadow-lg transition group">
                    <div class="h-40 bg-gradient-to-br from-purple-400 to-purple-300 relative overflow-hidden">
                        <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition bg-black bg-opacity-30">
                            <button class="w-12 h-12 bg-white rounded-full flex items-center justify-center hover:scale-110 transition">
                                <svg class="w-6 h-6 text-purple-500 ml-1" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M8 5v14l11-7z"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div class="p-4">
                        <p class="text-xs text-purple-600 font-medium mb-1">Nail Art</p>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">French Ombre Nails</h3>
                        <p class="text-sm text-gray-600 mb-4">Master teknik ombre nails yang elegan</p>
                        <div class="flex items-center justify-between">
                            <span class="text-lg font-bold text-pink-500">Rp 149K</span>
                            <button class="p-2 hover:bg-pink-50 rounded-lg transition">
                                <svg class="w-6 h-6 text-gray-400 hover:text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h6a2 2 0 012 2v12a2 2 0 01-2 2H7a2 2 0 01-2-2V5z"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Recommendation Card 3 -->
                <div class="bg-white rounded-xl overflow-hidden shadow-md border border-pink-100 hover:shadow-lg transition group">
                    <div class="h-40 bg-gradient-to-br from-red-400 to-red-300 relative overflow-hidden">
                        <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition bg-black bg-opacity-30">
                            <button class="w-12 h-12 bg-white rounded-full flex items-center justify-center hover:scale-110 transition">
                                <svg class="w-6 h-6 text-red-500 ml-1" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M8 5v14l11-7z"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div class="p-4">
                        <p class="text-xs text-red-600 font-medium mb-1">Hair Care</p>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Keratin Treatment</h3>
                        <p class="text-sm text-gray-600 mb-4">Teknik perawatan rambut dengan keratin</p>
                        <div class="flex items-center justify-between">
                            <span class="text-lg font-bold text-pink-500">Rp 249K</span>
                            <button class="p-2 hover:bg-pink-50 rounded-lg transition">
                                <svg class="w-6 h-6 text-gray-400 hover:text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h6a2 2 0 012 2v12a2 2 0 01-2 2H7a2 2 0 01-2-2V5z"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Recommendation Card 4 -->
                <div class="bg-white rounded-xl overflow-hidden shadow-md border border-pink-100 hover:shadow-lg transition group">
                    <div class="h-40 bg-gradient-to-br from-cyan-400 to-blue-300 relative overflow-hidden">
                        <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition bg-black bg-opacity-30">
                            <button class="w-12 h-12 bg-white rounded-full flex items-center justify-center hover:scale-110 transition">
                                <svg class="w-6 h-6 text-blue-500 ml-1" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M8 5v14l11-7z"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div class="p-4">
                        <p class="text-xs text-blue-600 font-medium mb-1">Skincare</p>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Acne Treatment</h3>
                        <p class="text-sm text-gray-600 mb-4">Solusi lengkap perawatan kulit berjerawat</p>
                        <div class="flex items-center justify-between">
                            <span class="text-lg font-bold text-pink-500">Rp 199K</span>
                            <button class="p-2 hover:bg-pink-50 rounded-lg transition">
                                <svg class="w-6 h-6 text-gray-400 hover:text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h6a2 2 0 012 2v12a2 2 0 01-2 2H7a2 2 0 01-2-2V5z"></path>
                                </svg>
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
                <div class="bg-white rounded-xl overflow-hidden shadow-md border border-pink-100 hover:shadow-lg transition group">
                    <div class="h-40 bg-gradient-to-br from-pink-400 to-pink-300 relative overflow-hidden">
                        <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition bg-black bg-opacity-30">
                            <button class="w-12 h-12 bg-white rounded-full flex items-center justify-center hover:scale-110 transition">
                                <svg class="w-6 h-6 text-pink-500 ml-1" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M8 5v14l11-7z"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div class="p-4">
                        <p class="text-xs text-pink-600 font-medium mb-1">Makeup</p>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Makeup Dasar</h3>
                        <p class="text-sm text-gray-600 mb-4">Pelajari fundamental makeup</p>
                        <div class="flex items-center justify-between">
                            <span class="text-lg font-bold text-pink-500">Rp 299K</span>
                            <button class="p-2 hover:bg-pink-50 rounded-lg transition">
                                <svg class="w-6 h-6 text-gray-400 hover:text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h6a2 2 0 012 2v12a2 2 0 01-2 2H7a2 2 0 01-2-2V5z"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Class Card 2 -->
                <div class="bg-white rounded-xl overflow-hidden shadow-md border border-pink-100 hover:shadow-lg transition group">
                    <div class="h-40 bg-gradient-to-br from-purple-400 to-purple-300 relative overflow-hidden">
                        <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition bg-black bg-opacity-30">
                            <button class="w-12 h-12 bg-white rounded-full flex items-center justify-center hover:scale-110 transition">
                                <svg class="w-6 h-6 text-purple-500 ml-1" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M8 5v14l11-7z"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div class="p-4">
                        <p class="text-xs text-purple-600 font-medium mb-1">Nail Art</p>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Nail Art Profesional</h3>
                        <p class="text-sm text-gray-600 mb-4">Master nail art technique</p>
                        <div class="flex items-center justify-between">
                            <span class="text-lg font-bold text-pink-500">Rp 249K</span>
                            <button class="p-2 hover:bg-pink-50 rounded-lg transition">
                                <svg class="w-6 h-6 text-gray-400 hover:text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h6a2 2 0 012 2v12a2 2 0 01-2 2H7a2 2 0 01-2-2V5z"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Class Card 3 -->
                <div class="bg-white rounded-xl overflow-hidden shadow-md border border-pink-100 hover:shadow-lg transition group">
                    <div class="h-40 bg-gradient-to-br from-red-400 to-red-300 relative overflow-hidden">
                        <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition bg-black bg-opacity-30">
                            <button class="w-12 h-12 bg-white rounded-full flex items-center justify-center hover:scale-110 transition">
                                <svg class="w-6 h-6 text-red-500 ml-1" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M8 5v14l11-7z"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div class="p-4">
                        <p class="text-xs text-red-600 font-medium mb-1">Hair Care</p>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Hair Styling Advanced</h3>
                        <p class="text-sm text-gray-600 mb-4">Advanced hair styling course</p>
                        <div class="flex items-center justify-between">
                            <span class="text-lg font-bold text-pink-500">Rp 399K</span>
                            <button class="p-2 hover:bg-pink-50 rounded-lg transition">
                                <svg class="w-6 h-6 text-gray-400 hover:text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h6a2 2 0 012 2v12a2 2 0 01-2 2H7a2 2 0 01-2-2V5z"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Class Card 4 -->
                <div class="bg-white rounded-xl overflow-hidden shadow-md border border-pink-100 hover:shadow-lg transition group">
                    <div class="h-40 bg-gradient-to-br from-cyan-400 to-blue-300 relative overflow-hidden">
                        <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition bg-black bg-opacity-30">
                            <button class="w-12 h-12 bg-white rounded-full flex items-center justify-center hover:scale-110 transition">
                                <svg class="w-6 h-6 text-blue-500 ml-1" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M8 5v14l11-7z"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div class="p-4">
                        <p class="text-xs text-blue-600 font-medium mb-1">Skincare</p>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Skincare & Wellness</h3>
                        <p class="text-sm text-gray-600 mb-4">Complete skincare knowledge</p>
                        <div class="flex items-center justify-between">
                            <span class="text-lg font-bold text-pink-500">Rp 349K</span>
                            <button class="p-2 hover:bg-pink-50 rounded-lg transition">
                                <svg class="w-6 h-6 text-gray-400 hover:text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h6a2 2 0 012 2v12a2 2 0 01-2 2H7a2 2 0 01-2-2V5z"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Load More Button -->
            <div class="text-center mt-8">
                <button class="px-8 py-3 border-2 border-pink-500 text-pink-500 font-bold rounded-lg hover:bg-pink-50 transition">
                    Muat Lebih Banyak
                </button>
            </div>
        </section>
    </main>

    <!-- FOOTER -->
    <footer class="bg-gray-900 text-white py-12 px-4 sm:px-6 lg:px-8 mt-16">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                <!-- Footer Brand -->
                <div>
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-8 h-8 bg-pink-500 rounded-lg flex items-center justify-center">
                            <span class="text-white font-bold">S</span>
                        </div>
                        <span class="text-lg font-bold">Salonkita</span>
                    </div>
                    <p class="text-gray-400 text-sm">Belajar Beauty Skill Profesional dari Rumah</p>
                </div>

                <!-- Footer Links 1 -->
                <div>
                    <h4 class="font-bold mb-4">Produk</h4>
                    <ul class="space-y-2 text-gray-400 text-sm">
                        <li><a href="#" class="hover:text-pink-500 transition">Semua Kelas</a></li>
                        <li><a href="#" class="hover:text-pink-500 transition">Program Premium</a></li>
                        <li><a href="#" class="hover:text-pink-500 transition">Sertifikat</a></li>
                    </ul>
                </div>

                <!-- Footer Links 2 -->
                <div>
                    <h4 class="font-bold mb-4">Perusahaan</h4>
                    <ul class="space-y-2 text-gray-400 text-sm">
                        <li><a href="#" class="hover:text-pink-500 transition">Tentang Kami</a></li>
                        <li><a href="#" class="hover:text-pink-500 transition">Blog</a></li>
                        <li><a href="#" class="hover:text-pink-500 transition">Karir</a></li>
                    </ul>
                </div>

                <!-- Footer Links 3 -->
                <div>
                    <h4 class="font-bold mb-4">Dukungan</h4>
                    <ul class="space-y-2 text-gray-400 text-sm">
                        <li><a href="#" class="hover:text-pink-500 transition">Bantuan</a></li>
                        <li><a href="#" class="hover:text-pink-500 transition">Kebijakan Privasi</a></li>
                        <li><a href="#" class="hover:text-pink-500 transition">Syarat & Ketentuan</a></li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-800 pt-8">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <p class="text-gray-400 text-sm">&copy; 2024 Salonkita. Semua hak dilindungi.</p>
                    <div class="flex gap-4 mt-4 md:mt-0">
                        <a href="#" class="text-gray-400 hover:text-pink-500 transition">Facebook</a>
                        <a href="#" class="text-gray-400 hover:text-pink-500 transition">Instagram</a>
                        <a href="#" class="text-gray-400 hover:text-pink-500 transition">TikTok</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- JAVASCRIPT -->
    <script>
        // Smooth interactions and mobile menu
        document.addEventListener('DOMContentLoaded', function() {
            console.log('[v0] Dashboard loaded successfully');
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const navbar = document.querySelector('nav');
            if (!navbar.contains(event.target)) {
                // Add any additional dropdown close logic here if needed
            }
        });
    </script>
</body>
</html>
