<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompraProveedor extends Model
{
    // Vincula explícitamente el modelo con tu tabla en español
    protected $table = 'compras_proveedores';

    // Esto es lo más importante: evita errores de seguridad de "Mass Assignment"
    protected $fillable = [
        'proveedor',
        'producto',
        'cantidad',
        'costo_total',
        'fecha_entrega',
        'estado'
    ];

    // Esto ayuda a que Laravel maneje automáticamente los formatos de datos
    protected $casts = [
        'fecha_entrega' => 'date',
        'costo_total' => 'decimal:2',
    ];
}
