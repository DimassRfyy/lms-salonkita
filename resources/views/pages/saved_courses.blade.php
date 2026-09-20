<x-layout>
    <x-navbar />
    <x-breadcrumb />
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
                    <x-course-card :course="$course" :show-delete="true" data-title="{{ $course->name }}" />
                @empty
                    <div class="md:col-span-2 lg:col-span-4 text-center py-12 bg-white border border-pink-100 rounded-2xl text-gray-500">
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