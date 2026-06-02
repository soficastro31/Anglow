<!DOCTYPE html>
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
<html>
<head>
    <title>Tienda</title>
</head>
<body>

<div class="container">

    <h1>Tienda de Productos</h1>

    @foreach($productos as $producto)

        <div class="card">

            <h3>{{ $producto->nombre }}</h3>
            <p>{{ $producto->descripcion }}</p>
            <p><strong>${{ $producto->precio }}</strong></p>

            <form>
                <button type="button">
                    Agregar al carrito
                </button>
            </form>

        </div>

    @endforeach
<a href="/carrito/agregar/{{ $producto->id }}">
    <button>Agregar al carrito</button>
</a>
</div>

</body>
</html>