<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
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

    <div class="grid-productos">

        @foreach($productos as $producto)

        <div class="producto-card">

            <img 
                src="{{ asset('storage/' . $producto->imagen) }}" 
                alt="{{ $producto->nombre }}"
                onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1513542789411-b6a5d4f31634?w=500';">

            <div class="info">

                <h3>{{ $producto->nombre }}</h3>

                <p class="desc">
                    {{ $producto->descripcion }}
                </p>

                <p class="precio">
                    ${{ $producto->precio }}
                </p>

                <div class="cantidad">
                    <button type="button" onclick="restar({{ $producto->id }})">-</button>
                    <span id="valor{{ $producto->id }}">1</span>
                    <button type="button" onclick="sumar({{ $producto->id }})">+</button>
                </div>

                <a id="btn{{ $producto->id }}" href="/carrito/agregar/{{ $producto->id }}/1">
                    <button class="primary">
                        Agregar al carrito
                    </button>
                </a>

            </div>

        </div>

        @endforeach

    </div>

</div>

<script>
function sumar(id) {
    let cantidad = document.getElementById('valor' + id);
    let valor = parseInt(cantidad.innerText);
    valor++;
    cantidad.innerText = valor;
    document.getElementById('btn' + id).href = '/carrito/agregar/' + id + '/' + valor;
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