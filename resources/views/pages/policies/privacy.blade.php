<x-layout>
    <x-navbar />
    
    <x-breadcrumb :url="route('home')" label="Kembali ke Beranda" />

    <main class="min-h-screen bg-gradient-to-b from-gray-50 via-white to-pink-50/20 py-10 sm:py-14 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <!-- Header Section -->
            <div class="text-center max-w-3xl mx-auto mb-10 sm:mb-12">
                <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-900 tracking-tight mb-2">
                    Kebijakan Privasi Data
                </h1>
                <p class="text-gray-500 text-sm sm:text-base font-medium">
                    Privacy Policy • Terakhir diperbarui: 22 September 2026
                </p>

                <!-- Navigation Tabs between Policies -->
                <div class="flex flex-wrap justify-center gap-2 mt-6">
                    <a href="{{ route('terms') }}"
                        class="px-4 py-2 text-xs sm:text-sm font-semibold rounded-xl bg-white text-gray-600 hover:text-pink-600 hover:bg-pink-50 border border-gray-200 transition">
                        Syarat & Ketentuan (T&C)
                    </a>
                    <a href="{{ route('privacy') }}"
                        class="px-4 py-2 text-xs sm:text-sm font-bold rounded-xl bg-pink-600 text-white shadow-sm transition">
                        Kebijakan Privasi
                    </a>
                    <a href="{{ route('refund') }}"
                        class="px-4 py-2 text-xs sm:text-sm font-semibold rounded-xl bg-white text-gray-600 hover:text-pink-600 hover:bg-pink-50 border border-gray-200 transition">
                        Kebijakan Pembatalan & Refund
                    </a>
                </div>
            </div>

            <!-- Konten Dokumen (Full Width Terpusat, Tanpa Daftar Isi) -->
            <article class="bg-white rounded-3xl p-6 sm:p-12 lg:p-14 border border-gray-200/80 shadow-sm divide-y divide-gray-200/80 text-gray-700 leading-relaxed text-sm sm:text-base">
                <!-- Section 1 -->
                <section id="komitmen" class="pb-12 sm:pb-16">
                    <div class="flex items-center gap-3.5 mb-6">
                        <span class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-pink-100 text-pink-700 font-extrabold flex items-center justify-center text-sm sm:text-base shrink-0 shadow-xs">1</span>
                        <h2 class="text-xl sm:text-2xl font-bold text-gray-900">Komitmen Privasi Salonkita</h2>
                    </div>
                    <div class="space-y-4 text-gray-600 sm:text-[17px] leading-relaxed">
                        <p>
                            Salonkita ("SKID", "Kami") sangat menghargai privasi setiap pengguna, siswa, mentor, dan pengunjung platform kami. Kebijakan Privasi ini menjelaskan bagaimana kami mengumpulkan, menyimpan, memproses, menggunakan, dan melindungi data pribadi Anda sesuai dengan <strong>Undang-Undang Republik Indonesia No. 27 Tahun 2022 tentang Perlindungan Data Pribadi (UU PDP)</strong> serta regulasi terkait.
                        </p>
                    </div>
                </section>

                <!-- Section 2 -->
                <section id="data-dikumpulkan" class="py-12 sm:py-16">
                    <div class="flex items-center gap-3.5 mb-6">
                        <span class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-pink-100 text-pink-700 font-extrabold flex items-center justify-center text-sm sm:text-base shrink-0 shadow-xs">2</span>
                        <h2 class="text-xl sm:text-2xl font-bold text-gray-900">Data Pribadi yang Kami Kumpulkan</h2>
                    </div>
                    <div class="space-y-4 text-gray-600 sm:text-[17px] leading-relaxed">
                        <p>Kami mengumpulkan informasi yang Anda berikan secara langsung saat menggunakan platform kami, antara lain:</p>
                        <div class="space-y-3.5 pt-1">
                            <div class="p-4 sm:p-5 bg-gray-50 rounded-2xl border border-gray-100">
                                <h4 class="font-bold text-gray-900 text-base mb-1">A. Data Registrasi Akun</h4>
                                <p class="text-xs sm:text-sm text-gray-600">Nama lengkap (sesuai KTP untuk penerbitan e-sertifikat), alamat email, nomor telepon/WhatsApp aktif, kata sandi (disimpan secara terenkripsi hash Bcrypt), dan foto profil pengguna.</p>
                            </div>
                            <div class="p-4 sm:p-5 bg-gray-50 rounded-2xl border border-gray-100">
                                <h4 class="font-bold text-gray-900 text-base mb-1">B. Data Aktivitas Pembelajaran & Akademik</h4>
                                <p class="text-xs sm:text-sm text-gray-600">Riwayat modul video yang ditonton, progres pembelajaran, skor evaluasi kuis, portofolio tugas praktik kecantikan (tata rias/rambut), review dan rating kelas, serta catatan sertifikat kelulusan.</p>
                            </div>
                            <div class="p-4 sm:p-5 bg-gray-50 rounded-2xl border border-gray-100">
                                <h4 class="font-bold text-gray-900 text-base mb-1">C. Data Transaksi & Pembayaran</h4>
                                <p class="text-xs sm:text-sm text-gray-600">ID transaksi, nomor referensi invoice, nominal pembelian, metode pembayaran yang dipilih (Virtual Account / QRIS / E-Wallet / Kartu Kredit), status pembayaran, dan tanggal transaksi.</p>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Section 3 -->
                <section id="tujuan-penggunaan" class="py-12 sm:py-16">
                    <div class="flex items-center gap-3.5 mb-6">
                        <span class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-pink-100 text-pink-700 font-extrabold flex items-center justify-center text-sm sm:text-base shrink-0 shadow-xs">3</span>
                        <h2 class="text-xl sm:text-2xl font-bold text-gray-900">Tujuan Penggunaan Informasi Pribadi</h2>
                    </div>
                    <ul class="space-y-3.5 text-gray-600 sm:text-[17px] leading-relaxed">
                        <li class="flex items-start gap-3">
                            <span class="w-2 h-2 rounded-full bg-pink-500 mt-2.5 shrink-0"></span>
                            <div class="flex-1">Membuat dan mengelola akun akses kelas kursus kecantikan Anda.</div>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="w-2 h-2 rounded-full bg-pink-500 mt-2.5 shrink-0"></span>
                            <div class="flex-1">Memproses transaksi pembayaran dan aktivasi otomatis kursus secara real-time.</div>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="w-2 h-2 rounded-full bg-pink-500 mt-2.5 shrink-0"></span>
                            <div class="flex-1">Mencetak dan menerbitkan e-sertifikat resmi berverifikasi kode seri unik.</div>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="w-2 h-2 rounded-full bg-pink-500 mt-2.5 shrink-0"></span>
                            <div class="flex-1">Memfasilitasi penjadwalan sesi bimbingan 1-on-1 dengan mentor kecantikan pilihan Anda.</div>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="w-2 h-2 rounded-full bg-pink-500 mt-2.5 shrink-0"></span>
                            <div class="flex-1">Mengirimkan informasi pembaruan materi kursus, konfirmasi pembayaran, dan notifikasi kuis.</div>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="w-2 h-2 rounded-full bg-pink-500 mt-2.5 shrink-0"></span>
                            <div class="flex-1">Menjaga keamanan platform serta mendeteksi potensi kecurangan atau pelanggaran hak cipta.</div>
                        </li>
                    </ul>
                </section>

                <!-- Section 4 -->
                <section id="keamanan-transaksi" class="py-12 sm:py-16">
                    <div class="flex items-center gap-3.5 mb-6">
                        <span class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-pink-100 text-pink-700 font-extrabold flex items-center justify-center text-sm sm:text-base shrink-0 shadow-xs">4</span>
                        <h2 class="text-xl sm:text-2xl font-bold text-gray-900">Keamanan Pembayaran & Xendit Payment Gateway</h2>
                    </div>
                    <div class="space-y-4 text-gray-600 sm:text-[17px] leading-relaxed">
                        <div class="bg-pink-50/70 border border-pink-100 rounded-2xl p-5 sm:p-6">
                            <p class="text-base font-bold text-gray-900 mb-2">Perlindungan Data Finansial Tingkat Bank (PCI-DSS):</p>
                            <p class="text-sm sm:text-base text-gray-700 leading-relaxed">
                                Seluruh transaksi di platform Salonkita diproses melalui penyedia gerbang pembayaran resmi berlisensi Bank Indonesia yaitu <strong>Xendit</strong>. Salonkita <strong>TIDAK PERNAH</strong> menyimpan nomor kartu kredit penuh, kode CVV/CVC, maupun data rahasia perbankan Anda di server kami. Semua data finansial diproses langsung secara aman di server payment gateway yang tersertifikasi PCI-DSS Level 1.
                            </p>
                        </div>
                    </div>
                </section>

                <!-- Section 5 -->
                <section id="pihak-ketiga" class="py-12 sm:py-16">
                    <div class="flex items-center gap-3.5 mb-6">
                        <span class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-pink-100 text-pink-700 font-extrabold flex items-center justify-center text-sm sm:text-base shrink-0 shadow-xs">5</span>
                        <h2 class="text-xl sm:text-2xl font-bold text-gray-900">Pembagian Data ke Pihak Ketiga</h2>
                    </div>
                    <div class="space-y-4 text-gray-600 sm:text-[17px] leading-relaxed">
                        <p>
                            Salonkita <strong>TIDAK AKAN PERNAH</strong> menjual, menyewakan, memperdagangkan, atau membagikan data pribadi Anda kepada pihak ketiga untuk kepentingan pemasaran pihak lain. Kami hanya membagikan data Anda kepada:
                        </p>
                        <ul class="space-y-3">
                            <li class="flex items-start gap-3">
                                <span class="w-2 h-2 rounded-full bg-pink-500 mt-2.5 shrink-0"></span>
                                <div class="flex-1"><strong>Mitra Layanan Pembayaran Resmi:</strong> Xendit (hanya untuk pemrosesan status invoice transaksi Anda).</div>
                            </li>
                            <li class="flex items-start gap-3">
                                <span class="w-2 h-2 rounded-full bg-pink-500 mt-2.5 shrink-0"></span>
                                <div class="flex-1"><strong>Mentor & Instruktur Kelas:</strong> Hanya data relevan seperti nama siswa dan tugas praktik yang dikumpulkan untuk keperluan penilaian dan feedback.</div>
                            </li>
                            <li class="flex items-start gap-3">
                                <span class="w-2 h-2 rounded-full bg-pink-500 mt-2.5 shrink-0"></span>
                                <div class="flex-1"><strong>Kewajiban Hukum:</strong> Lembaga penegak hukum atau otoritas berwenang Republik Indonesia jika terdapat surat perintah sah sesuai undang-undang yang berlaku.</div>
                            </li>
                        </ul>
                    </div>
                </section>

                <!-- Section 6 -->
                <section id="penyimpanan-keamanan" class="py-12 sm:py-16">
                    <div class="flex items-center gap-3.5 mb-6">
                        <span class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-pink-100 text-pink-700 font-extrabold flex items-center justify-center text-sm sm:text-base shrink-0 shadow-xs">6</span>
                        <h2 class="text-xl sm:text-2xl font-bold text-gray-900">Penyimpanan & Perlindungan Data</h2>
                    </div>
                    <div class="space-y-4 text-gray-600 sm:text-[17px] leading-relaxed">
                        <p>
                            Kami menerapkan standar keamanan teknis dan organisasional yang ketat, meliputi enkripsi kata sandi menggunakan hashing modern (Bcrypt), firewall jaringan, dan kontrol akses berjenjang. Kami menyimpan data pribadi Anda selama akun Anda aktif di Salonkita atau selama diwajibkan oleh ketentuan hukum dan perpajakan Indonesia.
                        </p>
                    </div>
                </section>

                <!-- Section 7 -->
                <section id="hak-pengguna" class="py-12 sm:py-16">
                    <div class="flex items-center gap-3.5 mb-6">
                        <span class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-pink-100 text-pink-700 font-extrabold flex items-center justify-center text-sm sm:text-base shrink-0 shadow-xs">7</span>
                        <h2 class="text-xl sm:text-2xl font-bold text-gray-900">Hak-Hak Pemilik Data (Hak Anda)</h2>
                    </div>
                    <div class="space-y-4 text-gray-600 sm:text-[17px] leading-relaxed">
                        <p>Berdasarkan UU Perlindungan Data Pribadi (UU PDP), Anda memiliki hak untuk:</p>
                        <ul class="space-y-3">
                            <li class="flex items-start gap-3">
                                <span class="w-2 h-2 rounded-full bg-pink-500 mt-2.5 shrink-0"></span>
                                <div class="flex-1"><strong>Mengakses & Memperbarui Data:</strong> Anda dapat memperbarui profil, nomor telepon, dan foto melalui menu <a href="{{ route('profile') }}" class="text-pink-600 font-semibold underline hover:text-pink-700">Profil Saya</a>.</div>
                            </li>
                            <li class="flex items-start gap-3">
                                <span class="w-2 h-2 rounded-full bg-pink-500 mt-2.5 shrink-0"></span>
                                <div class="flex-1"><strong>Memperbaiki Data Sertifikat:</strong> Mengajukan koreksi nama jika terdapat kekeliruan cetak sebelum sertifikat resmi diterbitkan.</div>
                            </li>
                            <li class="flex items-start gap-3">
                                <span class="w-2 h-2 rounded-full bg-pink-500 mt-2.5 shrink-0"></span>
                                <div class="flex-1"><strong>Menghapus Akun (Right to Erasure):</strong> Meminta penutupan dan penghapusan akun melalui email dukungan resmi kami.</div>
                            </li>
                        </ul>
                    </div>
                </section>

                <!-- Section 8 -->
                <section id="cookies" class="py-12 sm:py-16">
                    <div class="flex items-center gap-3.5 mb-6">
                        <span class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-pink-100 text-pink-700 font-extrabold flex items-center justify-center text-sm sm:text-base shrink-0 shadow-xs">8</span>
                        <h2 class="text-xl sm:text-2xl font-bold text-gray-900">Penggunaan Cookies & Sesi</h2>
                    </div>
                    <div class="space-y-4 text-gray-600 sm:text-[17px] leading-relaxed">
                        <p>
                            Kami menggunakan cookies sesi yang aman (secure cookies) untuk menjaga status login Anda, mengingat preferensi tampilan, dan mencegah serangan CSRF (Cross-Site Request Forgery). Anda dapat menonaktifkan cookies di browser Anda, namun beberapa fungsi seperti tetap masuk ke akun mungkin tidak berjalan maksimal.
                        </p>
                    </div>
                </section>

                <!-- Section 9 -->
                <section id="kontak-privasi" class="pt-12 sm:pt-16">
                    <div class="flex items-center gap-3.5 mb-6">
                        <span class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-pink-100 text-pink-700 font-extrabold flex items-center justify-center text-sm sm:text-base shrink-0 shadow-xs">9</span>
                        <h2 class="text-xl sm:text-2xl font-bold text-gray-900">Kontak Petugas Privasi & Pengaduan</h2>
                    </div>
                    <div class="space-y-4 text-gray-600 sm:text-[17px] leading-relaxed">
                        <p>
                            Jika Anda memiliki pertanyaan, keberatan, atau ingin menggunakan hak privasi Anda, silakan hubungi tim Perlindungan Data Salonkita:
                        </p>
                        <div class="bg-gray-50 border border-gray-200 rounded-2xl p-5 text-xs sm:text-sm text-gray-700 space-y-2">
                            <p><strong>Email Tim Privasi & Keamanan:</strong> <a href="mailto:support@salonkita.com" class="text-pink-600 font-semibold underline">support@salonkita.com</a></p>
                            <p><strong>Layanan Pelanggan WhatsApp:</strong> <a href="https://wa.me/6281234567890" target="_blank" class="text-pink-600 font-semibold underline">+62 812-3456-7890</a></p>
                            <p><strong>Platform:</strong> Salonkita (SKID) - Edukasi Keahlian Kecantikan Profesional Indonesia</p>
                        </div>
                    </div>
                </section>
            </article>
        </div>
    </main>

    <x-footer />
</x-layout>
