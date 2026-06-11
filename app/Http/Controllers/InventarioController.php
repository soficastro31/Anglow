<?php

namespace App\Http\Controllers;

use App\Models\Inventario;
use App\Models\Productos;
use Illuminate\Http\Request;

class InventarioController extends Controller
{
    /**
     * Muestra el panel de control de inventarios con soporte para filtros.
     */
    /**
     * Muestra el panel de control de inventarios con soporte para filtros.
     */
    public function index(Request $request)
    {
        // 1. Capturamos lo que el usuario escribió en el input de búsqueda
        $buscar = $request->get('buscar');

        // 2. Traemos todos los movimientos de inventario históricos
        $inventario = \App\Models\Inventario::with('producto')->orderBy('created_at', 'desc')->get();

        // 3. MOTOR DE BÚSQUEDA CORREGIDO: Buscamos únicamente por la columna 'nombre'
        $productos = Productos::with('categoria')
            ->when($buscar, function ($query) use ($buscar) {
                return $query->where('nombre', 'LIKE', "%{$buscar}%");
            })
            ->get();

        // 4. Enviamos las variables a la vista
        return view('admin.inventario.index', compact('inventario', 'productos', 'buscar'));
    }

    /**
     * Registra de forma manual un movimiento de inventario (Entrada / Salida / Ajuste)
     */
    public function store(Request $request)
    {
        $request->validate([
            'producto_id'     => 'required|exists:productos,id',
            'cantidad'        => 'required|integer|min:1',
            'tipo_movimiento' => 'required|in:entrada,salida',
            'descripcion'     => 'nullable|string|max:255',
        ]);

        $producto = Productos::findOrFail($request->producto_id);

        if ($request->tipo_movimiento === 'entrada') {
            $nuevoStock = $producto->stock + $request->cantidad;
        } else {
            if ($producto->stock < $request->cantidad) {
                return back()->with('error', 'Operación cancelada. No hay suficiente stock en bodega para este egreso.');
            }
            $nuevoStock = $producto->stock - $request->cantidad;
        }

        $producto->update(['stock' => $nuevoStock]);

        \App\Models\Inventario::create([
            'producto_id'     => $request->producto_id,
            'cantidad'        => $request->cantidad,
            'tipo_movimiento' => $request->tipo_movimiento,
            'descripcion'     => $request->descripcion ?? 'Ajuste manual de inventario',
        ]);

        return redirect()->route('inventario.index')->with('success', 'Movimiento de inventario registrado con éxito.');
    }
}
