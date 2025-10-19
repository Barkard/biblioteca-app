<?php

namespace App\Filament\Admin\Resources\Reservations\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ReservationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                DatePicker::make('reservation_date')
                    ->required(),
                Toggle::make('status')
                    ->required(),
            ]);
    }
}
