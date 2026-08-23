<?php

namespace App\Filament\Resources\Mentoring\Templates;

use App\Filament\Resources\Mentoring\Templates\Pages\ManageMentorAvailabilityTemplates;
use App\Models\MentorAvailabilitySlot;
use App\Models\MentorAvailabilityTemplate;
use App\Support\Mentoring\MentorAvailabilitySlotGenerator;
use Illuminate\Database\Eloquent\Collection;
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
                            ->seconds(false)
                            ->default(fn () => now()->startOfHour()->format('H:i'))
                            ->required(),

                        TimePicker::make('end_time')
                            ->label('Jam Selesai (WIB)')
                            ->seconds(false)
                            ->default(fn () => now()->startOfHour()->addHour()->format('H:i'))
                            ->required(),

                        Toggle::make('is_active')
                            ->label('Status Pola Aktif')
                            ->helperText('Hanya pola aktif yang akan muncul menjadi slot jadwal rutin')
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
                            ->label('Ubah Pola')
                            ->modalHeading('Ubah Pola Jadwal Rutin')
                            ->modalDescription(function (MentorAvailabilityTemplate $record): string {
                                $bookedCount = MentorAvailabilitySlot::query()
                                    ->where('mentor_availability_template_id', $record->id)
                                    ->where('status', MentorAvailabilitySlot::STATUS_BOOKED)
                                    ->where('starts_at', '>=', now())
                                    ->count();

                                if ($bookedCount > 0) {
                                    return "Perhatian: Terdapat {$bookedCount} sesi yang SUDAH DIBOOKING siswa pada pola jam ini. Sesi siswa tersebut TETAP BERLAKU di jam semula demi kenyamanan siswa. Perubahan pola ini hanya akan menyinkronkan slot kosong masa depan yang belum dibooking.";
                                }

                                return 'Slot kosong masa depan yang belum dibooking akan otomatis disinkronkan ke jam baru ini setelah Anda simpan.';
                            })
                            ->after(function (MentorAvailabilityTemplate $record): void {
                                $syncResult = app(MentorAvailabilitySlotGenerator::class)->syncTemplateSlots($record, 30);

                                $body = 'Pola jadwal berhasil diperbarui.';
                                if ($syncResult['deleted_unbooked'] > 0 || $syncResult['new_created'] > 0) {
                                    $body .= " {$syncResult['deleted_unbooked']} slot kosong lama dibersihkan dan {$syncResult['new_created']} slot baru dibuat.";
                                }
                                if ($syncResult['booked_retained'] > 0) {
                                    $body .= " ({$syncResult['booked_retained']} jadwal siswa yang sudah dibooking tetap aman di jam semula).";
                                }

                                Notification::make()
                                    ->title('Pola & Slot Kalender Disinkronkan')
                                    ->body($body)
                                    ->success()
                                    ->send();
                            }),

                        Action::make('generateSlots')
                            ->label('Terapkan ke Kalender')
                            ->icon('heroicon-m-calendar-days')
                            ->color('success')
                            ->form([
                                Select::make('horizon_days')
                                    ->label('Pilih Periode Buka Jadwal')
                                    ->options([
                                        14 => '2 Minggu ke Depan (14 Hari)',
                                        30 => '1 Bulan ke Depan (30 Hari) - Direkomendasikan',
                                        60 => '2 Bulan ke Depan (60 Hari)',
                                        90 => '3 Bulan ke Depan (90 Hari)',
                                    ])
                                    ->default(30)
                                    ->required()
                                    ->helperText('Slot akan otomatis dibuat untuk hari & jam ini yang belum ada di kalender.'),
                            ])
                            ->modalHeading(fn (MentorAvailabilityTemplate $record): string => 'Buka Jadwal: ' . match ((int) $record->day_of_week) {
                                1 => 'Senin',
                                2 => 'Selasa',
                                3 => 'Rabu',
                                4 => 'Kamis',
                                5 => 'Jumat',
                                6 => 'Sabtu',
                                0 => 'Minggu',
                                default => 'Hari',
                            } . ' (' . substr((string) $record->start_time, 0, 5) . ' - ' . substr((string) $record->end_time, 0, 5) . ' WIB)')
                            ->modalDescription('Sistem akan membuat slot tanggal & jam nyata di kalender bimbingan berdasarkan pola hari ini agar siswa dapat memilihnya.')
                            ->modalSubmitActionLabel('Buat Slot Jadwal')
                            ->visible(fn (MentorAvailabilityTemplate $record): bool => (bool) $record->is_active)
                            ->action(function (MentorAvailabilityTemplate $record, array $data): void {
                                $horizonDays = (int) ($data['horizon_days'] ?? 30);
                                $generatedCount = app(MentorAvailabilitySlotGenerator::class)
                                    ->generateForTemplate($record, $horizonDays);

                                if ($generatedCount > 0) {
                                    Notification::make()
                                        ->title('Slot Jadwal Berhasil Dibuat')
                                        ->body("Berhasil menambahkan {$generatedCount} slot tanggal baru ke kalender mentoring Anda.")
                                        ->success()
                                        ->send();
                                } else {
                                    Notification::make()
                                        ->title('Jadwal Sudah Terbuka')
                                        ->body("Slot jadwal untuk pola ini sudah tersedia di kalender untuk periode {$horizonDays} hari ke depan.")
                                        ->info()
                                        ->send();
                                }
                            }),
                    ])
                        ->dropdown(false),
                    DeleteAction::make()
                        ->label('Hapus Pola')
                        ->modalDescription(function (MentorAvailabilityTemplate $record): string {
                            $bookedCount = MentorAvailabilitySlot::query()
                                ->where('mentor_availability_template_id', $record->id)
                                ->where('status', MentorAvailabilitySlot::STATUS_BOOKED)
                                ->where('starts_at', '>=', now())
                                ->count();

                            if ($bookedCount > 0) {
                                return "Perhatian: Terdapat {$bookedCount} sesi yang sudah dibooking siswa dari pola ini. Slot kosong yang belum dibooking akan dihapus dari kalender, tetapi sesi yang sudah dibooking siswa TIDAK akan terhapus.";
                            }

                            return 'Semua slot kosong masa depan yang dibuat dari pola ini akan otomatis dihapus dari kalender.';
                        })
                        ->after(function (MentorAvailabilityTemplate $record): void {
                            $deletedCount = app(MentorAvailabilitySlotGenerator::class)->cleanupTemplateSlotsOnDelete($record->id);
                            if ($deletedCount > 0) {
                                Notification::make()
                                    ->title('Pola & Slot Kosong Dihapus')
                                    ->body("{$deletedCount} slot kosong masa depan dari pola ini telah dibersihkan dari kalender.")
                                    ->success()
                                    ->send();
                            }
                        }),
                ])->icon('heroicon-m-bars-3'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->after(function (Collection $records): void {
                            foreach ($records as $record) {
                                app(MentorAvailabilitySlotGenerator::class)->cleanupTemplateSlotsOnDelete($record->id);
                            }
                        }),
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