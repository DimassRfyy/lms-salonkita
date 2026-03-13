<?php

namespace App\Filament\Resources\Courses\RelationManagers;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SectionsRelationManager extends RelationManager
{
    protected static string $relationship = 'sections';

    protected static function formatDurationForDisplay(mixed $state): string
    {
        $seconds = max((int) ($state ?? 0), 0);
        $minutes = intdiv($seconds, 60);
        $remainingSeconds = $seconds % 60;

        return sprintf('%d:%02d', $minutes, $remainingSeconds);
    }

    protected static function parseDurationToSeconds(mixed $state): int
    {
        if (is_int($state) || is_float($state) || (is_string($state) && ctype_digit($state))) {
            return max((int) $state, 0);
        }

        if (! is_string($state)) {
            return 0;
        }

        $value = trim($state);

        if (! preg_match('/^(\d+):([0-5]\d)$/', $value, $matches)) {
            return 0;
        }

        return ((int) $matches[1] * 60) + (int) $matches[2];
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                Repeater::make('videos')
                    ->label('Section Videos')
                    ->relationship('videos')
                    ->schema([
                        TextInput::make('title')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('video_url')
                            ->label('Video URL')
                            ->url()
                            ->required(),
                        TextInput::make('duration_seconds')
                            ->label('Duration (mm:ss)')
                            ->required()
                            ->default('0:00')
                            ->placeholder('05:30')
                            ->helperText('Masukkan format menit:detik')
                            ->rule('regex:/^(\d+):[0-5]\d$/')
                            ->validationMessages([
                                'regex' => 'Format durasi harus menit:detik, misalnya 05:30.',
                            ])
                            ->formatStateUsing(fn (mixed $state): string => static::formatDurationForDisplay($state))
                            ->dehydrateStateUsing(fn (mixed $state): int => static::parseDurationToSeconds($state)),
                    ])
                    ->defaultItems(3)
                    ->columnSpanFull()
                    ->grid(3),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                TextColumn::make('title')
                    ->searchable(),
                TextColumn::make('videos_count')
                    ->label('Videos')
                    ->counts('videos')
                    ->badge(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make(),
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
}
