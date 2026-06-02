<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProductosController;
use App\Http\Controllers\AuthController;

/* =========================
   AUTH
========================= */
Route::get('/login', [AuthController::class, 'form']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout']);

Route::get('/register', [AuthController::class, 'formRegister']);
Route::post('/register', [AuthController::class, 'register']);

/* =========================
   INICIO
========================= */
Route::get('/', function () {
    return view('inicio');
});

/* =========================
   TIENDA (CLIENTE)
========================= */
Route::get('/tienda', function () {

    if (!Auth::check()) {
        return redirect('/login');
    }

    return app(ProductosController::class)->tienda();
});

/* =========================
   ADMIN
========================= */
Route::get('/admin', function () {

    if (!Auth::check() || Auth::user()->rol !== 'admin') {
        return redirect('/tienda');
    }

    return app(ProductosController::class)->index();
});

/* =========================
   PRODUCTOS (ADMIN CRUD)
========================= */
Route::get('/productos/create', [ProductosController::class, 'create']);
Route::post('/productos', [ProductosController::class, 'store']);

Route::get('/productos/edit/{id}', [ProductosController::class, 'edit']);
Route::post('/productos/update/{id}', [ProductosController::class, 'update']);

/* ⚠ IMPORTANTE: DELETE MEJOR ASÍ (NO GET) */
Route::delete('/productos/{id}', [ProductosController::class, 'destroy']);

/* =========================
   CARRITO
========================= */
Route::get('/carrito', function () {
    return view('clientes.carrito');
});

Route::get('/carrito/agregar/{id}', [ProductosController::class, 'agregarCarrito']);
Route::get('/carrito/eliminar/{id}', [ProductosController::class, 'eliminarDelCarrito']);
Route::get('/carrito/vaciar', [ProductosController::class, 'vaciarCarrito']);

/* =========================
   CHECKOUT
========================= */
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