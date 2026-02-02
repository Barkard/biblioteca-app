<?php

namespace App\Observers;

use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserObserver
{
    public function created(User $user): void
    {
        ActivityLog::create([
            'user_id' => Auth::id(),
            'description' => 'se creó el usuario "' . $user->name . '" exitosamente',
        ]);
    }

    public function updated(User $user): void
    {
        ActivityLog::create([
            'user_id' => Auth::id(),
            'description' => 'se actualizó el usuario "' . $user->name . '"',
        ]);
    }

    public function deleted(User $user): void
    {
        ActivityLog::create([
            'user_id' => Auth::id(),
            'description' => 'se eliminó el usuario "' . $user->name . '"',
        ]);
    }
}
