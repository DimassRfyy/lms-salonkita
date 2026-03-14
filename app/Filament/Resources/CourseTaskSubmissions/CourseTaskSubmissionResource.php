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
use UnitEnum;

class CourseTaskSubmissionResource extends Resource
{
    protected static ?string $model = CourseTaskSubmission::class;

    protected static string | UnitEnum | null $navigationGroup = 'Course Management';

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
                TextColumn::make('google_drive_url')
                    ->searchable(),
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
