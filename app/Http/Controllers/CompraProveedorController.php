<?php

namespace App\Http\Controllers;

use App\Models\CompraProveedor;
use Illuminate\Http\Request;

class CompraProveedorController extends Controller
{
    /**
     * Muestra el listado de compras a proveedores.
     */
    public function index()
    {
        // Traemos todas las compras ordenadas por la más reciente
        $compras = CompraProveedor::latest()->get();

        // Retornamos la vista
        return view('admin.compras_proveedor.index', compact('compras'));
    }

    /**
     * Guarda una nueva compra en la base de datos.
     */
    public function store(Request $request)
    {
        // 1. Validamos que los datos vengan correctos
        $validatedData = $request->validate([
            'proveedor'     => 'required|string|max:255',
            'producto'      => 'required|string|max:255',
            'cantidad'      => 'required|integer|min:1',
            'costo_total'   => 'required|numeric|min:0',
            'fecha_entrega' => 'required|date',
        ]);

        // Por defecto, al crear la compra, su estado inicial será 'pendiente'
        $validatedData['estado'] = 'pendiente';

        // 2. Creamos el registro en la base de datos
        CompraProveedor::create($validatedData);

        // 3. Redirigimos de vuelta al listado con un mensaje de éxito
        return redirect()->route('compras-proveedor.index')
            ->with('success', 'Compra a proveedor registrada con éxito.');
    }

    /**
     * Cambia el estado de la compra a "recibido".
     */
    public function confirmar($id)
    {
        // 1. Buscamos la compra por su ID, si no existe lanza un error 404
        $compra = CompraProveedor::findOrFail($id);

        // 2. Cambiamos el estado a recibido
        $compra->estado = 'recibido';
        $compra->save();

        // 3. Volvemos atrás a la misma vista con un mensaje de éxito
        return redirect()->back()->with('success', '¡La compra ha sido marcada como Recibida!');
    }
}
