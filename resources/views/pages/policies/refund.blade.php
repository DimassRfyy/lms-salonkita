<x-layout>
    <x-navbar />
    
    <x-breadcrumb :url="route('home')" label="Kembali ke Beranda" />

    <main class="min-h-screen bg-gradient-to-b from-gray-50 via-white to-pink-50/20 py-10 sm:py-14 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <!-- Header Section -->
            <div class="text-center max-w-3xl mx-auto mb-10 sm:mb-12">
                <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-900 tracking-tight mb-2">
                    Kebijakan Pembatalan & Pengembalian Dana
                </h1>
                <p class="text-gray-500 text-sm sm:text-base font-medium">
                    Refund & Cancellation Policy • Terakhir diperbarui: 22 September 2026
                </p>

                <!-- Navigation Tabs between Policies -->
                <div class="flex flex-wrap justify-center gap-2 mt-6">
                    <a href="{{ route('terms') }}"
                        class="px-4 py-2 text-xs sm:text-sm font-semibold rounded-xl bg-white text-gray-600 hover:text-pink-600 hover:bg-pink-50 border border-gray-200 transition">
                        Syarat & Ketentuan (T&C)
                    </a>
                    <a href="{{ route('privacy') }}"
                        class="px-4 py-2 text-xs sm:text-sm font-semibold rounded-xl bg-white text-gray-600 hover:text-pink-600 hover:bg-pink-50 border border-gray-200 transition">
                        Kebijakan Privasi
                    </a>
                    <a href="{{ route('refund') }}"
                        class="px-4 py-2 text-xs sm:text-sm font-bold rounded-xl bg-pink-600 text-white shadow-sm transition">
                        Kebijakan Pembatalan & Refund
                    </a>
                </div>
            </div>

            <!-- Konten Dokumen (Full Width Terpusat, Tanpa Daftar Isi) -->
            <article class="bg-white rounded-3xl p-6 sm:p-12 lg:p-14 border border-gray-200/80 shadow-sm divide-y divide-gray-200/80 text-gray-700 leading-relaxed text-sm sm:text-base">
                <!-- Section 1 -->
                <section id="prinsip-umum" class="pb-12 sm:pb-16">
                    <div class="flex items-center gap-3.5 mb-6">
                        <span class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-pink-100 text-pink-700 font-extrabold flex items-center justify-center text-sm sm:text-base shrink-0 shadow-xs">1</span>
                        <h2 class="text-xl sm:text-2xl font-bold text-gray-900">Prinsip Umum Produk Digital</h2>
                    </div>
                    <div class="space-y-4 text-gray-600 sm:text-[17px] leading-relaxed">
                        <p>
                            Di platform <strong>Salonkita</strong>, sebagian besar produk yang ditawarkan adalah kursus kecantikan online berbentuk materi digital (video tutorial rekaman, modul panduan, kuis, dan e-sertifikat). Karena sifat produk digital yang dapat langsung dikonsumsi dan diakses seketika setelah pembayaran terverifikasi, maka ketentuan pengembalian dana diatur secara jelas dan transparan untuk melindungi hak konsumen sekaligus mencegah penyalahgunaan hak cipta intelektual.
                        </p>
                    </div>
                </section>

                <!-- Section 2 -->
                <section id="kelayakan-refund" class="py-12 sm:py-16">
                    <div class="flex items-center gap-3.5 mb-6">
                        <span class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-emerald-100 text-emerald-800 font-extrabold flex items-center justify-center text-sm sm:text-base shrink-0 shadow-xs">2</span>
                        <h2 class="text-xl sm:text-2xl font-bold text-gray-900">Kondisi yang Berhak Mendapatkan Pengembalian Dana (Eligible)</h2>
                    </div>
                    <div class="space-y-4 text-gray-600 sm:text-[17px] leading-relaxed">
                        <p>Pengguna berhak mengajukan pengembalian dana 100% apabila memenuhi salah satu kondisi berikut:</p>
                        <div class="space-y-3.5 pt-1">
                            <div class="p-4 sm:p-5 bg-emerald-50/60 rounded-2xl border border-emerald-100 flex items-start gap-4">
                                <span class="w-6 h-6 rounded-full bg-emerald-100 text-emerald-700 font-bold text-xs flex items-center justify-center shrink-0 mt-0.5">✓</span>
                                <div>
                                    <h4 class="font-bold text-gray-900 text-base">Pembayaran Ganda (Double Charge)</h4>
                                    <p class="text-xs sm:text-sm text-gray-600 mt-1">Terjadi debit ganda atau pembayaran terduplikasi pada satu pesanan kelas yang sama karena gangguan jaringan perbankan atau payment gateway.</p>
                                </div>
                            </div>
                            <div class="p-4 sm:p-5 bg-emerald-50/60 rounded-2xl border border-emerald-100 flex items-start gap-4">
                                <span class="w-6 h-6 rounded-full bg-emerald-100 text-emerald-700 font-bold text-xs flex items-center justify-center shrink-0 mt-0.5">✓</span>
                                <div>
                                    <h4 class="font-bold text-gray-900 text-base">Kegagalan Aktivasi Sistem Permanen</h4>
                                    <p class="text-xs sm:text-sm text-gray-600 mt-1">Pembayaran telah berhasil didebit dari rekening/e-wallet Anda, namun sistem Salonkita gagal mengaktivasi akses kelas dan tim teknis kami tidak dapat menyelesaikannya dalam waktu 2x24 jam sejak dilaporkan.</p>
                                </div>
                            </div>
                            <div class="p-4 sm:p-5 bg-emerald-50/60 rounded-2xl border border-emerald-100 flex items-start gap-4">
                                <span class="w-6 h-6 rounded-full bg-emerald-100 text-emerald-700 font-bold text-xs flex items-center justify-center shrink-0 mt-0.5">✓</span>
                                <div>
                                    <h4 class="font-bold text-gray-900 text-base">Materi Rusak / Tidak Dapat Diakses dari Sisi Server</h4>
                                    <p class="text-xs sm:text-sm text-gray-600 mt-1">Konten video atau materi kelas mengalami kerusakan teknis permanen di server kami sehingga tidak dapat ditonton sama sekali, dan pengaduan diajukan dalam waktu maksimal 7 (tujuh) hari kalender sejak tanggal transaksi.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Section 3 -->
                <section id="tidak-layak" class="py-12 sm:py-16">
                    <div class="flex items-center gap-3.5 mb-6">
                        <span class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-red-100 text-red-700 font-extrabold flex items-center justify-center text-sm sm:text-base shrink-0 shadow-xs">3</span>
                        <h2 class="text-xl sm:text-2xl font-bold text-gray-900">Kondisi yang TIDAK Memenuhi Syarat Refund (Non-Refundable)</h2>
                    </div>
                    <div class="space-y-4 text-gray-600 sm:text-[17px] leading-relaxed">
                        <p>Permohonan pengembalian dana <strong>TIDAK DAPAT DITERIMA</strong> dalam situasi berikut:</p>
                        <ul class="space-y-3">
                            <li class="flex items-start gap-3">
                                <span class="w-2 h-2 rounded-full bg-red-500 mt-2.5 shrink-0"></span>
                                <div class="flex-1">Pengguna telah menonton lebih dari <strong>20% durasi video pembelajaran</strong> di kelas tersebut.</div>
                            </li>
                            <li class="flex items-start gap-3">
                                <span class="w-2 h-2 rounded-full bg-red-500 mt-2.5 shrink-0"></span>
                                <div class="flex-1">Pengguna telah mengerjakan kuis, mengunggah tugas submission, atau mengklaim/mengunduh sertifikat kelulusan.</div>
                            </li>
                            <li class="flex items-start gap-3">
                                <span class="w-2 h-2 rounded-full bg-red-500 mt-2.5 shrink-0"></span>
                                <div class="flex-1">Pengguna berubah pikiran, merasa salah memilih kelas, atau tidak lagi memiliki waktu luang untuk belajar.</div>
                            </li>
                            <li class="flex items-start gap-3">
                                <span class="w-2 h-2 rounded-full bg-red-500 mt-2.5 shrink-0"></span>
                                <div class="flex-1">Kendala yang berasal dari perangkat keras pribadi pengguna atau koneksi jaringan internet pribadi yang lambat/tidak memadai.</div>
                            </li>
                            <li class="flex items-start gap-3">
                                <span class="w-2 h-2 rounded-full bg-red-500 mt-2.5 shrink-0"></span>
                                <div class="flex-1">Akun pengguna dinonaktifkan atau diblokir akibat pelanggaran berat terhadap Syarat & Ketentuan (seperti membajak/merekam materi kelas).</div>
                            </li>
                            <li class="flex items-start gap-3">
                                <span class="w-2 h-2 rounded-full bg-red-500 mt-2.5 shrink-0"></span>
                                <div class="flex-1">Permohonan diajukan lebih dari 7 (tujuh) hari kalender sejak tanggal transaksi berhasil.</div>
                            </li>
                        </ul>
                    </div>
                </section>

                <!-- Section 4 -->
                <section id="pembatalan-mentoring" class="py-12 sm:py-16">
                    <div class="flex items-center gap-3.5 mb-6">
                        <span class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-pink-100 text-pink-700 font-extrabold flex items-center justify-center text-sm sm:text-base shrink-0 shadow-xs">4</span>
                        <h2 class="text-xl sm:text-2xl font-bold text-gray-900">Kebijakan Pembatalan & Reschedule Mentoring 1-on-1</h2>
                    </div>
                    <div class="space-y-4 text-gray-600 sm:text-[17px] leading-relaxed">
                        <div class="p-4 sm:p-5 bg-gray-50 rounded-2xl border border-gray-100 space-y-2.5">
                            <h4 class="font-bold text-gray-900 text-base">A. Pembatalan oleh Mentee (Peserta):</h4>
                            <ul class="space-y-2">
                                <li class="flex items-start gap-2.5">
                                    <span class="w-1.5 h-1.5 rounded-full bg-pink-500 mt-2 shrink-0"></span>
                                    <div class="flex-1 text-xs sm:text-sm text-gray-600">Pembatalan atau permintaan jadwal ulang yang diajukan <strong>lebih dari 24 jam</strong> sebelum sesi dimulai: Jadwal dapat diatur ulang (reschedule) gratis tanpa penalti.</div>
                                </li>
                                <li class="flex items-start gap-2.5">
                                    <span class="w-1.5 h-1.5 rounded-full bg-pink-500 mt-2 shrink-0"></span>
                                    <div class="flex-1 text-xs sm:text-sm text-gray-600">Pembatalan <strong>kurang dari 24 jam</strong> atau peserta tidak hadir (no-show) tanpa kabar dalam 15 menit pertama: Sesi mentoring dinyatakan hangus dan tidak dapat dikembalikan.</div>
                                </li>
                            </ul>
                        </div>
                        <div class="p-4 sm:p-5 bg-gray-50 rounded-2xl border border-gray-100 space-y-2">
                            <h4 class="font-bold text-gray-900 text-base">B. Pembatalan oleh Mentor / Coach:</h4>
                            <p class="text-xs sm:text-sm text-gray-600">
                                Apabila mentor/coach berhalangan hadir karena kondisi darurat mendadak, peserta berhak mendapatkan penjadwalan ulang prioritas di waktu yang disepakati atau opsi pengembalian kuota/dana penuh untuk sesi tersebut.
                            </p>
                        </div>
                    </div>
                </section>

                <!-- Section 5 -->
                <section id="alur-pengajuan" class="py-12 sm:py-16">
                    <div class="flex items-center gap-3.5 mb-6">
                        <span class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-pink-100 text-pink-700 font-extrabold flex items-center justify-center text-sm sm:text-base shrink-0 shadow-xs">5</span>
                        <h2 class="text-xl sm:text-2xl font-bold text-gray-900">Prosedur & Alur Pengajuan Refund</h2>
                    </div>
                    <div class="space-y-4 text-gray-600 sm:text-[17px] leading-relaxed">
                        <p>Untuk mengajukan permohonan pengembalian dana, ikuti langkah berikut:</p>
                        <ol class="space-y-4 pt-1">
                            <li class="flex items-start gap-3.5">
                                <span class="w-7 h-7 rounded-lg bg-pink-100 text-pink-700 font-bold text-xs flex items-center justify-center shrink-0 mt-0.5">1</span>
                                <div class="flex-1">
                                    Kirimkan email resmi ke <a href="mailto:info@skid.co.id" class="text-pink-600 font-semibold underline">info@skid.co.id</a> dengan subjek format: <code>[Pengajuan Refund] - [ID Transaksi] - [Nama Anda]</code>.
                                </div>
                            </li>
                            <li class="flex items-start gap-3.5">
                                <span class="w-7 h-7 rounded-lg bg-pink-100 text-pink-700 font-bold text-xs flex items-center justify-center shrink-0 mt-0.5">2</span>
                                <div class="flex-1">
                                    <p class="mb-2">Cantumkan informasi lengkap berikut:</p>
                                    <ul class="space-y-2 pl-1">
                                        <li class="flex items-start gap-2.5">
                                            <span class="w-1.5 h-1.5 rounded-full bg-pink-500 mt-2 shrink-0"></span>
                                            <span class="text-xs sm:text-sm text-gray-600">Nama lengkap dan email akun Salonkita yang terdaftar</span>
                                        </li>
                                        <li class="flex items-start gap-2.5">
                                            <span class="w-1.5 h-1.5 rounded-full bg-pink-500 mt-2 shrink-0"></span>
                                            <span class="text-xs sm:text-sm text-gray-600">ID Transaksi / Nomor Referensi Pembayaran Xendit</span>
                                        </li>
                                        <li class="flex items-start gap-2.5">
                                            <span class="w-1.5 h-1.5 rounded-full bg-pink-500 mt-2 shrink-0"></span>
                                            <span class="text-xs sm:text-sm text-gray-600">Nama kelas atau paket mentoring yang dibeli</span>
                                        </li>
                                        <li class="flex items-start gap-2.5">
                                            <span class="w-1.5 h-1.5 rounded-full bg-pink-500 mt-2 shrink-0"></span>
                                            <span class="text-xs sm:text-sm text-gray-600">Alasan lengkap pengajuan refund disertai bukti pendukung (tangkapan layar error atau bukti transfer ganda)</span>
                                        </li>
                                        <li class="flex items-start gap-2.5">
                                            <span class="w-1.5 h-1.5 rounded-full bg-pink-500 mt-2 shrink-0"></span>
                                            <span class="text-xs sm:text-sm text-gray-600">Nomor rekening bank tujuan (Nama Bank, Nomor Rekening, dan Nama Pemilik Rekening harus sesuai identitas akun)</span>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="flex items-start gap-3.5">
                                <span class="w-7 h-7 rounded-lg bg-pink-100 text-pink-700 font-bold text-xs flex items-center justify-center shrink-0 mt-0.5">3</span>
                                <div class="flex-1">
                                    Tim verifikasi keuangan Salonkita akan memeriksa kelayakan riwayat akses dan sistem dalam waktu <strong>1 - 3 hari kerja</strong>.
                                </div>
                            </li>
                        </ol>
                    </div>
                </section>

                <!-- Section 6 -->
                <section id="waktu-pemrosesan" class="py-12 sm:py-16">
                    <div class="flex items-center gap-3.5 mb-6">
                        <span class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-pink-100 text-pink-700 font-extrabold flex items-center justify-center text-sm sm:text-base shrink-0 shadow-xs">6</span>
                        <h2 class="text-xl sm:text-2xl font-bold text-gray-900">Waktu & Metode Pengembalian Dana (Refund Processing)</h2>
                    </div>
                    <div class="space-y-4 text-gray-600 sm:text-[17px] leading-relaxed">
                        <p>
                            Setelah permohonan Anda disetujui secara resmi oleh tim verifikasi, pengembalian dana akan diproses kembali sesuai saluran pembayaran yang digunakan:
                        </p>
                        <div class="overflow-x-auto pt-1">
                            <table class="w-full text-left text-xs sm:text-sm border border-gray-200 rounded-2xl overflow-hidden">
                                <thead class="bg-gray-50 text-gray-900 font-bold border-b border-gray-200">
                                    <tr>
                                        <th class="p-3.5">Metode Pembayaran Awal</th>
                                        <th class="p-3.5">Estimasi Waktu</th>
                                        <th class="p-3.5">Metode Pengembalian</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100 text-gray-600">
                                    <tr>
                                        <td class="p-3.5 font-medium text-gray-900">Virtual Account (BCA, Mandiri, BNI, BRI)</td>
                                        <td class="p-3.5">3 - 7 Hari Kerja</td>
                                        <td class="p-3.5">Transfer ke Rekening Bank Pemohon</td>
                                    </tr>
                                    <tr>
                                        <td class="p-3.5 font-medium text-gray-900">QRIS / E-Wallet (GoPay, OVO, ShopeePay)</td>
                                        <td class="p-3.5">3 - 7 Hari Kerja</td>
                                        <td class="p-3.5">Pengembalian Saldo / Transfer Bank</td>
                                    </tr>
                                    <tr>
                                        <td class="p-3.5 font-medium text-gray-900">Kartu Kredit / Debit Online</td>
                                        <td class="p-3.5">7 - 14 Hari Kerja</td>
                                        <td class="p-3.5">Reverse / Kredit Saldo ke Kartu (sesuai siklus bank)</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <p class="text-xs text-gray-500">
                            *Catatan: Hari kerja tidak mencakup hari Sabtu, Minggu, dan hari libur nasional. Biaya administrasi transfer pihak ketiga (jika ada) dapat dibebankan kepada penerima dana.
                        </p>
                    </div>
                </section>

                <!-- Section 7 -->
                <section id="kontak-refund" class="pt-12 sm:pt-16">
                    <div class="flex items-center gap-3.5 mb-6">
                        <span class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-pink-100 text-pink-700 font-extrabold flex items-center justify-center text-sm sm:text-base shrink-0 shadow-xs">7</span>
                        <h2 class="text-xl sm:text-2xl font-bold text-gray-900">Layanan Bantuan Transaksi & Kontak CS</h2>
                    </div>
                    <div class="space-y-4 text-gray-600 sm:text-[17px] leading-relaxed">
                        <p>
                            Jika Anda membutuhkan bantuan seputar status transaksi, invoice, atau pengajuan pengembalian dana, hubungi kami melalui:
                        </p>
                        <div class="bg-gray-50 border border-gray-200 rounded-2xl p-5 text-xs sm:text-sm text-gray-700 space-y-2">
                            <p><strong>Email Dukungan Pelanggan:</strong> <a href="mailto:info@skid.co.id" class="text-pink-600 font-semibold underline">info@skid.co.id</a></p>
                            <p><strong>WhatsApp Customer Support:</strong> <a href="https://wa.me/6281264444213" target="_blank" class="text-pink-600 font-semibold underline">+62 812-6444-4213</a></p>
                            <p><strong>Jam Operasional Layanan CS:</strong> Senin - Sabtu, 09.00 - 18.00 WIB</p>
                        </div>
                    </div>
                </section>
            </article>
        </div>
    </main>

    <x-footer />
</x-layout>
