<h1>Editar producto</h1>

<link rel="stylesheet" href="{{ asset('css/app.css') }}">

<form method="POST" action="/productos/update/{{ $producto->id }}">
    @csrf

    <input type="text" name="nombre" value="{{ $producto->nombre }}">
    <input type="text" name="precio" value="{{ $producto->precio }}">
    <textarea name="descripcion">{{ $producto->descripcion }}</textarea>

    <button type="submit">Actualizar</button>
</form>