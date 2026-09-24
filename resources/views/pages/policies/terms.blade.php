<x-layout>
    <x-navbar />
    
    <x-breadcrumb :url="route('home')" label="Kembali ke Beranda" />

    <main class="min-h-screen bg-gradient-to-b from-gray-50 via-white to-pink-50/20 py-10 sm:py-14 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <!-- Header Section -->
            <div class="text-center max-w-3xl mx-auto mb-10 sm:mb-12">
                <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-900 tracking-tight mb-2">
                    Syarat & Ketentuan Penggunaan
                </h1>
                <p class="text-gray-500 text-sm sm:text-base font-medium">
                    Terms & Conditions • Terakhir diperbarui: 22 September 2026
                </p>

                <!-- Navigation Tabs between Policies -->
                <div class="flex flex-wrap justify-center gap-2 mt-6">
                    <a href="{{ route('terms') }}"
                        class="px-4 py-2 text-xs sm:text-sm font-bold rounded-xl bg-pink-600 text-white shadow-sm transition">
                        Syarat & Ketentuan (T&C)
                    </a>
                    <a href="{{ route('privacy') }}"
                        class="px-4 py-2 text-xs sm:text-sm font-semibold rounded-xl bg-white text-gray-600 hover:text-pink-600 hover:bg-pink-50 border border-gray-200 transition">
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
                <section id="pendahuluan" class="pb-12 sm:pb-16">
                    <div class="flex items-center gap-3.5 mb-6">
                        <span class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-pink-100 text-pink-700 font-extrabold flex items-center justify-center text-sm sm:text-base shrink-0 shadow-xs">1</span>
                        <h2 class="text-xl sm:text-2xl font-bold text-gray-900">Pendahuluan & Penerimaan Ketentuan</h2>
                    </div>
                    <div class="space-y-4 text-gray-600 sm:text-[17px] leading-relaxed">
                        <p>
                            Selamat datang di platform pembelajaran kecantikan daring <strong>Salonkita</strong> (atau disingkat "SKID"). Syarat & Ketentuan Penggunaan ini ("Ketentuan") merupakan perjanjian yang mengikat secara hukum antara Anda ("Pengguna", "Siswa", atau "Anda") dengan pengelola Salonkita ("Kami").
                        </p>
                        <p>
                            Dengan mendaftar, mengakses, membeli kursus, atau menggunakan fitur apa pun di website ini, Anda menyatakan bahwa Anda telah membaca, memahami, dan menyetujui seluruh isi Syarat & Ketentuan ini serta <a href="{{ route('privacy') }}" class="text-pink-600 font-semibold underline hover:text-pink-700">Kebijakan Privasi</a> dan <a href="{{ route('refund') }}" class="text-pink-600 font-semibold underline hover:text-pink-700">Kebijakan Pembatalan & Refund</a> kami.
                        </p>
                    </div>
                </section>

                <!-- Section 2 -->
                <section id="definisi" class="py-12 sm:py-16">
                    <div class="flex items-center gap-3.5 mb-6">
                        <span class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-pink-100 text-pink-700 font-extrabold flex items-center justify-center text-sm sm:text-base shrink-0 shadow-xs">2</span>
                        <h2 class="text-xl sm:text-2xl font-bold text-gray-900">Definisi Istilah</h2>
                    </div>
                    <ul class="space-y-3.5 text-gray-600 sm:text-[17px] leading-relaxed">
                        <li class="flex items-start gap-3">
                            <span class="w-2 h-2 rounded-full bg-pink-500 mt-2.5 shrink-0"></span>
                            <div class="flex-1"><strong>Platform Salonkita:</strong> Situs web lms-salonkita dan seluruh domain, sub-domain, atau aplikasi terkait yang dioperasikan oleh pihak Salonkita.</div>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="w-2 h-2 rounded-full bg-pink-500 mt-2.5 shrink-0"></span>
                            <div class="flex-1"><strong>Akun:</strong> Identitas digital unik yang dibuat oleh Pengguna untuk mengakses materi, kuis, sesi mentoring, dan transaksi di Salonkita.</div>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="w-2 h-2 rounded-full bg-pink-500 mt-2.5 shrink-0"></span>
                            <div class="flex-1"><strong>Kelas / Kursus:</strong> Program edukasi kecantikan daring (video tutorial, kuis evaluasi, modul praktik, tugas, dan sertifikat) berkategori Basic, Intermediate, maupun Advanced.</div>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="w-2 h-2 rounded-full bg-pink-500 mt-2.5 shrink-0"></span>
                            <div class="flex-1"><strong>Layanan Mentoring:</strong> Sesi bimbingan terarah, konsultasi karir kecantikan, atau review portofolio secara daring antara Mentee dan Mentor/Coach resmi.</div>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="w-2 h-2 rounded-full bg-pink-500 mt-2.5 shrink-0"></span>
                            <div class="flex-1"><strong>Payment Gateway:</strong> Penyedia gerbang pembayaran resmi pihak ketiga berlisensi Bank Indonesia (termasuk Xendit) yang terintegrasi di Salonkita untuk memproses pembayaran aman melalui Virtual Account, E-Wallet, QRIS, maupun Kartu Kredit.</div>
                        </li>
                    </ul>
                </section>

                <!-- Section 3 -->
                <section id="akun" class="py-12 sm:py-16">
                    <div class="flex items-center gap-3.5 mb-6">
                        <span class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-pink-100 text-pink-700 font-extrabold flex items-center justify-center text-sm sm:text-base shrink-0 shadow-xs">3</span>
                        <h2 class="text-xl sm:text-2xl font-bold text-gray-900">Pendaftaran & Keamanan Akun</h2>
                    </div>
                    <ul class="space-y-3.5 text-gray-600 sm:text-[17px] leading-relaxed">
                        <li class="flex items-start gap-3">
                            <span class="w-2 h-2 rounded-full bg-pink-500 mt-2.5 shrink-0"></span>
                            <div class="flex-1">Pengguna wajib berusia sekurang-kurangnya 17 tahun atau memiliki izin sah dari orang tua/wali untuk menggunakan layanan berbayar.</div>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="w-2 h-2 rounded-full bg-pink-500 mt-2.5 shrink-0"></span>
                            <div class="flex-1">Pengguna wajib memberikan data yang akurat, jujur, dan terkini pada saat pendaftaran (nama lengkap yang sesuai identitas untuk pencetakan e-sertifikat resmi).</div>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="w-2 h-2 rounded-full bg-pink-500 mt-2.5 shrink-0"></span>
                            <div class="flex-1">Pengguna bertanggung jawab penuh dalam menjaga kerahasiaan kata sandi (password) akun. Segala aktivitas yang terjadi di bawah akun Anda merupakan tanggung jawab Anda sepenuhnya.</div>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="w-2 h-2 rounded-full bg-pink-500 mt-2.5 shrink-0"></span>
                            <div class="flex-1">Satu akun hanya diperuntukkan bagi 1 (satu) individu. Dilarang meminjamkan, menjual, atau membagikan akses akun kepada pihak lain mana pun.</div>
                        </li>
                    </ul>
                </section>

                <!-- Section 4 -->
                <section id="pembayaran" class="py-12 sm:py-16">
                    <div class="flex items-center gap-3.5 mb-6">
                        <span class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-pink-100 text-pink-700 font-extrabold flex items-center justify-center text-sm sm:text-base shrink-0 shadow-xs">4</span>
                        <h2 class="text-xl sm:text-2xl font-bold text-gray-900">Pembelian, Transaksi & Pembayaran</h2>
                    </div>
                    <div class="space-y-4 text-gray-600 sm:text-[17px] leading-relaxed">
                        <p>
                            Semua harga kursus dan layanan mentoring tertera dalam mata uang <strong>Rupiah (IDR)</strong>. Transaksi diproses secara real-time dan terenkripsi menggunakan mitra Payment Gateway resmi (Xendit).
                        </p>
                        <div class="bg-pink-50/70 border-l-4 border-pink-500 p-4 sm:p-5 rounded-r-2xl text-xs sm:text-sm text-gray-700 space-y-1 my-3">
                            <p class="font-bold text-gray-900 text-sm sm:text-base">Pemberitahuan Transaksi Otomatis:</p>
                            <p>Kelas berbayar akan aktif otomatis setelah pembayaran Anda diverifikasi oleh payment gateway. Anda akan menerima notifikasi status transaksi di sistem dan invoice pembayaran.</p>
                        </div>
                        <p>
                            Ketentuan pengembalian dana dan pembatalan transaksi tunduk secara tegas pada <a href="{{ route('refund') }}" class="text-pink-600 font-semibold underline hover:text-pink-700">Kebijakan Pembatalan & Pengembalian Dana</a> Salonkita.
                        </p>
                    </div>
                </section>

                <!-- Section 5 -->
                <section id="hak-cipta" class="py-12 sm:py-16">
                    <div class="flex items-center gap-3.5 mb-6">
                        <span class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-pink-100 text-pink-700 font-extrabold flex items-center justify-center text-sm sm:text-base shrink-0 shadow-xs">5</span>
                        <h2 class="text-xl sm:text-2xl font-bold text-gray-900">Hak Kekayaan Intelektual (HAKI)</h2>
                    </div>
                    <div class="space-y-4 text-gray-600 sm:text-[17px] leading-relaxed">
                        <p>
                            Seluruh materi pembelajaran di Salonkita—termasuk namun tidak terbatas pada video rekaman, modul teks, ilustrasi grafis, materi presentasi instruktur, bank soal kuis, kurikulum, logo, dan desain platform—merupakan hak cipta yang dilindungi oleh Undang-Undang Hak Cipta No. 28 Tahun 2014 Republik Indonesia.
                        </p>
                        <div class="bg-red-50 border border-red-200 rounded-2xl p-4 sm:p-5 text-red-800 text-xs sm:text-sm my-3">
                            <span class="font-bold">Larangan Keras Pembajakan:</span> Pengguna DILARANG KERAS merekam layar (screen recording), mengunduh video tanpa hak, memperbanyak, mendistribusikan ulang di platform publik/media sosial, atau menjual kembali materi kelas Salonkita. Pelanggaran akan berakibat pemblokiran akun permanen tanpa refund serta tuntutan pidana/perdata.
                        </div>
                    </div>
                </section>

                <!-- Section 6 -->
                <section id="sertifikat" class="py-12 sm:py-16">
                    <div class="flex items-center gap-3.5 mb-6">
                        <span class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-pink-100 text-pink-700 font-extrabold flex items-center justify-center text-sm sm:text-base shrink-0 shadow-xs">6</span>
                        <h2 class="text-xl sm:text-2xl font-bold text-gray-900">Sertifikasi & Kelulusan Kelas</h2>
                    </div>
                    <ul class="space-y-3.5 text-gray-600 sm:text-[17px] leading-relaxed">
                        <li class="flex items-start gap-3">
                            <span class="w-2 h-2 rounded-full bg-pink-500 mt-2.5 shrink-0"></span>
                            <div class="flex-1">E-Sertifikat kelulusan hanya diterbitkan apabila Pengguna telah menyelesaikan seluruh persyaratan modul: menonton 100% video materi, lulus kuis evaluasi dengan passing score yang ditentukan, dan mengumpulkan tugas praktik yang telah disetujui (apabila dipersyaratkan).</div>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="w-2 h-2 rounded-full bg-pink-500 mt-2.5 shrink-0"></span>
                            <div class="flex-1">E-sertifikat dilengkapi nomor seri unik dan kode verifikasi digital yang dapat dicek keabsahannya oleh pihak pemberi kerja atau salon mitra.</div>
                        </li>
                    </ul>
                </section>

                <!-- Section 7 -->
                <section id="mentoring" class="py-12 sm:py-16">
                    <div class="flex items-center gap-3.5 mb-6">
                        <span class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-pink-100 text-pink-700 font-extrabold flex items-center justify-center text-sm sm:text-base shrink-0 shadow-xs">7</span>
                        <h2 class="text-xl sm:text-2xl font-bold text-gray-900">Layanan Mentoring & Sesi 1-on-1</h2>
                    </div>
                    <div class="space-y-4 text-gray-600 sm:text-[17px] leading-relaxed">
                        <p>
                            Pengguna yang memiliki kuota atau membeli paket mentoring berhak melakukan booking jadwal dengan Mentor/Coach sesuai ketersediaan kalender.
                        </p>
                        <ul class="space-y-3.5">
                            <li class="flex items-start gap-3">
                                <span class="w-2 h-2 rounded-full bg-pink-500 mt-2.5 shrink-0"></span>
                                <div class="flex-1">Peserta wajib hadir tepat waktu melalui tautan video meeting yang disediakan.</div>
                            </li>
                            <li class="flex items-start gap-3">
                                <span class="w-2 h-2 rounded-full bg-pink-500 mt-2.5 shrink-0"></span>
                                <div class="flex-1">Penjadwalan ulang (reschedule) wajib diajukan maksimal 24 jam sebelum sesi berlangsung. Keterlambatan lebih dari 15 menit tanpa kabar dapat dianggap sebagai sesi hangus.</div>
                            </li>
                            <li class="flex items-start gap-3">
                                <span class="w-2 h-2 rounded-full bg-pink-500 mt-2.5 shrink-0"></span>
                                <div class="flex-1">Etika saling menghormati wajib dijaga selama interaksi mentoring berlangsung.</div>
                            </li>
                        </ul>
                    </div>
                </section>

                <!-- Section 8 -->
                <section id="larangan" class="py-12 sm:py-16">
                    <div class="flex items-center gap-3.5 mb-6">
                        <span class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-pink-100 text-pink-700 font-extrabold flex items-center justify-center text-sm sm:text-base shrink-0 shadow-xs">8</span>
                        <h2 class="text-xl sm:text-2xl font-bold text-gray-900">Larangan & Tindakan Pelanggaran</h2>
                    </div>
                    <div class="space-y-4 text-gray-600 sm:text-[17px] leading-relaxed">
                        <p>Dalam menggunakan platform Salonkita, Pengguna dilarang keras:</p>
                        <ul class="space-y-3">
                            <li class="flex items-start gap-3">
                                <span class="w-2 h-2 rounded-full bg-pink-500 mt-2.5 shrink-0"></span>
                                <div class="flex-1">Menggunakan metode peretasan, bot otomatis, scraping data, atau mengganggu kestabilan server platform.</div>
                            </li>
                            <li class="flex items-start gap-3">
                                <span class="w-2 h-2 rounded-full bg-pink-500 mt-2.5 shrink-0"></span>
                                <div class="flex-1">Mengunggah konten tugas yang mengandung unsur SARA, pornografi, ujaran kebencian, atau melanggar hak cipta orang lain.</div>
                            </li>
                            <li class="flex items-start gap-3">
                                <span class="w-2 h-2 rounded-full bg-pink-500 mt-2.5 shrink-0"></span>
                                <div class="flex-1">Melakukan transaksi mencurigakan, penipuan kartu kredit, atau pencucian uang melalui sistem pembayaran.</div>
                            </li>
                        </ul>
                    </div>
                </section>

                <!-- Section 9 -->
                <section id="disclaimer" class="py-12 sm:py-16">
                    <div class="flex items-center gap-3.5 mb-6">
                        <span class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-pink-100 text-pink-700 font-extrabold flex items-center justify-center text-sm sm:text-base shrink-0 shadow-xs">9</span>
                        <h2 class="text-xl sm:text-2xl font-bold text-gray-900">Pembatasan Tanggung Jawab (Disclaimer)</h2>
                    </div>
                    <div class="space-y-4 text-gray-600 sm:text-[17px] leading-relaxed">
                        <p>
                            Materi kursus Salonkita disusun dengan standar edukasi kecantikan profesional oleh instruktur berkompeten. Namun demikian, hasil keahlian, tingkat pendapatan usaha salon, atau keberhasilan individu setelah mengikuti kursus sangat bergantung pada komitmen, ketekunan berlatih, dan dedikasi pribadi masing-masing peserta. Salonkita tidak memberikan jaminan keuntungan finansial tertentu atas keikutsertaan kursus.
                        </p>
                    </div>
                </section>

                <!-- Section 10 -->
                <section id="hukum" class="pt-12 sm:pt-16">
                    <div class="flex items-center gap-3.5 mb-6">
                        <span class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-pink-100 text-pink-700 font-extrabold flex items-center justify-center text-sm sm:text-base shrink-0 shadow-xs">10</span>
                        <h2 class="text-xl sm:text-2xl font-bold text-gray-900">Hukum yang Berlaku & Penyelesaian Sengketa</h2>
                    </div>
                    <div class="space-y-4 text-gray-600 sm:text-[17px] leading-relaxed">
                        <p>
                            Syarat dan Ketentuan ini diatur dan ditafsirkan sesuai dengan hukum Negara Kesatuan Republik Indonesia. Setiap perselisihan yang timbul akan diupayakan untuk diselesaikan terlebih dahulu secara musyawarah mufakat. Apabila tidak tercapai mufakat dalam jangka waktu 30 (tiga puluh) hari kalender, maka para pihak sepakat untuk menyelesaikan sengketa melalui yurisdiksi Pengadilan Negeri yang berwenang di Indonesia.
                        </p>
                    </div>
                </section>
            </article>
        </div>
    </main>

    <x-footer />
</x-layout>
