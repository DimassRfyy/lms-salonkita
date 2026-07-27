<?php

namespace App\Filament\Resources\Transactions;

use App\Filament\Resources\Transactions\Pages\ManageTransactions;
use App\Models\Transaction;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ActionGroup;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;

    public static function getNavigationBadgeTooltip(): ?string
    {
        return 'Transaksi menunggu pembayaran';
    }

    public static function canAccess(): bool
    {
        $user = Auth::user();

        return $user !== null && $user->role === 'admin';
    }

    protected static string | \UnitEnum | null $navigationGroup = 'Payment Management';

    public static function getNavigationBadge(): ?string
    {
        return (string) static::getModel()::query()
            ->where('status', Transaction::STATUS_PENDING)
            ->count();
    }

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Banknotes;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('trx_id')
                    ->required(),
                Select::make('user_id')
                    ->relationship(
                        'student',
                        'name',
                        modifyQueryUsing: fn(Builder $query) => $query->where('role', 'student')
                    )
                    ->required(),
                Select::make('course_id')
                    ->relationship('course', 'name')
                    ->required(),
                Select::make('payment_method')
                    ->options([
                        'xendit' => 'Xendit Invoice',
                        'free' => 'Gratis / Promo 100%',
                        'bca' => 'BCA',
                        'bri' => 'BRI',
                        'ovo' => 'OVO',
                        'dana' => 'DANA',
                        'gopay' => 'GoPay',
                        'qris' => 'QRIS',
                        'bank_transfer' => 'Bank Transfer',
                        'echannel' => 'eChannel',
                    ])
                    ->required(),
                Select::make('status')
                    ->options([
                        Transaction::STATUS_PENDING => 'Menunggu Pembayaran',
                        Transaction::STATUS_PAID => 'Berhasil Dibayar (PAID)',
                        Transaction::STATUS_SETTLED => 'Berhasil Dibayar (SETTLED)',
                        Transaction::STATUS_EXPIRED => 'Kedaluwarsa',
                    ])
                    ->default(Transaction::STATUS_PENDING)
                    ->required(),
                TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->prefix('Rp'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('trx_id')
                    ->searchable(),
                TextColumn::make('student.name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('course.name')
                    ->searchable(),
                TextColumn::make('payment_method')
                    ->formatStateUsing(fn (string $state) => match ($state) {
                        'xendit' => 'Xendit Invoice',
                        'free' => 'Gratis / Promo 100%',
                        'bca' => 'BCA',
                        'bri' => 'BRI',
                        'ovo' => 'OVO',
                        'dana' => 'DANA',
                        'gopay' => 'GoPay',
                        'qris' => 'QRIS',
                        'bank_transfer' => 'Bank Transfer',
                        'echannel' => 'eChannel',
                        default => $state,
                    })
                    ->searchable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn (string $state, Transaction $record): string => $record->status_label)
                    ->color(fn (string $state): string => match (mb_strtoupper($state)) {
                        'PENDING' => 'warning',
                        'PAID', 'SETTLED', 'SETTLEMENT', 'CAPTURE' => 'success',
                        'EXPIRED', 'EXPIRE', 'CANCEL', 'CANCELLED', 'DENY', 'FAILURE' => 'danger',
                        default => 'gray',
                    }),
                TextColumn::make('promoCode.code')
                    ->label('Promo')
                    ->placeholder('-')
                    ->description(fn (Transaction $record): ?string => $record->promoCode?->description)
                    ->searchable(),
                TextColumn::make('price')
                    ->formatStateUsing(fn ($state): string => 'Rp ' . number_format((int) $state, 0, ',', '.'))
                    ->sortable(),
                TextColumn::make('paid_at')
                    ->dateTime()
                    ->placeholder('-')
                    ->toggleable(),
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
            ->filters([])
            ->recordActions([
                ActionGroup::make([
                    ActionGroup::make([
                        ViewAction::make(),
                    ])->dropdown(false),
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
            'index' => ManageTransactions::route('/'),
        ];
    }
}
