<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;

    // Forzamos el nombre de la tabla en español si tu migración la crea así
    protected $table = 'ventas';

    /**
     * Campos que se pueden llenar de forma masiva (Mass Assignment).
     * Ajusta los nombres según las columnas exactas de tu migración.
     */
    protected $fillable = [
        'user_id',          // ID del usuario autenticado que compró
        'nombre_cliente',   // Campo opcional por si manejas compras de clientes invitados o sin cuenta
        'subtotal',
        'impuesto',
        'total',
        'metodo_pago',
        'estado'            // pendiente, pagada, completada, cancelada
    ];

    /**
     * Relación: Una venta pertenece a un Usuario (Cliente).
     * Esto te permitirá hacer en la vista cosas como: $venta->user->name
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relación: Una venta puede tener una factura asociada (Módulo de Facturación).
     */
    public function factura()
    {
        return $this->hasOne(Factura::class, 'venta_id');
    }
}
