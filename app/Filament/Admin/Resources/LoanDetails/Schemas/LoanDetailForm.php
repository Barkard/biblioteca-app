<?php

namespace App\Filament\Admin\Resources\LoanDetails\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class LoanDetailForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Toggle::make('status')
                    ->required(),
                DatePicker::make('return_date'),
            ]);
    }
}
