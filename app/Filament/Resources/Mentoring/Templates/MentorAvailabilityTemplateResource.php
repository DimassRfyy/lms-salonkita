<?php

namespace App\Filament\Resources\Mentoring\Templates;

use App\Filament\Resources\Mentoring\Templates\Pages\ManageMentorAvailabilityTemplates;
use App\Models\MentorAvailabilityTemplate;
use App\Support\Mentoring\MentorAvailabilitySlotGenerator;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class MentorAvailabilityTemplateResource extends Resource
{
    protected static ?string $model = MentorAvailabilityTemplate::class;

    protected static string | \UnitEnum | null $navigationGroup = 'Mentoring';

    protected static ?string $navigationLabel = 'Pola Jadwal Rutin';

    protected static ?string $modelLabel = 'Pola Jadwal Rutin';

    protected static ?string $pluralModelLabel = 'Pola Jadwal Rutin';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::CalendarDays;

    protected static ?int $navigationSort = 2;

    public static function canAccess(): bool
    {
        $user = Auth::user();

        return $user !== null && $user->role === 'mentor';
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('mentor_id', Auth::id());
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Hidden::make('mentor_id')
                    ->default(fn () => Auth::id())
                    ->required(),

                Section::make('Atur Hari & Jam Rutin Mingguan')
                    ->description('Pola ini digunakan untuk menentukan hari apa saja dan jam berapa Anda bersedia membuka sesi bimbingan setiap minggunya.')
                    ->schema([
                        Select::make('day_of_week')
                            ->label('Hari Rutin')
                            ->options([
                                1 => 'Senin',
                                2 => 'Selasa',
                                3 => 'Rabu',
                                4 => 'Kamis',
                                5 => 'Jumat',
                                6 => 'Sabtu',
                                0 => 'Minggu',
                            ])
                            ->helperText('Pilih hari dalam seminggu di mana Anda rutin membuka jam konsultasi.')
                            ->required(),

                        TimePicker::make('start_time')
                            ->label('Jam Mulai (WIB)')
                            ->required(),

                        TimePicker::make('end_time')
                            ->label('Jam Selesai (WIB)')
                            ->required(),

                        Toggle::make('is_active')
                            ->label('Status Pola Aktif')
                            ->helperText('Hanya pola aktif yang akan digenerate menjadi slot tanggal kalender bagi siswa.')
                            ->default(true)
                            ->required(),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('day_of_week')
                    ->label('Hari Rutin')
                    ->formatStateUsing(fn (string|int $state): string => match ((int) $state) {
                        1 => 'Senin',
                        2 => 'Selasa',
                        3 => 'Rabu',
                        4 => 'Kamis',
                        5 => 'Jumat',
                        6 => 'Sabtu',
                        0 => 'Minggu',
                        default => (string) $state,
                    })
                    ->sortable()
                    ->badge()
                    ->color('primary'),

                TextColumn::make('start_time')
                    ->label('Jam Mulai')
                    ->formatStateUsing(fn ($state) => substr((string) $state, 0, 5) . ' WIB')
                    ->sortable(),

                TextColumn::make('end_time')
                    ->label('Jam Selesai')
                    ->formatStateUsing(fn ($state) => substr((string) $state, 0, 5) . ' WIB')
                    ->sortable(),

                IconColumn::make('is_active')
                    ->label('Status Aktif')
                    ->boolean(),

                TextColumn::make('created_at')
                    ->label('Dibuat Pada')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('day_of_week')
            ->recordActions([
                ActionGroup::make([
                    ActionGroup::make([
                        EditAction::make()
                            ->label('Ubah Pola'),

                        Action::make('generateSlots')
                            ->label('Generate Slot Kalender')
                            ->icon('heroicon-m-bolt')
                            ->color('success')
                            ->form([
                                TextInput::make('horizon_days')
                                    ->label('Berapa hari ke depan?')
                                    ->helperText('Contoh: 14 hari akan membuat slot tanggal untuk 2 minggu ke depan, 30 hari untuk 1 bulan.')
                                    ->numeric()
                                    ->default(14)
                                    ->minValue(1)
                                    ->maxValue(90)
                                    ->required(),
                            ])
                            ->modalHeading('Otomatis Buat Slot Tanggal Kalender')
                            ->modalDescription('Sistem akan membuat slot tanggal & jam nyata di kalender berdasarkan hari dan jam rutin ini agar siswa dapat memilihnya.')
                            ->modalSubmitActionLabel('Buat Slot Sekarang')
                            ->visible(fn (MentorAvailabilityTemplate $record): bool => $record->is_active)
                            ->action(function (MentorAvailabilityTemplate $record, array $data): void {
                                $generatedCount = app(MentorAvailabilitySlotGenerator::class)
                                    ->generateForTemplate($record, (int) ($data['horizon_days'] ?? 14));

                                Notification::make()
                                    ->title('Slot Kalender Berhasil Dibuat')
                                    ->body($generatedCount . ' slot jadwal baru berhasil ditambahkan ke kalender mentoring Anda.')
                                    ->success()
                                    ->send();
                            }),
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
            'index' => ManageMentorAvailabilityTemplates::route('/'),
        ];
    }
}