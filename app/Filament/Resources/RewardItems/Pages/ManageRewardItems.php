<?php

namespace App\Filament\Resources\RewardItems\Pages;

use App\Filament\Resources\RewardItems\RewardItemResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageRewardItems extends ManageRecords
{
    protected static string $resource = RewardItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
