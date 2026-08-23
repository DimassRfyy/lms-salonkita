<?php

namespace App\Filament\Resources\Courses\Tables;

use App\Models\Course;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class CoursesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('thumbnail')
                    ->disk('public'),
                TextColumn::make('name')
                    ->description(fn ($record) => $record->category?->name)
                    ->searchable(),
                TextColumn::make('instructor.name')
                    ->label('Coach')
                    ->searchable(),
                TextColumn::make('price')
                    ->label('Harga')
                    ->formatStateUsing(fn ($state): string => 'Rp ' . number_format((int) $state, 0, ',', '.'))
                    ->sortable(),
                TextColumn::make('is_published')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn (bool $state): string => $state ? 'Aktif' : 'Belum Aktif')
                    ->color(fn (bool $state): string => $state ? 'success' : 'warning')
                    ->icon(fn (bool $state): string => $state ? 'heroicon-m-check-circle' : 'heroicon-m-clock')
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
                SelectFilter::make('is_published')
                    ->label('Status Publikasi')
                    ->options([
                        '1' => 'Kelas Aktif (Published)',
                        '0' => 'Belum Aktif (Menunggu Review)',
                    ]),
                SelectFilter::make('category_id')
                    ->label('Kategori')
                    ->relationship('category', 'name'),
                SelectFilter::make('user_id')
                    ->label('Coach')
                    ->relationship('instructor', 'name', fn ($query) => $query->where('role', 'coach'))
                    ->visible(fn () => Auth::user()?->role === 'admin'),
            ])
            ->recordActions([
                ActionGroup::make([
                    ActionGroup::make([
                        ViewAction::make(),
                        EditAction::make(),
                        Action::make('publish')
                            ->label('Publish Kelas')
                            ->icon('heroicon-m-check-circle')
                            ->color('success')
                            ->requiresConfirmation()
                            ->modalHeading('Publikasikan Kelas')
                            ->modalDescription('Apakah Anda yakin kelas ini sudah selesai diperiksa dan siap dipublikasikan ke katalog student?')
                            ->modalSubmitActionLabel('Ya, Publikasikan')
                            ->visible(fn (Course $record) => ! $record->is_published && Auth::user()?->role === 'admin')
                            ->action(function (Course $record) {
                                $record->update(['is_published' => true]);

                                Notification::make()
                                    ->title('Kelas Berhasil Dipublikasikan')
                                    ->body("Kelas \"{$record->name}\" sekarang berstatus aktif.")
                                    ->success()
                                    ->send();
                            }),
                        Action::make('unpublish')
                            ->label('Batal Publish')
                            ->icon('heroicon-m-x-circle')
                            ->color('danger')
                            ->requiresConfirmation()
                            ->modalHeading('Nonaktifkan Publikasi Kelas')
                            ->modalDescription('Apakah Anda yakin ingin menonaktifkan kelas ini dari katalog?')
                            ->modalSubmitActionLabel('Ya, Nonaktifkan')
                            ->visible(fn (Course $record) => (bool) $record->is_published && Auth::user()?->role === 'admin')
                            ->action(function (Course $record) {
                                $record->update(['is_published' => false]);

                                Notification::make()
                                    ->title('Kelas Dinonaktifkan')
                                    ->body("Kelas \"{$record->name}\" sekarang berstatus belum aktif.")
                                    ->warning()
                                    ->send();
                            }),
                    ])
                        ->dropdown(false),
                    DeleteAction::make(),
                ])->icon('heroicon-m-bars-3'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    BulkAction::make('publish_selected')
                        ->label('Publish Terpilih')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->requiresConfirmation()
                        ->visible(fn () => Auth::user()?->role === 'admin')
                        ->action(function (Collection $records) {
                            $records->each(fn (Course $record) => $record->update(['is_published' => true]));

                            Notification::make()
                                ->title('Kelas Terpilih Berhasil Dipublikasikan')
                                ->success()
                                ->send();
                        })
                        ->deselectRecordsAfterCompletion(),
                    BulkAction::make('unpublish_selected')
                        ->label('Nonaktifkan Terpilih')
                        ->icon('heroicon-o-x-circle')
                        ->color('warning')
                        ->requiresConfirmation()
                        ->visible(fn () => Auth::user()?->role === 'admin')
                        ->action(function (Collection $records) {
                            $records->each(fn (Course $record) => $record->update(['is_published' => false]));

                            Notification::make()
                                ->title('Kelas Terpilih Berhasil Dinonaktifkan')
                                ->warning()
                                ->send();
                        })
                        ->deselectRecordsAfterCompletion(),
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
