@props([
    'url' => route('dashboard'),
    'label' => 'Kembali ke Dashboard',
    'maxWidth' => 'max-w-7xl',
])

<div class="bg-gray-50 border-b border-gray-200 px-4 sm:px-6 lg:px-8 py-4">
    <div class="{{ $maxWidth }} mx-auto">
        <a href="{{ $url }}"
            class="text-pink-500 font-medium inline-flex items-center gap-2 hover:text-pink-700 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            {{ $label }}
        </a>
    </div>
</div>
