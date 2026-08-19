<?php

namespace App\Filament\Resources\CourseVideoQuizzes;

use App\Filament\Resources\CourseVideoQuizzes\Pages\ManageCourseVideoQuizzes;
use App\Models\Course;
use App\Models\CourseVideo;
use App\Models\CourseVideoQuiz;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Wizard;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Filament\Actions\ActionGroup;
use Filament\Actions\ViewAction;

class CourseVideoQuizResource extends Resource
{
    protected static ?string $model = CourseVideoQuiz::class;

    protected static string | \UnitEnum | null $navigationGroup = 'Course Management';

    protected static ?string $navigationLabel = 'Video Quizzes';

    public static function canAccess(): bool
    {
        $user = Auth::user();

        return $user !== null && in_array($user->role, ['admin', 'coach'], true);
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();
        $user = Auth::user();

        if ($user?->role === 'coach') {
            $query->whereHas('video.section.course', fn ($q) => $q->where('user_id', $user->id));
        }

        return $query;
    }

    protected static string|BackedEnum|null $navigationIcon = Heroicon::QuestionMarkCircle;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Wizard::make([
                    Wizard\Step::make('Initial Quiz')
                        ->description('Setup video quiz basics')
                        ->schema([
                            Select::make('course_id')
                                ->label('Pilih Kelas')
                                ->options(function () {
                                    $user = Auth::user();
                                    return Course::query()
                                        ->when($user?->role === 'coach', fn ($q) => $q->where('user_id', $user->id))
                                        ->pluck('name', 'id');
                                })
                                ->searchable()
                                ->preload()
                                ->live()
                                ->dehydrated(false)
                                ->afterStateHydrated(function (Select $component, ?CourseVideoQuiz $record) {
                                    if ($record && $record->video && $record->video->section) {
                                        $component->state($record->video->section->course_id);
                                    }
                                })
                                ->afterStateUpdated(fn (Set $set) => $set('course_video_id', null))
                                ->helperText('Pilih kelas terlebih dahulu untuk memfilter daftar video.')
                                ->required(fn (?CourseVideoQuiz $record) => $record === null),
                            Select::make('course_video_id')
                                ->label('Pilih Video')
                                ->options(function (Get $get, ?CourseVideoQuiz $record) {
                                    $courseId = $get('course_id');
                                    if (! $courseId) {
                                        return [];
                                    }

                                    return CourseVideo::query()
                                        ->whereHas('section', fn ($query) => $query->where('course_id', $courseId))
                                        ->with('section')
                                        ->where(function ($query) use ($record) {
                                            $query->doesntHave('quiz');
                                            if ($record) {
                                                $query->orWhere('id', $record->course_video_id);
                                            }
                                        })
                                        ->get()
                                        ->mapWithKeys(function ($video) {
                                            $sectionTitle = $video->section?->title ? '[' . $video->section->title . '] ' : '';
                                            return [$video->id => $sectionTitle . $video->title];
                                        });
                                })
                                ->disabled(fn (Get $get) => blank($get('course_id')))
                                ->placeholder(fn (Get $get) => blank($get('course_id')) ? 'Pilih kelas terlebih dahulu...' : 'Pilih salah satu video...')
                                ->searchable()
                                ->required()
                                ->unique(ignoreRecord: true)
                                ->columnSpanFull(),
                            TextInput::make('title')
                                ->label('Judul Quiz')
                                ->required()
                                ->maxLength(255),
                            TextInput::make('passing_score')
                                ->label('Passing Score (%)')
                                ->numeric()
                                ->minValue(0)
                                ->maxValue(100)
                                ->default(70)
                                ->required(),
                            Toggle::make('is_active')
                                ->label('Status Aktif')
                                ->default(true)
                                ->required()
                                ->columnSpanFull(),
                        ])
                        ->columns(2),
                    Wizard\Step::make('Questions & Options')
                        ->description('Add quiz questions and answers')
                        ->schema([
                            Repeater::make('questions')
                                ->relationship('questions')
                                ->label('Questions')
                                ->schema([
                                    Textarea::make('question')
                                        ->required()
                                        ->rows(3)
                                        ->columnSpanFull(),
                                    Repeater::make('options')
                                        ->relationship('options')
                                        ->label('Answer Options')
                                        ->schema([
                                            TextInput::make('option_text')
                                                ->label('Option')
                                                ->required()
                                                ->columnSpanFull(),
                                            Toggle::make('is_correct')
                                                ->label('Correct Answer')
                                                ->default(false),
                                        ])
                                        ->defaultItems(4)
                                        ->columns(2)
                                        ->grid(2)
                                        ->columnSpanFull(),
                                ])
                                ->defaultItems(1)
                                ->columns(1)
                                ->columnSpanFull(),
                        ]),
                ])
                    ->columnSpanFull()
                    ->skippable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('video.section.course.name')
                    ->label('Kelas')
                    ->badge()
                    ->color('gray')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('title')
                    ->label('Judul Quiz')
                    ->searchable(),
                TextColumn::make('video.title')
                    ->label('Video')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('questions_count')
                    ->counts('questions')
                    ->badge()
                    ->label('Questions'),
                TextColumn::make('passing_score')
                    ->badge()
                    ->label('Passing')
                    ->suffix('%'),
                IconColumn::make('is_active')
                    ->label('Status')
                    ->colors([
                        'success' => true,
                        'gray' => false,
                    ]),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('course')
                    ->label('Filter Kelas')
                    ->relationship('video.section.course', 'name', function (Builder $query) {
                        $user = Auth::user();
                        if ($user?->role === 'coach') {
                            $query->where('courses.user_id', $user->id);
                        }
                    })
                    ->searchable()
                    ->preload(),
            ])
            ->headerActions([
                //
            ])
            ->recordActions([
                ActionGroup::make([
                    ActionGroup::make([
                        ViewAction::make(),
                        EditAction::make(),
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
            'index' => ManageCourseVideoQuizzes::route('/'),
        ];
    }
}