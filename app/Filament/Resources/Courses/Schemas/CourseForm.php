<?php

namespace App\Filament\Resources\Courses\Schemas;

use App\Support\Youtube;
use App\Support\GoogleSlides;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Wizard;
use Filament\Schemas\Schema;
use Filament\Support\RawJs;
use Illuminate\Support\Facades\Auth;

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
                                ->rows(6)
                                ->columnSpanFull(),
                            Select::make('category_id')
                                ->relationship('category', 'name')
                                ->createOptionForm([
                                    TextInput::make('name')
                                        ->required(),
                                 ])
                                ->required(),
                            Select::make('user_id')
                                ->label('Coach')
                                ->relationship('instructor', 'name', fn ($query) => $query->where('role', 'coach'))
                                ->default(fn () => Auth::user()?->role === 'coach' ? Auth::id() : null)
                                ->disabled(fn () => Auth::user()?->role === 'coach')
                                ->dehydrated()
                                ->required(),
                            TextInput::make('price')
                                ->label('Harga')
                                ->required()
                                ->prefix('Rp')
                                ->mask(RawJs::make('$money($input, \',\', \'.\', 0)'))
                                ->stripCharacters('.')
                                ->numeric()
                                ->minValue(0),
                            TextInput::make('rating')
                                ->required()
                                ->numeric(),
                            TextInput::make('introduction_video_url')
                                ->label('Introduction Video (YouTube URL / ID)')
                                ->placeholder('https://www.youtube.com/watch?v=XXXXXXXXXXX atau XXXXXXX')
                                ->rule('regex:/^(?:[A-Za-z0-9_-]{11}|(?:https?:\/\/)?(?:www\.)?(?:youtube\.com\/(?:watch\?v=|embed\/|shorts\/|live\/)|youtu\.be\/)[A-Za-z0-9_-]{11}(?:[&?][^\s]*)?)$/i')
                                ->validationMessages([
                                    'regex' => 'Masukkan URL YouTube valid atau ID video YouTube (11 karakter).',
                                ])
                                ->dehydrateStateUsing(fn (?string $state): ?string => Youtube::extractId($state)),
                            TextInput::make('presentation_url')
                                ->label('Materi Kelas (Google Drive PDF / Google Slides URL)')
                                ->placeholder('https://drive.google.com/file/d/1wApLWXSb311GvxjNivsxgbaAyAHYvI5p/view atau Google Slides URL')
                                ->nullable()
                                ->rule(function () {
                                     return function ($attribute, $value, $fail) {
                                         if (empty($value)) {
                                              return; // nullable
                                         }
                                         if (!GoogleSlides::isValid($value)) {
                                             $fail('Format URL materi tidak valid. Gunakan link Google Drive PDF (drive.google.com/file/d/...) atau Google Slides.');
                                         }
                                     };
                                 }),
                            Toggle::make('is_published')
                                ->label('Publikasikan Kelas (Aktif)')
                                ->helperText(fn () => Auth::user()?->role === 'admin'
                                    ? 'Aktifkan kelas agar tampil di katalog student'
                                    : 'Kelas buatan Coach harus dicek dan dipublikasikan Admin')
                                ->disabled(fn () => Auth::user()?->role !== 'admin')
                                ->dehydrated(fn () => Auth::user()?->role === 'admin')
                                ->default(false),
                        ])
                        ->columns(2),

                    Wizard\Step::make('Class Keypoints')
                        ->description('Add key learning points')
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

                    Wizard\Step::make('Class Assignment')
                        ->description('Set task instructions and guidelines')
                        ->schema([
                            RichEditor::make('task_description')
                                ->label('Instruksi / Panduan Tugas Siswa')
                                ->placeholder('Tuliskan panduan atau instruksi tugas praktik untuk siswa...')
                                ->toolbarButtons([
                                    'bold',
                                    'italic',
                                    'underline',
                                    'strike',
                                    'link',
                                    'bulletList',
                                    'orderedList',
                                    'h2',
                                    'h3',
                                    'blockquote',
                                    'codeBlock',
                                    'undo',
                                    'redo',
                                ])
                                ->columnSpanFull(),
                        ]),
                ])
                    ->columnSpanFull()
                    ->skippable(),
            ]);
    }
}
