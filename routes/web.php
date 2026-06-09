<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProductosController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\CompraProveedorController;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\FacturaController;

/* ===================================================
   AUTENTICACIÓN (AUTH)
=================================================== */

Route::get('/login', [AuthController::class, 'form']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout']);
Route::get('/register', [AuthController::class, 'formRegister']);
Route::post('/register', [AuthController::class, 'register']);

/* ===================================================
   INICIO
=================================================== */
Route::get('/', function () {
    return view('inicio');
});

/* ===================================================
   TIENDA (CLIENTE)
=================================================== */
Route::get('/tienda', function () {
    if (!Auth::check()) {
        return redirect('/login');
    }
    return app(ProductosController::class)->tienda();
});

/* ===================================================
   ADMINISTRACIÓN (PANEL)
=================================================== */
Route::get('/admin', function () {
    if (!Auth::check() || Auth::user()->rol !== 'admin') {
        return redirect('/tienda');
    }
    return app(ProductosController::class)->index();
});

/* ===================================================
   PRODUCTOS (ADMIN CRUD)
=================================================== */
Route::get('/productos/gestion', [ProductosController::class, 'gestion'])->name('productos.gestion');
Route::get('/productos/create', [ProductosController::class, 'create'])->name('productos.create');
Route::post('/productos', [ProductosController::class, 'store'])->name('productos.store');
Route::get('/productos/edit/{id}', [ProductosController::class, 'edit'])->name('productos.edit');

// AQUÍ ESTÁ EL CAMBIO: Usamos 'put' para que coincida con @method('PUT') de tu formulario
Route::put('/productos/update/{id}', [ProductosController::class, 'update'])->name('productos.update');

Route::delete('/productos/{id}', [ProductosController::class, 'destroy'])->name('productos.destroy');

/* ===================================================
   CATEGORÍAS (ADMIN CRUD COMPLETO)
=================================================== */
Route::get('/admin/categorias', [CategoriaController::class, 'index'])->name('admin.categorias.index');
Route::get('/admin/categorias/create', [CategoriaController::class, 'create'])->name('admin.categorias.create');
Route::post('/admin/categorias', [CategoriaController::class, 'store'])->name('admin.categorias.store');
Route::get('/admin/categorias/edit/{id}', [CategoriaController::class, 'edit'])->name('admin.categorias.edit');
Route::put('/admin/categorias/update/{id}', [CategoriaController::class, 'update'])->name('admin.categorias.update');
Route::delete('/admin/categorias/{id}', [CategoriaController::class, 'destroy'])->name('admin.categorias.destroy');

/* ===================================================
   USUARIOS (ADMIN CRUD)
=================================================== */
Route::get('/admin/usuarios', [UserController::class, 'index'])->name('usuarios.index');
Route::get('/admin/usuarios/create', [UserController::class, 'create'])->name('usuarios.create');
Route::post('/admin/usuarios', [UserController::class, 'store'])->name('usuarios.store');
Route::get('/admin/usuarios/edit/{id}', [UserController::class, 'edit'])->name('usuarios.edit');
Route::post('/admin/usuarios/update/{id}', [UserController::class, 'update'])->name('usuarios.update');
Route::delete('/admin/usuarios/{id}', [UserController::class, 'destroy'])->name('usuarios.destroy');

/* ===================================================
   OTROS MÓDULOS ADMIN
=================================================== */
Route::get('/admin/clientes/{id}', [ClienteController::class, 'show'])->name('clientes.show');
Route::get('/admin/clientes', [ClienteController::class, 'index'])->name('clientes.index');

// GESTIÓN DE COMPRAS A PROVEEDORES
Route::get('/admin/compras', [CompraProveedorController::class, 'index'])->name('compras-proveedor.index');
Route::post('/admin/compras', [CompraProveedorController::class, 'store'])->name('compras-proveedor.store');
Route::post('/admin/compras/{id}/confirmar', [CompraProveedorController::class, 'confirmar'])->name('compras-proveedor.confirmar');

Route::get('/admin/inventario', [InventarioController::class, 'index'])->name('inventario.index');
Route::get('/admin/ventas', [VentaController::class, 'index'])->name('ventas.index');
Route::get('/admin/reportes', [ReporteController::class, 'index'])->name('reportes.index');

/* ===================================================
   MÓDULO DE FACTURACIÓN
=================================================== */
Route::get('/admin/facturacion', [FacturaController::class, 'index'])->name('facturacion.index');
Route::get('/admin/facturacion/{id}', [FacturaController::class, 'show'])->name('facturacion.show');

/* ===================================================
   CARRITO DE COMPRAS
=================================================== */
Route::get('/carrito', function () {
    return view('clientes.carrito');
});
Route::get('/carrito/agregar/{id}/{cantidad}', [ProductosController::class, 'agregarCarrito']);
Route::get('/carrito/eliminar/{id}', [ProductosController::class, 'eliminarDelCarrito']);
Route::get('/carrito/vaciar', [ProductosController::class, 'vaciarCarrito']);
Route::get('/carrito/incrementar/{id}', [ProductosController::class, 'incrementarCarrito'])->name('carrito.incrementar');
Route::get('/carrito/disminuir/{id}', [ProductosController::class, 'disminuirCarrito'])->name('carrito.disminuir');

/* ===================================================
   CHECKOUT & SIMULADOR DE PAGO
=================================================== */
Route::get('/checkout', function () {
    if (!Auth::check()) {
        return redirect('/login');
    }
    $carrito = session('carrito', []);
    if (empty($carrito)) {
        return redirect('/carrito');
    }
    return app(ProductosController::class)->checkout();
});

Route::post('/checkout/procesar', [ProductosController::class, 'procesarCheckout']);
Route::post('/checkout/simular-pago/{id}/{resultado}', [ProductosController::class, 'procesarPagoSimulado'])->name('checkout.simular-pago');
