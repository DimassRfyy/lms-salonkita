<?php

namespace App\Filament\Resources\RewardItems;

use App\Filament\Resources\RewardItems\Pages\ManageRewardItems;
use App\Models\RewardItem;
use BackedEnum;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class RewardItemResource extends Resource
{
    protected static ?string $model = RewardItem::class;

    // FITUR REDEEM POINT DI-DISABLE SEMENTARA
    protected static bool $shouldRegisterNavigation = false;

    protected static string | \UnitEnum | null $navigationGroup = 'Gamifikasi & Poin';

    public static function canAccess(): bool
    {
        $user = Auth::user();

        return $user !== null && $user->role === 'admin';
    }

    protected static ?string $navigationLabel = 'Katalog Hadiah';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-gift';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nama Hadiah / Item')
                    ->required()
                    ->maxLength(100),
                Textarea::make('description')
                    ->label('Deskripsi Item')
                    ->rows(3),
                FileUpload::make('image')
                    ->label('Foto / Poster Item')
                    ->image()
                    ->directory('rewards'),
                TextInput::make('points_required')
                    ->label('Poin Yang Dibutuhkan')
                    ->required()
                    ->numeric()
                    ->minValue(1)
                    ->default(50),
                TextInput::make('stock')
                    ->label('Jumlah Stok (Kosongkan jika unlimited)')
                    ->numeric()
                    ->nullable(),
                Select::make('type')
                    ->label('Tipe Item')
                    ->required()
                    ->options([
                        'VOUCHER' => 'Voucher Diskon',
                        'DIGITAL_ITEM' => 'Konten / Item Digital',
                        'PHYSICAL' => 'Barang Fisik / Merchandise',
                        'GENERAL' => 'Umum',
                    ])
                    ->default('GENERAL'),
                Toggle::make('is_active')
                    ->label('Aktif / Tampilkan di Catalog')
                    ->default(true)
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')
                    ->label('Foto'),
                TextColumn::make('name')
                    ->label('Nama Hadiah')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('points_required')
                    ->label('Poin Required')
                    ->sortable()
                    ->badge()
                    ->color('warning')
                    ->formatStateUsing(fn ($state) => number_format((int) $state, 0, ',', '.') . ' Poin'),
                TextColumn::make('stock')
                    ->label('Stok')
                    ->formatStateUsing(fn ($state) => $state === null ? 'Unlimited' : (string) $state),
                TextColumn::make('type')
                    ->label('Tipe')
                    ->badge(),
                IconColumn::make('is_active')
                    ->label('Status Aktif')
                    ->boolean(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->recordActions([
                ActionGroup::make([
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
            'index' => ManageRewardItems::route('/'),
        ];
    }
}
