<?php

namespace App\Filament\Admin\Resources\Reservations\Pages;

use App\Filament\Admin\Resources\Reservations\ReservationResource;
use Filament\Resources\Pages\CreateRecord;

class CreateReservation extends CreateRecord
{
    protected static string $resource = ReservationResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getFormActions(): array
    {
        return [
            \Filament\Actions\Action::make('confirmCreate')
                ->label('Continuar con la reserva')
                ->color('success')
                ->requiresConfirmation()
                ->modalHeading('Confirmar Reserva')
                ->modalDescription(function () {
                    $expiryDate = \Carbon\Carbon::now()->addDays(5)->format('d/m/Y');
                    return "Tiene 5 días para buscar los libros (ejemplares). La reserva vence el día {$expiryDate}.";
                })
                ->modalSubmitActionLabel('Crear')
                ->modalCancelActionLabel('Cancelar')
                ->action(fn () => $this->create()),

            \Filament\Actions\Action::make('confirmCreateAnother')
                ->label('Crear y añadir otro')
                ->color('gray')
                ->requiresConfirmation()
                ->modalHeading('Confirmar Reserva')
                ->modalDescription(function () {
                    $expiryDate = \Carbon\Carbon::now()->addDays(5)->format('d/m/Y');
                    return "Tiene 5 días para buscar los libros (ejemplares). La reserva vence el día {$expiryDate}.";
                })
                ->modalSubmitActionLabel('Crear y añadir otro')
                ->action(fn () => $this->create(another: true)),

            $this->getCancelFormAction(),
        ];
    }

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
                    $days = \Carbon\Carbon::now()->startOfDay()->diffInDays($carbonDate->startOfDay(), false);
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
