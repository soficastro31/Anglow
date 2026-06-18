<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {

        // ✅ Registramos ambos alias dentro del mismo arreglo
        $middleware->alias([
            'solo_admin' => \App\Http\Middleware\SoloAdmin::class,
            'no_cache'   => \App\Http\Middleware\PreventBackHistory::class, // 🚀 NUEVO ALIAS AÑADIDO
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
