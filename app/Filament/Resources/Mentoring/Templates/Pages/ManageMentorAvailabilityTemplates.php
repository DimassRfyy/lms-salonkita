<?php

namespace App\Filament\Resources\Mentoring\Templates\Pages;

use App\Filament\Resources\Mentoring\Templates\MentorAvailabilityTemplateResource;
use App\Support\Mentoring\MentorAvailabilitySlotGenerator;
use Filament\Actions\CreateAction;
use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Support\Facades\Auth;

class ManageMentorAvailabilityTemplates extends ManageRecords
{
    protected static string $resource = MentorAvailabilityTemplateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
            Action::make('generateAllSlots')
                ->label('Generate All Slots')
                ->icon('heroicon-m-bolt')
                ->color('success')
                ->form([
                    TextInput::make('horizon_days')
                        ->label('Generate for how many days')
                        ->numeric()
                        ->default(30)
                        ->minValue(1)
                        ->required(),
                ])
                ->requiresConfirmation()
                ->action(function (array $data): void {
                    $user = Auth::user();

                    if ($user === null) {
                        return;
                    }

                    $generatedCount = app(MentorAvailabilitySlotGenerator::class)
                        ->generateForMentor($user, (int) ($data['horizon_days'] ?? 30));

                    Notification::make()
                        ->title('All slots generated')
                        ->body($generatedCount . ' availability slots created from all active templates.')
                        ->success()
                        ->send();
                }),
        ];
    }
}