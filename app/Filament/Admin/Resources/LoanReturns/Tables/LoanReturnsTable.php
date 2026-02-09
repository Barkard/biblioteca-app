<?php

namespace App\Filament\Admin\Resources\LoanReturns\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class LoanReturnsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('return_date')
                    ->label('Fecha de Devolución')
                    ->date()
                    ->sortable(),
                IconColumn::make('status')
                    ->label('Estado')
                    ->icon(fn ($state) => $state === 'activo' || $state == 1 ? 'heroicon-o-clock' : 'heroicon-o-check-circle')
                    ->color(fn ($state) => $state === 'activo' || $state == 1 ? 'warning' : 'success')
                    ->tooltip(fn ($state) => $state === 'activo' || $state == 1 ? 'Pendiente' : 'Completado'),
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
                EditAction::make(),
                \Filament\Actions\ViewAction::make()
                    ->modalHeading('Detalle del Préstamo'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
