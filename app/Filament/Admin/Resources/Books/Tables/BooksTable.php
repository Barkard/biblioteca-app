<?php

namespace App\Filament\Admin\Resources\Books\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables\Columns\ImageColumn;


class BooksTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('cover')
                    ->label('Portada')
                    ->width(50)
                    ->height(80),
                TextColumn::make('title')
                    ->label('Título')
                    ->searchable(),

                TextColumn::make('Edition')
                    ->label('Edición')
                    ->searchable(),
                TextColumn::make('publisher.name')
                    ->label('Editorial')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('date_published')
                    ->label('Fecha de Publicación')
                    ->date()
                    ->sortable(),
                TextColumn::make('author.name')
                    ->label('Autor')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('category.name')
                    ->label('Categoría')
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
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
