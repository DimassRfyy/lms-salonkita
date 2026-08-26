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
use Filament\Forms\Components\Placeholder;
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
use Illuminate\Support\HtmlString;

class MentoringRequestResource extends Resource
{
    protected static ?string $model = MentoringRequest::class;

    protected static string | \UnitEnum | null $navigationGroup = 'Mentoring';

    protected static ?string $navigationLabel = 'Permohonan Mentoring';

    protected static ?string $modelLabel = 'Permohonan Mentoring';

    protected static ?string $pluralModelLabel = 'Permohonan & Riwayat Mentoring';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::InboxStack;

    protected static ?int $navigationSort = 1;

    public static function canAccess(): bool
    {
        $user = Auth::user();

        return $user !== null && in_array($user->role, ['mentor', 'admin'], true);
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function getNavigationGroup(): ?string
    {
        return Auth::user()?->role === 'admin' ? 'User Management' : 'Mentoring';
    }

    public static function getNavigationLabel(): string
    {
        return Auth::user()?->role === 'admin' ? 'Riwayat Hubungan Mentor' : 'Permohonan Mentoring';
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery()
            ->with(['student', 'mentor', 'course', 'entitlement']);

        if (Auth::user()?->role === 'mentor') {
            $query->where('mentor_id', Auth::id());
        }

        return $query;
    }

    public static function getNavigationBadge(): ?string
    {
        $user = Auth::user();

        if (! $user || ! in_array($user->role, ['mentor', 'admin'], true)) {
            return null;
        }

        $query = MentoringRequest::query()
            ->where('status', MentoringRequest::STATUS_PENDING);

        if ($user->role === 'mentor') {
            $query->where('mentor_id', $user->id);
        }

        $count = $query->count('*');

        return $count > 0 ? (string) $count : null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }

    public static function getNavigationBadgeTooltip(): ?string
    {
        return 'Permohonan mentoring yang menunggu persetujuan';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi & Kontak Siswa')
                    ->description('Profil lengkap siswa yang mengajukan permohonan bimbingan.')
                    ->schema([
                        Placeholder::make('student_avatar_preview')
                            ->label('Foto Profil')
                            ->content(function (?MentoringRequest $record): HtmlString {
                                $avatarUrl = $record?->student?->avatar_url 
                                    ?? ('https://ui-avatars.com/api/?name=' . urlencode($record?->student?->name ?? 'S') . '&color=db2777&background=fdf2f8');

                                return new HtmlString('
                                    <div class="flex items-center pt-1">
                                        <img src="' . e($avatarUrl) . '" alt="Avatar" class="rounded-2xl object-cover shadow-xs border-2 border-pink-200" style="width: 64px; height: 64px; min-width: 64px; min-height: 64px; max-width: 64px; max-height: 64px;" />
                                    </div>
                                ');
                            })
                            ->columnSpanFull(),

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

                Section::make('Informasi Mentor Pembimbing')
                    ->schema([
                        TextInput::make('mentor_name')
                            ->label('Nama Mentor')
                            ->formatStateUsing(fn (?MentoringRequest $record) => $record?->mentor?->name)
                            ->disabled()
                            ->dehydrated(false),

                        TextInput::make('mentor_job_title')
                            ->label('Profesi Mentor')
                            ->formatStateUsing(fn (?MentoringRequest $record) => $record?->mentor?->job_title ?? 'Mentor Profesional')
                            ->disabled()
                            ->dehydrated(false),
                    ])
                    ->columns(2)
                    ->visible(fn () => Auth::user()?->role === 'admin'),

                Section::make('Detail Status & Riwayat Mentorship')
                    ->schema([
                        Select::make('course_id')
                            ->label('Kelas Awal Pengajuan')
                            ->relationship('course', 'name')
                            ->disabled()
                            ->dehydrated(false),

                        Select::make('status')
                            ->label('Status Hubungan Mentorship')
                            ->options([
                                MentoringRequest::STATUS_PENDING => 'Menunggu Review Mentor',
                                MentoringRequest::STATUS_APPROVED => 'Disetujui (Mentor Aktif)',
                                MentoringRequest::STATUS_REJECTED => 'Ditolak Mentor',
                                MentoringRequest::STATUS_TERMINATED => 'Putus Hubungan (Dibatalkan Siswa)',
                                MentoringRequest::STATUS_CANCELED => 'Pengajuan Dibatalkan Siswa',
                                MentoringRequest::STATUS_COMPLETED => 'Selesai',
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

                        Textarea::make('termination_reason')
                            ->label('Alasan Pembatalan / Putus Hubungan oleh Siswa')
                            ->rows(3)
                            ->disabled()
                            ->dehydrated(false)
                            ->visible(fn (?MentoringRequest $record) => filled($record?->termination_reason) || $record?->status === MentoringRequest::STATUS_TERMINATED)
                            ->columnSpanFull(),

                        Textarea::make('rejection_reason')
                            ->label('Alasan Penolakan (Jika ditolak mentor)')
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
                            ->label('Waktu Disetujui / Ditinjau')
                            ->disabled()
                            ->dehydrated(false),

                        DateTimePicker::make('terminated_at')
                            ->label('Waktu Putus Hubungan')
                            ->disabled()
                            ->dehydrated(false)
                            ->visible(fn (?MentoringRequest $record) => filled($record?->terminated_at)),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('student.avatar')
                    ->label('')
                    ->disk('public')
                    ->circular()
                    ->defaultImageUrl(fn (MentoringRequest $record) => $record->student?->avatar && (str_starts_with($record->student->avatar, 'http://') || str_starts_with($record->student->avatar, 'https://'))
                        ? $record->student->avatar
                        : ('https://ui-avatars.com/api/?name=' . urlencode($record->student?->name ?? 'S') . '&color=db2777&background=fdf2f8')
                    ),

                TextColumn::make('student.name')
                    ->label('Siswa')
                    ->searchable()
                    ->sortable()
                    ->description(fn (MentoringRequest $record): ?string => $record->student?->whatsapp_number ? 'WA: ' . $record->student->whatsapp_number : $record->student?->email),

                TextColumn::make('mentor.name')
                    ->label('Mentor')
                    ->searchable()
                    ->sortable()
                    ->visible(fn () => Auth::user()?->role === 'admin'),

                TextColumn::make('course.name')
                    ->label('Kelas Awal')
                    ->searchable()
                    ->sortable()
                    ->wrap(),

                TextColumn::make('student_notes')
                    ->label('Topik Siswa')
                    ->limit(30)
                    ->tooltip(fn (MentoringRequest $record): ?string => $record->student_notes)
                    ->placeholder('Tidak ada catatan')
                    ->wrap(),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->colors([
                        'warning' => MentoringRequest::STATUS_PENDING,
                        'success' => MentoringRequest::STATUS_APPROVED,
                        'danger' => [MentoringRequest::STATUS_REJECTED, MentoringRequest::STATUS_TERMINATED],
                        'gray' => MentoringRequest::STATUS_CANCELED,
                        'info' => MentoringRequest::STATUS_COMPLETED,
                    ])
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        MentoringRequest::STATUS_PENDING => 'Menunggu Review',
                        MentoringRequest::STATUS_APPROVED => 'Mentor Aktif',
                        MentoringRequest::STATUS_REJECTED => 'Ditolak',
                        MentoringRequest::STATUS_TERMINATED => 'Putus Hubungan',
                        MentoringRequest::STATUS_CANCELED => 'Dibatalkan',
                        MentoringRequest::STATUS_COMPLETED => 'Selesai',
                        default => ucfirst($state),
                    })
                    ->sortable(),

                TextColumn::make('termination_reason')
                    ->label('Alasan Putus Hubungan')
                    ->limit(35)
                    ->tooltip(fn (MentoringRequest $record): ?string => $record->termination_reason)
                    ->placeholder('-')
                    ->wrap()
                    ->visible(fn () => Auth::user()?->role === 'admin'),

                TextColumn::make('created_at')
                    ->label('Diajukan')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),

                TextColumn::make('terminated_at')
                    ->label('Tgl Putus')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->visible(fn () => Auth::user()?->role === 'admin'),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Status Mentorship')
                    ->options([
                        MentoringRequest::STATUS_PENDING => 'Menunggu Review',
                        MentoringRequest::STATUS_APPROVED => 'Mentor Aktif (Disetujui)',
                        MentoringRequest::STATUS_TERMINATED => 'Putus Hubungan (Dibatalkan Siswa)',
                        MentoringRequest::STATUS_REJECTED => 'Ditolak Mentor',
                        MentoringRequest::STATUS_CANCELED => 'Pengajuan Dibatalkan',
                    ]),
                SelectFilter::make('mentor_id')
                    ->label('Filter Mentor')
                    ->relationship('mentor', 'name')
                    ->visible(fn () => Auth::user()?->role === 'admin'),
            ])
            ->defaultSort('created_at', 'desc')
            ->recordActions([
                ActionGroup::make([
                    ActionGroup::make([
                        ViewAction::make()
                            ->label('Detail')
                            ->modalHeading('Detail Permohonan & Riwayat Mentorship'),

                        Action::make('approve')
                            ->label('Setujui (ACC)')
                            ->icon('heroicon-m-check')
                            ->color('success')
                            ->visible(fn (MentoringRequest $record): bool => $record->status === MentoringRequest::STATUS_PENDING && (Auth::user()?->role === 'mentor' && $record->mentor_id === Auth::id() || Auth::user()?->role === 'admin'))
                            ->requiresConfirmation()
                            ->modalHeading('Setujui Siswa Bimbingan')
                            ->modalDescription('Apakah Anda yakin ingin menyetujui siswa ini? Siswa akan resmi menjadi anak bimbingan Anda dan dapat langsung memilih jadwal sesi bimbingan.')
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
                            ->visible(fn (MentoringRequest $record): bool => $record->status === MentoringRequest::STATUS_PENDING && (Auth::user()?->role === 'mentor' && $record->mentor_id === Auth::id() || Auth::user()?->role === 'admin'))
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
                    DeleteAction::make()
                        ->visible(fn () => Auth::user()?->role === 'admin'),
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
