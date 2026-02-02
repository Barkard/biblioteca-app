<?php

namespace App\Filament\Admin\Resources\Reservations\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Actions\Action;

class ReservationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('status')
                    ->label('Estado')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'activa' => 'success',
                        'pendiente' => 'warning',
                        'finalizada' => 'gray',
                        default => 'gray',
                    })
                    ->icon(fn (string $state): string => match ($state) {
                        'pendiente' => 'heroicon-o-clock',
                        default => 'heroicon-o-check-circle',
                    }),
                TextColumn::make('user.name')
                    ->label('Usuario')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Creado el')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('Actualizado el')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                \Filament\Actions\Action::make('generateLoan')
                    ->label('Generar Préstamo')
                    ->icon('heroicon-o-document-plus')
                    ->color('success')
                    ->requiresConfirmation()
                    ->action(function (\App\Models\Reservation $record) {
                        // Check if all copies are still available
                        $allAvailable = $record->reservationDetails->every(fn ($detail) => $detail->copyBook->status);

                        if (! $allAvailable) {
                            \Filament\Notifications\Notification::make()
                                ->title('No se puede generar el préstamo')
                                ->body('Algunos ejemplares no están disponibles actualmente.')
                                ->danger()
                                ->send();
                            return;
                        }

                        \Illuminate\Support\Facades\DB::transaction(function () use ($record) {
                            // Create LoanReturn
                            $loan = \App\Models\LoanReturn::create([
                                'user_id' => $record->user_id,
                                'status' => 'activo',
                                'loan_date' => now(),
                                'return_date' => now()->addDays(7), // Default 7 days
                            ]);

                            // Create LoanDetails
                            foreach ($record->reservationDetails as $detail) {
                                \App\Models\LoanDetail::create([
                                    'loan_return_id' => $loan->id,
                                    'copy_book_id' => $detail->copy_book_id,
                                    'status' => 'entregado',
                                ]);

                                // Update copyBook status
                                $detail->copyBook->update(['status' => false]);
                            }

                            // Finish reservation
                            $record->update(['status' => 'finalizada']);
                        });

                        \Filament\Notifications\Notification::make()
                            ->title('Préstamo generado con éxito')
                            ->success()
                            ->send();
                    })
                    ->visible(function (\App\Models\Reservation $record) {
                        // Visible only if all copies are available and reservation is active/pending
                        if ($record->status === 'finalizada') return false;

                        return $record->reservationDetails->every(fn ($detail) => $detail->copyBook?->status);
                    }),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
