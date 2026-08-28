<?php

namespace App\Filament\Resources\Mentoring\Bookings;

use App\Filament\Resources\Mentoring\Bookings\Pages\ManageMentoringBookings;
use App\Models\MentoringBooking;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Enums\Width;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class MentoringBookingResource extends Resource
{
    protected static ?string $model = MentoringBooking::class;

    protected static string | \UnitEnum | null $navigationGroup = 'Mentoring';

    protected static ?string $navigationLabel = 'Bookings';

    protected static ?string $modelLabel = 'Booking Mentoring';

    protected static ?string $pluralModelLabel = 'Booking Mentoring';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::CalendarDays;

    public static function canAccess(): bool
    {
        $user = Auth::user();

        return $user !== null && $user->role === 'mentor';
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('mentor_id', Auth::id())
            ->with(['student', 'course', 'slot']);
    }

    public static function getNavigationBadge(): ?string
    {
        $user = Auth::user();

        if (! $user || $user->role !== 'mentor') {
            return null;
        }

        $count = MentoringBooking::query()
            ->where('mentor_id', $user->id)
            ->where('status', MentoringBooking::STATUS_CONFIRMED)
            ->where(function (Builder $query): void {
                $query->whereNull('meeting_url')
                    ->orWhere('meeting_url', '');
            })
            ->count('*');

        return $count > 0 ? (string) $count : null;
    }

    public static function getNavigationBadgeTooltip(): ?string
    {
        return 'Booking yang belum punya link meeting';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Hidden::make('mentor_id')
                    ->default(fn () => Auth::id())
                    ->required(),

                Section::make('Informasi Booking')
                    ->description('Detail sesi yang sudah dibooking siswa.')
                    ->schema([
                        Select::make('student_id')
                            ->label('Siswa')
                            ->relationship('student', 'name')
                            ->disabled()
                            ->dehydrated(),
                        Select::make('course_id')
                            ->label('Kelas')
                            ->relationship('course', 'name')
                            ->disabled()
                            ->dehydrated(),
                        DateTimePicker::make('starts_at')
                            ->label('Waktu Mulai')
                            ->seconds(false)
                            ->disabled()
                            ->dehydrated(),
                        DateTimePicker::make('ends_at')
                            ->label('Waktu Selesai')
                            ->seconds(false)
                            ->disabled()
                            ->dehydrated(),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),

                Section::make('Pengaturan Meeting')
                    ->description('Isi platform dan link Meet/Zoom supaya siswa bisa bergabung.')
                    ->schema([
                        Select::make('meeting_platform')
                            ->label('Platform Meeting')
                            ->options([
                                'zoom' => 'Zoom',
                                'google_meet' => 'Google Meet',
                            ])
                            ->native(false)
                            ->placeholder('Pilih platform')
                            ->nullable(),
                        TextInput::make('meeting_url')
                            ->label('Link Meeting')
                            ->url()
                            ->placeholder('https://meet.google.com/... atau https://zoom.us/j/...')
                            ->helperText('Paste link Zoom / Google Meet di sini.')
                            ->nullable(),
                        Select::make('status')
                            ->label('Status Sesi')
                            ->options([
                                MentoringBooking::STATUS_CONFIRMED => 'Confirmed (Terjadwal)',
                                MentoringBooking::STATUS_COMPLETED => 'Completed (Selesai)',
                                MentoringBooking::STATUS_CANCELED => 'Canceled (Dibatalkan)',
                                MentoringBooking::STATUS_NO_SHOW => 'No Show (Siswa Tidak Hadir)',
                            ])
                            ->native(false)
                            ->required(),
                    ])
                    ->columns(1)
                    ->columnSpanFull(),

                Section::make('Catatan & Feedback Mentoring')
                    ->description('Catatan persiapan dan evaluasi/feedback setelah sesi mentoring selesai.')
                    ->schema([
                        Textarea::make('notes')
                            ->label('Catatan Sebelum Sesi (untuk Siswa)')
                            ->placeholder('Contoh: Siapkan hasil tugas makeup kamu sebelum sesi dimulai.')
                            ->rows(3)
                            ->nullable(),
                        Textarea::make('feedback')
                            ->label('Feedback / Evaluasi Pasca Sesi')
                            ->placeholder('Tuliskan evaluasi perkembangan siswa, poin-poin yang sudah bagus, dan saran perbaikan...')
                            ->helperText('Diisi setelah sesi mentoring selesai sebagai umpan balik untuk siswa.')
                            ->rows(4)
                            ->nullable(),
                    ])
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('student.name')
                    ->label('Siswa')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('course.name')
                    ->label('Kelas')
                    ->searchable()
                    ->sortable()
                    ->wrap(),
                TextColumn::make('starts_at')
                    ->label('Jadwal')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->description(fn (MentoringBooking $record): string => $record->ends_at?->format('H:i') ?? ''),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->colors([
                        'info' => MentoringBooking::STATUS_CONFIRMED,
                        'success' => MentoringBooking::STATUS_COMPLETED,
                        'danger' => MentoringBooking::STATUS_CANCELED,
                        'warning' => MentoringBooking::STATUS_NO_SHOW,
                    ])
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        MentoringBooking::STATUS_CONFIRMED => 'Confirmed',
                        MentoringBooking::STATUS_COMPLETED => 'Completed',
                        MentoringBooking::STATUS_CANCELED => 'Canceled',
                        MentoringBooking::STATUS_NO_SHOW => 'No Show',
                        default => ucfirst($state),
                    })
                    ->sortable(),
                TextColumn::make('meeting_platform')
                    ->label('Platform')
                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                        'zoom' => 'Zoom',
                        'google_meet' => 'Google Meet',
                        default => '-',
                    })
                    ->placeholder('-'),
                TextColumn::make('meeting_url')
                    ->label('Link Meeting')
                    ->limit(24)
                    ->url(fn (MentoringBooking $record): ?string => $record->meeting_url, shouldOpenInNewTab: true)
                    ->placeholder('Belum diisi')
                    ->color(fn (MentoringBooking $record): string => filled($record->meeting_url) ? 'primary' : 'warning'),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        MentoringBooking::STATUS_CONFIRMED => 'Confirmed',
                        MentoringBooking::STATUS_COMPLETED => 'Completed',
                        MentoringBooking::STATUS_CANCELED => 'Canceled',
                        MentoringBooking::STATUS_NO_SHOW => 'No Show',
                    ]),
                SelectFilter::make('meeting_url')
                    ->label('Link Meeting')
                    ->options([
                        'missing' => 'Belum diisi',
                        'filled' => 'Sudah diisi',
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return match ($data['value'] ?? null) {
                            'missing' => $query->where(function (Builder $inner): void {
                                $inner->whereNull('meeting_url')->orWhere('meeting_url', '');
                            }),
                            'filled' => $query->whereNotNull('meeting_url')->where('meeting_url', '!=', ''),
                            default => $query,
                        };
                    }),
            ])
            ->defaultSort('starts_at', 'desc')
            ->recordActions([
                EditAction::make()
                    ->label('Atur Meeting')
                    ->modalHeading('Atur Meeting & Feedback Mentoring')
                    ->modalDescription('Lengkapi platform, link meeting, status, catatan, dan feedback untuk siswa.')
                    ->modalWidth(Width::TwoExtraLarge)
                    ->modalSubmitActionLabel('Simpan'),
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
            'index' => ManageMentoringBookings::route('/'),
        ];
    }
}
