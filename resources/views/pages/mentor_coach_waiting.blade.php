<x-layout>
    <style>
        .waiting-animation {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.5;
            }
        }

        .check-animation {
            animation: bounce 1s ease-in-out infinite;
        }

        @keyframes bounce {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
            }
        }
    </style>

    <div
        class="min-h-screen bg-linear-to-br from-pink-50 via-white to-rose-50 flex flex-col justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="mx-auto w-full max-w-lg">
            <!-- Card -->
            <div class="bg-white rounded-3xl shadow-lg border border-pink-100 p-8 text-center">
                <!-- Icon -->
                <div class="mb-8 flex justify-center">
                    <div class="relative w-24 h-24">
                        <div
                            class="waiting-animation absolute inset-0 rounded-full border-4 border-pink-200 border-t-pink-500">
                        </div>
                        <div class="absolute inset-4 flex items-center justify-center">
                            <svg class="w-12 h-12 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Heading -->
                <h1 class="text-xl md:text-3xl font-bold text-gray-900 mb-2">Akun Anda Sedang Ditinjau</h1>
                <p class="text-gray-600 mb-8">
                    Terima kasih telah mendaftar sebagai
                    <span class="font-semibold text-pink-600">{{ ucfirst($user->role) }}</span>.
                    Admin sedang meninjau data profil Anda.
                </p>

                <!-- Status Info -->
                <div class="bg-pink-50 rounded-2xl p-6 mb-8">
                    <div class="space-y-4">
                        <div class="flex items-start gap-3">
                            <div class="shrink-0 mt-1">
                                <svg class="w-5 h-5 text-pink-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div class="text-left">
                                <p class="font-semibold text-gray-900">Profil Lengkap</p>
                                <p class="text-sm text-gray-600">Data kontak dan sosial sudah tersimpan</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <div class="shrink-0 mt-1">
                                <svg class="w-5 h-5 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z">
                                    </path>
                                </svg>
                            </div>
                            <div class="text-left">
                                <p class="font-semibold text-gray-900">Menunggu Verifikasi</p>
                                <p class="text-sm text-gray-600">Admin akan meninjau akun Anda segera</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Information -->
                <div class="bg-blue-50 border border-blue-200 rounded-2xl p-4 mb-8">
                    <p class="text-sm text-blue-800">
                        <span class="font-semibold">💡 Info:</span> Anda akan menerima email notifikasi ketika akun Anda
                        telah disetujui. Proses verifikasi biasanya memakan waktu 1-2 hari kerja.
                    </p>
                </div>

                <!-- User Info Card -->
                <div class="bg-gray-50 rounded-2xl p-6 mb-8 text-left">
                    <h3 class="font-semibold text-gray-900 mb-4">Informasi Akun Anda</h3>
                    <div class="space-y-3">
                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wide">Nama</p>
                            <p class="text-gray-900 font-medium">{{ $user->name }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wide">Email</p>
                            <p class="text-gray-900 font-medium">{{ $user->email }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wide">Role</p>
                            <div class="mt-1">
                                <span
                                    class="inline-flex items-center rounded-full bg-pink-100 px-3 py-1 text-sm font-semibold text-pink-700">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </div>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wide">Status Approval</p>
                            <div class="mt-1">
                                <span
                                    class="inline-flex items-center gap-2 rounded-full bg-yellow-100 px-3 py-1 text-sm font-semibold text-yellow-700">
                                    <span class="h-2 w-2 rounded-full bg-yellow-500 animate-pulse"></span>
                                    Menunggu
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="space-y-3">
                    <button type="button" onclick="location.reload()"
                        class="w-full rounded-2xl bg-pink-500 py-3 font-bold text-white transition hover:bg-pink-600">
                        Segarkan Halaman
                    </button>
                    <a href="/"
                        class="block rounded-2xl border border-gray-300 py-3 font-semibold text-gray-700 transition hover:bg-gray-50">
                        Kembali ke Beranda
                    </a>
                </div>

                <!-- Footer Note -->
                <p class="mt-8 text-xs text-gray-500">
                    Jika ada pertanyaan, hubungi kami melalui
                    <a href="https://wa.me/YOUR_WHATSAPP_NUMBER"
                        class="text-pink-600 font-semibold hover:text-pink-700">WhatsApp</a>
                    atau
                    <a href="mailto:support@salonkita.com"
                        class="text-pink-600 font-semibold hover:text-pink-700">Email</a>.
                </p>
            </div>
        </div>
    </div>
</x-layout>