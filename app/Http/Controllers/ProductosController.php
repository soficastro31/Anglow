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
    /* ================= ADMIN (Muestra las 6 tarjetas con datos reales) ================= */
    public function index()
    {
        /* --------------------------------------------------------------------------
           REPARACIÓN TEMPORAL AUTOMÁTICA: Sincroniza ventas viejas en NULL con su user_id
           -------------------------------------------------------------------------- */
        $ventasHuerfanas = Venta::whereNull('user_id')->get();
        foreach ($ventasHuerfanas as $venta) {
            $pedidoOriginal = Pedido::find($venta->pedido_id);
            if ($pedidoOriginal && $pedidoOriginal->user_id) {
                $venta->update(['user_id' => $pedidoOriginal->user_id]);
            }
        }

        // 1. Total de ingresos acumulados (Suma de todas las ventas completadas)
        $totalVentas = Venta::where('estado', 'completada')->sum('total');

        // 2. Volumen total de transacciones exitosas
        $cantidadVentas = Venta::where('estado', 'completada')->count();

        // 3. Alertas de Inventario Crítico: Productos totalmente agotados
        $productosAgotados = Productos::where('stock', 0)->count();

        // 4. Alertas de Abastecimiento: Productos con stock bajo (entre 1 y 10 unidades)
        $productosCriticos = Productos::where('stock', '>', 0)->where('stock', '<=', 10)->count();

        // 5. Auditoría de Pasarela: Clientes con pago retenido o pendiente
        $pedidosPendientes = Pedido::where('estado_pago', 'pendiente')->count();

        // 6. Control de Excepciones: Transacciones rechazadas por el simulador bancario
        $pedidosRechazados = Pedido::where('estado_pago', 'rechazado')->count();

        // Retornamos la vista del panel inyectando de forma compacta todas las variables estadísticas
        return view('admin.index', compact(
            'totalVentas',
            'cantidadVentas',
            'productosAgotados',
            'productosCriticos',
            'pedidosPendientes',
            'pedidosRechazados'
        ));
    }

    /* ================= GESTIÓN INDEPENDIENTE CON FILTRO MULTICRITERIO ================= */
    public function gestion(Request $request)
    {
        // 1. Iniciamos la consulta base cargando la relación de la categoría para evitar N+1
        $query = Productos::with('categoria');

        // 2. CRITERIO 1: Filtro por texto libre (Nombre del producto)
        if ($request->filled('buscar')) {
            $query->where('nombre', 'LIKE', '%' . $request->buscar . '%');
        }

        // 3. CRITERIO 2: Filtro por menú desplegable (ID de Categoría)
        if ($request->filled('categoria_id')) {
            $query->where('categoria_id', $request->categoria_id);
        }

        // 4. CRITERIO 3: Filtro por Estado de Stock (Agotado / Bajo Stock / Disponible)
        if ($request->filled('estado_stock')) {
            if ($request->estado_stock == 'agotado') {
                $query->where('stock', 0);
            } elseif ($request->estado_stock == 'bajo') {
                $query->where('stock', '>', 0)->where('stock', '<=', 10);
            } elseif ($request->estado_stock == 'disponible') {
                $query->where('stock', '>', 10);
            }
        }

        // 5. Ejecutamos la consulta con todos los filtros acumulados
        $productos = $query->get();

        // 6. Traemos las categorías para armar el select del formulario en la vista
        $categorias = Categoria::all();

        return view('admin.productos', compact('productos', 'categorias'));
    }

    /* ================= CREAR ================= */
    public function create()
    {
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
            'categoria_id' => 'required|exists:categoria,id',
            'imagen'       => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $datos = $request->except('imagen');

        if ($request->hasFile('imagen')) {
            $rutaImagen = $request->file('imagen')->store('productos', 'public');
            $datos['imagen'] = $rutaImagen;
        }

        /* Enfoque de conciencia social: Control de inserción limpia */
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
            'categoria_id' => 'required|exists:categoria,id',
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

    /* ================= TIENDA (FILTROS DE CATÁLOGO) ================= */
    public function tienda(Request $request)
    {
        $query = Productos::with('categoria');

        if ($request->filled('buscar')) {
            $query->where('nombre', 'LIKE', '%' . $request->buscar . '%');
        }

        if ($request->filled('categoria_id')) {
            $query->where('categoria_id', $request->categoria_id);
        }

        $productos = $query->get();
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

        if ($producto->stock < $cantidad) {
            return back()->with('error', 'Lo sentimos, solo quedan ' . $producto->stock . ' unidades de este artículo.');
        }

        $carrito = session()->get('carrito', []);

        if (isset($carrito[$id])) {
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

    /* ================= PROCESAR CHECKOUT ================= */
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

        // 1. Guardar el pedido inicial como 'pendiente'
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

        session()->put('carrito_pedido_' . $pedido->id, $carrito);

        return view('clientes.pasarela_simulada', compact('pedido'));
    }

    /* ================= SIMULAR PROCESAMIENTO DEL PAGO MULTI-ESTADO ================= */
    public function procesarPagoSimulado($id, $resultado)
    {
        $pedido = Pedido::findOrFail($id);

        if ($resultado === 'aprobado') {
            $pedido->update(['estado_pago' => 'aprobado']);

            // DESCUENTO AUTOMÁTICO DE STOCK EN BODEGA
            $snapshotCarrito = session()->get('carrito_pedido_' . $pedido->id, []);
            foreach ($snapshotCarrito as $productoId => $item) {
                $productoBD = Productos::find($productoId);
                if ($productoBD) {
                    $nuevoStock = max(0, $productoBD->stock - $item['cantidad']);
                    $productoBD->update(['stock' => $nuevoStock]);
                }
            }

            session()->forget('carrito_pedido_' . $pedido->id);
            session()->forget('carrito');

            // Generamos el registro contable en VENTAS (CONEXIÓN DE USER_ID REPARADA DEFINITIVAMENTE)
            $venta = Venta::create([
                'pedido_id'   => $pedido->id,
                'user_id'     => $pedido->user_id, // ← Solución definitiva: Vincula el comprador directo a la venta
                'total'       => $pedido->total,
                'metodo_pago' => 'Simulador',
                'estado'      => 'completada'
            ]);

            // Registramos la factura legal
            Factura::create([
                'numero_factura' => 'ANG-' . str_pad($venta->id, 6, '0', STR_PAD_LEFT),
                'venta_id'       => $venta->id,
                'cliente_nombre' => Auth::user()->name ?? 'Cliente General',
                'subtotal'       => $venta->total / 1.19,
                'impuesto'       => $venta->total - ($venta->total / 1.19),
                'total'          => $venta->total,
                'metodo_pago'    => $venta->metodo_pago,
                'estado'         => 'pagada'
            ]);

            return view('clientes.factura', compact('pedido'))->with('success', '¡Pago procesado con éxito!');
        } elseif ($resultado === 'rechazado') {
            $snapshotCarrito = session()->get('carrito_pedido_' . $pedido->id, []);
            if (!empty($snapshotCarrito)) {
                session()->put('carrito', $snapshotCarrito);
            }

            session()->forget('carrito_pedido_' . $pedido->id);
            $pedido->update(['estado_pago' => 'rechazado']);

            return redirect('/carrito')->with('error', 'El pago fue rechazado por la entidad bancaria. Intente con otra tarjeta.');
        } else {
            $pedido->update(['estado_pago' => 'pendiente']);

            session()->forget('carrito_pedido_' . $pedido->id);
            session()->forget('carrito');

            return view('clientes.factura', compact('pedido'))->with('info', 'Su pago está en proceso de verificación.');
        }
    }

    /* ================= AUDITORÍA DE PEDIDOS (ADMIN) ================= */
    public function adminPedidos(Request $request)
    {
        $query = Pedido::with('user');

        if ($request->filled('buscar')) {
            $buscar = $request->buscar;
            $query->where(function ($q) use ($buscar) {
                $q->where('telefono', 'LIKE', '%' . $buscar . '%')
                    ->orWhere('ciudad_departamento', 'LIKE', '%' . $buscar . '%')
                    ->orWhereHas('user', function ($userQuery) use ($buscar) {
                        $userQuery->where('name', 'LIKE', '%' . $buscar . '%');
                    });
            });
        }

        if ($request->filled('estado_pago')) {
            $query->where('estado_pago', $request->estado_pago);
        }

        $pedidos = $query->orderBy('created_at', 'desc')->get();

        return view('admin.pedidos', compact('pedidos'));
    }
}
