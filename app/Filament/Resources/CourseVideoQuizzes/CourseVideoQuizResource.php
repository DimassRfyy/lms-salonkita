<?php

namespace App\Filament\Resources\CourseVideoQuizzes;

use App\Filament\Resources\CourseVideoQuizzes\Pages\ManageCourseVideoQuizzes;
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
use Filament\Resources\Resource;
use Filament\Schemas\Components\Wizard;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
class CourseVideoQuizResource extends Resource
{
    protected static ?string $model = CourseVideoQuiz::class;

    protected static string | \UnitEnum | null $navigationGroup = 'Course Management';

    protected static ?string $navigationLabel = 'Video Quizzes';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::QuestionMarkCircle;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Wizard::make([
                    Wizard\Step::make('Initial Quiz')
                        ->description('Setup video quiz basics')
                        ->schema([
                            Select::make('course_video_id')
                                ->relationship('video', 'title')
                                ->searchable()
                                ->preload()
                                ->required()
                                ->unique(ignoreRecord: true)
                                ->helperText('Satu video hanya boleh punya satu quiz.'),
                            TextInput::make('title')
                                ->required()
                                ->maxLength(255),
                            TextInput::make('passing_score')
                                ->label('Passing Score')
                                ->numeric()
                                ->minValue(0)
                                ->maxValue(100)
                                ->default(70)
                                ->required(),
                            Toggle::make('is_active')
                                ->default(true)
                                ->required(),
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
                TextColumn::make('title')
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
                    ->label('Passing'),
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
                //
            ])
            ->headerActions([
                //
            ])
            ->recordActions([
                EditAction::make(),
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
            'index' => ManageCourseVideoQuizzes::route('/'),
        ];
    }
}