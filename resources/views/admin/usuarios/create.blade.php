<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Usuario - Anglow</title>
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
        <h1>Nuevo Usuario</h1>
        <p style="color: #6b7280;">Completa los datos para registrar un nuevo usuario en el sistema.</p>
    </div>

    <div class="producto-card" style="padding: 30px; border: 1px solid #ddd;">
        <form action="/admin/usuarios" method="POST">
            @csrf
            
            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: bold;">Nombre Completo</label>
                <input type="text" name="name" required placeholder="Ej: Juan Pérez"
                       style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: bold;">Correo Electrónico</label>
                <input type="email" name="email" required placeholder="Ej: juan@ejemplo.com"
                       style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: bold;">Contraseña</label>
                <input type="password" name="password" required placeholder="********"
                       style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 5px; font-weight: bold;">Rol</label>
                <select name="rol" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
                    <option value="cliente">Cliente</option>
                    <option value="admin">Administrador</option>
                </select>
            </div>

            <div style="display: flex; gap: 10px;">
                <button type="submit" class="primary" style="flex: 2; padding: 10px; border: none; cursor: pointer; border-radius: 5px;">
                    Guardar Usuario
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