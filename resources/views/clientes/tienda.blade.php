<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        /* Unos pequeños estilos rápidos para las alertas y badges si no los tienes en tu app.css */
        .alert-error { background-color: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px; margin-bottom: 20px; border: 1px solid #f5c6cb; }
        .badge-categoria { background-color: #e2e8f0; color: #4a5568; padding: 4px 8px; border-radius: 4px; font-size: 0.85rem; display: inline-block; margin-bottom: 8px; }
        .stock-disponible { font-size: 0.9rem; color: #2d3748; margin: 8px 0; }
        .stock-agotado { color: #e53e3e; font-weight: bold; font-size: 0.9rem; margin: 8px 0; }
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

        <a href="/logout">
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
                    ${{ $producto->precio }}
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
// El script ahora recibe el límite máximo de stock de la base de datos
function sumar(id, stockMaximo) {
    let cantidad = document.getElementById('valor' + id);
    let valor = parseInt(cantidad.innerText);
    
    // FRENO DE SEGURIDAD: No permite al cliente subir el contador visual más allá del stock real
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