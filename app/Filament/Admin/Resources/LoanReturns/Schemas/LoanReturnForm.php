<?php

namespace App\Filament\Admin\Resources\LoanReturns\Schemas;

use App\Models\User;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

class LoanReturnForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                DatePicker::make('return_date')
                    ->label('Fecha de Devolución'),
                Toggle::make('status')
                    ->label('Estado')
                    ->required(),
                Select::make('user_id')
                    ->label('Usuario')
                    ->options(function () {
                        return User::query()
                            ->orderBy('name')
                            ->get()
                            ->mapWithKeys(function (User $u) {
                                return [$u->id => $u->id_user . ' - ' . $u->name . ' ' . $u->last_name];
                            })
                            ->toArray();
                    })
                    ->searchable()
                    ->preload()
                    ->required(),
            ]);
    }
}
