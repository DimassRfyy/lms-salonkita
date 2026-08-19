<?php

namespace App\Filament\Resources\RewardRedemptions;

use App\Filament\Resources\RewardRedemptions\Pages\ManageRewardRedemptions;
use App\Models\RewardRedemption;
use BackedEnum;
use Filament\Actions\ActionGroup;
use Filament\Actions\ViewAction;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class RewardRedemptionResource extends Resource
{
    protected static ?string $model = RewardRedemption::class;

    // FITUR REDEEM POINT DI-DISABLE SEMENTARA
    protected static bool $shouldRegisterNavigation = false;

    protected static string | \UnitEnum | null $navigationGroup = 'Gamifikasi & Poin';

    public static function canAccess(): bool
    {
        $user = Auth::user();

        return $user !== null && $user->role === 'admin';
    }

    protected static ?string $navigationLabel = 'Riwayat Penukaran Poin';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-shopping-bag';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('redemption_code')
                    ->label('Kode Klaim')
                    ->searchable()
                    ->copyable(),
                TextColumn::make('user.name')
                    ->label('Siswa')
                    ->searchable(),
                TextColumn::make('user.email')
                    ->label('Email')
                    ->searchable(),
                TextColumn::make('rewardItem.name')
                    ->label('Item Hadiah')
                    ->searchable(),
                TextColumn::make('points_spent')
                    ->label('Poin Terpakai')
                    ->badge()
                    ->color('danger')
                    ->formatStateUsing(fn ($state) => '-' . number_format((int) $state, 0, ',', '.') . ' Poin'),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state) => match ($state) {
                        'COMPLETED' => 'success',
                        'PENDING' => 'warning',
                        'CANCELLED' => 'danger',
                        default => 'secondary',
                    }),
                TextColumn::make('created_at')
                    ->label('Tanggal Klaim')
                    ->dateTime()
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->recordActions([
                ActionGroup::make([
                    ViewAction::make(),
                ])->icon('heroicon-m-bars-3'),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageRewardRedemptions::route('/'),
        ];
    }
}
