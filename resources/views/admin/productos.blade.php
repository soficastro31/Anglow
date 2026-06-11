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

    <form action="{{ url('/productos/gestion') }}" method="GET" style="background: #fff; padding: 20px; border-radius: 8px; margin-bottom: 25px; display: flex; flex-wrap: wrap; gap: 15px; align-items: flex-end; box-shadow: 0 2px 4px rgba(0,0,0,0.05); border: 1px solid #e5e7eb;">
        
        <div style="flex: 1; min-width: 200px; display: flex; flex-direction: column; gap: 6px;">
            <label style="font-weight: bold; font-size: 13px; color: #4b5563;">
                <i class="fa-solid fa-magnifying-glass"></i> Nombre del Producto:
            </label>
            <input type="text" name="buscar" value="{{ request('buscar') }}" placeholder="Buscar por nombre..." style="padding: 9px; border: 1px solid #cbd5e0; border-radius: 6px; font-size: 14px; width: 100%; box-sizing: border-box;">
        </div>

        <div style="flex: 1; min-width: 180px; display: flex; flex-direction: column; gap: 6px;">
            <label style="font-weight: bold; font-size: 13px; color: #4b5563;">
                <i class="fa-solid fa-folder"></i> Categoría:
            </label>
            <select name="categoria_id" style="padding: 9px; border: 1px solid #cbd5e0; border-radius: 6px; font-size: 14px; background: #fff; width: 100%; height: 38px; cursor: pointer;">
                <option value="">-- Todas --</option>
                @foreach($categorias as $cat)
                    <option value="{{ $cat->id }}" {{ request('categoria_id') == $cat->id ? 'selected' : '' }}>
                        {{ $cat->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        <div style="flex: 1; min-width: 180px; display: flex; flex-direction: column; gap: 6px;">
            <label style="font-weight: bold; font-size: 13px; color: #4b5563;">
                <i class="fa-solid fa-boxes-stacked"></i> Alerta de Stock:
            </label>
            <select name="estado_stock" style="padding: 9px; border: 1px solid #cbd5e0; border-radius: 6px; font-size: 14px; background: #fff; width: 100%; height: 38px; cursor: pointer;">
                <option value="">-- Todos los estados --</option>
                <option value="disponible" {{ request('estado_stock') == 'disponible' ? 'selected' : '' }}>🟢 Disponible (> 10 u.)</option>
                <option value="bajo" {{ request('estado_stock') == 'bajo' ? 'selected' : '' }}>🟡 Stock Bajo (≤ 10 u.)</option>
                <option value="agotado" {{ request('estado_stock') == 'agotado' ? 'selected' : '' }}>🔴 Agotado (0 u.)</option>
            </select>
        </div>

        <div style="display: flex; gap: 10px;">
            <button type="submit" style="background: #4f8cff; color: white; border: none; padding: 10px 20px; border-radius: 6px; font-weight: bold; cursor: pointer; font-size: 14px; display: inline-flex; align-items: center; gap: 8px; height: 38px;">
                <i class="fa-solid fa-filter"></i> Filtrar
            </button>
            
            @if(request('buscar') || request('categoria_id') || request('estado_stock'))
                <a href="{{ url('/productos/gestion') }}" style="background: #e5e7eb; color: #374151; padding: 0 15px; border-radius: 6px; text-decoration: none; font-weight: bold; font-size: 14px; display: inline-flex; align-items: center; height: 38px; border: 1px solid #d1d5db;">
                    Limpiar
                </a>
            @endif
        </div>
    </form>

    @if($productos->isEmpty())
        <div style="background: white; padding: 40px; border-radius: 8px; text-align: center; border: 1px solid #e5e7eb; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
            <p style="color: #6b7280; font-size: 16px; margin: 0;">No se encontraron artículos que coincidan con los criterios de búsqueda aplicados.</p>
        </div>
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
                    <p class="precio">${{ number_format($producto->precio, 2) }}</p>
                    
                    <p style="font-size: 13px; color: #6b7280; margin: 4px 0;">
                        <i class="fa-solid fa-tag" style="width: 16px;"></i> Cat: {{ $producto->categoria->nombre ?? 'N/A' }}
                    </p>

                    <p style="font-size: 13px; color: #6b7280; margin-bottom: 15px;">
                        <i class="fa-solid fa-boxes-stacked" style="width: 16px;"></i> Stock: 
                        @if($producto->stock == 0)
                            <span style="background: #f8d7da; color: #842029; padding: 2px 6px; border-radius: 4px; font-weight: bold; font-size: 12px;">Agotado (0 u.)</span>
                        @elseif($producto->stock <= 10)
                            <span style="background: #fff3cd; color: #664d03; padding: 2px 6px; border-radius: 4px; font-weight: bold; font-size: 12px;">Bajo Stock ({{ $producto->stock }} u.)</span>
                        @else
                            <span style="background: #d1e7dd; color: #0f5132; padding: 2px 6px; border-radius: 4px; font-weight: bold; font-size: 12px;">{{ $producto->stock }} u.</span>
                        @endif
                    </p>

                    <div class="acciones" style="display: flex; gap: 10px; margin-top: auto;">
                        <a href="/productos/edit/{{ $producto->id }}" class="btn editar" style="flex: 1; text-align: center; text-decoration: none; background: #ffb703; color: white; padding: 8px; border-radius: 6px; font-weight: 500;">
                            Editar
                        </a>

                        <form action="/productos/{{ $producto->id }}" method="POST"
                              onsubmit="return confirm('¿Seguro que quieres inhabilitar este producto?')"
                              style="flex: 1; padding: 0; background: none; box-shadow: none;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn eliminar" style="width: 100%; background: #e63946; color: white; padding: 8px; border-radius: 6px; margin: 0; border: none; cursor: pointer;">
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