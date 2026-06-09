<?php

namespace App\Http\Controllers;

use App\Models\Factura;
use Illuminate\Http\Request;

class FacturaController extends Controller
{
    /**
     * Muestra el historial de todas las facturas emitidas.
     */
    public function index()
    {
        // Traemos las facturas de la más reciente a la más antigua
        $facturas = Factura::latest()->get();

        return view('admin.facturacion.index', compact('facturas'));
    }

    /**
     * Muestra el detalle visual de una sola factura (Listo para imprimir).
     */
    public function show($id)
    {
        $factura = Factura::findOrFail($id);

        return view('admin.facturacion.show', compact('factura'));
    }

    /**
     * Ejemplo de cómo se crearía una factura internamente (Lógica para tu Checkout).
     * Este método no se llama desde una vista, sino desde el procesador de pagos.
     */
    public function generarFacturaAutomatica($venta)
    {
        // Generamos un consecutivo único basado en el ID de la venta
        $numeroFactura = 'ANG-' . str_pad($venta->id, 6, '0', STR_PAD_LEFT);

        // Supongamos un IVA del 19% ya incluido o por calcular
        $subtotal = $venta->total / 1.19;
        $impuesto = $venta->total - $subtotal;

        return Factura::create([
            'numero_factura' => $numeroFactura,
            'venta_id'       => $venta->id,
            'cliente_nombre' => $venta->cliente->name ?? 'Cliente General',
            'subtotal'       => $subtotal,
            'impuesto'       => $impuesto,
            'total'          => $venta->total,
            'metodo_pago'    => $venta->metodo_pago ?? 'Simulador',
            'estado'         => 'pagada'
        ]);
    }
}
