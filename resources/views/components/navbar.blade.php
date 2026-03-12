<div>
    <!-- NAVBAR -->
    <nav class="sticky top-0 z-50 bg-white border-b border-pink-100 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-12">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <a href="/" class="flex items-center">
                    <div class="flex items-center gap-2">
                        <img src="assets/images/logos/logo_skid.webp" alt="Salonkita Logo"
                            class="w-20 h-20 rounded-lg object-contain">
                    </div>
                </a>

                <!-- Search Bar -->
                <div class="hidden md:flex flex-1 max-w-xs mx-8">
                    <div class="w-full relative">
                        <input type="text" placeholder="Cari kelas..."
                            class="w-full px-4 py-2 bg-gray-100 text-gray-900 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:bg-white transition">
                        <svg class="w-5 h-5 text-gray-400 absolute right-3 top-2.5" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>

                <!-- Right Side Menu -->
                <div class="flex items-center gap-4">
                    <!-- Mobile Search -->
                    <button class="md:hidden p-2">
                        <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </button>

                    <!-- Profile Dropdown -->
                    <div class="relative group">
                        <div class="flex items-center gap-2 cursor-pointer hover:bg-gray-100 p-2 rounded-lg">
                            <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=40&h=40&fit=crop"
                                alt="Profile" class="w-8 h-8 rounded-full">
                            <span class="hidden sm:inline font-medium text-gray-900">Jessica Tan</span>
                            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                            </svg>
                        </div>

                        <!-- Dropdown Menu -->
                        <div
                            class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                            <a href="profile.html"
                                class="flex items-center gap-3 px-4 py-3 text-gray-900 hover:bg-gray-50 border-b">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Profil
                            </a>
                            <a href="dashboard.html"
                                class="flex items-center gap-3 px-4 py-3 text-gray-900 hover:bg-gray-50 border-b">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6.253v13m0-13C6.5 6.253 2 10.998 2 17s4.5 10.747 10 10.747c5.5 0 10-4.998 10-10.747S17.5 6.253 12 6.253z">
                                    </path>
                                </svg>
                                Kelas Saya
                            </a>
                            <a href="#"
                                class="flex items-center gap-3 px-4 py-3 text-gray-900 hover:bg-gray-50 border-b">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Pencapaian
                            </a>
                            <a href="#"
                                class="flex items-center gap-3 px-4 py-3 text-gray-900 hover:bg-gray-50 border-b">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                    </path>
                                </svg>
                                Tugas
                            </a>
                            <a href="#"
                                class="flex items-center gap-3 px-4 py-3 text-gray-900 hover:bg-gray-50 border-b">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 5a2 2 0 012-2h6a2 2 0 012 2v14a2 2 0 01-2 2H7a2 2 0 01-2-2V5z"></path>
                                </svg>
                                Kelas Tersimpan
                            </a>
                            <button onclick="alert('Logout berhasil!')"
                                class="w-full text-left flex items-center gap-3 px-4 py-3 text-red-600 hover:bg-gray-50">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                    </path>
                                </svg>
                                Logout
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</div>