<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany; // Importamos la clase para la relación

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'rol',
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

    /* ===================================================
       RELACIONES DE MODELO (NUEVO)
    =================================================== */

    /**
     * Obtiene todas las ventas (compras) asociadas a este usuario.
     */
    public function ventas(): HasMany
    {
        // Conecta el ID de este usuario con la columna 'user_id' en tu tabla 'ventas'
        return $this->hasMany(Venta::class, 'user_id');
    }
}
