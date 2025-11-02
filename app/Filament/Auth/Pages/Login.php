<?php

namespace App\Filament\Auth\Pages;

use Filament\Auth\Pages\Login as BaseLogin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Filament\Auth\Http\Responses\LoginResponse;

class Login extends BaseLogin
{
    public function mount(): void
    {
        Log::info('Login::mount ejecutado', [
            'panel' => (filament()->getCurrentPanel()?->id) ?? null,
            'url' => request()->fullUrl(),
        ]);

        parent::mount();
    }

}
