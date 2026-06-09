<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario - Anglow</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>

<nav>
    <div>
        <a href="/admin/usuarios"><strong>← Volver a Usuarios</strong></a>
    </div>
    <div>
        <span>👤 {{ Auth::user()->name }}</span>
    </div>
</nav>

<div class="container" style="margin-top: 30px; max-width: 600px;">
    
    <div style="margin-bottom: 25px;">
        <h1>Editar Usuario</h1>
        <p style="color: #6b7280;">Modifica los datos del usuario: {{ $usuario->name }}</p>
    </div>

    <div class="producto-card" style="padding: 30px; border: 1px solid #ddd;">
        <form action="/admin/usuarios/update/{{ $usuario->id }}" method="POST">
            @csrf
            
            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: bold;">Nombre</label>
                <input type="text" name="name" value="{{ $usuario->name }}" required 
                       style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: bold;">Correo Electrónico</label>
                <input type="email" name="email" value="{{ $usuario->email }}" required 
                       style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 5px; font-weight: bold;">Rol</label>
                <select name="rol" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
                    <option value="admin" {{ $usuario->rol == 'admin' ? 'selected' : '' }}>Administrador</option>
                    <option value="cliente" {{ $usuario->rol == 'cliente' ? 'selected' : '' }}>Cliente</option>
                </select>
            </div>

            <div style="display: flex; gap: 10px;">
                <button type="submit" class="primary" style="flex: 2; padding: 10px; border: none; cursor: pointer; border-radius: 5px;">
                    Guardar Cambios
                </button>
                <a href="/admin/usuarios" style="flex: 1; text-align: center; background: #ccc; color: #333; padding: 10px; text-decoration: none; border-radius: 5px;">
                    Cancelar
                </a>
            </div>
        </form>
    </div>

</div>

</body>
</html>