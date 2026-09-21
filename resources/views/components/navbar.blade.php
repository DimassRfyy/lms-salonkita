@props([
    'containerClass' => 'max-w-7xl mx-auto px-4 sm:px-6 lg:px-12'
])

<div>
    <!-- NAVBAR -->
    <nav class="fixed top-0 left-0 right-0 z-50 bg-white border-b border-pink-100 shadow-sm">
        <div class="{{ $containerClass }}">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <a href="/" class="flex items-center">
                    <div class="flex items-center gap-2">
                        <img src="{{ asset('assets/images/logos/logo_skid.webp') }}" alt="Salonkita Logo"
                            class="w-20 h-20 rounded-lg object-contain">
                    </div>
                </a>

                <!-- Menu Tengah (Akses Publik & Login) -->
                <div class="hidden md:flex items-center gap-1 lg:gap-2">
                    <!-- Dropdown Semua Kelas -->
                    <div class="relative group">
                        <button type="button"
                            class="px-3.5 lg:px-4 py-2 text-[15px] font-semibold text-gray-700 hover:text-pink-600 hover:bg-pink-50 rounded-xl transition duration-150 inline-flex items-center gap-1 focus:outline-none cursor-pointer {{ request()->routeIs('all-courses') ? 'text-pink-600 bg-pink-50/70' : '' }}">
                            <span>Semua Kelas</span>
                            <svg class="w-4 h-4 text-gray-400 group-hover:text-pink-600 transition-transform duration-200 group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>

                        <!-- Dropdown Menu Level -->
                        <div class="absolute left-0 mt-1 w-60 bg-white rounded-2xl shadow-xl border border-pink-100 py-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                            <a href="{{ route('all-courses') }}"
                                class="flex flex-col px-4 py-2 hover:bg-pink-50 transition">
                                <span class="text-sm font-bold text-gray-800 hover:text-pink-600">Semua Kelas</span>
                            </a>
                            <div class="border-t border-pink-50 my-1"></div>
                            <a href="{{ route('all-courses', ['level' => 'basic']) }}"
                                class="flex items-center justify-between px-4 py-2 hover:bg-pink-50 transition group/item">
                                <div class="flex flex-col">
                                    <span class="text-sm font-semibold text-gray-700 group-hover/item:text-pink-600">Basic (Free)</span>
                                    <span class="text-[11px] text-gray-400">Tingkat dasar gratis</span>
                                </div>
                            </a>
                            <a href="{{ route('all-courses', ['level' => 'intermediate']) }}"
                                class="flex items-center justify-between px-4 py-2 hover:bg-pink-50 transition group/item">
                                <div class="flex flex-col">
                                    <span class="text-sm font-semibold text-gray-700 group-hover/item:text-pink-600">Intermediate</span>
                                    <span class="text-[11px] text-gray-400">Tingkat menengah</span>
                                </div>
                            </a>
                            <a href="{{ route('all-courses', ['level' => 'advanced']) }}"
                                class="flex items-center justify-between px-4 py-2 hover:bg-pink-50 transition group/item">
                                <div class="flex flex-col">
                                    <span class="text-sm font-semibold text-gray-700 group-hover/item:text-pink-600">Advanced</span>
                                    <span class="text-[11px] text-gray-400">Tingkat profesional</span>
                                </div>
                            </a>
                        </div>
                    </div>

                    <!-- Mentor Link -->
                    <a href="{{ route('mentors.index') }}"
                        class="px-3.5 lg:px-4 py-2 text-[15px] font-semibold text-gray-700 hover:text-pink-600 hover:bg-pink-50 rounded-xl transition duration-150 {{ request()->routeIs('mentors.*') ? 'text-pink-600 bg-pink-50/70' : '' }}">
                        Mentor
                    </a>

                    <!-- Coach Link -->
                    <a href="{{ route('coaches.index') }}"
                        class="px-3.5 lg:px-4 py-2 text-[15px] font-semibold text-gray-700 hover:text-pink-600 hover:bg-pink-50 rounded-xl transition duration-150 {{ request()->routeIs('coaches.*') ? 'text-pink-600 bg-pink-50/70' : '' }}">
                        Coach
                    </a>

                    <!-- FAQ Link -->
                    <a href="{{ route('home') }}#faq"
                        class="px-3.5 lg:px-4 py-2 text-[15px] font-semibold text-gray-700 hover:text-pink-600 hover:bg-pink-50 rounded-xl transition duration-150">
                        FAQ
                    </a>
                </div>

                <!-- Right Side Menu -->
                <div class="flex items-center gap-3 sm:gap-4">
                    <!-- Mobile Hamburger Button -->
                    <button type="button" onclick="toggleMobileMenu()" class="md:hidden p-2 text-gray-700 hover:text-pink-600 rounded-lg hover:bg-pink-50 transition" aria-label="Buka menu navigasi">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                        </svg>
                    </button>

                    @auth
                        @php
                            $avatarUrl = auth()->user()->avatar_url;
                            $isApproved = (bool) auth()->user()->is_approved;
                            $role = auth()->user()->role;
                            $isAdmin = $role === 'admin';
                            $hasMentoringEntitlement = $role === 'student' && auth()->user()->availableMentoringEntitlements()->exists();
                            $latestMentoringBooking = $role === 'student'
                                ? auth()->user()->mentoringBookingsAsStudent()->latest('starts_at')->first()
                                : null;
                            $hasMentoringAccess = $hasMentoringEntitlement || $latestMentoringBooking !== null;
                            $mentoringButtonLabel = $latestMentoringBooking ? 'Lihat Mentoring' : 'Mulai Mentoring';
                            $adminLabel = match ($role) {
                                'mentor' => 'Ruang Mentor',
                                'coach' => 'Ruang Coach',
                                default => 'Ruang Admin',
                            };
                        @endphp
                        @if ($hasMentoringAccess)
                            <a href="{{ route('mentoring.index') }}"
                                class="hidden sm:inline-flex items-center gap-1.5 rounded-full bg-pink-50 border border-pink-200 px-3.5 py-1.5 text-xs font-bold text-pink-600 shadow-2xs transition hover:bg-pink-100">
                                <svg class="h-4 w-4 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                Mentoring
                            </a>
                        @endif

                        {{-- FITUR REDEEM POINT DI-DISABLE SEMENTARA --}}
                        {{--
                        <!-- Points Badge -->
                        <a href="{{ route('points.index') }}"
                            class="inline-flex items-center gap-1.5 rounded-full bg-amber-50 border border-amber-200 px-3.5 py-1.5 text-xs font-black text-amber-700 hover:bg-amber-100 transition shadow-sm">
                            <span class="text-sm">🪙</span>
                            <span>{{ number_format(auth()->user()->points_balance ?? 0) }} Poin</span>
                        </a>
                        --}}

                        <!-- Profile Dropdown -->
                        <div class="relative group">
                            <div class="flex items-center gap-2 cursor-pointer hover:bg-gray-100 p-2 rounded-lg">
                                @if ($avatarUrl)
                                    <img src="{{ $avatarUrl }}" alt="{{ auth()->user()->name }}"
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
                                @if($isAdmin || $isApproved)
                                    <a href="{{ url('/admin') }}"
                                        class="flex items-center gap-3 px-4 py-3 text-pink-500 hover:bg-gray-50 border-b">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                                            </path>
                                        </svg>
                                        {{ $adminLabel }}
                                    </a>
                                @endif
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
                                @if($hasMentoringAccess)
                                    <a href="{{ route('mentoring.index') }}"
                                        class="flex items-center gap-3 px-4 py-3 text-gray-900 hover:bg-gray-50 border-b">
                                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        Sesi Mentoring
                                    </a>
                                @endif
                                <a href="{{ route('points.index') }}"
                                    class="flex items-center gap-3 px-4 py-3 text-gray-900 hover:bg-gray-50 border-b">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                        </path>
                                    </svg>
                                    Redem Poin
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

        <!-- Mobile Menu Dropdown -->
        <div id="mobileMenu" class="hidden md:hidden border-t border-pink-100 bg-white px-4 pt-3 pb-5 shadow-lg">
            <div class="flex flex-col space-y-1">
                <div class="py-1">
                    <span class="px-3 text-xs font-bold text-gray-400 uppercase tracking-wider">Katalog Kelas</span>
                    <a href="{{ route('all-courses') }}"
                        class="flex items-center justify-between px-3 py-2 rounded-xl text-sm font-semibold text-gray-800 hover:text-pink-600 hover:bg-pink-50 transition">
                        <span>Semua Kelas</span>
                    </a>
                    <div class="pl-3 flex flex-col space-y-0.5 border-l-2 border-pink-100 ml-3 my-1">
                        <a href="{{ route('all-courses', ['level' => 'basic']) }}"
                            class="px-3 py-1.5 rounded-lg text-xs font-medium text-gray-600 hover:text-pink-600 hover:bg-pink-50 transition flex items-center justify-between">
                            <span>Basic (Free)</span>
                            <span class="text-[10px] font-bold text-emerald-700 bg-emerald-100 px-2 py-0.5 rounded-full">Free</span>
                        </a>
                        <a href="{{ route('all-courses', ['level' => 'intermediate']) }}"
                            class="px-3 py-1.5 rounded-lg text-xs font-medium text-gray-600 hover:text-pink-600 hover:bg-pink-50 transition flex items-center justify-between">
                            <span>Intermediate</span>
                            <span class="text-[10px] font-bold text-sky-700 bg-sky-100 px-2 py-0.5 rounded-full">Pro</span>
                        </a>
                        <a href="{{ route('all-courses', ['level' => 'advanced']) }}"
                            class="px-3 py-1.5 rounded-lg text-xs font-medium text-gray-600 hover:text-pink-600 hover:bg-pink-50 transition flex items-center justify-between">
                            <span>Advanced</span>
                            <span class="text-[10px] font-bold text-purple-700 bg-purple-100 px-2 py-0.5 rounded-full">Expert</span>
                        </a>
                    </div>
                </div>

                <div class="border-t border-gray-100 my-1"></div>

                <a href="{{ route('mentors.index') }}"
                    class="px-3 py-2 rounded-xl text-sm font-semibold text-gray-800 hover:text-pink-600 hover:bg-pink-50 transition {{ request()->routeIs('mentors.*') ? 'text-pink-600 bg-pink-50/70' : '' }}">
                    Mentor
                </a>

                <a href="{{ route('coaches.index') }}"
                    class="px-3 py-2 rounded-xl text-sm font-semibold text-gray-800 hover:text-pink-600 hover:bg-pink-50 transition {{ request()->routeIs('coaches.*') ? 'text-pink-600 bg-pink-50/70' : '' }}">
                    Coach
                </a>

                <a href="{{ route('home') }}#faq" onclick="toggleMobileMenu()"
                    class="px-3 py-2 rounded-xl text-sm font-semibold text-gray-800 hover:text-pink-600 hover:bg-pink-50 transition">
                    FAQ
                </a>

                @guest
                    <div class="pt-3 border-t border-gray-100 flex items-center gap-2">
                        <a href="{{ route('login') }}" class="flex-1 py-2 text-center text-sm font-semibold text-gray-700 hover:text-pink-600 bg-gray-50 rounded-xl">Masuk</a>
                        <a href="{{ route('register') }}" class="flex-1 py-2 text-center text-sm font-semibold text-white bg-pink-500 hover:bg-pink-600 rounded-xl">Daftar</a>
                    </div>
                @endguest
            </div>
        </div>

        <script>
            if (typeof toggleMobileMenu !== 'function') {
                function toggleMobileMenu() {
                    const menu = document.getElementById('mobileMenu');
                    if (menu) {
                        menu.classList.toggle('hidden');
                    }
                }
            }
        </script>
    </nav>
</div>