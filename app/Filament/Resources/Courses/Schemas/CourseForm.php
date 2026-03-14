<?php

namespace App\Filament\Resources\Courses\Schemas;

use App\Support\Youtube;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Wizard;
use Filament\Schemas\Schema;

class CourseForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Wizard::make([
                    Wizard\Step::make('Class Details')
                        ->description('Set basic course information')
                        ->schema([
                            FileUpload::make('thumbnail')
                                ->image()
                                ->disk('public')
                                ->directory('course-thumbnails'),
                            TextInput::make('name')
                                ->required(),
                            Textarea::make('description')
                                ->columnSpanFull(),
                            Select::make('category_id')
                                ->relationship('category', 'name')
                                ->createOptionForm([
                                    TextInput::make('name')
                                        ->required(),
                                ])
                                ->required(),
                            Select::make('user_id')
                                ->relationship('instructor', 'name', fn ($query) => $query->where('role', 'coach'))
                                ->required(),
                            TextInput::make('price')
                                ->required()
                                ->numeric()
                                ->prefix('Rp'),
                            TextInput::make('rating')
                                ->required()
                                ->numeric(),
                            Toggle::make('is_published')
                                ->default(false)
                                ->required(),
                            TextInput::make('introduction_video_url')
                                ->label('Introduction Video (YouTube URL / ID)')
                                ->placeholder('https://www.youtube.com/watch?v=XXXXXXXXXXX atau XXXXXXX')
                                ->helperText('Admin boleh isi URL YouTube lengkap atau langsung ID. Sistem akan simpan ID unik.')
                                ->rule('regex:/^(?:[A-Za-z0-9_-]{11}|(?:https?:\/\/)?(?:www\.)?(?:youtube\.com\/(?:watch\?v=|embed\/|shorts\/|live\/)|youtu\.be\/)[A-Za-z0-9_-]{11}(?:[&?][^\s]*)?)$/i')
                                ->validationMessages([
                                    'regex' => 'Masukkan URL YouTube valid atau ID video YouTube (11 karakter).',
                                ])
                                ->dehydrateStateUsing(fn (?string $state): ?string => Youtube::extractId($state)),
                        ])
                        ->columns(2),

                    Wizard\Step::make('Class Keypoints')
                        ->description('Add key learning points for this class')
                        ->schema([
                            Repeater::make('keypoints')
                                ->label('Class Keypoints')
                                ->relationship('keypoints')
                                ->schema([
                                    TextInput::make('point')
                                        ->label('Keypoint')
                                        ->required(),
                                ])
                                ->defaultItems(4)
                                ->columnSpanFull()
                                ->grid(2),
                        ]),
                ])
                    ->columnSpanFull()
                    ->skippable(),
            ]);
    }
}
