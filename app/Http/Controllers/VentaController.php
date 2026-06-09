<?php

namespace App\Http\Controllers;

use App\Models\Venta; // Asegúrate de que el modelo exista con este nombre
use Illuminate\Http\Request;

class VentaController extends Controller
{
    /**
     * Muestra el historial de ventas en el Panel de Administración.
     */
    public function index()
    {
        // Traemos todas las ventas ordenadas desde la más nueva.
        // Si tu modelo tiene relación con el usuario, puedes optimizar con: with('user') o with('cliente')
        $ventas = Venta::latest()->get();

        // Retornamos la vista pasándole la colección de ventas
        return view('admin.ventas.index', compact('ventas'));
    }
}
