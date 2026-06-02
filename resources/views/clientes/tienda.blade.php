<!DOCTYPE html>
<html>
<head>
    <title>Tienda</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>

<div class="container">

    <h1>Tienda</h1>

    <div class="grid-productos">

        @foreach($productos as $producto)

            <div class="producto-card">

                <img src="https://unsplash.com/photos/a-pencil-with-a-yellow-tip-X08CpWnZtWY">

                <h3>{{ $producto->nombre }}</h3>

                <p>{{ $producto->descripcion }}</p>

                <p><strong>${{ $producto->precio }}</strong></p>

                <a href="/carrito/agregar/{{ $producto->id }}">
                    <button class="btn">Agregar al carrito</button>
                </a>

                <a href="/carrito">
                    <button class="btn">Ver carrito</button>
                </a>

                <a href="/checkout">
                    <button class="btn">Comprar</button>
                </a>

            </div>

        @endforeach

    </div>

</div>

</body>
</html>