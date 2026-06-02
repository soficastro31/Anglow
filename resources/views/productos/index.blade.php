<h1>Lista de productos</h1>
<link rel="stylesheet" href="{{ asset('css/style.css') }}">

@foreach($productos as $producto)
    <div>
        <h3>{{ $producto->nombre }}</h3>
        <p>{{ $producto->descripcion }}</p>
        <p>${{ $producto->precio }}</p>
        <hr>
    </div>
@endforeach