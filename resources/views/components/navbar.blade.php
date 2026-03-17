<div>
    <!-- NAVBAR -->
    <nav class="sticky top-0 z-50 bg-white border-b border-pink-100 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-12">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <a href="/" class="flex items-center">
                    <div class="flex items-center gap-2">
                        <img src="{{ asset('assets/images/logos/logo_skid.webp') }}" alt="Salonkita Logo"
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

                    @auth
                        <!-- Profile Dropdown -->
                        <div class="relative group">
                            <div class="flex items-center gap-2 cursor-pointer hover:bg-gray-100 p-2 rounded-lg">
                                @if(auth()->user()->avatar)
                                    <img src="{{ Storage::url(auth()->user()->avatar) }}" alt="{{ auth()->user()->name }}"
                                        class="w-8 h-8 rounded-full object-cover">
                                @else
                                    <div
                                        class="w-8 h-8 rounded-full bg-pink-200 flex items-center justify-center text-pink-700 font-bold text-sm">
                                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                    </div>
                                @endif
                                <span class="hidden sm:inline font-medium text-gray-900">{{ auth()->user()->name }}</span>
                                <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>

                            <!-- Dropdown Menu -->
                            <div
                                class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                                <a href="{{ route('profile') }}"
                                    class="flex items-center gap-3 px-4 py-3 text-gray-900 hover:bg-gray-50 border-b">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    Profil
                                </a>
                                <a href="{{ route('dashboard') }}"
                                    class="flex items-center gap-3 px-4 py-3 text-gray-900 hover:bg-gray-50 border-b">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                                        </path>
                                    </svg>
                                    Dashboard Kelas
                                </a>
                                <a href="{{ route('task') }}"
                                    class="flex items-center gap-3 px-4 py-3 text-gray-900 hover:bg-gray-50 border-b">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                        </path>
                                    </svg>
                                    Tugas
                                </a>
                                <a href="{{ route('saved-courses') }}"
                                    class="flex items-center gap-3 px-4 py-3 text-gray-900 hover:bg-gray-50 border-b">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
                                    </svg>
                                    Kelas Tersimpan
                                </a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="w-full text-left flex items-center gap-3 px-4 py-3 text-red-600 hover:bg-gray-50">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                            </path>
                                        </svg>
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <!-- Guest: Masuk & Daftar -->
                        <a href="{{ route('login') }}"
                            class="px-4 py-2 text-gray-700 font-medium hover:text-pink-500 transition text-sm">
                            Masuk
                        </a>
                        <a href="{{ route('register') }}"
                            class="px-4 py-2 bg-pink-500 text-white font-medium rounded-lg hover:bg-pink-600 transition text-sm">
                            Daftar
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>
</div>