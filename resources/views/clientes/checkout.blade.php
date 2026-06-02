<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Checkout</title>

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>

<div class="container">

    <h1>Checkout</h1>

    @php
        $carrito = session('carrito', []);
        $total = 0;
    @endphp

    @if(empty($carrito))
        <p>No hay productos en el carrito</p>
    @else

        @foreach($carrito as $item)
            <div class="card">
                <h3>{{ $item['nombre'] }}</h3>
                <p>Cantidad: {{ $item['cantidad'] }}</p>
                <p>Precio: ${{ $item['precio'] }}</p>

                @php
                    $total += $item['precio'] * $item['cantidad'];
                @endphp
            </div>
        @endforeach

        <h2>Total: ${{ $total }}</h2>

        <button>Pagar</button>

    @endif

</div>

</body>
</html>