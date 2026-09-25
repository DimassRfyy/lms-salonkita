@props([
    'containerClass' => 'max-w-7xl mx-auto px-4 sm:px-6 lg:px-12'
])

<div class="mt-auto">
    <!-- FOOTER -->
    <footer class="bg-gray-900 text-white py-12">
        <div class="{{ $containerClass }}">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                <!-- Footer Brand -->
                <div class="space-y-3.5">
                    <a href="{{ route('home') }}" class="inline-block hover:opacity-90 transition" aria-label="Beranda Salonkita">
                        <img src="{{ asset('assets/images/logos/logo_skid.webp') }}" alt="Salonkita Logo"
                            class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl object-contain">
                    </a>
                    <p class="text-gray-400 text-sm leading-relaxed">
                        Belajar Beauty Skill Profesional dari Rumah dengan Instruktur Berpengalaman
                    </p>
                </div>

                <!-- Footer Links 1 -->
                <div>
                    <h4 class="font-bold mb-4 text-white">Program & Kelas</h4>
                    <ul class="space-y-2.5 text-gray-400 text-sm">
                        <li><a href="{{ route('all-courses') }}" class="hover:text-pink-500 transition">Semua Kelas Kecantikan</a></li>
                        <li><a href="{{ route('mentors.index') }}" class="hover:text-pink-500 transition">Mentor & Coach Profesional</a></li>
                        <li><a href="{{ route('all-courses', ['level' => 'basic']) }}" class="hover:text-pink-500 transition">Kelas Dasar (Gratis)</a></li>
                    </ul>
                </div>

                <!-- Footer Links 2: Kebijakan Publik (Wajib Payment Gateway) -->
                <div>
                    <h4 class="font-bold mb-4 text-white">Kebijakan Publik</h4>
                    <ul class="space-y-2.5 text-gray-400 text-sm">
                        <li>
                            <a href="{{ route('terms') }}" class="hover:text-pink-500 transition inline-flex items-center gap-1.5">
                                <span>Terms & Conditions</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('privacy') }}" class="hover:text-pink-500 transition inline-flex items-center gap-1.5">
                                <span>Privacy Policy</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('refund') }}" class="hover:text-pink-500 transition inline-flex items-center gap-1.5">
                                <span>Refund & Cancellation</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Footer Links 3: Dukungan & Kontak -->
                <div>
                    <h4 class="font-bold mb-4 text-white">Bantuan & Kontak</h4>
                    <ul class="space-y-2.5 text-gray-400 text-sm">
                        <li>
                            <a href="mailto:info@skid.co.id" class="hover:text-pink-500 transition inline-flex items-center gap-2">
                                <svg class="w-4 h-4 text-pink-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                <span>info@skid.co.id</span>
                            </a>
                        </li>
                        <li>
                            <a href="https://wa.me/6281264444213" target="_blank" rel="noopener noreferrer" class="hover:text-pink-500 transition inline-flex items-center gap-2">
                                <svg class="w-4 h-4 text-pink-500 shrink-0" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.312.045-.694.076-2.003-.467-1.674-.694-2.73-2.39-2.812-2.502-.084-.112-.676-.902-.676-1.72 0-.819.428-1.222.58-1.388.152-.167.333-.209.444-.209.112 0 .224.002.321.007.103.006.242-.039.378.291.144.35.49 1.196.533 1.284.043.088.072.191.014.307-.058.115-.088.188-.175.291-.088.103-.185.23-.264.309-.088.088-.18.185-.078.361.102.176.452.747.969 1.208.666.594 1.228.778 1.404.866.176.088.278.077.382-.042.103-.119.444-.517.562-.695.118-.178.236-.148.397-.089.16.059 1.016.479 1.19.567.175.088.291.132.334.206.043.074.043.432-.101.837z" />
                                </svg>
                                <span>0812-6444-4213 (WhatsApp)</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-800 pt-8">
                <div class="flex flex-col lg:flex-row justify-between items-center gap-4">
                    <p class="text-gray-400 text-sm text-center lg:text-left">&copy; {{ date('Y') }} <span class="text-pink-600 font-semibold">SKID</span>. All rights
                        reserved.</p>

                    <div class="flex gap-4 items-center">
                        <!-- YouTube -->
                        <a href="https://youtube.com/@salonkitaindonesia?si=UiM0TbAFPow0_vNf" target="_blank" rel="noopener noreferrer" class="text-gray-400 hover:text-pink-500 transition" aria-label="YouTube">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z" />
                            </svg>
                        </a>
                        <!-- LinkedIn -->
                        <a href="https://www.linkedin.com/company/salonkita/" target="_blank" rel="noopener noreferrer" class="text-gray-400 hover:text-pink-500 transition" aria-label="LinkedIn">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M19 3a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h14m-.5 15.5v-5.3a3.26 3.26 0 0 0-3.26-3.26c-.85 0-1.84.52-2.28 1.3v-1.11h-2.79v8.37h2.79v-4.93c0-.77.62-1.4 1.39-1.4a1.4 1.4 0 0 1 1.4 1.4v4.93h2.75M6.46 10.9v8.37H9.2V10.9H6.46M7.83 6.64c-.95 0-1.72.77-1.72 1.72s.77 1.72 1.72 1.72 1.72-.77 1.72-1.72-.77-1.72-1.72-1.72z" />
                            </svg>
                        </a>
                        <!-- Instagram -->
                        <a href="https://www.instagram.com/skid.indonesia?igsi=Y2cwOGZ2eTNobjB0" target="_blank" rel="noopener noreferrer" class="text-gray-400 hover:text-pink-500 transition" aria-label="Instagram">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12 2.163c3.204 0 3.584.012 4.85.07 1.366.062 2.633.334 3.608 1.308.975.975 1.246 2.242 1.308 3.608.058 1.266.07 1.646.07 4.85s-.012 3.584-.07 4.85c-.062 1.366-.334 2.633-1.308 3.608-.975.975-2.242 1.246-3.608 1.308-1.266.058-1.646.07-4.85.07s-3.584-.012-4.85-.07c-1.366-.062-2.633-.334-3.608-1.308-.975-.975-1.246-2.242-1.308-3.608C2.175 15.584 2.163 15.204 2.163 12s.012-3.584.07-4.85c.062-1.366.334-2.633 1.308-3.608C4.516 2.497 5.783 2.226 7.149 2.163 8.415 2.105 8.795 2.163 12 2.163zm0-2.163C8.741 0 8.332.013 7.052.072 5.197.157 3.355.673 2.014 2.014.673 3.355.157 5.197.072 7.052.013 8.332 0 8.741 0 12c0 3.259.013 3.668.072 4.948.085 1.855.601 3.697 1.942 5.038 1.341 1.341 3.183 1.857 5.038 1.942C8.332 23.987 8.741 24 12 24c3.259 0 3.668-.013 4.948-.072 1.855-.085 3.697-.601 5.038-1.942 1.341-1.341 1.857-3.183 1.942-5.038.059-1.28.072-1.689.072-4.948 0-3.259-.013-3.668-.072-4.948-.085-1.855-.601-3.697-1.942-5.038C20.645.673 18.803.157 16.948.072 15.668.013 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zm0 10.162a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z" />
                            </svg>
                        </a>
                        <!-- TikTok -->
                        <a href="https://www.tiktok.com/@salonkita.id?_r=1&_t=ZS-99FfTnIQAfE" target="_blank" rel="noopener noreferrer" class="text-gray-400 hover:text-pink-500 transition" aria-label="TikTok">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M19.59 6.69a4.83 4.83 0 01-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 01-2.88 2.5 2.89 2.89 0 01-2.89-2.89 2.89 2.89 0 012.89-2.89c.28 0 .54.04.79.1V9.01a6.33 6.33 0 00-.79-.05 6.34 6.34 0 00-6.34 6.34 6.34 6.34 0 006.34 6.34 6.34 6.34 0 006.33-6.34V8.69a8.18 8.18 0 004.78 1.52V6.75a4.85 4.85 0 01-1.01-.06z" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</div>