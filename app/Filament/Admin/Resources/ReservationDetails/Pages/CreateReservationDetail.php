<?php

namespace App\Filament\Admin\Resources\ReservationDetails\Pages;

use App\Filament\Admin\Resources\ReservationDetails\ReservationDetailResource;
use Filament\Resources\Pages\CreateRecord;

class CreateReservationDetail extends CreateRecord
{
    protected static string $resource = ReservationDetailResource::class;
}
