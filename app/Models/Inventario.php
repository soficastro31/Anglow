<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventario extends Model
{
    use HasFactory;

    // Indicamos el nombre exacto de la tabla en la base de datos (en plural)
    protected $table = 'inventarios';

    // Campos que permitimos llenar de forma masiva desde el controlador
    protected $fillable = [
        'producto_id',
        'cantidad',
        'tipo_movimiento', // 'entrada' (compra/abastecimiento) o 'salida' (venta)
        'descripcion',     // 'Stock inicial', 'Ajuste manual', etc.
    ];

    /**
     * Relación: Cada registro de inventario le pertenece a un producto.
     */
    public function producto()
    {
        return $this->belongsTo(Productos::class, 'producto_id');
    }
}
