<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Producto - Anglow</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>

<div class="form-container">
    <div class="form-card">
        <h1>Editar Producto</h1>

        <form method="POST" action="/productos/update/{{ $producto->id }}" enctype="multipart/form-data">
            @csrf

            <input type="text" name="nombre" value="{{ $producto->nombre }}" placeholder="Nombre" required>

            <textarea name="descripcion" placeholder="Descripción" required>{{ $producto->descripcion }}</textarea>

            <input type="number" step="0.01" name="precio" value="{{ $producto->precio }}" placeholder="Precio" required>

            <input type="number" name="stock" value="{{ $producto->stock }}" placeholder="Stock" required>

            <label style="display:block; margin-bottom:8px; color:#6b7280; font-size:14px; font-weight:500;">
                Cambiar Imagen (Dejar vacío para conservar la actual):
            </label>
            <input type="file" name="imagen" accept="image/*">

            <button type="submit" class="primary">Actualizar Producto</button>
        </form>
        
        <p style="text-align: center; margin-top: 15px;">
            <a href="/admin" style="color: #4f8cff; text-decoration: none;">Cancelar</a>
        </p>
    </div>
</div>

</body>
</html>