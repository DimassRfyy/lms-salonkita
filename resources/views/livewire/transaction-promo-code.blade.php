<div class="space-y-4">
    <div class="rounded-xl border border-pink-100 bg-pink-50 p-4">
        <label for="promo-code" class="block text-sm font-semibold text-gray-800 mb-2">Kode Promo</label>
        <input id="promo-code" name="promo_code" type="text" wire:model.live.debounce.300ms="promoCode"
            placeholder="Masukkan kode promo"
            class="w-full rounded-lg border {{ $isPromoValid ? 'border-emerald-300' : 'border-gray-300' }} px-3 py-2 text-sm focus:border-pink-400 focus:outline-none" />

        @if ($promoMessage)
            <p class="mt-2 text-xs {{ $isPromoValid ? 'text-emerald-600' : 'text-red-500' }}">{{ $promoMessage }}</p>
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
</div>