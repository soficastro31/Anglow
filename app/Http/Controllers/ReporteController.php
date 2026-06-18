<?php

namespace App\Http\Controllers;

use App\Models\{Venta, Productos, CompraProveedor, Factura}; // Volvemos a incluir Factura
use Illuminate\Http\Request;

class ReporteController extends Controller
{
    public function index(Request $request)
    {
        $tipo = $request->get('tipo');

        // 1. Dashboard Estadístico
        if (!$tipo) {
            $estadosValidos = ['pagada', 'completada', 'pagado', 'aprobado'];

            $totalVentas = Venta::whereIn('estado', $estadosValidos)->sum('total');
            $cantidadVentas = Venta::whereIn('estado', $estadosValidos)->count();
            $totalInversion = CompraProveedor::sum('costo_total') ?? 0;
            $productosCriticos = Productos::where('stock', '<=', 5)->take(3)->get();
            $totalProductos = Productos::count();

            return view('admin.reportes.index', compact('totalVentas', 'cantidadVentas', 'totalInversion', 'productosCriticos', 'totalProductos'));
        }

        // 2. Módulos de Impresión
        $datos = [];
        switch ($tipo) {
            case 'ventas':
                $datos = Venta::all();
                break;
            case 'inventario':
                $datos = Productos::with('categoria')->get();
                break;
            case 'compras':
                $datos = CompraProveedor::all();
                break;
            case 'facturacion':
                // Traemos todas las facturas de la tabla 'facturas'
                $datos = Factura::all();
                break;
        }

        return view('admin.reportes.imprimir', compact('datos', 'tipo'));
    }
}
