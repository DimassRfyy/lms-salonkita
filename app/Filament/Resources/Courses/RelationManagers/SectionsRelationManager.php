<?php

namespace App\Filament\Resources\Courses\RelationManagers;

use App\Support\Youtube;
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
                    ->label('Judul Section')
                    ->required()
                    ->maxLength(255),
                Repeater::make('videos')
                    ->label('Video Materi Section')
                    ->relationship('videos')
                    ->orderColumn('sort_order')
                    ->reorderableWithDragAndDrop(true)
                    ->reorderableWithButtons(true)
                    ->collapsible()
                    ->itemLabel(fn (array $state): ?string => !empty($state['title']) ? $state['title'] : 'Video Baru')
                    ->cloneable()
                    ->schema([
                        TextInput::make('title')
                            ->label('Judul Video')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('video_url')
                            ->label('YouTube URL / ID')
                            ->required()
                            ->placeholder('https://www.youtube.com/watch?v=XXXXXXXXXXX')
                            ->rule('regex:/^(?:[A-Za-z0-9_-]{11}|(?:https?:\/\/)?(?:www\.)?(?:youtube\.com\/(?:watch\?v=|embed\/|shorts\/|live\/)|youtu\.be\/)[A-Za-z0-9_-]{11}(?:[&?][^\s]*)?)$/i')
                            ->validationMessages([
                                'regex' => 'Masukkan URL YouTube valid atau ID video YouTube (11 karakter).',
                            ])
                            ->dehydrateStateUsing(fn (?string $state): ?string => Youtube::extractId($state)),
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
                    ->defaultItems(1)
                    ->columnSpanFull()
                    ->grid(3),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->reorderable('sort_order')
            ->defaultSort('sort_order', 'asc')
            ->columns([
                TextColumn::make('sort_order')
                    ->label('Urutan')
                    ->sortable()
                    ->badge(),
                TextColumn::make('title')
                    ->label('Judul Section')
                    ->searchable(),
                TextColumn::make('videos_count')
                    ->label('Total Video')
                    ->counts('videos')
                    ->badge()
                    ->color('info'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make()
                    ->mutateFormDataUsing(function (array $data, RelationManager $livewire): array {
                        $ownerRecord = $livewire->getOwnerRecord();
                        $maxOrder = (int) ($ownerRecord->sections()->max('sort_order') ?? 0);
                        $data['sort_order'] = $maxOrder + 1;

                        return $data;
                    }),
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
