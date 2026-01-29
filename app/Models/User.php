<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser; // IMPORTANTE
use Filament\Panel; // IMPORTANTE
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements FilamentUser // IMPLEMENTAR INTERFAZ
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name','second_name','last_name','second_last_name',
        'role_id','email','password','nationality',
        'country_code','phone','id_user','birthdate','status'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Determina quién puede entrar al panel de Filament.
     */
    public function canAccessPanel(Panel $panel): bool
    {
        // Opción A: Permitir a todos los usuarios registrados (Solo para pruebas)
        return true;

        /*
        Opción B: Solo permitir a un rol específico (Recomendado)
        return $this->role_id === 1; // Asumiendo que 1 es Admin
        */
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    protected static function booted()
    {
        static::creating(function ($user) {
            if (is_null($user->role_id)) {
                $user->role_id = 3;
            }
        });
    }
}
