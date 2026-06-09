<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    /**
     * Muestra el listado de categorías.
     */
    public function index()
    {
        $categorias = Categoria::withCount('productos')->get();
        return view('admin.categorias.index', compact('categorias'));
    }

    /**
     * Muestra el formulario para crear una categoría.
     */
    public function create()
    {
        return view('admin.categorias.create');
    }

    /**
     * Guarda una nueva categoría en la base de datos.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre'      => 'required|string|max:255|unique:categoria,nombre',
            'descripcion' => 'nullable|string',
        ]);

        Categoria::create($request->all());

        return redirect()->route('admin.categorias.index')->with('success', 'Categoría creada con éxito.');
    }

    /**
     * Muestra el formulario para editar una categoría.
     */
    public function edit($id)
    {
        $categoria = Categoria::findOrFail($id);
        return view('admin.categorias.edit', compact('categoria'));
    }

    /**
     * Actualiza la categoría en la base de datos.
     */
    public function update(Request $request, $id)
    {
        $categoria = Categoria::findOrFail($id);

        $request->validate([
            'nombre'      => 'required|string|max:255|unique:categoria,nombre,' . $id,
            'descripcion' => 'nullable|string',
        ]);

        $categoria->update($request->all());

        return redirect()->route('admin.categorias.index')->with('success', 'Categoría actualizada con éxito.');
    }

    /**
     * Elimina una categoría del sistema.
     */
    public function destroy($id)
    {
        $categoria = Categoria::findOrFail($id);

        // Al borrar la categoría, los productos asociados pasarán a tener 'categoria_id = null'
        // gracias a la regla onDelete('set null') que pusimos en la migración.
        $categoria->delete();

        return redirect()->route('admin.categorias.index')->with('success', 'Categoría eliminada con éxito.');
    }
}
