<?php

namespace App\Observers;

use App\Models\ActivityLog;
use App\Models\LoanReturn;
use Illuminate\Support\Facades\Auth;

class LoanReturnObserver
{
    public function created(LoanReturn $loanReturn): void
    {
        $this->logActivity('prestamo', $loanReturn);
    }

    public function updated(LoanReturn $loanReturn): void
    {
        // $this->logActivity('actualización de prestamo', $loanReturn);
    }

    private function logActivity(string $action, LoanReturn $loanReturn): void
    {
        $user = $loanReturn->user;
        $userInfo = $user ? "{$user->name} {$user->last_name} - {$user->id_user}" : 'Usuario desconocido';

        ActivityLog::create([
            'user_id' => Auth::id(),
            'description' => "{$action} al usuario \"{$userInfo}\"",
        ]);
    }
}
