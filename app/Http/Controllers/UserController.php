<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // Muestra la lista de usuarios
    public function index()
    {
        $usuarios = User::all();
        return view('admin.usuarios.index', compact('usuarios'));
    }

    // Muestra el formulario de creación
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
