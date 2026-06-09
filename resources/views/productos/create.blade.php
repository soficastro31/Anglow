<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Producto - Anglow</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>

<div class="form-container">
    <div class="form-card">
        <h1>Nuevo Producto</h1>

        <form method="POST" action="/productos" enctype="multipart/form-data">
            @csrf

            <input type="text" name="nombre" placeholder="Nombre del Producto" required>

            <div style="margin-bottom: 15px; text-align: left;">
                <label for="categoria_id" style="display:block; margin-bottom:8px; color:#3d4a64; font-size:14px; font-weight:500;">
                    Categoría de la Miscelánea:
                </label>
                <select name="categoria_id" id="categoria_id" required 
                        style="width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; font-size: 14px; color: #333; background-color: #fff;">
                    <option value="" disabled selected>-- Elige una categoría --</option>
                    @foreach($categorias as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <textarea name="descripcion" placeholder="Descripción del producto..." required></textarea>

            <input type="number" step="0.01" name="precio" placeholder="Precio (Ej: 6000.00)" required>

            <input type="number" name="stock" placeholder="Cantidad en Stock (Ej: 10)" required>

            <label style="display:block; margin-bottom:8px; color:#3d4a64; font-size:14px; font-weight:500;">
                Imagen del Producto:
            </label>
            <input type="file" name="imagen" accept="image/*" required>

            <button type="submit">Guardar Producto</button>
        </form>
        
        <p style="text-align: center; margin-top: 15px;">
            <a href="/admin" style="color: #4f8cff; text-decoration: none;">Volver al Panel</a>
        </p>
    </div>
</div>

</body>
</html>