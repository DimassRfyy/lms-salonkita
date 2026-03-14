<?php

namespace App\Filament\Resources\Transactions\Pages;

use App\Filament\Resources\Transactions\TransactionResource;
use App\Models\Transaction;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageTransactions extends ManageRecords
{
    protected static string $resource = TransactionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->after(function (Transaction $record): void {
                    if (! $record->is_paid) {
                        return;
                    }

                    $record->student?->ownedCourses()->syncWithoutDetaching([$record->course_id]);
                }),
        ];
    }
}
