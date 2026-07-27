<?php

namespace App\Livewire;

use App\Models\PromoCode;
use Illuminate\View\View;
use Livewire\Component;

class TransactionPromoCode extends Component
{
    public int $coursePrice;

    public string $promoCode = '';

    public int $discountAmount = 0;

    public int $finalPrice = 0;

    public bool $isPromoValid = false;

    public ?string $promoMessage = null;

    public function mount(int $coursePrice, ?string $initialPromoCode = ''): void
    {
        $this->coursePrice = max(0, $coursePrice);
        $this->promoCode = trim((string) $initialPromoCode);
        $this->finalPrice = $this->coursePrice;

        $this->recalculate();
    }

    public function updatedPromoCode(): void
    {
        $this->recalculate();
    }

    public function recalculate(): void
    {
        $rawCode = trim($this->promoCode);
        $normalizedCode = mb_strtoupper($rawCode);

        $this->discountAmount = 0;
        $this->finalPrice = $this->coursePrice;
        $this->isPromoValid = false;
        $this->promoMessage = null;

        if ($normalizedCode === '') {
            return;
        }

        $promo = PromoCode::query()
            ->whereRaw('UPPER(code) = ?', [$normalizedCode], 'and')
            ->where('is_active', true)
            ->first();

        if (! $promo) {
            $this->promoMessage = 'Kode promo tidak ditemukan atau sudah tidak aktif.';
            return;
        }

        $discountAmount = $promo->type === 'percentage'
            ? (int) round($this->coursePrice * ((int) $promo->value / 100))
            : (int) $promo->value;

        $discountAmount = min(max($discountAmount, 0), $this->coursePrice);

        $this->discountAmount = $discountAmount;
        $this->finalPrice = max($this->coursePrice - $discountAmount, 0);
        $this->isPromoValid = true;
        $this->promoMessage = 'Promo berhasil dipakai.';
    }

    public function render(): View
    {
        return view('livewire.transaction-promo-code');
    }
}