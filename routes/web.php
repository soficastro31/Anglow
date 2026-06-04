<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProductosController;
use App\Http\Controllers\AuthController;

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
   ADMINISTRACIÓN (PANEL DE LAS 6 TARJETAS)
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
Route::get('/productos/gestion', [ProductosController::class, 'gestion']);
Route::get('/productos/create', [ProductosController::class, 'create']);
Route::post('/productos', [ProductosController::class, 'store']);
Route::get('/productos/edit/{id}', [ProductosController::class, 'edit']);
Route::post('/productos/update/{id}', [ProductosController::class, 'update']);
Route::delete('/productos/{id}', [ProductosController::class, 'destroy']);

/* ===================================================
   CARRITO DE COMPRAS
=================================================== */
Route::get('/carrito', function () {
    return view('clientes.carrito');
});
Route::get('/carrito/agregar/{id}/{cantidad}', [ProductosController::class, 'agregarCarrito']);
Route::get('/carrito/eliminar/{id}', [ProductosController::class, 'eliminarDelCarrito']);
Route::get('/carrito/vaciar', [ProductosController::class, 'vaciarCarrito']);

/* ===================================================
   CHECKOUT & FLUJO DE PAGO (INTEGRADO Y SEGURO)
=================================================== */

// 1. Muestra el formulario de envío y el resumen del pedido
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

// 2. Procesa los datos del formulario de envío y crea el Pedido en la BD
Route::post('/checkout/procesar', [ProductosController::class, 'procesarCheckout']);

// 3. Muestra la pantalla de la pasarela simulada para el pedido específico
Route::get('/checkout/pasarela/{id}', [ProductosController::class, 'vistaPasarela'])->name('checkout.pasarela');

// 4. Confirma el pago exitoso (POST por seguridad), cambia estado a 'aprobado' y limpia carrito
Route::post('/checkout/simular-pago/{id}', [ProductosController::class, 'pagar'])->name('checkout.simular-pago');

// 5. Muestra la factura o recibo final de compra exitosa
Route::get('/checkout/confirmacion/{id}', [ProductosController::class, 'mostrarFactura'])->name('checkout.factura');