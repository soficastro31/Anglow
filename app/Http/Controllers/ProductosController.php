<?php

namespace App\Http\Controllers;

use App\Models\Productos;
use App\Models\Pedido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductosController extends Controller
{
    /* ================= ADMIN (Muestra las 6 tarjetas) ================= */
    public function index()
    {
        return view('admin.index');
    }

    /* ================= GESTIÓN INDEPENDIENTE (Muestra solo los productos) ================= */
    public function gestion()
    {
        $productos = Productos::all();
        return view('admin.productos', compact('productos'));
    }

    /* ================= CREAR ================= */
    public function create()
    {
        return view('productos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre'      => 'required|string|max:255',
            'descripcion' => 'required|string',
            'precio'      => 'required|numeric',
            'stock'       => 'required|integer',
            'imagen'      => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $datos = $request->except('imagen');

        if ($request->hasFile('imagen')) {
            $rutaImagen = $request->file('imagen')->store('productos', 'public');
            $datos['imagen'] = $rutaImagen;
        }

        @class_exists('Productos') && Productos::create($datos);

        return redirect('/productos/gestion')->with('success', 'Producto creado con éxito');
    }

    /* ================= EDITAR ================= */
    public function edit($id)
    {
        $producto = Productos::find($id);

        if (!$producto) {
            return redirect('/productos/gestion');
        }

        return view('productos.edit', compact('producto'));
    }

    /* ================= ACTUALIZAR ================= */
    public function update(Request $request, $id)
    {
        $producto = Productos::find($id);

        if (!$producto) {
            return redirect('/productos/gestion');
        }

        $request->validate([
            'nombre'      => 'required|string|max:255',
            'descripcion' => 'required|string',
            'precio'      => 'required|numeric',
            'stock'       => 'required|integer',
            'imagen'      => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $datos = $request->except('imagen');

        if ($request->hasFile('imagen')) {
            $rutaImagen = $request->file('imagen')->store('productos', 'public');
            $datos['imagen'] = $rutaImagen;
        }

        $producto->update($datos);

        return redirect('/productos/gestion')->with('success', 'Producto actualizado con éxito');
    }

    /* ================= ELIMINAR ================= */
    public function destroy($id)
    {
        $producto = Productos::find($id);

        if (!$producto) {
            return redirect('/productos/gestion');
        }

        $producto->delete();

        return redirect('/productos/gestion')->with('success', 'Producto eliminado');
    }

    /* ================= TIENDA ================= */
    public function tienda()
    {
        $productos = Productos::all();

        return view('clientes.tienda', compact('productos'));
    }

    /* ================= CARRITO ================= */
    public function agregarCarrito($id, $cantidad)
    {
        $producto = Productos::find($id);

        if (!$producto) {
            return back();
        }

        $carrito = session()->get('carrito', []);

        if (isset($carrito[$id])) {
            $carrito[$id]['cantidad'] += $cantidad;
        } else {
            $carrito[$id] = [
                "nombre" => $producto->nombre,
                "precio" => $producto->precio,
                "cantidad" => $cantidad
            ];
        }

        session()->put('carrito', $carrito);

        return back();
    }

    public function eliminarDelCarrito($id)
    {
        $carrito = session()->get('carrito', []);

        if (isset($carrito[$id])) {
            unset($carrito[$id]);
        }

        session()->put('carrito', $carrito);

        return back();
    }

    public function vaciarCarrito()
    {
        session()->forget('carrito');

        return back();
    }

    /* ================= CHECKOUT ================= */
    public function checkout()
    {
        $carrito = session()->get('carrito', []);

        if (empty($carrito)) {
            return redirect('/carrito');
        }

        $total = 0;
        foreach ($carrito as $item) {
            $total += $item['precio'] * $item['cantidad'];
        }

        return view('clientes.checkout', compact('carrito', 'total'));
    }

    /* ================= PROCESAR CHECKOUT (GUARDA EL PEDIDO) ================= */
    public function procesarCheckout(Request $request)
    {
        $request->validate([
            'telefono'            => 'required|string|max:20',
            'ciudad_departamento' => 'required|string|max:255',
            'barrio_sector'       => 'required|string|max:255',
            'direccion'           => 'required|string|max:255',
            'notas_envio'         => 'nullable|string',
        ]);

        $carrito = session()->get('carrito', []);

        if (empty($carrito)) {
            return redirect('/carrito')->with('error', 'El carrito está vacío.');
        }

        // Recalcular el total en servidor para máxima seguridad
        $total = 0;
        foreach ($carrito as $item) {
            $total += $item['precio'] * $item['cantidad'];
        }

        // Crear el registro del pedido vinculado al usuario autenticado
        $pedido = Pedido::create([
            'user_id'             => Auth::id(),
            'telefono'            => $request->telefono,
            'ciudad_departamento' => $request->ciudad_departamento,
            'barrio_sector'       => $request->barrio_sector,
            'direccion'           => $request->direccion,
            'notas_envio'         => $request->notas_envio,
            'total'               => $total,
            'estado_pago'         => 'pendiente', 
        ]);

        session()->put('ultimo_pedido_id', $pedido->id);

        // Redirige usando el ID dinámico a la pasarela adaptada
        return redirect()->route('checkout.pasarela', ['id' => $pedido->id]);
    }

    /* ================= VISTA DE LA PASARELA ADAPTADA ================= */
    public function vistaPasarela($id)
    {
        // Buscamos el pedido real creado para pasarlo a la pasarela simulada
        $pedido = Pedido::findOrFail($id);

        return view('clientes.pasarela_simulada', compact('pedido'));
    }

    /* ================= PAGAR (SIMULACIÓN DE LA PASARELA) ================= */
    public function pagar($id)
    {
        // Buscamos el pedido correspondiente al ID de la URL
        $pedido = Pedido::findOrFail($id);
        
        // Actualizamos el estado del pedido en la base de datos
        $pedido->update(['estado_pago' => 'aprobado']);

        // Limpiamos las variables de control de sesión
        session()->forget('ultimo_pedido_id');
        session()->forget('carrito');

        // Redirigimos a la pantalla de confirmación/factura
        return redirect()->route('checkout.factura', ['id' => $pedido->id]);
    }

    /* ================= MOSTRAR FACTURA O RECIBO FINAL ================= */
    public function mostrarFactura($id)
    {
        // Buscamos el pedido para pintar la información completa en el recibo
        $pedido = Pedido::findOrFail($id);

        return view('clientes.factura', compact('pedido'));
    }
}