<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // Muestra la lista de usuarios
    public function index(Request $request)
    {
        $query = \App\Models\User::query();

        if ($request->filled('buscar')) {
            $buscar = $request->buscar;
            $query->where(function ($q) use ($buscar) {
                $q->where('name', 'LIKE', '%' . $buscar . '%')
                    ->orWhere('email', 'LIKE', '%' . $buscar . '%');
            });
        }

        $usuarios = $query->orderBy('name', 'asc')->get();

        return view('admin.usuarios.index', compact('usuarios'));
    }

    // ✅ METODO ADICIONADO: Muestra el formulario para crear un nuevo usuario
    public function create()
    {
        return view('admin.usuarios.create');
    }

    // Guarda un nuevo usuario
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'rol' => 'required'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'rol' => $request->rol ?? 'cliente',
        ]);

        return redirect('/admin/usuarios')->with('success', 'Usuario creado exitosamente');
    }

    // Muestra el formulario de edición
    public function edit($id)
    {
        $usuario = User::findOrFail($id);
        return view('admin.usuarios.edit', compact('usuario'));
    }

    // Actualiza los datos
    public function update(Request $request, $id)
    {
        $usuario = User::findOrFail($id);

        // Pasamos validación para evitar colisiones de emails repetidos al editar
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'rol' => 'required'
        ]);

        $usuario->update([
            'name'  => $request->name,
            'email' => $request->email,
            'rol'   => $request->rol,
        ]);

        return redirect('/admin/usuarios')->with('success', 'Usuario actualizado correctamente');
    }

    // Elimina un usuario
    public function destroy($id)
    {
        $usuario = User::findOrFail($id);
        $usuario->delete();
        return redirect('/admin/usuarios')->with('success', 'Usuario eliminado correctamente');
    }
}
