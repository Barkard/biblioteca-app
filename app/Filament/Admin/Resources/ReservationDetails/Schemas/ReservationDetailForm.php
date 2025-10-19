<?php

namespace App\Filament\Admin\Resources\ReservationDetails\Schemas;

use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ReservationDetailForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Toggle::make('status')
                    ->required(),
            ]);
    }
}
