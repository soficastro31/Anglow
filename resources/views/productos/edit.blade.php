<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Producto - Anglow</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        .form-container { max-width: 500px; margin: 50px auto; padding: 20px; }
        .form-card { background: white; padding: 30px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        input, textarea, select { width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        button { width: 100%; padding: 12px; background: #4f8cff; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: bold; }
    </style>
</head>
<body>

<div class="form-container">
    <div class="form-card">
        <h1>Editar Producto</h1>

        <form method="POST" action="{{ route('productos.update', $producto->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT') {{-- ESTO ES LO QUE HACÍA QUE NO GUARDARA --}}

            <label>Nombre:</label>
            <input type="text" name="nombre" value="{{ $producto->nombre }}" required>

            <label>Categoría:</label>
            <select name="categoria_id" required>
                @foreach($categorias as $cat)
                    <option value="{{ $cat->id }}" {{ $producto->categoria_id == $cat->id ? 'selected' : '' }}>
                        {{ $cat->nombre }}
                    </option>
                @endforeach
            </select>

            <label>Descripción:</label>
            <textarea name="descripcion" required>{{ $producto->descripcion }}</textarea>

            <label>Precio:</label>
            <input type="number" step="0.01" name="precio" value="{{ $producto->precio }}" required>

            <label>Stock:</label>
            <input type="number" name="stock" value="{{ $producto->stock }}" required>

            <label>Imagen (Opcional):</label>
            <input type="file" name="imagen" accept="image/*">

            <button type="submit">Actualizar Producto</button>
        </form>
        
        <p style="text-align: center; margin-top: 15px;">
            <a href="/productos/gestion" style="color: #6b7280;">Cancelar</a>
        </p>
    </div>
</div>

</body>
</html>