<x-layout>
    <style>
        .navbar-shadow {
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .card-shadow {
            box-shadow: 0 4px 12px rgba(236, 72, 153, 0.1);
        }

        .btn-pink-gradient {
            background: linear-gradient(135deg, #ec4899 0%, #db2777 100%);
            transition: all 0.3s ease;
        }

        .btn-pink-gradient:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(236, 72, 153, 0.3);
        }

        .badge-achievement {
            background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
        }

        .tab-active {
            color: #ec4899;
            border-bottom: 3px solid #ec4899;
        }

        .transition-smooth {
            transition: all 0.3s ease;
        }

        .profile-cover {
            height: 200px;
            background: linear-gradient(135deg, #ec4899 0%, #db2777 100%);
        }

        .medal-icon {
            font-size: 32px;
        }
    </style>
    <x-navbar />
    <!-- Profile Cover Section -->
    <div class="profile-cover"></div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-12 -mt-16 relative z-10">
        <!-- Profile Header -->
        <div class="bg-white rounded-lg card-shadow p-6 mb-8">
            <div class="flex flex-col md:flex-row md:items-end gap-6">
                <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=150&h=150&fit=crop"
                    alt="Profile" class="w-32 h-32 rounded-lg border-4 border-white shadow-lg">
                <div class="flex-1">
                    <h1 class="text-4xl font-bold text-gray-900 mb-2">Jessica Tan</h1>
                    <p class="text-gray-600 mb-4">Beauty Professional | Makeup Artist</p>
                    <div class="flex flex-wrap gap-4">
                        <div>
                            <p class="text-gray-600 text-sm">Member Sejak</p>
                            <p class="font-bold text-gray-900">12 Agustus 2024</p>
                        </div>
                        <div>
                            <p class="text-gray-600 text-sm">Email</p>
                            <p class="font-bold text-gray-900">jessica@email.com</p>
                        </div>
                    </div>
                </div>
                <button class="btn-pink-gradient text-white px-6 py-2 rounded-lg font-semibold self-start md:self-end">
                    Edit Profil
                </button>
            </div>
        </div>

        <!-- Stats Section -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Kelas Terdaftar -->
            <div class="bg-white rounded-lg card-shadow p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.669 0-3.218.51-4.5 1.385A7.968 7.968 0 009 4.804z">
                            </path>
                        </svg>
                    </div>
                    <span class="text-right">
                        <p class="text-gray-600 text-sm">Kelas Terdaftar</p>
                    </span>
                </div>
                <p class="text-4xl font-bold text-gray-900">8</p>
            </div>

            <!-- Kelas Selesai -->
            <div class="bg-white rounded-lg card-shadow p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <span class="text-right">
                        <p class="text-gray-600 text-sm">Kelas Selesai</p>
                    </span>
                </div>
                <p class="text-4xl font-bold text-gray-900">5</p>
            </div>

            <!-- Total Pencapaian -->
            <div class="bg-white rounded-lg card-shadow p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                            </path>
                        </svg>
                    </div>
                    <span class="text-right">
                        <p class="text-gray-600 text-sm">Total Pencapaian</p>
                    </span>
                </div>
                <p class="text-4xl font-bold text-gray-900">23</p>
            </div>

            <!-- Poin -->
            <div class="bg-white rounded-lg card-shadow p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M9.167 4.5a.75.75 0 01.75.75v7.08l1.465-1.465a.75.75 0 11-1.06-1.06l-2.5 2.5a.75.75 0 001.06 1.06l1.465-1.465v1.465a.75.75 0 01-.75.75h-7.5a.75.75 0 01-.75-.75V10a.75.75 0 111.5 0v2.917h5.25V5.25a.75.75 0 01.75-.75z">
                            </path>
                        </svg>
                    </div>
                    <span class="text-right">
                        <p class="text-gray-600 text-sm">Total Poin</p>
                    </span>
                </div>
                <p class="text-4xl font-bold text-gray-900">2,850</p>
            </div>
        </div>

        <!-- Pencapaian & Sertifikat Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <!-- Pencapaian Terkini -->
            <div class="bg-white rounded-lg card-shadow p-6">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Pencapaian Terkini</h2>
                <div class="space-y-4">
                    <!-- Achievement 1 -->
                    <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-smooth">
                        <div class="medal-icon">🏆</div>
                        <div class="flex-1">
                            <h3 class="font-bold text-gray-900">Master Makeup Artist</h3>
                            <p class="text-gray-600 text-sm">Selesaikan semua kelas makeup</p>
                            <p class="text-gray-500 text-xs mt-1">Diraih pada 15 Januari 2025</p>
                        </div>
                        <div class="text-right">
                            <p class="text-pink-600 font-bold">+500 poin</p>
                        </div>
                    </div>

                    <!-- Achievement 2 -->
                    <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-smooth">
                        <div class="medal-icon">⭐</div>
                        <div class="flex-1">
                            <h3 class="font-bold text-gray-900">5 Bintang Evaluasi</h3>
                            <p class="text-gray-600 text-sm">Dapatkan rating 5 bintang di 5 kelas</p>
                            <p class="text-gray-500 text-xs mt-1">Diraih pada 10 Januari 2025</p>
                        </div>
                        <div class="text-right">
                            <p class="text-pink-600 font-bold">+300 poin</p>
                        </div>
                    </div>

                    <!-- Achievement 3 -->
                    <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-smooth">
                        <div class="medal-icon">🎯</div>
                        <div class="flex-1">
                            <h3 class="font-bold text-gray-900">Fokus Belajar</h3>
                            <p class="text-gray-600 text-sm">Belajar minimal 7 hari berturut-turut</p>
                            <p class="text-gray-500 text-xs mt-1">Diraih pada 05 Januari 2025</p>
                        </div>
                        <div class="text-right">
                            <p class="text-pink-600 font-bold">+250 poin</p>
                        </div>
                    </div>

                    <!-- Achievement 4 -->
                    <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-smooth">
                        <div class="medal-icon">🚀</div>
                        <div class="flex-1">
                            <h3 class="font-bold text-gray-900">Cepat Belajar</h3>
                            <p class="text-gray-600 text-sm">Menyelesaikan kelas dalam 2 minggu</p>
                            <p class="text-gray-500 text-xs mt-1">Diraih pada 02 Januari 2025</p>
                        </div>
                        <div class="text-right">
                            <p class="text-pink-600 font-bold">+200 poin</p>
                        </div>
                    </div>
                </div>
                <a href="#" class="inline-block mt-6 text-pink-600 font-semibold hover:text-pink-700">Lihat Semua
                    Pencapaian →</a>
            </div>

            <!-- Sertifikat Terkini -->
            <div class="bg-white rounded-lg card-shadow p-6">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Sertifikat Terkini</h2>
                <div class="space-y-4">
                    <!-- Certificate 1 -->
                    <div class="border-2 border-pink-200 rounded-lg p-4 hover:border-pink-400 transition-smooth">
                        <div class="flex items-start gap-4">
                            <div
                                class="w-16 h-16 bg-gradient-to-br from-yellow-300 to-yellow-500 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 110 2H4a1 1 0 110-2V4z"></path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h3 class="font-bold text-gray-900">Certified Makeup Artist Professional</h3>
                                <p class="text-gray-600 text-sm">Dari Salonkita</p>
                                <p class="text-gray-500 text-xs mt-2">Diraih pada 15 Januari 2025</p>
                                <div class="mt-3 flex gap-2">
                                    <button class="text-pink-600 text-sm font-semibold hover:text-pink-700">Lihat
                                        Sertifikat</button>
                                    <button
                                        class="text-gray-600 text-sm font-semibold hover:text-gray-700">Bagikan</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Certificate 2 -->
                    <div class="border-2 border-pink-200 rounded-lg p-4 hover:border-pink-400 transition-smooth">
                        <div class="flex items-start gap-4">
                            <div
                                class="w-16 h-16 bg-gradient-to-br from-pink-300 to-pink-500 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 110 2H4a1 1 0 110-2V4z"></path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h3 class="font-bold text-gray-900">Eyeshadow Techniques Master</h3>
                                <p class="text-gray-600 text-sm">Dari Salonkita</p>
                                <p class="text-gray-500 text-xs mt-2">Diraih pada 10 Januari 2025</p>
                                <div class="mt-3 flex gap-2">
                                    <button class="text-pink-600 text-sm font-semibold hover:text-pink-700">Lihat
                                        Sertifikat</button>
                                    <button
                                        class="text-gray-600 text-sm font-semibold hover:text-gray-700">Bagikan</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Certificate 3 -->
                    <div class="border-2 border-pink-200 rounded-lg p-4 hover:border-pink-400 transition-smooth">
                        <div class="flex items-start gap-4">
                            <div
                                class="w-16 h-16 bg-gradient-to-br from-purple-300 to-purple-500 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 110 2H4a1 1 0 110-2V4z"></path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h3 class="font-bold text-gray-900">Event Makeup Specialist</h3>
                                <p class="text-gray-600 text-sm">Dari Salonkita</p>
                                <p class="text-gray-500 text-xs mt-2">Diraih pada 05 Januari 2025</p>
                                <div class="mt-3 flex gap-2">
                                    <button class="text-pink-600 text-sm font-semibold hover:text-pink-700">Lihat
                                        Sertifikat</button>
                                    <button
                                        class="text-gray-600 text-sm font-semibold hover:text-gray-700">Bagikan</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <a href="#" class="inline-block mt-6 text-pink-600 font-semibold hover:text-pink-700">Lihat Semua
                    Sertifikat →</a>
            </div>
        </div>

        <!-- Kelas Terdaftar Section -->
        <div class="bg-white rounded-lg card-shadow p-6 mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Kelas yang Saat Ini Diambil</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Class Card 1 -->
                <div class="border border-gray-200 rounded-lg overflow-hidden hover:shadow-lg transition-smooth">
                    <img src="https://images.unsplash.com/photo-1596885289519-5ab0e4a4eb78?w=300&h=150&fit=crop"
                        alt="Class" class="w-full h-40 object-cover">
                    <div class="p-4">
                        <h3 class="font-bold text-gray-900 mb-2">Natural Makeup Daily</h3>
                        <p class="text-gray-600 text-sm mb-3">Makeup untuk Penggunaan Sehari-hari</p>
                        <div class="bg-gray-100 rounded-full h-2 mb-2">
                            <div class="bg-pink-600 h-2 rounded-full" style="width: 65%"></div>
                        </div>
                        <p class="text-gray-600 text-xs">65% Selesai</p>
                    </div>
                </div>

                <!-- Class Card 2 -->
                <div class="border border-gray-200 rounded-lg overflow-hidden hover:shadow-lg transition-smooth">
                    <img src="https://images.unsplash.com/photo-1599643478518-a784e5dc4c8f?w=300&h=150&fit=crop"
                        alt="Class" class="w-full h-40 object-cover">
                    <div class="p-4">
                        <h3 class="font-bold text-gray-900 mb-2">Contouring Mastery</h3>
                        <p class="text-gray-600 text-sm mb-3">Teknik Kontur Profesional</p>
                        <div class="bg-gray-100 rounded-full h-2 mb-2">
                            <div class="bg-pink-600 h-2 rounded-full" style="width: 45%"></div>
                        </div>
                        <p class="text-gray-600 text-xs">45% Selesai</p>
                    </div>
                </div>

                <!-- Class Card 3 -->
                <div class="border border-gray-200 rounded-lg overflow-hidden hover:shadow-lg transition-smooth">
                    <img src="https://images.unsplash.com/photo-1600965962160-e38dae4f9ed9?w=300&h=150&fit=crop"
                        alt="Class" class="w-full h-40 object-cover">
                    <div class="p-4">
                        <h3 class="font-bold text-gray-900 mb-2">Bridal Makeup</h3>
                        <p class="text-gray-600 text-sm mb-3">Makeup Khusus Pengantin</p>
                        <div class="bg-gray-100 rounded-full h-2 mb-2">
                            <div class="bg-pink-600 h-2 rounded-full" style="width: 20%"></div>
                        </div>
                        <p class="text-gray-600 text-xs">20% Selesai</p>
                    </div>
                </div>

                <!-- Class Card 4 -->
                <div class="border border-gray-200 rounded-lg overflow-hidden hover:shadow-lg transition-smooth">
                    <img src="https://images.unsplash.com/photo-1608571423902-eed4a5ad8108?w=300&h=150&fit=crop"
                        alt="Class" class="w-full h-40 object-cover">
                    <div class="p-4">
                        <h3 class="font-bold text-gray-900 mb-2">Skincare Foundation</h3>
                        <p class="text-gray-600 text-sm mb-3">Dasar-dasar Perawatan Kulit</p>
                        <div class="bg-gray-100 rounded-full h-2 mb-2">
                            <div class="bg-pink-600 h-2 rounded-full" style="width: 90%"></div>
                        </div>
                        <p class="text-gray-600 text-xs">90% Selesai</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-footer />
</x-layout>
