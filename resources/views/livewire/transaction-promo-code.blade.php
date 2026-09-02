<div class="space-y-4">
    <div class="rounded-xl border border-pink-100 bg-pink-50 p-4">
        <label for="promo-code" class="block text-sm font-semibold text-gray-800 mb-2">Kode Promo</label>
        <input id="promo-code" name="promo_code" type="text" wire:model.live.debounce.300ms="promoCode"
            placeholder="Masukkan kode promo"
            class="w-full rounded-lg border {{ $isPromoValid ? 'border-emerald-300' : 'border-gray-300' }} px-3 py-2 text-sm focus:border-pink-400 focus:outline-none" />

        @if ($promoMessage)
            <p class="mt-2 text-xs {{ $isPromoValid ? 'text-emerald-600 font-semibold' : 'text-red-500' }}">{{ $promoMessage }}</p>
        @endif

        @error('promo_code')
            <p class="mt-2 text-xs text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <div class="space-y-3 mb-5 pb-5 border-b border-gray-100 text-sm">
        <div class="flex justify-between text-gray-600">
            <span>Harga kelas</span>
            <span>Rp {{ number_format((int) $coursePrice, 0, ',', '.') }}</span>
        </div>
        <div class="flex justify-between text-gray-600">
            <span>Biaya admin</span>
            <span>Rp 0</span>
        </div>
        <div class="flex justify-between {{ $discountAmount > 0 ? 'text-emerald-600' : 'text-gray-400' }}">
            <span>Diskon promo</span>
            <span>- Rp {{ number_format((int) $discountAmount, 0, ',', '.') }}</span>
        </div>
    </div>

    <div class="flex justify-between items-center mb-6">
        <span class="font-bold text-gray-900">Total Pembayaran</span>
        <span class="text-xl font-extrabold text-pink-500">Rp {{ number_format((int) $finalPrice, 0, ',', '.') }}</span>
    </div>

    {{--
    Maintenance: uncomment blok ini dan hapus tombol submit di bawahnya
    untuk menonaktifkan bayar tanpa voucher 100%.

    @if ($finalPrice > 0)
        <button type="button" disabled
            class="w-full py-4 bg-gray-200 text-gray-400 font-bold text-lg rounded-xl cursor-not-allowed flex items-center justify-center gap-2 select-none shadow-none">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
            </svg>
            <span>Bayar Sekarang</span>
        </button>
        <p class="text-center text-xs text-gray-400 mt-2">
            Pembayaran saat ini sedang dalam pemeliharaan.
        </p>
    @else
        <button type="submit"
            class="w-full py-4 bg-pink-500 hover:bg-pink-600 active:bg-pink-700 text-white font-bold text-lg rounded-xl transition shadow-sm flex items-center justify-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span>Bayar Sekarang</span>
        </button>
    @endif
    --}}

    <button type="submit"
        class="w-full py-4 bg-pink-500 hover:bg-pink-600 active:bg-pink-700 text-white font-bold text-lg rounded-xl transition shadow-sm flex items-center justify-center gap-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <span>Bayar Sekarang</span>
    </button>
</div>