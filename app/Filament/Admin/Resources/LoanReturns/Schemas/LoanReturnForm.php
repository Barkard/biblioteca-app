<?php

namespace App\Filament\Admin\Resources\LoanReturns\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class LoanReturnForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                DatePicker::make('return_date'),
                TextInput::make('loan_detail')
                    ->required()
                    ->numeric(),
                Toggle::make('status')
                    ->required(),
            ]);
    }
}
