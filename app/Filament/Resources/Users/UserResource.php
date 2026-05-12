<?php

namespace App\Filament\Resources\Users;

use App\Filament\Resources\Users\Pages\ManageUsers;
use App\Models\User;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ActionGroup;
use Filament\Actions\ViewAction;
use Filament\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::UserGroup;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                FileUpload::make('avatar')
                    ->label('Avatar')
                    ->image()
                    ->disk('public')
                    ->directory('avatars'),
                TextInput::make('name')
                    ->required(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required(),
                TextInput::make('whatsapp_number')
                    ->label('WhatsApp Number')
                    ->maxLength(30),
                DatePicker::make('birth_date')
                    ->label('Birth Date')
                    ->native(false),
                TextInput::make('city')
                    ->maxLength(100),
                TextInput::make('country')
                    ->maxLength(100),
                TextInput::make('job_title')
                    ->label('Job Title')
                    ->maxLength(150),
                Textarea::make('bio')
                    ->rows(3)
                    ->columnSpanFull(),
                TextInput::make('instagram_url')
                    ->label('Instagram URL')
                    ->url()
                    ->maxLength(1000),
                TextInput::make('tiktok_url')
                    ->label('TikTok URL')
                    ->url()
                    ->maxLength(1000),
                TextInput::make('youtube_url')
                    ->label('YouTube URL')
                    ->url()
                    ->maxLength(1000),
                Select::make('role')
                    ->required()
                    ->default('student')
                    ->options([
                        'student' => 'Student',
                        'mentor' => 'Mentor',
                        'coach' => 'Coach',
                        'admin' => 'Admin',
                    ]),
                Toggle::make('is_approved')
                    ->label('Is Approved')
                    ->helperText('Toggle to mark user as approved for mentor/coach'),
                TextInput::make('password')
                    ->password()
                    ->autocomplete('new-password')
                    ->placeholder('Leave blank to keep current password')
                    ->helperText('Only fill this field if you want to change the password.')
                    ->required(fn (string $operation): bool => $operation === 'create')
                    ->dehydrated(fn (?string $state): bool => filled($state)),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('avatar')
                    ->label('Avatar')
                    ->disk('public')
                    ->circular(),
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('email')
                    ->label('Email address')
                    ->searchable(),
                TextColumn::make('role')
                    ->badge()
                    ->searchable(),
                IconColumn::make('is_approved')
                    ->label('Approved')
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
            ->defaultSort('created_at', 'desc')
            ->filters([
                //
            ])
            ->recordActions([
                ActionGroup::make([
                    ActionGroup::make([
                        ViewAction::make(),
                        EditAction::make(),
                        Action::make('approve')
                        ->label('Approve')
                        ->color('success')
                        ->icon('heroicon-m-check')
                        ->action(fn ($record) => $record->update(['is_approved' => true]))
                        ->requiresConfirmation()
                        ->visible(fn ($record) => ! $record->is_approved),
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
            'index' => ManageUsers::route('/'),
        ];
    }
}
