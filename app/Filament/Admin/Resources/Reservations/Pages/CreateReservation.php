<?php

namespace App\Filament\Admin\Resources\Reservations\Pages;

use App\Filament\Admin\Resources\Reservations\ReservationResource;
use Filament\Resources\Pages\CreateRecord;

class CreateReservation extends CreateRecord
{
    protected static string $resource = ReservationResource::class;

    protected function afterCreate(): void
    {
        $record = $this->record;
        $shouldBePending = false;

        foreach ($record->reservationDetails as $detail) {
            $copy = $detail->copyBook;
            if ($copy && ! $copy->status) {
                $date = $copy->nextAvailableDate();
                if ($date) {
                    $carbonDate = \Carbon\Carbon::parse($date);
                    $days = \Carbon\Carbon::now()->diffInDays($carbonDate, false);
                    if ($days <= 4 && $days >= 0) {
                        $shouldBePending = true;
                        break;
                    }
                }
            }
        }

        if ($shouldBePending) {
            $record->update(['status' => 'pendiente']);
        }
    }
}
