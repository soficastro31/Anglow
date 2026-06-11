<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    /**
     * Muestra la lista de clientes registrados con filtros de búsqueda.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // 1. Iniciamos la consulta apuntando al modelo User y filtrando solo los que son clientes
        $query = User::where('rol', 'cliente');

        // 2. Aplicamos el filtro si el administrador escribe en el buscador
        if ($request->filled('buscar')) {
            $buscar = $request->buscar;
            $query->where(function ($q) use ($buscar) {
                $q->where('name', 'LIKE', '%' . $buscar . '%')
                    ->orWhere('email', 'LIKE', '%' . $buscar . '%');
            });
        }

        // 3. Traemos los clientes del más reciente al más antiguo
        $clientes = $query->latest()->get();

        // 4. Retornamos la vista enviando la colección de clientes filtrados
        return view('admin.clientes.index', compact('clientes'));
    }

    /**
     * Muestra la información detallada de un cliente.
     *
     * @param int $id
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
