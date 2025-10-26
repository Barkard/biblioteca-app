<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $fillable = [
        'module_id',
        'role_id',
        'create',
        'read',
        'update',
        'delete',
    ];

    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}

/*
php artisan make:filament-resource Book --generate
php artisan make:filament-resource CopyBook --generate
php artisan make:filament-resource LoanDetail --generate
php artisan make:filament-resource LoanReturn --generate
php artisan make:filament-resource Module --generate
php artisan make:filament-resource Permission --generate
php artisan make:filament-resource Reservation --generate
php artisan make:filament-resource ReservationDetail --generate
*/
