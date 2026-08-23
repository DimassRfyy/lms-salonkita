<?php

namespace App\Filament\Resources\CourseTaskSubmissions;

use App\Filament\Resources\CourseTaskSubmissions\Pages\ManageCourseTaskSubmissions;
use App\Models\CourseTaskSubmission;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ActionGroup;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class CourseTaskSubmissionResource extends Resource
{
    protected static ?string $model = CourseTaskSubmission::class;

    protected static string|\UnitEnum|null $navigationGroup = 'Course Management';

    protected static ?string $navigationLabel = 'Task Submissions';

    public static function canAccess(): bool
    {
        $user = Auth::user();

        return $user !== null && in_array($user->role, ['admin', 'coach'], true);
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();
        $user = Auth::user();

        if ($user?->role === 'coach') {
            $query->whereHas('course', fn($q) => $q->where('user_id', $user->id));
        }

        return $query;
    }

    public static function getNavigationBadgeTooltip(): ?string
    {
        return 'Tugas menunggu review';
    }

    public static function getNavigationBadge(): ?string
    {
        $user = Auth::user();
        $query = static::getModel()::query()->where('status', CourseTaskSubmission::STATUS_PENDING);

        if ($user?->role === 'coach') {
            $query->whereHas('course', fn($q) => $q->where('user_id', $user->id));
        }

        return (string) $query->count();
    }

    protected static string|BackedEnum|null $navigationIcon = Heroicon::ClipboardDocumentList;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('course_id')
                    ->label('Kelas')
                    ->relationship('course', 'name')
                    ->disabled()
                    ->dehydrated(false),
                Select::make('user_id')
                    ->label('Siswa')
                    ->relationship('student', 'name')
                    ->disabled()
                    ->dehydrated(false),
                TextInput::make('subject')
                    ->label('Judul Tugas')
                    ->disabled()
                    ->dehydrated(false)
                    ->columnSpanFull(),
                TextInput::make('google_drive_url')
                    ->label('Link Google Drive')
                    ->disabled()
                    ->dehydrated(false)
                    ->suffixAction(
                        Action::make('openDrive')
                            ->label('Buka Link Drive')
                            ->icon('heroicon-m-arrow-top-right-on-square')
                            ->url(fn(?CourseTaskSubmission $record) => $record?->google_drive_url)
                            ->openUrlInNewTab()
                            ->visible(fn(?CourseTaskSubmission $record) => filled($record?->google_drive_url))
                    )
                    ->columnSpanFull(),
                TextInput::make('score')
                    ->label('Nilai Tugas (0 - 100)')
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(100)
                    ->nullable()
                    ->columnSpanFull(),
                Textarea::make('feedback')
                    ->label('Umpan Balik / Catatan Review')
                    ->placeholder('Tuliskan catatan evaluasi, saran, atau masukan untuk siswa mengenai tugas ini...')
                    ->rows(4)
                    ->nullable()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('course.name')
                    ->label('Kelas')
                    ->searchable(),
                TextColumn::make('student.name')
                    ->label('Siswa')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->colors([
                        'warning' => CourseTaskSubmission::STATUS_PENDING,
                        'success' => CourseTaskSubmission::STATUS_REVIEWED,
                    ])
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        CourseTaskSubmission::STATUS_REVIEWED => 'Reviewed',
                        default => 'Pending Review',
                    }),
                TextColumn::make('score')
                    ->label('Nilai')
                    ->numeric()
                    ->sortable()
                    ->placeholder('-'),
                TextColumn::make('created_at')
                    ->label('Tanggal Submit')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('course_id')
                    ->label('Kelas')
                    ->relationship('course', 'name', function (Builder $query) {
                        $user = Auth::user();
                        if ($user?->role === 'coach') {
                            $query->where('user_id', $user->id);
                        }
                    }),
            ])
            ->recordActions([
                ActionGroup::make([
                    ActionGroup::make([
                        Action::make('open_drive')
                            ->label('Buka Drive')
                            ->icon('heroicon-m-arrow-top-right-on-square')
                            ->color('gray')
                            ->url(fn(CourseTaskSubmission $record): ?string => $record->google_drive_url)
                            ->openUrlInNewTab()
                            ->visible(fn(CourseTaskSubmission $record): bool => filled($record->google_drive_url)),
                        EditAction::make()
                            ->label('Review & Nilai')
                            ->modalHeading('Review & Beri Nilai Tugas Siswa')
                            ->modalDescription('Periksa link Google Drive tugas siswa, lalu berikan nilai dan catatan umpan balik.')
                            ->modalSubmitActionLabel('Simpan Hasil Review'),
                    ])
                        ->dropdown(false),
                    DeleteAction::make()
                ])->icon('heroicon-m-bars-3')
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
            'index' => ManageCourseTaskSubmissions::route('/'),
        ];
    }
}
