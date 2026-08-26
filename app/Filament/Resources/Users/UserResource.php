<?php

namespace App\Filament\Resources\Users;

use App\Filament\Resources\Users\Pages\ManageUsers;
use App\Models\User;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::UserGroup;

    public static function canAccess(): bool
    {
        $user = Auth::user();

        return $user !== null && in_array($user->role, ['admin', 'coach'], true);
    }

    public static function canCreate(): bool
    {
        return Auth::user()?->role === 'admin';
    }

    public static function canEdit(Model $record): bool
    {
        return Auth::user()?->role === 'admin';
    }

    public static function canDelete(Model $record): bool
    {
        return Auth::user()?->role === 'admin';
    }

    public static function canDeleteAny(): bool
    {
        return Auth::user()?->role === 'admin';
    }

    public static function getNavigationGroup(): ?string
    {
        return Auth::user()?->role === 'coach' ? 'Course Management' : 'User Management';
    }

    public static function getNavigationSort(): ?int
    {
        return Auth::user()?->role === 'coach' ? 2 : 1;
    }

    public static function getNavigationLabel(): string
    {
        return Auth::user()?->role === 'coach' ? 'Siswa Saya' : 'User Management';
    }

    public static function getModelLabel(): string
    {
        return Auth::user()?->role === 'coach' ? 'Siswa' : 'User';
    }

    public static function getPluralModelLabel(): string
    {
        return Auth::user()?->role === 'coach' ? 'Siswa Saya' : 'Users';
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();
        $user = Auth::user();

        if ($user?->role === 'coach') {
            $query->where('role', 'student')
                ->whereHas('ownedCourses', fn ($q) => $q->where('courses.user_id', $user->id))
                ->with(['ownedCourses', 'courseVideoWatches', 'courseTaskSubmissions', 'courseVideoQuizCompletions', 'certificates']);
        }

        return $query;
    }

    public static function getNavigationBadge(): ?string
    {
        $user = Auth::user();
        if (! $user) {
            return null;
        }

        if ($user->role === 'admin') {
            $count = static::getModel()::query()
                ->whereIn('role', ['mentor', 'coach'])
                ->where('is_approved', false)
                ->count();

            return $count > 0 ? (string) $count : null;
        }

        if ($user->role === 'coach') {
            $count = static::getModel()::query()
                ->where('role', 'student')
                ->whereHas('ownedCourses', fn ($q) => $q->where('courses.user_id', $user->id))
                ->count();

            return $count > 0 ? (string) $count : null;
        }

        return null;
    }

    public static function getNavigationBadgeColor(): string|array|null
    {
        return Auth::user()?->role === 'coach' ? 'info' : 'warning';
    }

    public static function getNavigationBadgeTooltip(): ?string
    {
        return Auth::user()?->role === 'coach' ? 'Total siswa di kelas Anda' : 'Mentor & Coach menunggu persetujuan';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('StudentDetailTabs')
                    ->tabs([
                        Tab::make('Informasi Siswa')
                            ->icon(Heroicon::User)
                            ->schema([
                                FileUpload::make('avatar')
                                    ->label('Avatar')
                                    ->image()
                                    ->disk('public')
                                    ->directory('avatars')
                                    ->disabled(fn () => Auth::user()?->role !== 'admin')
                                    ->dehydrated(fn () => Auth::user()?->role === 'admin')
                                    ->columnSpanFull(),
                                TextInput::make('name')
                                    ->label('Nama Lengkap')
                                    ->required()
                                    ->disabled(fn () => Auth::user()?->role !== 'admin'),
                                TextInput::make('email')
                                    ->label('Alamat Email')
                                    ->email()
                                    ->required()
                                    ->disabled(fn () => Auth::user()?->role !== 'admin'),
                                TextInput::make('whatsapp_number')
                                    ->label('Nomor WhatsApp')
                                    ->maxLength(30)
                                    ->disabled(fn () => Auth::user()?->role !== 'admin')
                                    ->suffixAction(
                                        Action::make('chatWhatsapp')
                                            ->label('Chat WhatsApp')
                                            ->icon(Heroicon::ChatBubbleLeftEllipsis)
                                            ->color('success')
                                            ->url(function (?User $record): ?string {
                                                $phone = $record?->whatsapp_number;
                                                if (! $phone) {
                                                    return null;
                                                }
                                                $cleanPhone = preg_replace('/[^0-9]/', '', $phone);
                                                if (str_starts_with($cleanPhone, '0')) {
                                                    $cleanPhone = '62' . substr($cleanPhone, 1);
                                                }
                                                return 'https://wa.me/' . $cleanPhone;
                                            })
                                            ->openUrlInNewTab()
                                            ->visible(fn (?User $record) => filled($record?->whatsapp_number))
                                    ),
                                DatePicker::make('birth_date')
                                    ->label('Tanggal Lahir')
                                    ->native(false)
                                    ->disabled(fn () => Auth::user()?->role !== 'admin'),
                                TextInput::make('city')
                                    ->label('Kota')
                                    ->maxLength(100)
                                    ->disabled(fn () => Auth::user()?->role !== 'admin'),
                                TextInput::make('country')
                                    ->label('Negara')
                                    ->maxLength(100)
                                    ->disabled(fn () => Auth::user()?->role !== 'admin'),
                                TextInput::make('job_title')
                                    ->label('Pekerjaan / Profesi')
                                    ->maxLength(150)
                                    ->disabled(fn () => Auth::user()?->role !== 'admin'),
                                Textarea::make('bio')
                                    ->label('Bio / Tentang Siswa')
                                    ->rows(3)
                                    ->columnSpanFull()
                                    ->disabled(fn () => Auth::user()?->role !== 'admin'),
                                TextInput::make('instagram_url')
                                    ->label('Instagram URL')
                                    ->url()
                                    ->maxLength(1000)
                                    ->disabled(fn () => Auth::user()?->role !== 'admin'),
                                TextInput::make('tiktok_url')
                                    ->label('TikTok URL')
                                    ->url()
                                    ->maxLength(1000)
                                    ->disabled(fn () => Auth::user()?->role !== 'admin'),
                                TextInput::make('youtube_url')
                                    ->label('YouTube URL')
                                    ->url()
                                    ->maxLength(1000)
                                    ->disabled(fn () => Auth::user()?->role !== 'admin'),

                                Section::make('Pengaturan Akun & Akses (Admin Only)')
                                    ->schema([
                                        Select::make('role')
                                            ->required()
                                            ->default('student')
                                            ->options([
                                                'student' => 'Student',
                                                'mentor' => 'Mentor',
                                                'coach' => 'Coach',
                                                'admin' => 'Admin',
                                            ]),
                                        Toggle::make('is_approved')
                                            ->label('Is Approved')
                                            ->helperText('Toggle to mark user as approved for mentor/coach'),
                                        TextInput::make('password')
                                            ->password()
                                            ->autocomplete('new-password')
                                            ->placeholder('Leave blank to keep current password')
                                            ->helperText('Only fill this field if you want to change the password.')
                                            ->required(fn (string $operation): bool => $operation === 'create')
                                            ->dehydrated(fn (?string $state): bool => filled($state)),
                                    ])
                                    ->columns(2)
                                    ->columnSpanFull()
                                    ->visible(fn () => Auth::user()?->role === 'admin'),
                            ])
                            ->columns(2),

                        Tab::make('Progress Belajar')
                            ->icon(Heroicon::AcademicCap)
                            ->schema([
                                Textarea::make('student_progress_summary')
                                    ->label('Detail Progress Siswa di Kelas')
                                    ->formatStateUsing(function (?User $record) {
                                        if (! $record) {
                                            return null;
                                        }

                                        $coachId = Auth::user()?->role === 'coach' ? Auth::id() : null;
                                        $coursesQuery = $record->ownedCourses();
                                        if ($coachId) {
                                            $coursesQuery->where('courses.user_id', $coachId);
                                        }
                                        $courses = $coursesQuery->get();

                                        if ($courses->isEmpty()) {
                                            return 'Siswa belum terdaftar di kelas Anda.';
                                        }

                                        $summary = [];
                                        foreach ($courses as $index => $course) {
                                            $totalVideos = $course->videos()->count();
                                            $watchedCount = $record->courseVideoWatches()
                                                ->where('course_id', $course->id)
                                                ->distinct('course_video_id')
                                                ->count('course_video_id');
                                            $progressPercent = $totalVideos > 0 ? (int) round(($watchedCount / $totalVideos) * 100) : 0;

                                            $task = $record->courseTaskSubmissions()->where('course_id', $course->id)->first();
                                            $taskStatus = 'Belum submit tugas';
                                            if ($task) {
                                                if ($task->isReviewed()) {
                                                    $taskStatus = 'Tugas Selesai Direview (Nilai: ' . ($task->score ?? '-') . '/100)';
                                                } else {
                                                    $taskStatus = 'Tugas Menunggu Review Coach';
                                                }
                                                if ($task->google_drive_url) {
                                                    $taskStatus .= "\n     • Link Drive: " . $task->google_drive_url;
                                                }
                                                if ($task->feedback) {
                                                    $taskStatus .= "\n     • Catatan Feedback: " . $task->feedback;
                                                }
                                            }

                                            $quizCompleted = $record->courseVideoQuizCompletions()
                                                ->where('course_id', $course->id)
                                                ->where('is_passed', true)
                                                ->count();

                                            $cert = $record->certificates()->where('course_id', $course->id)->first();
                                            $certStatus = $cert ? 'Telah Diterbitkan (Kode: ' . $cert->certificate_code . ')' : 'Belum Diterbitkan';

                                            $summary[] = "═══════════════════════════════════════════\n"
                                                . "📚 KELAS #" . ($index + 1) . ": " . strtoupper($course->name) . "\n"
                                                . "═══════════════════════════════════════════\n"
                                                . "▶ Progress Video     : " . $watchedCount . " / " . $totalVideos . " video (" . $progressPercent . "% selesai)\n"
                                                . "✔ Kuis Selesai       : " . $quizCompleted . " kuis lulus\n"
                                                . "📝 Status Tugas      : " . $taskStatus . "\n"
                                                . "🎓 Sertifikat        : " . $certStatus;
                                        }

                                        return implode("\n\n", $summary);
                                    })
                                    ->disabled()
                                    ->dehydrated(false)
                                    ->rows(12)
                                    ->columnSpanFull(),
                            ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('avatar')
                    ->label('Avatar')
                    ->disk('public')
                    ->circular(),
                TextColumn::make('name')
                    ->label('Nama Siswa')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->label('Email')
                    ->searchable(),
                TextColumn::make('whatsapp_number')
                    ->label('WhatsApp')
                    ->placeholder('-')
                    ->searchable(),
                TextColumn::make('ownedCourses.name')
                    ->label(fn () => Auth::user()?->role === 'coach' ? 'Kelas Diikuti' : 'Kelas')
                    ->badge()
                    ->color('pink')
                    ->limit(2)
                    ->searchable(),
                TextColumn::make('role')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => strtoupper($state))
                    ->color(fn (string $state): string => match (strtolower($state)) {
                        'admin' => 'danger',
                        'coach' => 'info',
                        'mentor' => 'warning',
                        default => 'gray',
                    })
                    ->searchable()
                    ->sortable()
                    ->visible(fn () => Auth::user()?->role === 'admin'),
                IconColumn::make('is_approved')
                    ->label('Status Approval')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-clock')
                    ->trueColor('success')
                    ->falseColor('warning')
                    ->sortable()
                    ->visible(fn () => Auth::user()?->role === 'admin'),
                TextColumn::make('created_at')
                    ->label('Tanggal Bergabung')
                    ->dateTime('d M Y')
                    ->sortable(),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('role')
                    ->label('Filter Role')
                    ->options([
                        'student' => 'Student',
                        'mentor' => 'Mentor',
                        'coach' => 'Coach',
                        'admin' => 'Admin',
                    ])
                    ->visible(fn () => Auth::user()?->role === 'admin'),
                SelectFilter::make('is_approved')
                    ->label('Status Approval')
                    ->options([
                        '1' => 'Approved (Disetujui)',
                        '0' => 'Pending (Menunggu Persetujuan)',
                    ])
                    ->visible(fn () => Auth::user()?->role === 'admin'),
                SelectFilter::make('course')
                    ->label('Filter Kelas')
                    ->relationship('ownedCourses', 'name', function (Builder $query) {
                        $user = Auth::user();
                        if ($user?->role === 'coach') {
                            $query->where('courses.user_id', $user->id);
                        }
                    }),
            ])
            ->recordActions([
                ViewAction::make()
                    ->label('Lihat Siswa')
                    ->modalHeading('Detail Profil & Progress Siswa')
                    ->modalWidth('3xl'),
                ActionGroup::make([
                    EditAction::make(),
                    Action::make('approve')
                        ->label('Approve')
                        ->color('success')
                        ->icon('heroicon-m-check')
                        ->action(fn ($record) => $record->update(['is_approved' => true]))
                        ->requiresConfirmation()
                        ->visible(fn ($record) => ! $record->is_approved && in_array($record->role, ['mentor', 'coach'], true)),
                    DeleteAction::make(),
                ])
                    ->icon('heroicon-m-bars-3')
                    ->visible(fn () => Auth::user()?->role === 'admin'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    BulkAction::make('approve_selected')
                        ->label('Approve Terpilih')
                        ->icon('heroicon-o-check')
                        ->color('success')
                        ->requiresConfirmation()
                        ->action(fn (Collection $records) => $records->each(fn ($record) => $record->update(['is_approved' => true])))
                        ->deselectRecordsAfterCompletion(),
                    DeleteBulkAction::make(),
                ])->visible(fn () => Auth::user()?->role === 'admin'),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageUsers::route('/'),
        ];
    }
}
