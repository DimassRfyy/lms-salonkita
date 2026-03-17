<x-layout>
    <x-navbar />

    <div class="bg-white rounded-xl shadow-md border border-pink-100 p-6 md:p-8 text-center min-h-screen">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">
                Klaim Sertifikat
            </h1>
            <p class="text-lg text-gray-600 mb-6">
                Selamat! Anda telah menyelesaikan kursus ini. Klaim sertifikat Anda sekarang untuk menunjukkan pencapaian Anda.
            </p>

            <a href="{{ route('course', ['slug' => $course->slug]) }}"
                class="px-5 py-2.5 bg-pink-500 text-white font-semibold rounded-lg hover:bg-pink-600 transition w-full sm:w-auto text-center">
                Kembali ke Kursus
            </a>
        </div>
</x-layout>
