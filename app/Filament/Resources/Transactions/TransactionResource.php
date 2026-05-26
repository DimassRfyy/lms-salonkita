<?php

namespace App\Filament\Resources\Transactions;

use App\Filament\Resources\Transactions\Pages\ManageTransactions;
use App\Models\Transaction;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ActionGroup;
use Filament\Actions\ViewAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;

    public static function getNavigationBadgeTooltip(): ?string
    {
        return 'Transaksi menunggu approve';
    }

    protected static string | \UnitEnum | null $navigationGroup = 'Payment Management';

    public static function getNavigationBadge(): ?string
    {
        return (string) static::getModel()::query()
            ->where('is_paid', false)
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
                        'bca' => 'BCA',
                        'bri' => 'BRI',
                        'ovo' => 'OVO',
                        'dana' => 'DANA',
                        'gopay' => 'GoPay',
                    ])
                    ->required(),
                FileUpload::make('proof_of_payment')
                    ->disk('public')
                    ->image()
                    ->directory('proof-of-payments'),
                Toggle::make('is_paid')
                    ->default(true)
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
                        'bca' => 'BCA',
                        'bri' => 'BRI',
                        'ovo' => 'OVO',
                        'dana' => 'DANA',
                        'gopay' => 'GoPay',
                        default => $state,
                    })
                    ->searchable(),
                TextColumn::make('promoCode.code')
                    ->label('Promo')
                    ->placeholder('-')
                    ->description(fn (Transaction $record): ?string => $record->promoCode?->description)
                    ->searchable(),
                IconColumn::make('is_paid')
                    ->label('Paid')
                    ->boolean(),
                TextColumn::make('price')
                    ->formatStateUsing(fn ($state): string => 'Rp ' . number_format((int) $state, 0, ',', '.'))
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
                            ->requiresConfirmation()
                            ->visible(fn (Transaction $record): bool => ! $record->is_paid)
                            ->action(function (Transaction $record): void {
                                $record->update(['is_paid' => true]);

                                $record->student?->ownedCourses()->syncWithoutDetaching([$record->course_id]);
                            }),
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
            'index' => ManageTransactions::route('/'),
        ];
    }
}
