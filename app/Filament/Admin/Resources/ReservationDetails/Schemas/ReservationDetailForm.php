<?php

namespace App\Filament\Admin\Resources\ReservationDetails\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

class ReservationDetailForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('book_id')
                ->label('Libro')
                ->relationship('book', 'title')
                ->searchable()
                ->preload()
                ->required(),
                Select::make('reservation_id')
                ->label('Reserva')
                ->relationship('reservation', 'id')
                ->searchable()
                ->preload()
                ->required(),
                Toggle::make('status')
                    ->required(),
            ]);
    }
}
