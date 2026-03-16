<x-layout>
    <x-navbar />
    <!-- MAIN CONTENT -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-12 py-8">
        <!-- GREETING SECTION -->
        <section class="mb-12">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">
                Kelas Tersimpan
            </h1>
            <p class="text-lg text-gray-600">
                Kelas yang Anda simpan untuk dipelajari nanti
            </p>
        </section>

        <!-- RECOMMENDATIONS SECTION -->
        <section class="mb-12">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @forelse($savedCourses as $course)
                    <div data-title="{{ $course->name }}"
                        class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-lg transition border border-pink-100">
                        <div class="relative h-40">
                            <img src="{{ $course->thumbnail ? Storage::url($course->thumbnail) : asset('assets/images/thumbnails/img_placeholder.png') }}"
                                alt="{{ $course->name }}"
                                onerror="this.onerror=null;this.src='{{ asset('assets/images/thumbnails/img_placeholder.png') }}';"
                                class="w-full h-full object-cover">
                            <div
                                class="absolute top-2 right-2 flex items-center gap-1 bg-white/80 backdrop-blur-sm px-2 py-1 rounded-full shadow-sm">
                                <svg class="w-3.5 h-3.5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                    </path>
                                </svg>
                                <span class="text-xs font-bold text-gray-700">{{ $course->rating_label }}</span>
                            </div>

                            <form method="POST" action="{{ route('saved-courses.destroy', ['course' => $course->id]) }}"
                                class="absolute bottom-2 right-2" data-delete-form data-course-title="{{ $course->name }}">
                                @csrf
                                @method('DELETE')
                                <button type="button" onclick="openDeleteModal(this)"
                                    class="p-1.5 bg-white/80 backdrop-blur-sm rounded-full shadow-sm hover:bg-red-50 transition"
                                    aria-label="Hapus {{ $course->name }} dari tersimpan">
                                    <svg class="w-4 h-4 text-gray-500 hover:text-red-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                        </path>
                                    </svg>
                                </button>
                            </form>
                        </div>

                        <div class="p-4">
                            <h3 class="text-lg font-bold text-gray-900 mb-1">{{ $course->name }}</h3>
                            <p class="text-sm text-pink-600 font-medium mb-2">{{ $course->category->name }}</p>
                            <div class="flex items-center gap-1 text-gray-500 text-xs mb-3">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>{{ $course->duration_label }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-xl font-bold text-pink-500">Rp
                                    {{ number_format((int) $course->price, 0, ',', '.') }}</span>
                                <a href="{{ route('course', ['slug' => $course->slug]) }}"
                                    class="px-3 py-1.5 bg-pink-500 text-white text-sm font-medium rounded-lg hover:bg-pink-600 transition">
                                    Lihat Detail
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="md:col-span-2 lg:col-span-4 text-center py-8 text-gray-500">
                        Belum ada kelas tersimpan. Simpan kelas dari dashboard agar muncul di sini.
                    </div>
                @endforelse
            </div>
        </section>
    </main>

    <!-- DELETE CONFIRMATION MODAL -->
    <div id="deleteModal"
        class="fixed inset-0 z-50 flex items-center justify-center opacity-0 pointer-events-none transition-opacity duration-150">
        <!-- Backdrop -->
        <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" onclick="closeDeleteModal()"></div>
        <!-- Modal Box -->
        <div class="relative bg-white rounded-2xl shadow-xl p-6 w-full max-w-sm mx-4">
            <!-- Icon -->
            <div class="flex items-center justify-center w-14 h-14 bg-red-100 rounded-full mx-auto mb-4">
                <svg class="w-7 h-7 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                    </path>
                </svg>
            </div>
            <h2 class="text-lg font-bold text-gray-900 text-center mb-1">Hapus Kelas Tersimpan?</h2>
            <p class="text-sm text-gray-500 text-center mb-6">
                Kelas <span id="deleteModalTitle" class="font-semibold text-gray-700"></span> akan dihapus dari daftar
                tersimpan Anda.
            </p>
            <div class="flex gap-3">
                <button onclick="closeDeleteModal()"
                    class="flex-1 px-4 py-2.5 border border-gray-200 text-gray-700 text-sm font-medium rounded-xl hover:bg-gray-50 transition">
                    Batal
                </button>
                <button onclick="confirmDelete()"
                    class="flex-1 px-4 py-2.5 bg-red-500 text-white text-sm font-medium rounded-xl hover:bg-red-600 transition">
                    Hapus
                </button>
            </div>
        </div>
    </div>
    <x-footer />
    <!-- JAVASCRIPT -->
    <script>
        let formToDelete = null;

        function openDeleteModal(btn) {
            formToDelete = btn.closest('[data-delete-form]');
            const title = formToDelete ? formToDelete.dataset.courseTitle : '';
            document.getElementById('deleteModalTitle').textContent = title;
            document.getElementById('deleteModal').classList.remove('opacity-0', 'pointer-events-none');
            document.body.style.overflow = 'hidden';
        }

        function closeDeleteModal() {
            formToDelete = null;
            document.getElementById('deleteModal').classList.add('opacity-0', 'pointer-events-none');
            document.body.style.overflow = '';
        }

        function confirmDelete() {
            if (formToDelete) {
                formToDelete.submit();
            }
        }

        // Close modal on Escape key
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') closeDeleteModal();
        });
    </script>
</x-layout>