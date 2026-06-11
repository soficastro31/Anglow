<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Clientes - Anglow</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Cuadrícula para clientes */
        .clientes-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
            padding: 20px 0;
        }
        .cliente-card {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            border: 1px solid #e5e7eb;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }
    </style>
</head>
<body>

<nav>
    <div>
        <a href="/admin" style="text-decoration: none; font-weight: bold; color: #4f8cff;">
            ← Volver al Panel Admin
        </a>
    </div>
    <div>
        <span style="margin-right:15px;">👤 {{ Auth::user()->name }}</span>
    </div>
</nav>

<div class="container" style="margin-top: 30px; max-width: 1200px; margin-left: auto; margin-right: auto; padding: 0 20px;">
    
    <div style="margin-bottom: 25px;">
        <h1>Módulo de Clientes</h1>
        <p style="color: #6b7280;">Listado de clientes registrados en la plataforma.</p>
    </div>
<div style="background: white; padding: 15px; border-radius: 6px; border: 1px solid #e5e7eb; margin-bottom: 20px;">
    <form action="{{ url('/admin/clientes') }}" method="GET" style="display: flex; gap: 15px; align-items: flex-end;">
        <div style="flex: 1; display: flex; flex-direction: column; gap: 5px;">
            <label style="font-weight: bold; font-size: 13px; color: #4b5563;">Buscar Cliente:</label>
            <input type="text" name="buscar" value="{{ request('buscar') }}" placeholder="Nombre, identificación o teléfono..." style="padding: 8px; border: 1px solid #cbd5e0; border-radius: 6px; height: 38px;">
        </div>
        <div style="display: flex; gap: 10px;">
            <button type="submit" style="background: #2ec4b6; color: white; border: none; padding: 0 15px; border-radius: 6px; font-weight: bold; height: 38px; cursor: pointer;">Buscar</button>
            @if(request('buscar'))
                <a href="{{ url('/admin/clientes') }}" style="background: #e5e7eb; color: #374151; padding: 0 15px; border-radius: 6px; text-decoration: none; font-weight: bold; font-size: 14px; display: inline-flex; align-items: center; height: 38px; border: 1px solid #d1d5db;">Limpiar</a>
            @endif
        </div>
    </form>
</div>
    @if(session('success'))
        <p style="color: green; font-weight: bold; margin-bottom: 15px;">{{ session('success') }}</p>
    @endif

    {{-- Usamos la clase clientes-grid en lugar de grid-productos --}}
    <div class="clientes-grid">
        @foreach($clientes as $cliente)
            <div class="cliente-card">
                
                <div style="font-size: 50px; color: #2a9d8f; margin: 20px 0;">
                    <i class="fa-solid fa-address-book"></i>
                </div>

                <div class="info" style="width: 100%;">
                    <h3 style="margin: 0 0 5px 0;">{{ $cliente->name }}</h3>
                    <p style="color: #6b7280; margin-bottom: 20px; font-size: 14px;">{{ $cliente->email }}</p>
                    
                    <a href="/admin/clientes/{{ $cliente->id }}" 
                       style="display: block; text-decoration: none; background: #4f8cff; color: white; padding: 10px; border-radius: 6px; font-weight: 500;">
                        Ver Perfil
                    </a>
                </div>
            </div>
        @endforeach
    </div>

</div>

</body>
</html>