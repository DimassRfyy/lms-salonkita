<?php

namespace App\Filament\Resources\Mentoring\Requests;

use App\Filament\Resources\Mentoring\Requests\Pages\ManageMentoringRequests;
use App\Models\MentoringRequest;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class MentoringRequestResource extends Resource
{
    protected static ?string $model = MentoringRequest::class;

    protected static string | \UnitEnum | null $navigationGroup = 'Mentoring';

    protected static ?string $navigationLabel = 'Permohonan Mentoring';

    protected static ?string $modelLabel = 'Permohonan Mentoring';

    protected static ?string $pluralModelLabel = 'Permohonan Mentoring';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::InboxStack;

    protected static ?int $navigationSort = 1;

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
            ->with(['student', 'course', 'entitlement']);
    }

    public static function getNavigationBadge(): ?string
    {
        $user = Auth::user();

        if (! $user || $user->role !== 'mentor') {
            return null;
        }

        $count = MentoringRequest::query()
            ->where('mentor_id', $user->id)
            ->where('status', MentoringRequest::STATUS_PENDING)
            ->count('*');

        return $count > 0 ? (string) $count : null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }

    public static function getNavigationBadgeTooltip(): ?string
    {
        return 'Permohonan mentoring yang menunggu persetujuan Anda';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi & Kontak Siswa')
                    ->description('Profil lengkap siswa yang mengajukan permohonan bimbingan.')
                    ->schema([
                        TextInput::make('student_name')
                            ->label('Nama Siswa')
                            ->formatStateUsing(fn (?MentoringRequest $record) => $record?->student?->name)
                            ->disabled()
                            ->dehydrated(false),

                        TextInput::make('student_email')
                            ->label('Email')
                            ->formatStateUsing(fn (?MentoringRequest $record) => $record?->student?->email)
                            ->disabled()
                            ->dehydrated(false),

                        TextInput::make('student_whatsapp')
                            ->label('Nomor WhatsApp')
                            ->formatStateUsing(fn (?MentoringRequest $record) => $record?->student?->whatsapp_number ?? 'Belum diisi')
                            ->disabled()
                            ->dehydrated(false)
                            ->suffixAction(
                                Action::make('chatWhatsapp')
                                    ->label('Chat WA')
                                    ->icon(Heroicon::ChatBubbleLeftEllipsis)
                                    ->url(function (?MentoringRequest $record): ?string {
                                        $phone = $record?->student?->whatsapp_number;
                                        if (! $phone) {
                                            return null;
                                        }
                                        $cleanPhone = preg_replace('/^0/', '62', preg_replace('/\D/', '', $phone));
                                        return 'https://wa.me/' . $cleanPhone;
                                    })
                                    ->openUrlInNewTab()
                                    ->visible(fn (?MentoringRequest $record) => filled($record?->student?->whatsapp_number))
                            ),

                        TextInput::make('student_city')
                            ->label('Kota Asal Siswa')
                            ->formatStateUsing(fn (?MentoringRequest $record) => $record?->student?->city ?? '-')
                            ->disabled()
                            ->dehydrated(false),
                    ])
                    ->columns(2),

                Section::make('Detail Permohonan Bimbingan')
                    ->schema([
                        Select::make('course_id')
                            ->label('Kelas yang Dipelajari')
                            ->relationship('course', 'name')
                            ->disabled()
                            ->dehydrated(false),

                        Select::make('status')
                            ->label('Status Permohonan')
                            ->options([
                                MentoringRequest::STATUS_PENDING => 'Menunggu Review Mentor',
                                MentoringRequest::STATUS_APPROVED => 'Disetujui',
                                MentoringRequest::STATUS_REJECTED => 'Ditolak',
                                MentoringRequest::STATUS_CANCELED => 'Dibatalkan Siswa',
                                MentoringRequest::STATUS_COMPLETED => 'Selesai Dijadwalkan',
                            ])
                            ->disabled()
                            ->dehydrated(false),

                        Textarea::make('student_notes')
                            ->label('Topik / Catatan Konsultasi dari Siswa')
                            ->placeholder('Siswa tidak menyertakan catatan khusus.')
                            ->rows(3)
                            ->disabled()
                            ->dehydrated(false)
                            ->columnSpanFull(),

                        Textarea::make('rejection_reason')
                            ->label('Alasan Penolakan (Jika ditolak)')
                            ->rows(2)
                            ->disabled()
                            ->dehydrated(false)
                            ->visible(fn (?MentoringRequest $record) => $record?->status === MentoringRequest::STATUS_REJECTED)
                            ->columnSpanFull(),

                        DateTimePicker::make('created_at')
                            ->label('Waktu Diajukan')
                            ->disabled()
                            ->dehydrated(false),

                        DateTimePicker::make('reviewed_at')
                            ->label('Waktu Ditinjau')
                            ->disabled()
                            ->dehydrated(false),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('student.avatar_url')
                    ->label('')
                    ->circular()
                    ->defaultImageUrl(fn (MentoringRequest $record) => 'https://ui-avatars.com/api/?name=' . urlencode($record->student?->name ?? 'S') . '&color=db2777&background=fdf2f8'),

                TextColumn::make('student.name')
                    ->label('Siswa')
                    ->searchable()
                    ->sortable()
                    ->description(fn (MentoringRequest $record): ?string => $record->student?->whatsapp_number ? 'WA: ' . $record->student->whatsapp_number : $record->student?->email),

                TextColumn::make('course.name')
                    ->label('Kelas')
                    ->searchable()
                    ->sortable()
                    ->wrap(),

                TextColumn::make('student_notes')
                    ->label('Topik / Catatan Siswa')
                    ->limit(40)
                    ->tooltip(fn (MentoringRequest $record): ?string => $record->student_notes)
                    ->placeholder('Tidak ada catatan')
                    ->wrap(),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->colors([
                        'warning' => MentoringRequest::STATUS_PENDING,
                        'success' => MentoringRequest::STATUS_APPROVED,
                        'danger' => MentoringRequest::STATUS_REJECTED,
                        'gray' => MentoringRequest::STATUS_CANCELED,
                        'info' => MentoringRequest::STATUS_COMPLETED,
                    ])
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        MentoringRequest::STATUS_PENDING => 'Menunggu Review',
                        MentoringRequest::STATUS_APPROVED => 'Disetujui',
                        MentoringRequest::STATUS_REJECTED => 'Ditolak',
                        MentoringRequest::STATUS_CANCELED => 'Dibatalkan',
                        MentoringRequest::STATUS_COMPLETED => 'Selesai',
                        default => ucfirst($state),
                    })
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Diajukan')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Status Permohonan')
                    ->options([
                        MentoringRequest::STATUS_PENDING => 'Menunggu Review',
                        MentoringRequest::STATUS_APPROVED => 'Disetujui',
                        MentoringRequest::STATUS_REJECTED => 'Ditolak',
                        MentoringRequest::STATUS_COMPLETED => 'Selesai',
                        MentoringRequest::STATUS_CANCELED => 'Dibatalkan',
                    ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->recordActions([
                ActionGroup::make([
                    ActionGroup::make([
                        ViewAction::make()
                            ->label('Detail Siswa')
                            ->modalHeading('Detail Permohonan & Profil Siswa'),

                        Action::make('approve')
                            ->label('Setujui')
                            ->icon('heroicon-m-check')
                            ->color('success')
                            ->visible(fn (MentoringRequest $record): bool => $record->status === MentoringRequest::STATUS_PENDING)
                            ->requiresConfirmation()
                            ->modalHeading('Setujui Permohonan Mentoring')
                            ->modalDescription('Apakah Anda yakin ingin menyetujui siswa ini untuk mentoring? Siswa akan dapat memilih jadwal sesi dengan Anda.')
                            ->modalSubmitActionLabel('Ya, Setujui')
                            ->action(function (MentoringRequest $record): void {
                                $record->update([
                                    'status' => MentoringRequest::STATUS_APPROVED,
                                    'reviewed_at' => now(),
                                ]);

                                Notification::make()
                                    ->title('Permohonan mentoring berhasil disetujui.')
                                    ->success()
                                    ->send();
                            }),

                        Action::make('reject')
                            ->label('Tolak')
                            ->icon('heroicon-m-x-mark')
                            ->color('danger')
                            ->visible(fn (MentoringRequest $record): bool => $record->status === MentoringRequest::STATUS_PENDING)
                            ->form([
                                Textarea::make('rejection_reason')
                                    ->label('Alasan Penolakan')
                                    ->placeholder('Contoh: Topik di luar fokus keahlian atau jadwal sedang padat.')
                                    ->rows(3)
                                    ->nullable(),
                            ])
                            ->modalHeading('Tolak Permohonan Mentoring')
                            ->modalDescription('Siswa akan mendapatkan info penolakan ini dan dapat mengajukan ke mentor lain.')
                            ->modalSubmitActionLabel('Tolak Permohonan')
                            ->action(function (MentoringRequest $record, array $data): void {
                                $record->update([
                                    'status' => MentoringRequest::STATUS_REJECTED,
                                    'rejection_reason' => $data['rejection_reason'] ?? null,
                                    'reviewed_at' => now(),
                                ]);

                                Notification::make()
                                    ->title('Permohonan mentoring ditolak.')
                                    ->warning()
                                    ->send();
                            }),
                    ])
                        ->dropdown(false),
                    DeleteAction::make(),
                ])->icon('heroicon-m-bars-3'),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageMentoringRequests::route('/'),
        ];
    }
}
