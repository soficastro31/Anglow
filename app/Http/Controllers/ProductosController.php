<?php

namespace App\Http\Controllers;

use App\Models\Productos;
use Illuminate\Http\Request;

class ProductosController extends Controller
{
    /* ================= ADMIN ================= */

    public function index()
    {
        $productos = Productos::all();
        return view('admin.index', compact('productos'));
    }

    public function create()
    {
        return view('productos.create');
    }

    public function store(Request $request)
    {
        Productos::create($request->all());
        return redirect('/admin');
    }

    /* ================= EDITAR ================= */

    public function edit($id)
    {
        $producto = Productos::find($id);

        if (!$producto) {
            return redirect('/admin');
        }

        return view('productos.edit', compact('producto'));
    }

    /* ================= ACTUALIZAR ================= */

    public function update(Request $request, $id)
    {
        $producto = Productos::find($id);

        if (!$producto) {
            return redirect('/admin');
        }

        $producto->update($request->all());

        return redirect('/admin')->with('success', 'Producto actualizado');
    }

    /* ================= ELIMINAR ================= */

    public function destroy($id)
    {
        $producto = Productos::find($id);

        if (!$producto) {
            return redirect('/admin');
        }

        $producto->delete();

        return redirect('/admin')->with('success', 'Producto eliminado');
    }

    /* ================= TIENDA ================= */

    public function tienda()
    {
        $productos = Productos::all();
        return view('clientes.tienda', compact('productos'));
    }

    /* ================= CARRITO ================= */

    public function agregarCarrito($id)
    {
        $producto = Productos::find($id);

        if (!$producto) return back();

        $carrito = session()->get('carrito', []);

        if (isset($carrito[$id])) {
            $carrito[$id]['cantidad']++;
        } else {
            $carrito[$id] = [
                "nombre" => $producto->nombre,
                "precio" => $producto->precio,
                "cantidad" => 1
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

    /* ================= PAGAR ================= */

    public function pagar()
    {
        session()->forget('carrito');

        return redirect('/tienda')->with('success', 'Compra realizada correctamente');
    }
}