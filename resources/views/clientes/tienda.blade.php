<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Unos pequeños estilos rápidos para las alertas y badges si no los tienes en tu app.css */
        .alert-error { background-color: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px; margin-bottom: 20px; border: 1px solid #f5c6cb; }
        .badge-categoria { background-color: #e2e8f0; color: #4a5568; padding: 4px 8px; border-radius: 4px; font-size: 0.85rem; display: inline-block; margin-bottom: 8px; }
        .stock-disponible { font-size: 0.9rem; color: #2d3748; margin: 8px 0; }
        .stock-agotado { color: #e53e3e; font-weight: bold; font-size: 0.9rem; margin: 8px 0; }
        
        /* Contenedor del formulario de filtros */
        .filtros-container {
            background: #fff; 
            padding: 20px; 
            border-radius: 8px; 
            margin-bottom: 30px; 
            display: flex; 
            flex-wrap: wrap; 
            gap: 15px; 
            align-items: flex-end; 
            border: 1px solid #e5e7eb;
        }
        .filtro-grupo {
            flex: 1; 
            min-width: 200px; 
            display: flex; 
            flex-direction: column; 
            gap: 6px;
        }
        .filtro-label {
            font-weight: bold; 
            font-size: 13px; 
            color: #4b5563;
        }
        .filtro-input, .filtro-select {
            padding: 10px; 
            border: 1px solid #cbd5e0; 
            border-radius: 6px; 
            font-size: 14px; 
            width: 100%; 
            box-sizing: border-box;
            background: #fff;
        }
        .filtro-select {
            height: 40px;
            cursor: pointer;
        }
        .btn-filtrar {
            background: #2ec4b6; 
            color: white; 
            border: none; 
            padding: 11px 22px; 
            border-radius: 6px; 
            font-weight: bold; 
            cursor: pointer; 
            font-size: 14px; 
            height: 40px;
        }
        .btn-limpiar {
            background: #e5e7eb; 
            color: #374151; 
            padding: 0 15px; 
            border-radius: 6px; 
            text-decoration: none; 
            font-weight: bold; 
            font-size: 14px; 
            display: inline-flex; 
            align-items: center; 
            height: 40px; 
            border: 1px solid #d1d5db;
        }
    </style>
</head>

<body>

<nav>
    <div>
        <a href="/tienda">
            <strong>Anglow</strong>
        </a>
    </div>

    <div>
        <a href="/carrito">
            🛒 Carrito ({{ count(session('carrito', [])) }})
        </a>

        <span style="margin-left:15px;">
            👤 {{ Auth::user()->name }}
        </span>

        <a href="/logout" style="margin-left:15px;">
            Cerrar sesión
        </a>
    </div>
</nav>

<div class="container">

    <h1>Tienda</h1>

    @if(session('error'))
        <div class="alert-error">
            ⚠️ {{ session('error') }}
        </div>
    @endif

    <form action="{{ url('/tienda') }}" method="GET" class="filtros-container">
        
        <div class="filtro-grupo" style="flex: 2;">
            <label class="filtro-label">
                <i class="fa-solid fa-magnifying-glass"></i> ¿Qué estás buscando?
            </label>
            <input type="text" name="buscar" value="{{ request('buscar') }}" placeholder="Buscar por nombre..." class="filtro-input">
        </div>

        <div class="filtro-grupo">
            <label class="filtro-label">
                <i class="fa-solid fa-tags"></i> Categoría:
            </label>
            <select name="categoria_id" class="filtro-select">
                <option value="">-- Todas las categorías --</option>
                @foreach($categorias as $cat)
                    <option value="{{ $cat->id }}" {{ request('categoria_id') == $cat->id ? 'selected' : '' }}>
                        {{ $cat->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        <div style="display: flex; gap: 10px;">
            <button type="submit" class="btn-filtrar">Buscar</button>
            @if(request('buscar') || request('categoria_id'))
                <a href="{{ url('/tienda') }}" class="btn-limpiar">Limpiar</a>
            @endif
        </div>
    </form>

    @if($productos->isEmpty())
        <div style="background: white; padding: 40px; border-radius: 8px; text-align: center; border: 1px solid #e5e7eb; margin-bottom: 30px;">
            <p style="color: #6b7280; font-size: 16px; margin: 0;">No hay productos disponibles que coincidan con los filtros aplicados.</p>
        </div>
    @endif

    <div class="grid-productos">

        @foreach($productos as $producto)

        <div class="producto-card">

            <img 
                src="{{ asset('storage/' . $producto->imagen) }}" 
                alt="{{ $producto->nombre }}"
                onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1513542789411-b6a5d4f31634?w=500';">

            <div class="info">
                
                <span class="badge-categoria">
                    📁 {{ $producto->categoria->nombre ?? 'Sin Categoría' }}
                </span>

                <h3>{{ $producto->nombre }}</h3>

                <p class="desc">
                    {{ $producto->descripcion }}
                </p>

                <p class="precio">
                    ${{ number_format($producto->precio, 2) }}
                </p>

                @if($producto->stock > 0)
                    <p class="stock-disponible">
                        Disponibles: <strong>{{ $producto->stock }} u.</strong>
                    </p>
                    
                    <div class="cantidad">
                        <button type="button" onclick="restar({{ $producto->id }})">-</button>
                        <span id="valor{{ $producto->id }}">1</span>
                        <button type="button" onclick="sumar({{ $producto->id }}, {{ $producto->stock }})">+</button>
                    </div>

                    <a id="btn{{ $producto->id }}" href="/carrito/agregar/{{ $producto->id }}/1">
                        <button class="primary">
                            Agregar al carrito
                        </button>
                    </a>
                @else
                    <p class="stock-agotado">❌ Agotado temporalmente</p>
                    <button class="primary" disabled style="opacity: 0.5; cursor: not-allowed;">
                        Sin Existencias
                    </button>
                @endif

            </div>

        </div>

        @endforeach

    </div>

</div>

<script>
// El script conserva de forma idéntica tu lógica de control dinámico por ID
function sumar(id, stockMaximo) {
    let cantidad = document.getElementById('valor' + id);
    let valor = parseInt(cantidad.innerText);
    
    if (valor < stockMaximo) {
        valor++;
        cantidad.innerText = valor;
        document.getElementById('btn' + id).href = '/carrito/agregar/' + id + '/' + valor;
    } else {
        alert('No puedes agregar más de las ' + stockMaximo + ' unidades disponibles en bodega.');
    }
}

function restar(id) {
    let cantidad = document.getElementById('valor' + id);
    let valor = parseInt(cantidad.innerText);
    if(valor > 1) {
        valor--;
        cantidad.innerText = valor;
        document.getElementById('btn' + id).href = '/carrito/agregar/' + id + '/' + valor;
    }
}
</script>

</body>
</html>