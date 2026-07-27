<?php

use App\Livewire\TransactionPromoCode;
use Livewire\Livewire;

test('transaction promo code component mounts with null initial promo code without error', function () {
    Livewire::test(TransactionPromoCode::class, [
        'coursePrice' => 100000,
        'initialPromoCode' => null,
    ])
    ->assertSet('promoCode', '')
    ->assertSet('finalPrice', 100000);
});

test('transaction promo code component mounts with string initial promo code', function () {
    Livewire::test(TransactionPromoCode::class, [
        'coursePrice' => 100000,
        'initialPromoCode' => 'DISCOUNT50',
    ])
    ->assertSet('promoCode', 'DISCOUNT50');
});
