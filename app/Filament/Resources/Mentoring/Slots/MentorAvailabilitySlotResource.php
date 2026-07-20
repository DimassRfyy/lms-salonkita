<?php

namespace App\Filament\Resources\Mentoring\Slots;

use App\Filament\Resources\Mentoring\Slots\Pages\ManageMentorAvailabilitySlots;
use App\Models\MentorAvailabilitySlot;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class MentorAvailabilitySlotResource extends Resource
{
    protected static ?string $model = MentorAvailabilitySlot::class;

    protected static string | \UnitEnum | null $navigationGroup = 'Mentoring';

    protected static ?string $navigationLabel = 'Generated Slots';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Clock;

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
                Select::make('mentor_availability_template_id')
                    ->label('Template')
                    ->relationship('template', 'id')
                    ->searchable()
                    ->preload()
                    ->nullable(),
                DateTimePicker::make('starts_at')
                    ->required(),
                DateTimePicker::make('ends_at')
                    ->required(),
                Select::make('status')
                    ->options([
                        MentorAvailabilitySlot::STATUS_AVAILABLE => 'Available',
                        MentorAvailabilitySlot::STATUS_BOOKED => 'Booked',
                        MentorAvailabilitySlot::STATUS_BLOCKED => 'Blocked',
                    ])
                    ->default(MentorAvailabilitySlot::STATUS_AVAILABLE)
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('starts_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('ends_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('status')
                    ->badge()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->recordActions([
                EditAction::make(),
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
            'index' => ManageMentorAvailabilitySlots::route('/'),
        ];
    }
}