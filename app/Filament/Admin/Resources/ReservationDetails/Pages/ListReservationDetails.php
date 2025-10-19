<?php

namespace App\Filament\Admin\Resources\ReservationDetails\Pages;

use App\Filament\Admin\Resources\ReservationDetails\ReservationDetailResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListReservationDetails extends ListRecords
{
    protected static string $resource = ReservationDetailResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
