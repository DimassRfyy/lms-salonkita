<?php

namespace App\Filament\Resources\CourseDiscussions;

use App\Filament\Resources\CourseDiscussions\Pages\ManageCourseDiscussions;
use App\Models\CourseDiscussion;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use UnitEnum;

class CourseDiscussionResource extends Resource
{
    protected static ?string $model = CourseDiscussion::class;

    protected static string | UnitEnum | null $navigationGroup = 'Course Management';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::ChatBubbleLeftRight;

    public static function canAccess(): bool
    {
        $user = Auth::user();

        return $user !== null && in_array($user->role, ['admin', 'coach'], true);
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function getNavigationBadge(): ?string
    {
        $user = Auth::user();
        if (! $user) {
            return null;
        }

        $query = static::getModel()::query()
            ->whereNull('parent_id')
            ->doesntHave('replies');

        if ($user->role === 'coach') {
            $query->whereHas('course', fn ($q) => $q->where('user_id', $user->id));
        }

        $count = $query->count();

        return $count > 0 ? (string) $count : null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery()
            ->with(['course', 'student', 'replies'])
            ->withCount('replies');

        $user = Auth::user();

        if ($user?->role === 'coach') {
            $query->whereHas('course', fn ($q) => $q->where('user_id', $user->id));
        }

        return $query;
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('course_id')
                    ->relationship('course', 'name', function (Builder $query) {
                        $user = Auth::user();
                        if ($user?->role === 'coach') {
                            $query->where('user_id', $user->id);
                        }
                    })
                    ->required(),
                Select::make('user_id')
                    ->relationship('student', 'name')
                    ->required(),
                Select::make('parent_id')
                    ->relationship('parent', 'id'),
                TextInput::make('subject')
                    ->required(),
                Textarea::make('message')
                    ->required()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('course.name')
                    ->label('Kelas')
                    ->searchable()
                    ->sortable()
                    ->weight('medium'),
                TextColumn::make('student.name')
                    ->label('Pengirim')
                    ->searchable()
                    ->sortable()
                    ->description(fn (CourseDiscussion $record): string => $record->user_id === $record->course?->user_id ? 'Coach / Mentor' : 'Student'),
                TextColumn::make('subject')
                    ->label('Subjek')
                    ->searchable()
                    ->limit(25),
                TextColumn::make('message')
                    ->label('Pesan')
                    ->searchable()
                    ->limit(45)
                    ->wrap(),
                TextColumn::make('reply_status')
                    ->label('Status')
                    ->badge()
                    ->state(function (CourseDiscussion $record): string {
                        if ($record->parent_id !== null) {
                            return 'Balasan';
                        }

                        $hasReplies = ($record->replies_count ?? $record->replies()->count()) > 0;

                        return $hasReplies ? 'Sudah Dibalas' : 'Belum Dibalas';
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'Belum Dibalas' => 'warning',
                        'Sudah Dibalas' => 'success',
                        'Balasan' => 'gray',
                        default => 'info',
                    }),
                TextColumn::make('created_at')
                    ->label('Waktu')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('reply_status')
                    ->label('Status Balasan')
                    ->options([
                        'unanswered' => 'Belum Dibalas',
                        'answered' => 'Sudah Dibalas',
                        'replies' => 'Hanya Pesan Balasan',
                    ])
                    ->query(function (Builder $query, array $data) {
                        if (($data['value'] ?? null) === 'unanswered') {
                            $query->whereNull('parent_id')->doesntHave('replies');
                        } elseif (($data['value'] ?? null) === 'answered') {
                            $query->whereNull('parent_id')->has('replies');
                        } elseif (($data['value'] ?? null) === 'replies') {
                            $query->whereNotNull('parent_id');
                        }
                    }),
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
                Action::make('reply')
                    ->label('Balas Diskusi')
                    ->icon('heroicon-m-chat-bubble-left-ellipsis')
                    ->color('primary')
                    ->modalHeading(fn (CourseDiscussion $record): string => 'Balas Pertanyaan dari ' . ($record->student?->name ?? 'Student'))
                    ->modalDescription(fn (CourseDiscussion $record): string => 'Pesan student: "' . Str::limit($record->message, 150) . '"')
                    ->modalSubmitActionLabel('Kirim Balasan')
                    ->visible(function (CourseDiscussion $record): bool {
                        $user = Auth::user();
                        if (! $user) {
                            return false;
                        }

                        $isAuthorized = $user->role === 'admin' || ($user->role === 'coach' && $record->course?->user_id === $user->id);
                        $isUnanswered = ($record->replies_count ?? $record->replies()->count()) === 0;

                        return $record->parent_id === null && $isUnanswered && $isAuthorized;
                    })
                    ->form([
                        Textarea::make('message')
                            ->label('Pesan Balasan Coach/Admin')
                            ->placeholder('Tuliskan jawaban atau penjelasan untuk pertanyaan siswa ini...')
                            ->required()
                            ->rows(4),
                    ])
                    ->action(function (CourseDiscussion $record, array $data): void {
                        $user = Auth::user();

                        CourseDiscussion::query()->create([
                            'course_id' => $record->course_id,
                            'user_id' => $user->id,
                            'parent_id' => $record->id,
                            'subject' => 'Balasan: ' . ($record->subject ?: 'Diskusi'),
                            'message' => $data['message'],
                        ]);

                        Notification::make()
                            ->title('Balasan berhasil dikirim')
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
            'index' => ManageCourseDiscussions::route('/'),
        ];
    }
}
