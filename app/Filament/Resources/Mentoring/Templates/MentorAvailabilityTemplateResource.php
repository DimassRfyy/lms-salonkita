<?php

namespace App\Filament\Resources\Mentoring\Templates;

use App\Filament\Resources\Mentoring\Templates\Pages\ManageMentorAvailabilityTemplates;
use App\Models\MentorAvailabilityTemplate;
use App\Support\Mentoring\MentorAvailabilitySlotGenerator;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
use Filament\Notifications\Notification;

class MentorAvailabilityTemplateResource extends Resource
{
    protected static ?string $model = MentorAvailabilityTemplate::class;

    protected static string | \UnitEnum | null $navigationGroup = 'Mentoring';

    protected static ?string $navigationLabel = 'Availability Templates';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::CalendarDays;

    public static function canAccess(): bool
    {
        $user = Auth::user();

        return $user !== null && $user->role === 'mentor';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Hidden::make('mentor_id')
                    ->default(fn () => Auth::id())
                    ->required(),
                Select::make('day_of_week')
                    ->options([
                        0 => 'Sunday',
                        1 => 'Monday',
                        2 => 'Tuesday',
                        3 => 'Wednesday',
                        4 => 'Thursday',
                        5 => 'Friday',
                        6 => 'Saturday',
                    ])
                    ->required(),
                TimePicker::make('start_time')
                    ->label('Start Time')
                    ->required(),
                TimePicker::make('end_time')
                    ->label('End Time')
                    ->required(),
                TextInput::make('slot_duration_minutes')
                    ->numeric()
                    ->default(60)
                    ->required(),
                Toggle::make('is_active')
                    ->default(true)
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('day_of_week')
                    ->formatStateUsing(fn (string|int $state): string => match ((int) $state) {
                        0 => 'Sunday',
                        1 => 'Monday',
                        2 => 'Tuesday',
                        3 => 'Wednesday',
                        4 => 'Thursday',
                        5 => 'Friday',
                        6 => 'Saturday',
                    })
                    ->sortable(),
                TextColumn::make('start_time')
                    ->label('Start')
                    ->sortable(),
                TextColumn::make('end_time')
                    ->label('End')
                    ->sortable(),
                TextColumn::make('slot_duration_minutes')
                    ->badge()
                    ->label('Duration'),
                IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('day_of_week')
            ->recordActions([
                EditAction::make(),
                Action::make('generateSlots')
                    ->label('Generate Slots')
                    ->icon('heroicon-m-bolt')
                    ->color('success')
                    ->form([
                        TextInput::make('horizon_days')
                            ->label('Generate for how many days')
                            ->numeric()
                            ->default(60)
                            ->minValue(1)
                            ->required(),
                    ])
                    ->requiresConfirmation()
                    ->visible(fn (MentorAvailabilityTemplate $record): bool => $record->is_active)
                    ->action(function (MentorAvailabilityTemplate $record, array $data): void {
                        $generatedCount = app(MentorAvailabilitySlotGenerator::class)
                            ->generateForTemplate($record, (int) ($data['horizon_days'] ?? 60));

                        Notification::make()
                            ->title('Slots generated')
                            ->body($generatedCount . ' availability slots created from this template.')
                            ->success()
                            ->send();
                    }),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageMentorAvailabilityTemplates::route('/'),
        ];
    }
}