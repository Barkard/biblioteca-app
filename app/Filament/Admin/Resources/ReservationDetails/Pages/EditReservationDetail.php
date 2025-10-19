<?php

namespace App\Filament\Admin\Resources\ReservationDetails\Pages;

use App\Filament\Admin\Resources\ReservationDetails\ReservationDetailResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditReservationDetail extends EditRecord
{
    protected static string $resource = ReservationDetailResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
