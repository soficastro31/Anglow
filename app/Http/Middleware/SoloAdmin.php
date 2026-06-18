<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SoloAdmin
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 🔒 Si el usuario no ha iniciado sesión, o su rol NO es 'admin'
        if (!Auth::check() || Auth::user()->rol !== 'admin') {

            // Lo regresamos al panel principal con un mensaje de error descacharrante
            return redirect('/admin')->with('error', 'No tienes permisos de Administrador para acceder a este módulo.');
        }

        return $next($request);
    }
}
