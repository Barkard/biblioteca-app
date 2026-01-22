<?php

namespace App\Filament\Admin\Resources\Reservations\Pages;

use App\Filament\Admin\Resources\Reservations\ReservationResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditReservation extends EditRecord
{
    protected static string $resource = ReservationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function afterSave(): void
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
        } elseif ($record->status === 'pendiente') {
            // Revert to activa if no longer pending (optional but good)
            $record->update(['status' => 'activa']);
        }
    }
}
