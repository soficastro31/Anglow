<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <title>Agregar Producto</title>
</head>
<body>

    <h1>Agregar Producto</h1>

    <form action="/productos" method="POST">

        @csrf

        <label>Nombre</label>
        <br>
        <input type="text" name="nombre">
        <br><br>

        <label>Descripción</label>
        <br>
        <textarea name="descripcion"></textarea>
        <br><br>

        <label>Precio</label>
        <br>
        <input type="number" name="precio">
        <br><br>

        <label>Stock</label>
        <br>
        <input type="number" name="stock">
        <br><br>

        <button type="submit">
            Guardar Producto
        </button>

    </form>

</body>
</html>