<?php

namespace App\Filament\Admin\Resources\CopyBooks\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

class CopyBookForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('cota')
                    ->required(),
                Toggle::make('status')
                    ->required(),
                Select::make('book_id')
                    ->label('Libro')
                    ->relationship('book', 'title')
                    ->searchable()
                    ->preload()
                    ->required(),
            ]);
    }
}
