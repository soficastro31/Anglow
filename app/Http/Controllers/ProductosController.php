<?php

namespace App\Http\Controllers;

use App\Models\Productos;
use App\Models\Pedido;
use App\Models\Categoria; // INTEGRACIÓN: Importamos el modelo Categoria
use App\Models\Venta;     // INTEGRACIÓN: Importamos el modelo Venta
use App\Models\Factura;   // INTEGRACIÓN: Importamos el modelo Factura
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
        // INTEGRACIÓN: Agregamos with('categoria') para evitar el problema de consultas N+1
        $productos = Productos::with('categoria')->get();
        return view('admin.productos', compact('productos'));
    }

    /* ================= CREAR ================= */
    public function create()
    {
        // INTEGRACIÓN: Traemos las categorías para el menú desplegable del formulario
        $categorias = Categoria::all();
        return view('productos.create', compact('categorias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre'       => 'required|string|max:255',
            'descripcion'  => 'required|string',
            'precio'       => 'required|numeric',
            'stock'        => 'required|integer',
            'categoria_id' => 'required|exists:categoria,id', // INTEGRACIÓN: Validación del campo nuevo
            'imagen'       => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $datos = $request->except('imagen');

        if ($request->hasFile('imagen')) {
            $rutaImagen = $request->file('imagen')->store('productos', 'public');
            $datos['imagen'] = $rutaImagen;
        }

        Productos::create($datos);

        return redirect('/productos/gestion')->with('success', 'Producto creado con éxito');
    }

    /* ================= EDITAR ================= */
    public function edit($id)
    {
        $producto = Productos::find($id);

        if (!$producto) {
            return redirect('/productos/gestion');
        }

        // INTEGRACIÓN: Traemos las categorías para poder cambiarlas en la edición
        $categorias = Categoria::all();

        return view('productos.edit', compact('producto', 'categorias'));
    }

    /* ================= ACTUALIZAR ================= */
    public function update(Request $request, $id)
    {
        $producto = Productos::find($id);

        if (!$producto) {
            return redirect('/productos/gestion');
        }

        $request->validate([
            'nombre'       => 'required|string|max:255',
            'descripcion'  => 'required|string',
            'precio'       => 'required|numeric',
            'stock'        => 'required|integer',
            'categoria_id' => 'required|exists:categoria,id', // INTEGRACIÓN: Validación en la actualización
            'imagen'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
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
        // Traemos los productos cargando su relación para mostrar la categoría en cada tarjeta
        $productos = Productos::with('categoria')->get();

        // CORRECCIÓN EXTRA: Traemos las categorías por si tu vista usa un menú lateral o filtros
        $categorias = Categoria::all();

        return view('clientes.tienda', compact('productos', 'categorias'));
    }

    /* ================= CARRITO ================= */
    public function agregarCarrito($id, $cantidad)
    {
        $producto = Productos::find($id);

        if (!$producto) {
            return back();
        }

        // VALIDACIÓN DE STOCK: Evita agregar más unidades de las disponibles en la base de datos
        if ($producto->stock < $cantidad) {
            return back()->with('error', 'Lo sentimos, solo quedan ' . $producto->stock . ' unidades de este artículo.');
        }

        $carrito = session()->get('carrito', []);

        if (isset($carrito[$id])) {
            // Si ya existe en el carrito, valida que la suma no supere las existencias actuales
            if (($carrito[$id]['cantidad'] + $cantidad) > $producto->stock) {
                return back()->with('error', 'No puedes agregar más unidades. Límite de existencias alcanzado (' . $producto->stock . ' u.).');
            }
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
            $carrito[$id]['clear'];
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

    /* ================= CONTROL DE CANTIDADES DINÁMICAS ================= */
    public function incrementarCarrito($id)
    {
        $producto = Productos::find($id);
        $carrito = session()->get('carrito', []);

        if (isset($carrito[$id])) {
            // VALIDACIÓN DE STOCK DINÁMICO: Bloquea incrementos desde la tabla del carrito si no hay stock
            if (($carrito[$id]['cantidad'] + 1) > $producto->stock) {
                return back()->with('error', 'No puedes añadir más unidades. Solo quedan ' . $producto->stock . ' unidades.');
            }

            $carrito[$id]['cantidad'] += 1;
            session()->put('carrito', $carrito);
        }

        return back();
    }

    public function disminuirCarrito($id)
    {
        $carrito = session()->get('carrito', []);

        if (isset($carrito[$id])) {
            if ($carrito[$id]['cantidad'] > 1) {
                $carrito[$id]['cantidad'] -= 1;
            } else {
                unset($carrito[$id]);
            }
            session()->put('carrito', $carrito);
        }

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

    /* ================= PROCESAR CHECKOUT CON SIMULADOR PROPIO (ANGLOW PAY) ================= */
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

        // VALIDACIÓN DE ÚLTIMO MOMENTO: Bloquea el proceso si alguien más compró las existencias en paralelo
        foreach ($carrito as $id => $item) {
            $prod = Productos::find($id);
            if (!$prod || $prod->stock < $item['cantidad']) {
                return redirect('/carrito')->with('error', 'El artículo ' . $item['nombre'] . ' ya no dispone de las unidades requeridas en bodega (' . ($prod->stock ?? 0) . ' u.). Reajusta tu orden.');
            }
        }

        $total = 0;
        foreach ($carrito as $item) {
            $total += $item['precio'] * $item['cantidad'];
        }

        // 1. Guardar el pedido inicial como 'pendiente' en la base de datos
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

        // Guardamos una instantánea del carrito vinculada al pedido para poder descontar el inventario al confirmarse el pago aprobado
        session()->put('carrito_pedido_' . $pedido->id, $carrito);

        // 2. Limpiar el carrito de la sesión de una vez
        session()->forget('carrito');

        // 3. Mandar al usuario directo a tu hermosa vista interactiva de pago
        return view('clientes.pasarela_simulada', compact('pedido'));
    }

    /* ================= SIMULAR PROCESAMIENTO DEL PAGO MULTI-ESTADO ================= */
    public function procesarPagoSimulado($id, $resultado)
    {
        // 1. Buscar el pedido que se acaba de crear
        $pedido = Pedido::findOrFail($id);

        // 2. Evaluar qué botón presionó el usuario en la vista interactiva
        if ($resultado === 'aprobado') {
            // Actualizar base de datos a aprobado
            $pedido->update(['estado_pago' => 'aprobado']);

            // DESCUENTO AUTOMÁTICO DE STOCK
            $snapshotCarrito = session()->get('carrito_pedido_' . $pedido->id, []);
            foreach ($snapshotCarrito as $productoId => $item) {
                $productoBD = Productos::find($productoId);
                if ($productoBD) {
                    // Restamos las unidades compradas directamente y prevenimos números negativos
                    $nuevoStock = max(0, $productoBD->stock - $item['cantidad']);
                    $productoBD->update(['stock' => $nuevoStock]);
                }
            }
            session()->forget('carrito_pedido_' . $pedido->id);

            // CAMBIO: 1. Generamos automáticamente la fila en la tabla de VENTAS
            $venta = Venta::create([
                'pedido_id'   => $pedido->id,
                'total'       => $pedido->total,
                'metodo_pago' => 'Simulador',
                'estado'      => 'completada'
            ]);

            // CAMBIO: 2. Registramos la factura usando el ID real de la VENTA recién creada
            Factura::create([
                'numero_factura' => 'ANG-' . str_pad($venta->id, 6, '0', STR_PAD_LEFT),
                'venta_id'       => $venta->id, // Ahora sí apunta a una venta real
                'cliente_nombre' => Auth::user()->name ?? 'Cliente General',
                'subtotal'       => $venta->total / 1.19,
                'impuesto'       => $venta->total - ($venta->total / 1.19),
                'total'          => $venta->total,
                'metodo_pago'    => $venta->metodo_pago,
                'estado'         => 'pagada'
            ]);

            // Mandar directo a tu vista de la factura final
            return view('clientes.factura', compact('pedido'))->with('success', '¡Pago procesado con éxito!');
        } elseif ($resultado === 'rechazado') {
            // Eliminamos la instantánea del carrito si la transacción falla
            session()->forget('carrito_pedido_' . $pedido->id);

            // Actualizar base de datos a rechazado
            $pedido->update(['estado_pago' => 'rechazado']);

            // Devolver al carrito explicando el error con un mensaje
            return redirect('/carrito')->with('error', 'El pago fue rechazado por la entidad bancaria. Intente con otra tarjeta.');
        } else {
            // Si es 'pendiente', actualizamos el estado
            $pedido->update(['estado_pago' => 'pendiente']);

            // Mandar a la factura avisando que está en verificación
            return view('clientes.factura', compact('pedido'))->with('info', 'Su pago está en proceso de verificación.');
        }
    }
}
