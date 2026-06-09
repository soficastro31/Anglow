<?php

namespace App\Http\Controllers;

use App\Models\Producto; // O Productos, según lo tengas en tu proyecto
use App\Models\Productos;
use Illuminate\Http\Request;

class InventarioController extends Controller
{
    /**
     * Muestra el estado del inventario actual.
     */
    public function index()
    {
        // Traemos todos los productos. Si tienes relación con categorías, puedes usar: with('categoria')
        $productos = Productos::all();

        // Retornamos la vista que ya creaste, pasándole la variable $productos
        return view('admin.inventario.index', compact('productos'));
    }
}
