<?php

namespace App\Observers;

use App\Models\ActivityLog;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;

class ReservationObserver
{
    public function created(Reservation $reservation): void
    {
        $this->logActivity('reserva', $reservation);
    }

    public function updated(Reservation $reservation): void
    {
       // $this->logActivity('actualización de reserva', $reservation);
    }

    public function deleted(Reservation $reservation): void
    {
       // $this->logActivity('eliminación de reserva', $reservation);
    }

    private function logActivity(string $action, Reservation $reservation): void
    {
        $user = $reservation->user;
        $userInfo = $user ? "{$user->name} {$user->last_name} - {$user->id_user}" : 'Usuario desconocido';

        ActivityLog::create([
            'user_id' => Auth::id(),
            'description' => "{$action} al usuario \"{$userInfo}\"",
        ]);
    }
}
