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