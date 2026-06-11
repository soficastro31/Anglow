<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Usuarios - Anglow</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

<nav>
    <div>
        <a href="/admin">
            <strong>← Volver al Panel Admin</strong>
        </a>
    </div>
    <div>
        <span style="margin-right:15px;">👤 {{ Auth::user()->name }}</span>
    </div>
</nav>

<div class="container" style="margin-top: 30px;">
    
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
        <div>
            <h1>Módulo de Usuarios</h1>
            <p style="color: #6b7280;">Administra los usuarios registrados en el sistema.</p>
        </div>
        <a href="/admin/usuarios/create" class="btn crear" style="text-decoration: none; padding: 10px 20px; background: #4f8cff; color: white; border-radius: 8px; font-weight: bold;">
            + Crear Usuario
        </a>
    </div>
    <div style="background: white; padding: 15px; border-radius: 6px; border: 1px solid #e5e7eb; margin-bottom: 20px;">
    <form action="{{ url('/admin/usuarios') }}" method="GET" style="display: flex; gap: 15px; align-items: flex-end;">
        <div style="flex: 1; display: flex; flex-direction: column; gap: 5px;">
            <label style="font-weight: bold; font-size: 13px; color: #4b5563;">Buscar Usuario:</label>
            <input type="text" name="buscar" value="{{ request('buscar') }}" placeholder="Nombre o correo electrónico..." style="padding: 8px; border: 1px solid #cbd5e0; border-radius: 6px; height: 38px;">
        </div>
        <div style="display: flex; gap: 10px;">
            <button type="submit" style="background: #2ec4b6; color: white; border: none; padding: 0 15px; border-radius: 6px; font-weight: bold; height: 38px; cursor: pointer;">Buscar</button>
            @if(request('buscar'))
                <a href="{{ url('/admin/usuarios') }}" style="background: #e5e7eb; color: #374151; padding: 0 15px; border-radius: 6px; text-decoration: none; font-weight: bold; font-size: 14px; display: inline-flex; align-items: center; height: 38px; border: 1px solid #d1d5db;">Limpiar</a>
            @endif
        </div>
    </form>
</div>

    @if(session('success'))
        <p style="color: green; font-weight: bold; margin-bottom: 15px;">{{ session('success') }}</p>
    @endif

    <div class="grid-productos">
        @foreach($usuarios as $usuario)
            <div class="producto-card" style="display: flex; flex-direction: column; align-items: center;">
                
                <div style="font-size: 50px; color: #4f8cff; margin: 20px 0;">
                    <i class="fa-solid fa-user-circle"></i>
                </div>

                <div class="info" style="width: 100%; text-align: center;">
                    <h3>{{ $usuario->name }}</h3>
                    <p class="desc" style="margin-bottom: 5px;">{{ $usuario->email }}</p>
                    <p style="font-size: 13px; color: #6b7280; margin-bottom: 15px;">Rol: {{ $usuario->rol }}</p>

                    <div class="acciones" style="display: flex; gap: 10px; margin-top: auto;">
                        <a href="/admin/usuarios/edit/{{ $usuario->id }}" class="btn editar" style="flex: 1; text-align: center; text-decoration: none; background: #ffb703; color: white; padding: 8px; border-radius: 6px; font-weight: 500;">
                            Editar
                        </a>

                        <form action="/admin/usuarios/{{ $usuario->id }}" method="POST"
                              onsubmit="return confirm('¿Seguro que quieres eliminar este usuario?')"
                              style="flex: 1; padding: 0; background: none; box-shadow: none;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn eliminar" style="width: 100%; background: #e63946; color: white; padding: 8px; border-radius: 6px; margin: 0; border: none; cursor: pointer;">
                                Eliminar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

</div>

</body>
</html>