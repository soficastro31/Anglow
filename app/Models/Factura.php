<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    use HasFactory;

    // Forzamos el nombre de la tabla en español
    protected $table = 'facturas';

    protected $fillable = [
        'numero_factura',
        'venta_id', // Almacena el ID real de la tabla ventas
        'cliente_nombre',
        'subtotal',
        'impuesto',
        'total',
        'metodo_pago',
        'estado'
    ];

    /**
     * Relación: Una factura pertenece a una Venta específica.
     */
    public function venta()
    {
        return $this->belongsTo(Venta::class, 'venta_id');
    }
}
