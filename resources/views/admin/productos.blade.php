<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Productos - Anglow</title>
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
            <h1>Módulo de Productos</h1>
            <p style="color: #6b7280;">Administra el catálogo activo de la tienda.</p>
        </div>
        <a href="/productos/create" class="btn crear" style="text-decoration: none; padding: 10px 20px; background: #4f8cff; color: white; border-radius: 8px; font-weight: bold;">
            + Crear producto
        </a>
    </div>

    @if(session('success'))
        <p style="color: green; font-weight: bold; margin-bottom: 15px;">{{ session('success') }}</p>
    @endif

    <div class="grid-productos">
        @foreach($productos as $producto)
            <div class="producto-card">
                
                <img src="{{ asset('storage/' . $producto->imagen) }}" 
                     alt="{{ $producto->nombre }}"
                     onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1513542789411-b6a5d4f31634?w=500';">

                <div class="info">
                    <h3>{{ $producto->nombre }}</h3>
                    <p class="desc">{{ $producto->descripcion }}</p>
                    <p class="precio">${{ $producto->precio }}</p>
                    <p style="font-size: 13px; color: #6b7280; margin-bottom: 15px;">Stock: {{ $producto->stock }} u.</p>

                    <div class="acciones" style="display: flex; gap: 10px; margin-top: auto;">
                        <a href="/productos/edit/{{ $producto->id }}" class="btn editar" style="flex: 1; text-align: center; text-decoration: none; background: #ffb703; color: white; padding: 8px; border-radius: 6px; font-weight: 500;">
                            Editar
                        </a>

                        <form action="/productos/{{ $producto->id }}" method="POST"
                              onsubmit="return confirm('¿Seguro que quieres eliminar este producto?')"
                              style="flex: 1; padding: 0; background: none; box-shadow: none;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn eliminar" style="width: 100%; background: #e63946; color: white; padding: 8px; border-radius: 6px; margin: 0;">
                                Inhabilitar
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