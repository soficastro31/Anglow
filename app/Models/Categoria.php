<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    /**
     * CORRECCIÓN: Descomentamos esta línea y configuramos 'categoria' en singular
     * para que Laravel busque en la tabla exacta de tu base de datos.
     */
    protected $table = 'categoria';

    protected $fillable = ['nombre', 'descripcion'];

    /**
     * Relación: Una Categoría tiene muchos Productos.
     */
    public function productos()
    {
        // Conecta correctamente con tu modelo 'Productos' y la llave 'categoria_id'
        return $this->hasMany(Productos::class, 'categoria_id');
    }
}
