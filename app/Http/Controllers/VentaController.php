<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use Illuminate\Http\Request;

class VentaController extends Controller
{
    /**
     * Muestra el historial de ventas en el Panel de Administración.
     */
    public function index(Request $request)
    {
        // Iniciamos la consulta limpia usando el modelo Venta
        $query = \App\Models\Venta::query();

        // MOTOR DE BÚSQUEDA PROTEGIDO: Buscamos solo por el ID de la venta
        if ($request->filled('buscar')) {
            $buscar = $request->buscar;
            $query->where('id', 'LIKE', '%' . $buscar . '%');
        }

        // Traemos las ventas ordenadas desde la más reciente
        $ventas = $query->latest()->get();

        // Retornamos la vista enviando los resultados
        return view('admin.ventas.index', compact('ventas'));
    }
}
