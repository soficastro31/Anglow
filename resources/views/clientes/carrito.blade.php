<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Carrito</title>

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>

<div class="container">

    <h1>Tu carrito</h1>

    @php
        $carrito = session('carrito', []);
        $total = 0;
    @endphp

    @if(empty($carrito))
        <p>No tienes productos en el carrito</p>
    @else

        @foreach($carrito as $id => $item)

            <div class="card">
                <h3>{{ $item['nombre'] }}</h3>

                <p>Cantidad: {{ $item['cantidad'] }}</p>
                <p>Precio: ${{ $item['precio'] }}</p>

                <p>
                    Subtotal:
                    ${{ $item['precio'] * $item['cantidad'] }}
                </p>

                <a href="/carrito/eliminar/{{ $id }}">
                    <button>Eliminar</button>
                </a>

                @php
                    $total += $item['precio'] * $item['cantidad'];
                @endphp
            </div>

        @endforeach

        <h2>Total: ${{ $total }}</h2>

        <a href="/checkout">
            <button>Ir a pagar</button>
        </a>

        <a href="/carrito/vaciar">
            <button style="background:red;">Vaciar carrito</button>
        </a>

    @endif

</div>

</body>
</html>