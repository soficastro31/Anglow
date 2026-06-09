<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    /**
     * Muestra la lista de clientes registrados.
     * * @return \Illuminate\View\View
     */
    public function index()
    {
        // Usamos paginate(15) en lugar de get() para que, si tienes 1000 clientes,
        // la página no se vuelva lenta.
        $clientes = User::where('rol', 'cliente')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.clientes.index', compact('clientes'));
    }

    /**
     * Muestra la información detallada de un cliente.
     * * @param int $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        // Seguridad: Filtramos por ID y por rol. 
        // Si intentan acceder al ID de un administrador, lanzará un error 404.
        $cliente = User::where('rol', 'cliente')->findOrFail($id);

        return view('admin.clientes.show', compact('cliente'));
    }
}
