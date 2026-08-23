<?php

namespace App\Filament\Resources\Mentoring\Slots;

use App\Filament\Resources\Mentoring\Slots\Pages\ManageMentorAvailabilitySlots;
use App\Models\MentorAvailabilitySlot;
use BackedEnum;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class MentorAvailabilitySlotResource extends Resource
{
    protected static ?string $model = MentorAvailabilitySlot::class;

    protected static string | \UnitEnum | null $navigationGroup = 'Mentoring';

    protected static ?string $navigationLabel = 'Daftar Slot Jadwal';

    protected static ?string $modelLabel = 'Slot Jadwal';

    protected static ?string $pluralModelLabel = 'Daftar Slot Jadwal';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Clock;

    protected static ?int $navigationSort = 3;

    public static function canAccess(): bool
    {
        $user = Auth::user();

        return $user !== null && $user->role === 'mentor';
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('mentor_id', Auth::id())
            ->with(['template']);
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Hidden::make('mentor_id')
                    ->default(fn () => Auth::id())
                    ->required(),

                Section::make('Informasi Slot Jadwal')
                    ->description('Tentukan tanggal, jam sesi bimbingan, dan status ketersediaannya untuk siswa.')
                    ->schema([
                        DateTimePicker::make('starts_at')
                            ->label('Waktu Mulai')
                            ->seconds(false)
                            ->default(fn () => now()->addDay()->startOfHour())
                            ->required(),

                        DateTimePicker::make('ends_at')
                            ->label('Waktu Selesai')
                            ->seconds(false)
                            ->default(fn () => now()->addDay()->startOfHour()->addHour())
                            ->required(),

                        Select::make('status')
                            ->label('Status Ketersediaan')
                            ->options([
                                MentorAvailabilitySlot::STATUS_AVAILABLE => 'Tersedia untuk Siswa',
                                MentorAvailabilitySlot::STATUS_BOOKED => 'Sudah Dibooking Siswa',
                                MentorAvailabilitySlot::STATUS_BLOCKED => 'Diblokir / Libur',
                            ])
                            ->default(MentorAvailabilitySlot::STATUS_AVAILABLE)
                            ->required(),

                        Select::make('mentor_availability_template_id')
                            ->label('Berdasarkan Pola Rutin')
                            ->relationship('template', 'id', fn (Builder $query) => $query->where('mentor_id', Auth::id()))
                            ->placeholder('Slot manual (tanpa pola)')
                            ->nullable(),
                    ])
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('starts_at')
                    ->label('Tanggal Sesi')
                    ->dateTime('d M Y (l)')
                    ->sortable(),

                TextColumn::make('jam_sesi')
                    ->label('Jam Bimbingan')
                    ->state(fn (MentorAvailabilitySlot $record): string => ($record->starts_at?->format('H:i') ?? '-') . ' - ' . ($record->ends_at?->format('H:i') ?? '-') . ' WIB'),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->colors([
                        'success' => MentorAvailabilitySlot::STATUS_AVAILABLE,
                        'info' => MentorAvailabilitySlot::STATUS_BOOKED,
                        'danger' => MentorAvailabilitySlot::STATUS_BLOCKED,
                    ])
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        MentorAvailabilitySlot::STATUS_AVAILABLE => 'Tersedia',
                        MentorAvailabilitySlot::STATUS_BOOKED => 'Sudah Dibooking',
                        MentorAvailabilitySlot::STATUS_BLOCKED => 'Diblokir / Libur',
                        default => ucfirst($state),
                    })
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Dibuat Pada')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Status Slot')
                    ->options([
                        MentorAvailabilitySlot::STATUS_AVAILABLE => 'Tersedia',
                        MentorAvailabilitySlot::STATUS_BOOKED => 'Sudah Dibooking',
                        MentorAvailabilitySlot::STATUS_BLOCKED => 'Diblokir',
                    ]),
            ])
            ->defaultSort('starts_at', 'asc')
            ->recordActions([
                ActionGroup::make([
                    ActionGroup::make([
                        EditAction::make()
                            ->label('Ubah Slot'),
                    ])
                        ->dropdown(false),
                    DeleteAction::make(),
                ])->icon('heroicon-m-bars-3'),
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