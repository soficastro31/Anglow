<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Productos extends Model
{
    // Indicamos el nombre exacto de la tabla en tu base de datos
    protected $table = 'productos';

    // CORRECCIÓN: Agregamos 'categoria_id' para permitir la asignación masiva desde el formulario
    protected $fillable = [
        'nombre',
        'descripcion',
        'precio',
        'stock',
        'imagen',
        'categoria_id'
    ];

    /**
     * RELACIÓN: Un producto pertenece a una única Categoría.
     * Esto nos permite hacer cosas como: $producto->categoria->nombre en las vistas.
     */
    public function categoria()
    {
        // Conectamos con el modelo Categoria usando la llave foránea 'categoria_id'
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }
}
