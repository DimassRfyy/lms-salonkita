<?php

namespace App\Filament\Resources\CourseTaskSubmissions;

use App\Filament\Resources\CourseTaskSubmissions\Pages\ManageCourseTaskSubmissions;
use App\Models\CourseTaskSubmission;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class CourseTaskSubmissionResource extends Resource
{
    protected static ?string $model = CourseTaskSubmission::class;

    protected static string | \UnitEnum | null $navigationGroup = 'Course Management';

    protected static ?string $navigationLabel = 'Task Submissions';

    public static function getNavigationBadgeTooltip(): ?string
    {
        return 'Tugas menunggu review';
    }

    public static function getNavigationBadge(): ?string
    {
        return (string) static::getModel()::query()
            ->where('status', CourseTaskSubmission::STATUS_PENDING)
            ->count();
    }

    protected static string|BackedEnum|null $navigationIcon = Heroicon::ClipboardDocumentList;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('course_id')
                    ->relationship('course', 'name')
                    ->required(),
                Select::make('user_id')
                    ->relationship('student', 'name')
                    ->required(),
                TextInput::make('subject')
                    ->required(),
                TextInput::make('google_drive_url')
                    ->url()
                    ->required(),
                Select::make('status')
                    ->options([
                        CourseTaskSubmission::STATUS_PENDING => 'Pending Review',
                        CourseTaskSubmission::STATUS_REVIEWED => 'Reviewed',
                    ])
                    ->default(CourseTaskSubmission::STATUS_PENDING)
                    ->required(),
                TextInput::make('score')
                    ->numeric()
                    ->minValue(1)
                    ->maxValue(100)
                    ->nullable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('course.name')
                    ->searchable(),
                TextColumn::make('student.name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('subject')
                    ->searchable(),
                TextColumn::make('status')
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
                    ->numeric()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('course_id')
                    ->label('Kelas')
                    ->relationship('course', 'name'),
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
            'index' => ManageCourseTaskSubmissions::route('/'),
        ];
    }
}
