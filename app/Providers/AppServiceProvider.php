<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;



class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
    */
    public function register(): void
    {

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \App\Models\Book::observe(\App\Observers\BookObserver::class);
        \App\Models\User::observe(\App\Observers\UserObserver::class);
        \App\Models\Reservation::observe(\App\Observers\ReservationObserver::class);
        \App\Models\LoanReturn::observe(\App\Observers\LoanReturnObserver::class);
    }
}
