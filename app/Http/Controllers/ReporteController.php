<?php

namespace App\Http\Controllers;

use App\Models\Venta;           // Tu modelo (que apunta a la tabla 'pedidos')
use App\Models\Productos;       // Importado una sola vez en plural como lo tienes
use App\Models\CompraProveedor; // Tu modelo de compras a proveedores
use Illuminate\Http\Request;

class ReporteController extends Controller
{
    /**
     * Genera el cuadro de mando de estadísticas para el Admin.
     */
    public function index()
    {
        // 1. BALANCE DE VENTAS: Cambiado a los estados típicos de tu tabla pedidos
        $totalVentas = Venta::whereIn('estado', ['pagada', 'completada', 'pagado'])->sum('total');
        $cantidadVentas = Venta::whereIn('estado', ['pagada', 'completada', 'pagado'])->count();

        // 2. COSTOS DE PROVEEDORES: Corregido con tu columna exacta 'costo_total'
        $totalInversion = CompraProveedor::sum('costo_total') ?? 0;

        // 3. PRODUCTOS EN STOCK CRÍTICO: Usando tu modelo 'Productos'
        $productosCriticos = Productos::where('stock', '<=', 5)->take(3)->get();

        // 4. MÉTRICAS EXTRA: Total de productos en catálogo
        $totalProductos = Productos::count();

        // Enviamos todas las variables calculadas a la vista
        return view('admin.reportes.index', compact(
            'totalVentas',
            'cantidadVentas',
            'totalInversion',
            'productosCriticos',
            'totalProductos'
        ));
    }
}
