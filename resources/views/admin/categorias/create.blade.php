<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva Categoría - Anglow</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        body { font-family: sans-serif; background: #f4f4f9; padding: 40px 20px; }
        .card { max-width: 500px; margin: 0 auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        h1 { margin-top: 0; color: #333; font-size: 24px; }
        input, textarea { width: 100%; padding: 12px; margin: 10px 0 20px 0; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; }
        button { background: #10b981; color: white; padding: 12px; border: none; border-radius: 4px; width: 100%; font-weight: bold; cursor: pointer; }
        .back-link { display: block; text-align: center; margin-top: 15px; color: #6b7280; text-decoration: none; }
    </style>
</head>
<body>

<div class="card">
    <h1>Nueva Categoría</h1>
    <form method="POST" action="{{ route('admin.categorias.store') }}">
        @csrf
        <label>Nombre de la Categoría</label>
        <input type="text" name="nombre" placeholder="Ej: Tecnología" required>
        
        <label>Descripción</label>
        <textarea name="descripcion" placeholder="Detalle breve..." rows="3"></textarea>
        
        <button type="submit">Guardar Categoría</button>
    </form>
    <a href="{{ route('admin.categorias.index') }}" class="back-link">Cancelar</a>
</div>

</body>
</html>