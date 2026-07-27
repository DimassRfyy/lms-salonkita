<?php

namespace App\Filament\Resources\RewardRedemptions\Pages;

use App\Filament\Resources\RewardRedemptions\RewardRedemptionResource;
use Filament\Resources\Pages\ManageRecords;

class ManageRewardRedemptions extends ManageRecords
{
    protected static string $resource = RewardRedemptionResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
