<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;

    // Protegemos la tabla definiendo qué campos se pueden rellenar desde el formulario
    protected $fillable = [
        'user_id',
        'telefono',
        'ciudad_departamento',
        'direccion',
        'barrio_sector',
        'notas_envio',
        'total',
        'estado_pago'
    ];

    // Relación: Un pedido le pertenece a un Usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}