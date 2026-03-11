<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salonkita - Belajar Beauty Skill Profesional dari Rumah</title>
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
<body class="bg-white">
    <!-- NAVBAR -->
    <nav class="sticky top-0 z-50 bg-white border-b border-pink-100 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <div class="flex items-center gap-2">
                        <img src="assets/images/logo_skid.webp" alt="Salonkita Logo" class="w-20 h-20 rounded-lg object-contain">
                    </div>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center gap-6">
                    <button class="px-6 py-2 text-gray-700 font-medium hover:text-pink-500 transition">
                        Masuk
                    </button>
                    <button class="px-6 py-2 bg-pink-500 text-white font-medium rounded-lg hover:bg-pink-600 transition">
                        Daftar
                    </button>
                    
                    <!-- Language Dropdown -->
                    <div class="relative group">
                        <button class="flex items-center gap-2 px-3 py-2 text-gray-700 hover:text-pink-500">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                            <span>ID</span>
                        </button>
                        <div class="hidden group-hover:block absolute right-0 mt-2 w-32 bg-white border border-pink-200 rounded-lg shadow-lg">
                            <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-pink-50 first:rounded-t-lg">Bahasa Indonesia</a>
                            <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-pink-50">English</a>
                            <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-pink-50 last:rounded-b-lg">中文</a>
                        </div>
                    </div>
                </div>

                <!-- Mobile Menu Button -->
                <div class="md:hidden flex items-center gap-4">
                    <button class="md:hidden" onclick="toggleMobileMenu()">
                        <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div id="mobileMenu" class="hidden md:hidden pb-4">
                <button class="block w-full text-left px-4 py-2 text-gray-700 hover:text-pink-500">Masuk</button>
                <button class="block w-full text-left px-4 py-2 text-gray-700 hover:text-pink-500">Daftar</button>
            </div>
        </div>
    </nav>

    <!-- BANNER UTAMA -->
    <section class="py-12 md:py-20 px-4 sm:px-6 lg:px-12 bg-gradient-to-br from-pink-50 to-white">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-12 items-center">
                <!-- Left Content -->
                <div class="space-y-6">
                    <h1 class="text-4xl md:text-5xl font-bold text-gray-900 leading-tight">
                        Belajar Beauty Skill Profesional dari Rumah
                    </h1>
                    <p class="text-lg text-gray-600">
                        Kembangkan Skill Beauty anda sekarang bisa dilakukan dimana saja sekaligus mendapatkan Sertifikat!
                    </p>

                    <!-- Checklist Benefits -->
                    <div class="space-y-3">
                        <div class="flex items-center gap-3">
                            <svg class="w-6 h-6 text-pink-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-gray-700">Instruktur Berpengalaman dari Industri Beauty</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <svg class="w-6 h-6 text-pink-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-gray-700">Sertifikat Resmi yang Diakui Industri</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <svg class="w-6 h-6 text-pink-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-gray-700">Akses Seumur Hidup ke Materi Pembelajaran</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <svg class="w-6 h-6 text-pink-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-gray-700">Komunitas Eksklusif dengan Para Profesional</span>
                        </div>
                    </div>

                    <button class="px-8 py-4 bg-pink-500 text-white font-bold rounded-lg hover:bg-pink-600 transition shadow-lg">
                        Mulai Belajar Sekarang
                    </button>
                </div>

                <!-- Right Design - 4 Images Grid -->
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-gradient-to-br from-pink-200 to-pink-100 rounded-xl h-40 md:h-48 flex items-center justify-center">
                        <div class="text-center">
                            <svg class="w-12 h-12 mx-auto mb-2 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <p class="text-sm text-pink-600">Makeup Profesional</p>
                        </div>
                    </div>
                    <div class="bg-gradient-to-br from-pink-300 to-pink-200 rounded-xl h-40 md:h-48 flex items-center justify-center">
                        <div class="text-center">
                            <svg class="w-12 h-12 mx-auto mb-2 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path>
                            </svg>
                            <p class="text-sm text-white">Skincare Expert</p>
                        </div>
                    </div>
                    <div class="bg-gradient-to-br from-red-200 to-pink-100 rounded-xl h-40 md:h-48 flex items-center justify-center">
                        <div class="text-center">
                            <svg class="w-12 h-12 mx-auto mb-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                            <p class="text-sm text-red-600">Hair Styling</p>
                        </div>
                    </div>
                    <div class="bg-gradient-to-br from-purple-200 to-pink-100 rounded-xl h-40 md:h-48 flex items-center justify-center">
                        <div class="text-center">
                            <svg class="w-12 h-12 mx-auto mb-2 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p class="text-sm text-purple-600">Nail Art Design</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION KENAPA BERBEDA -->
    <section class="py-16 md:py-24 px-4 sm:px-6 lg:px-12 bg-white">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                    Kenapa Kelas Beauty Online di Sini Berbeda?
                </h2>
                <p class="text-lg text-gray-600">Kami berkomitmen memberikan pengalaman belajar terbaik</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Card 1 -->
                <div class="bg-gradient-to-br from-pink-50 to-white p-8 rounded-xl border border-pink-200 hover:shadow-lg transition">
                    <div class="w-12 h-12 bg-pink-500 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Kurikulum Praktis</h3>
                    <p class="text-gray-600">Materi disesuaikan dengan kebutuhan industri beauty terkini dan trend global</p>
                </div>

                <!-- Card 2 -->
                <div class="bg-gradient-to-br from-pink-50 to-white p-8 rounded-xl border border-pink-200 hover:shadow-lg transition">
                    <div class="w-12 h-12 bg-pink-500 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Mentor Profesional</h3>
                    <p class="text-gray-600">Instruktur bersertifikat dengan pengalaman puluhan tahun di industri</p>
                </div>

                <!-- Card 3 -->
                <div class="bg-gradient-to-br from-pink-50 to-white p-8 rounded-xl border border-pink-200 hover:shadow-lg transition">
                    <div class="w-12 h-12 bg-pink-500 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Sertifikat Resmi</h3>
                    <p class="text-gray-600">Dapatkan sertifikat yang diakui secara nasional dan internasional</p>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION PILIHAN KELAS TERBAIK -->
    <section class="py-16 md:py-24 px-4 sm:px-6 lg:px-12 bg-pink-50">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                    Pilihan Kelas Terbaik
                </h2>
                <p class="text-lg text-gray-600">Pilih kelas yang sesuai dengan minat dan keahlian Anda</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Class Card 1 -->
                <div class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-lg transition border border-pink-100">
                    <div class="h-32 bg-gradient-to-br from-pink-400 to-pink-300 relative">
                        <div class="absolute inset-0 flex items-center justify-center text-white">
                            <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="p-4">
                        <h3 class="text-lg font-bold text-gray-900 mb-1">Makeup Dasar</h3>
                        <p class="text-sm text-pink-600 font-medium mb-3">Makeup</p>
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-2xl font-bold text-pink-500">Rp 299K</span>
                            <button class="p-2 hover:bg-pink-50 rounded-lg transition">
                                <svg class="w-6 h-6 text-gray-400 hover:text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h6a2 2 0 012 2v12a2 2 0 01-2 2H7a2 2 0 01-2-2V5z"></path>
                                </svg>
                            </button>
                        </div>
                        <button class="w-full py-2 bg-pink-500 text-white font-medium rounded-lg hover:bg-pink-600 transition">
                            Lihat Detail
                        </button>
                    </div>
                </div>

                <!-- Class Card 2 -->
                <div class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-lg transition border border-pink-100">
                    <div class="h-32 bg-gradient-to-br from-purple-400 to-purple-300 relative">
                        <div class="absolute inset-0 flex items-center justify-center text-white">
                            <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="p-4">
                        <h3 class="text-lg font-bold text-gray-900 mb-1">Nail Art Profesional</h3>
                        <p class="text-sm text-purple-600 font-medium mb-3">Nail Art</p>
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-2xl font-bold text-pink-500">Rp 249K</span>
                            <button class="p-2 hover:bg-pink-50 rounded-lg transition">
                                <svg class="w-6 h-6 text-gray-400 hover:text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h6a2 2 0 012 2v12a2 2 0 01-2 2H7a2 2 0 01-2-2V5z"></path>
                                </svg>
                            </button>
                        </div>
                        <button class="w-full py-2 bg-pink-500 text-white font-medium rounded-lg hover:bg-pink-600 transition">
                            Lihat Detail
                        </button>
                    </div>
                </div>

                <!-- Class Card 3 -->
                <div class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-lg transition border border-pink-100">
                    <div class="h-32 bg-gradient-to-br from-red-400 to-red-300 relative">
                        <div class="absolute inset-0 flex items-center justify-center text-white">
                            <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="p-4">
                        <h3 class="text-lg font-bold text-gray-900 mb-1">Hair Styling Advanced</h3>
                        <p class="text-sm text-red-600 font-medium mb-3">Hair Care</p>
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-2xl font-bold text-pink-500">Rp 399K</span>
                            <button class="p-2 hover:bg-pink-50 rounded-lg transition">
                                <svg class="w-6 h-6 text-gray-400 hover:text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h6a2 2 0 012 2v12a2 2 0 01-2 2H7a2 2 0 01-2-2V5z"></path>
                                </svg>
                            </button>
                        </div>
                        <button class="w-full py-2 bg-pink-500 text-white font-medium rounded-lg hover:bg-pink-600 transition">
                            Lihat Detail
                        </button>
                    </div>
                </div>

                <!-- Class Card 4 -->
                <div class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-lg transition border border-pink-100">
                    <div class="h-32 bg-gradient-to-br from-cyan-400 to-blue-300 relative">
                        <div class="absolute inset-0 flex items-center justify-center text-white">
                            <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.452a6 6 0 00-3.86.454l-.3.1a6 6 0 01-3.5.5 6.755 6.755 0 01-2.089-.759m12-6V5c0-1.657-.895-3.061-2.175-3.816m0 0a6 6 0 00-5.422 3.029m0 0A9 9 0 1015.971 12m0 0a3 3 0 11-6 0m6 0a6 6 0 11-12 0"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="p-4">
                        <h3 class="text-lg font-bold text-gray-900 mb-1">Skincare & Wellness</h3>
                        <p class="text-sm text-blue-600 font-medium mb-3">Skincare</p>
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-2xl font-bold text-pink-500">Rp 349K</span>
                            <button class="p-2 hover:bg-pink-50 rounded-lg transition">
                                <svg class="w-6 h-6 text-gray-400 hover:text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h6a2 2 0 012 2v12a2 2 0 01-2 2H7a2 2 0 01-2-2V5z"></path>
                                </svg>
                            </button>
                        </div>
                        <button class="w-full py-2 bg-pink-500 text-white font-medium rounded-lg hover:bg-pink-600 transition">
                            Lihat Detail
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION TESTIMONI SISWA -->
    <section class="py-16 md:py-24 px-4 sm:px-6 lg:px-12 bg-white">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                    Testimoni Siswa Kami
                </h2>
                <p class="text-lg text-gray-600">Ribuan siswa telah merasakan manfaatnya</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Testimonial 1 -->
                <div class="bg-white p-6 rounded-xl border border-pink-200 shadow-md">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="w-12 h-12 bg-pink-200 rounded-full"></div>
                        <div>
                            <h4 class="font-bold text-gray-900">Sarah Putri</h4>
                            <p class="text-sm text-gray-500">Makeup Artist</p>
                        </div>
                    </div>
                    <div class="flex text-yellow-400 mb-2">
                        <span>★</span><span>★</span><span>★</span><span>★</span><span>★</span>
                    </div>
                    <p class="text-gray-600">"Kursus ini benar-benar mengubah karir saya! Dari pemula hingga profesional hanya dalam 3 bulan. Instruktur sangat detail dan supportif."</p>
                </div>

                <!-- Testimonial 2 -->
                <div class="bg-white p-6 rounded-xl border border-pink-200 shadow-md">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="w-12 h-12 bg-purple-200 rounded-full"></div>
                        <div>
                            <h4 class="font-bold text-gray-900">Dina Wijaya</h4>
                            <p class="text-sm text-gray-500">Nail Technician</p>
                        </div>
                    </div>
                    <div class="flex text-yellow-400 mb-2">
                        <span>★</span><span>★</span><span>★</span><span>★</span><span>★</span>
                    </div>
                    <p class="text-gray-600">"Materi sangat lengkap dan mudah dipahami. Saya bisa belajar dengan fleksibel sesuai jadwal saya. Hasilnya, klien saya sangat puas!"</p>
                </div>

                <!-- Testimonial 3 -->
                <div class="bg-white p-6 rounded-xl border border-pink-200 shadow-md">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="w-12 h-12 bg-red-200 rounded-full"></div>
                        <div>
                            <h4 class="font-bold text-gray-900">Jessica Tan</h4>
                            <p class="text-sm text-gray-500">Beauty Coach</p>
                        </div>
                    </div>
                    <div class="flex text-yellow-400 mb-2">
                        <span>★</span><span>★</span><span>★</span><span>★</span><span>★</span>
                    </div>
                    <p class="text-gray-600">"Komunitas Salonkita sangat supportif dan aktif. Saya tidak hanya belajar skill, tapi juga mendapat networking yang berharga."</p>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION FAQ -->
    <section class="py-16 md:py-24 px-4 sm:px-6 lg:px-12 bg-pink-50">
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                    Pertanyaan yang Sering Diajukan
                </h2>
            </div>

            <div class="space-y-4">
                <!-- FAQ Item 1 -->
                <div class="bg-white rounded-lg border border-pink-200 overflow-hidden">
                    <button class="w-full p-4 flex items-center justify-between hover:bg-pink-50 transition faq-toggle" onclick="toggleFAQ(this)">
                        <span class="font-bold text-gray-900 text-left">Apakah saya harus memiliki pengalaman sebelumnya?</span>
                        <svg class="w-6 h-6 text-pink-500 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                        </svg>
                    </button>
                    <div class="hidden p-4 border-t border-pink-200 bg-pink-50 faq-content">
                        <p class="text-gray-600">Tidak perlu! Kursus kami dirancang untuk pemula. Kami akan mengajarkan semua dasar yang Anda butuhkan dari nol.</p>
                    </div>
                </div>

                <!-- FAQ Item 2 -->
                <div class="bg-white rounded-lg border border-pink-200 overflow-hidden">
                    <button class="w-full p-4 flex items-center justify-between hover:bg-pink-50 transition faq-toggle" onclick="toggleFAQ(this)">
                        <span class="font-bold text-gray-900 text-left">Berapa lama akses materi pembelajaran?</span>
                        <svg class="w-6 h-6 text-pink-500 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                        </svg>
                    </button>
                    <div class="hidden p-4 border-t border-pink-200 bg-pink-50 faq-content">
                        <p class="text-gray-600">Akses seumur hidup! Setelah membeli kursus, Anda bisa menonton materi kapan saja, di mana saja tanpa batasan waktu.</p>
                    </div>
                </div>

                <!-- FAQ Item 3 -->
                <div class="bg-white rounded-lg border border-pink-200 overflow-hidden">
                    <button class="w-full p-4 flex items-center justify-between hover:bg-pink-50 transition faq-toggle" onclick="toggleFAQ(this)">
                        <span class="font-bold text-gray-900 text-left">Apakah sertifikat ini diakui secara resmi?</span>
                        <svg class="w-6 h-6 text-pink-500 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                        </svg>
                    </button>
                    <div class="hidden p-4 border-t border-pink-200 bg-pink-50 faq-content">
                        <p class="text-gray-600">Ya! Sertifikat kami diakui oleh industri beauty nasional dan internasional. Anda dapat mencantumkannya di CV dan LinkedIn Anda.</p>
                    </div>
                </div>

                <!-- FAQ Item 4 -->
                <div class="bg-white rounded-lg border border-pink-200 overflow-hidden">
                    <button class="w-full p-4 flex items-center justify-between hover:bg-pink-50 transition faq-toggle" onclick="toggleFAQ(this)">
                        <span class="font-bold text-gray-900 text-left">Apa saja metode pembayaran yang tersedia?</span>
                        <svg class="w-6 h-6 text-pink-500 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                        </svg>
                    </button>
                    <div class="hidden p-4 border-t border-pink-200 bg-pink-50 faq-content">
                        <p class="text-gray-600">Kami menerima berbagai metode pembayaran termasuk transfer bank, e-wallet, cicilan kartu kredit, dan GCash untuk kemudahan Anda.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION MITRA KAMI -->
    <section class="py-16 md:py-24 px-4 sm:px-6 lg:px-8 bg-white">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                    Mitra Kami
                </h2>
                <p class="text-lg text-gray-600">Dipercaya oleh brand dan institusi terkemuka</p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 items-center justify-items-center">
                <!-- Partner Logo 1 -->
                <div class="w-32 h-20 bg-gray-100 rounded-lg flex items-center justify-center border border-gray-200">
                    <div class="text-center">
                        <p class="text-sm font-bold text-gray-700">Beauty+</p>
                        <p class="text-xs text-gray-500">Academy</p>
                    </div>
                </div>

                <!-- Partner Logo 2 -->
                <div class="w-32 h-20 bg-pink-100 rounded-lg flex items-center justify-center border border-pink-200">
                    <div class="text-center">
                        <p class="text-sm font-bold text-pink-700">Glam</p>
                        <p class="text-xs text-pink-500">Institute</p>
                    </div>
                </div>

                <!-- Partner Logo 3 -->
                <div class="w-32 h-20 bg-purple-100 rounded-lg flex items-center justify-center border border-purple-200">
                    <div class="text-center">
                        <p class="text-sm font-bold text-purple-700">Pro</p>
                        <p class="text-xs text-purple-500">Beauty School</p>
                    </div>
                </div>

                <!-- Partner Logo 4 -->
                <div class="w-32 h-20 bg-gray-100 rounded-lg flex items-center justify-center border border-gray-200">
                    <div class="text-center">
                        <p class="text-sm font-bold text-gray-700">Elite</p>
                        <p class="text-xs text-gray-500">Training Center</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="bg-gray-900 text-white py-12 px-4 sm:px-6 lg:px-12">
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
                    <p class="text-gray-400 text-sm">Belajar Beauty Skill Profesional dari Rumah dengan Instruktur Berpengalaman</p>
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
        function toggleFAQ(button) {
            const content = button.nextElementSibling;
            const svg = button.querySelector('svg');
            
            content.classList.toggle('hidden');
            svg.style.transform = content.classList.contains('hidden') ? 'rotate(0deg)' : 'rotate(180deg)';
        }

        function toggleMobileMenu() {
            const menu = document.getElementById('mobileMenu');
            menu.classList.toggle('hidden');
        }

        // Close mobile menu when clicking outside
        document.addEventListener('click', function(event) {
            const navbar = document.querySelector('nav');
            if (!navbar.contains(event.target)) {
                const menu = document.getElementById('mobileMenu');
                menu.classList.add('hidden');
            }
        });
    </script>
</body>
</html>
