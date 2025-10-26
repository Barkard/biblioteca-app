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
                DatePicker::make('return_date'),
                Toggle::make('status')
                    ->required(),
                Select::make('user_id')
                    ->label('User')
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
