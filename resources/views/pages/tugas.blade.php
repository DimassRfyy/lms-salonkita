<x-layout>
    <x-navbar />
    <!-- MAIN CONTENT -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-12 py-8">
        <!-- GREETING SECTION -->
        <section class="mb-12">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">
                Tugas Saya
            </h1>
            <p class="text-lg text-gray-600">
                Kelola dan pantau semua tugas kelas Anda!
            </p>
        </section>

        <section class="mb-12 space-y-6">
            <!-- Card 1: Sedang Menonton Video -->
            <div class="bg-white rounded-xl overflow-hidden shadow-md border border-pink-100 hover:shadow-lg transition">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-0">
                    <div class="h-48 md:h-auto bg-gradient-to-br from-pink-400 to-pink-300 relative overflow-hidden"></div>
                    <div class="md:col-span-2 p-6 md:p-8">
                        <div class="flex flex-wrap items-center gap-2 mb-2">
                            <span class="text-xs font-semibold text-pink-700 bg-pink-100 px-2.5 py-1 rounded-full">Sedang Menonton Video</span>
                            <span class="text-xs text-gray-500">3/8 video selesai</span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-1">Makeup Dasar</h3>
                        <p class="text-sm text-pink-600 font-medium mb-3">Beauty Artist</p>
                        <div class="mb-3">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-sm text-gray-600">Progress</span>
                                <span class="text-sm font-bold text-gray-900">37%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                <div class="bg-pink-500 h-2.5 rounded-full" style="width: 37%"></div>
                            </div>
                        </div>
                        <p class="text-sm text-gray-600 mb-5">Anda masih berada di tahap menonton materi. Lanjutkan video untuk membuka akses submit tugas.</p>
                        <button class="px-5 py-2.5 bg-pink-500 text-white font-semibold rounded-lg hover:bg-pink-600 transition w-full md:w-auto">
                            Lanjut Nonton
                        </button>
                    </div>
                </div>
            </div>

            <!-- Card 2: Siap Submit Tugas -->
            <div class="bg-white rounded-xl overflow-hidden shadow-md border border-pink-100 hover:shadow-lg transition">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-0">
                    <div class="h-48 md:h-auto bg-gradient-to-br from-rose-400 to-pink-300 relative overflow-hidden"></div>
                    <div class="md:col-span-2 p-6 md:p-8">
                        <div class="flex flex-wrap items-center gap-2 mb-2">
                            <span class="text-xs font-semibold text-emerald-700 bg-emerald-100 px-2.5 py-1 rounded-full">Siap Submit Tugas</span>
                            <span class="text-xs text-gray-500">8/8 video selesai</span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-1">Nailart Fundamental</h3>
                        <p class="text-sm text-pink-600 font-medium mb-3">Beauty Artist</p>
                        <div class="mb-3">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-sm text-gray-600">Progress</span>
                                <span class="text-sm font-bold text-gray-900">100%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                <div class="bg-emerald-500 h-2.5 rounded-full" style="width: 100%"></div>
                            </div>
                        </div>
                        <p class="text-sm text-gray-600 mb-5">Seluruh materi sudah selesai dipelajari. Silakan kirim tugas Anda untuk masuk ke tahap review.</p>
                        <button class="px-5 py-2.5 bg-emerald-500 text-white font-semibold rounded-lg hover:bg-emerald-600 transition w-full md:w-auto">
                            Submit Tugas
                        </button>
                    </div>
                </div>
            </div>

            <!-- Card 3: Menunggu Review -->
            <div class="bg-white rounded-xl overflow-hidden shadow-md border border-pink-100 hover:shadow-lg transition">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-0">
                    <div class="h-48 md:h-auto bg-gradient-to-br from-amber-300 to-orange-300 relative overflow-hidden"></div>
                    <div class="md:col-span-2 p-6 md:p-8">
                        <div class="flex flex-wrap items-center gap-2 mb-2">
                            <span class="text-xs font-semibold text-amber-700 bg-amber-100 px-2.5 py-1 rounded-full">Menunggu Review</span>
                            <span class="text-xs text-gray-500">8/8 video selesai</span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-1">Nailart Fundamental</h3>
                        <p class="text-sm text-pink-600 font-medium mb-3">Beauty Artist</p>
                        <div class="mb-3">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-sm text-gray-600">Progress</span>
                                <span class="text-sm font-bold text-gray-900">100%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                <div class="bg-amber-500 h-2.5 rounded-full" style="width: 100%"></div>
                            </div>
                        </div>
                        <p class="text-sm text-gray-600 mb-5">Tugas sedang direview oleh kami. Mohon tunggu sampai notifikasi selanjutnya. Kami akan segera mereview tugas Anda!</p>
                        <button class="px-5 py-2.5 bg-amber-500 text-white font-semibold rounded-lg hover:bg-amber-600 transition w-full md:w-auto">
                            Lihat Status Review
                        </button>
                    </div>
                </div>
            </div>

            <!-- Card 4: Sudah Direview -->
            <div class="bg-white rounded-xl overflow-hidden shadow-md border border-pink-100 hover:shadow-lg transition">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-0">
                    <div class="h-48 md:h-auto bg-gradient-to-br from-sky-300 to-blue-300 relative overflow-hidden"></div>
                    <div class="md:col-span-2 p-6 md:p-8">
                        <div class="flex flex-wrap items-center gap-2 mb-2">
                            <span class="text-xs font-semibold text-sky-700 bg-sky-100 px-2.5 py-1 rounded-full">Sudah Direview</span>
                            <span class="text-xs text-gray-500">8/8 video selesai</span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-1">Nailart Fundamental</h3>
                        <p class="text-sm text-pink-600 font-medium mb-3">Beauty Artist</p>
                        <div class="mb-3">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-sm text-gray-600">Progress</span>
                                <span class="text-sm font-bold text-gray-900">100%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                <div class="bg-sky-500 h-2.5 rounded-full" style="width: 100%"></div>
                            </div>
                        </div>
                        <p class="text-sm text-gray-600 mb-5">Review telah selesai. Cek catatan mentor untuk perbaikan atau lanjut ke modul berikutnya.</p>
                        <div class="flex flex-col sm:flex-row gap-3">
                            <button class="px-5 py-2.5 bg-sky-500 text-white font-semibold rounded-lg hover:bg-sky-600 transition w-full sm:w-auto">
                                Lihat Hasil Review
                            </button>
                            <button class="px-5 py-2.5 border border-pink-200 text-pink-600 font-semibold rounded-lg hover:bg-pink-50 transition w-full sm:w-auto">
                                Lanjut Kelas
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <x-footer />
</x-layout>