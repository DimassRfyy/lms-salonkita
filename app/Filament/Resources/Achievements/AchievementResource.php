<?php

namespace App\Filament\Resources\Achievements;

use App\Filament\Resources\Achievements\Pages\ManageAchievements;
use App\Models\Achievement;
use App\Models\User;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class AchievementResource extends Resource
{
    protected static ?string $model = Achievement::class;

    protected static string | \UnitEnum | null $navigationGroup = 'Gamifikasi & Poin';

    public static function canAccess(): bool
    {
        $user = Auth::user();

        return $user !== null && $user->role === 'admin';
    }

    protected static ?string $navigationLabel = 'Pencapaian & Lencana';

    protected static ?string $modelLabel = 'Achievement';

    protected static ?string $pluralModelLabel = 'Pencapaian (Achievements)';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-trophy';

    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nama Achievement')
                    ->placeholder('Contoh: First Graduate')
                    ->required()
                    ->maxLength(100),

                Select::make('level')
                    ->label('Level / Kesulitan')
                    ->options([
                        Achievement::LEVEL_BEGINNER => 'Beginner',
                        Achievement::LEVEL_INTERMEDIATE => 'Intermediate',
                        Achievement::LEVEL_EXPERT => 'Expert',
                    ])
                    ->default(Achievement::LEVEL_BEGINNER)
                    ->required(),

                Select::make('category')
                    ->label('Kelompok Aktivitas')
                    ->options([
                        Achievement::CATEGORY_COURSE_COMPLETION => 'Course Completion',
                        Achievement::CATEGORY_LEARNING_ACTIVITY => 'Learning Activity',
                        Achievement::CATEGORY_ASSIGNMENT_COMPLETION => 'Assignment Completion',
                    ])
                    ->default(Achievement::CATEGORY_COURSE_COMPLETION)
                    ->required(),

                TextInput::make('icon')
                    ->label('Icon Emoji')
                    ->default('🏆')
                    ->maxLength(10),

                TextInput::make('sort_order')
                    ->label('Urutan Tampilan')
                    ->numeric()
                    ->default(0),

                Textarea::make('description')
                    ->label('Deskripsi / Kriteria')
                    ->placeholder('Contoh: Complete your first course.')
                    ->required()
                    ->rows(3)
                    ->columnSpanFull(),

                Toggle::make('is_active')
                    ->label('Status Aktif')
                    ->default(true)
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query) => $query->withCount('users'))
            ->columns([
                TextColumn::make('icon')
                    ->label('')
                    ->alignCenter(),

                TextColumn::make('name')
                    ->label('Nama Achievement')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('level')
                    ->label('Level')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'beginner' => 'success',
                        'intermediate' => 'info',
                        'expert' => 'warning',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => ucfirst($state))
                    ->sortable(),

                TextColumn::make('category')
                    ->label('Kelompok')
                    ->badge()
                    ->color('gray')
                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                        Achievement::CATEGORY_COURSE_COMPLETION => 'Course Completion',
                        Achievement::CATEGORY_LEARNING_ACTIVITY => 'Learning Activity',
                        Achievement::CATEGORY_ASSIGNMENT_COMPLETION => 'Assignment Completion',
                        default => $state ?? '-',
                    })
                    ->sortable(),

                TextColumn::make('description')
                    ->label('Deskripsi')
                    ->wrap(),

                TextColumn::make('users_count')
                    ->label('Total Peraih')
                    ->badge()
                    ->color('success')
                    ->formatStateUsing(fn ($state) => "{$state} Siswa"),

                IconColumn::make('is_active')
                    ->label('Status Aktif')
                    ->boolean(),

                TextColumn::make('sort_order')
                    ->label('Urutan')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('sort_order', 'asc')
            ->filters([
                SelectFilter::make('level')
                    ->label('Filter Level')
                    ->options([
                        Achievement::LEVEL_BEGINNER => 'Beginner',
                        Achievement::LEVEL_INTERMEDIATE => 'Intermediate',
                        Achievement::LEVEL_EXPERT => 'Expert',
                    ]),

                SelectFilter::make('category')
                    ->label('Filter Kelompok')
                    ->options([
                        Achievement::CATEGORY_COURSE_COMPLETION => 'Course Completion',
                        Achievement::CATEGORY_LEARNING_ACTIVITY => 'Learning Activity',
                        Achievement::CATEGORY_ASSIGNMENT_COMPLETION => 'Assignment Completion',
                    ]),
            ])
            ->recordActions([
                ActionGroup::make([
                    // Grant achievement to student directly
                    Action::make('grant_to_student')
                        ->label('Beri ke Siswa')
                        ->icon('heroicon-o-user-plus')
                        ->color('success')
                        ->modalHeading(fn (Achievement $record) => "Beri Achievement: {$record->name}")
                        ->modalDescription('Pilih siswa yang akan diberikan achievement ini secara langsung.')
                        ->form([
                            Select::make('user_id')
                                ->label('Pilih Siswa')
                                ->options(function () {
                                    return User::query()
                                        ->where('role', 'student')
                                        ->orderBy('name')
                                        ->pluck('name', 'id');
                                })
                                ->searchable()
                                ->required(),

                            DatePicker::make('unlocked_at')
                                ->label('Tanggal Diraih')
                                ->default(now())
                                ->required(),

                            TextInput::make('notes')
                                ->label('Catatan (Opsional)')
                                ->placeholder('Contoh: Demonstrasi penghargaan kelas'),
                        ])
                        ->action(function (Achievement $record, array $data): void {
                            /** @var User|null $student */
                            $student = User::find($data['user_id']);
                            if (! $student) {
                                return;
                            }

                            $record->users()->syncWithoutDetaching([
                                $student->id => [
                                    'unlocked_at' => $data['unlocked_at'] ?? now(),
                                    'progress_percentage' => 100,
                                    'notes' => $data['notes'] ?? null,
                                ],
                            ]);

                            Notification::make()
                                ->title('Achievement Berhasil Diberikan!')
                                ->body("Achievement '{$record->name}' telah resmi diberikan kepada siswa {$student->name}.")
                                ->success()
                                ->send();
                        }),

                    // Revoke achievement from student
                    Action::make('revoke_from_student')
                        ->label('Cabut dari Siswa')
                        ->icon('heroicon-o-user-minus')
                        ->color('danger')
                        ->modalHeading(fn (Achievement $record) => "Cabut Achievement: {$record->name}")
                        ->modalDescription('Pilih siswa yang akan dicabut achievement-nya.')
                        ->form([
                            Select::make('user_id')
                                ->label('Pilih Siswa Peraih')
                                ->options(fn (Achievement $record) => $record->users()->pluck('users.name', 'users.id'))
                                ->searchable()
                                ->required(),
                        ])
                        ->visible(fn (Achievement $record) => $record->users()->exists())
                        ->action(function (Achievement $record, array $data): void {
                            /** @var User|null $student */
                            $student = User::find($data['user_id']);
                            if (! $student) {
                                return;
                            }

                            $record->users()->detach($student->id);

                            Notification::make()
                                ->title('Achievement Dicabut')
                                ->body("Achievement '{$record->name}' telah dicabut dari {$student->name}.")
                                ->warning()
                                ->send();
                        }),

                    ActionGroup::make([
                        ViewAction::make(),
                        EditAction::make(),
                    ])->dropdown(false),

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
            'index' => ManageAchievements::route('/'),
        ];
    }
}
