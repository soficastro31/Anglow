<!DOCTYPE html>
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
<html>
<head>
    <title>Registro</title>
</head>
<body>

<h2>Crear cuenta</h2>

<form method="POST" action="/register">
    @csrf

    <input type="text" name="name" placeholder="Nombre"><br><br>

    <input type="email" name="email" placeholder="Email"><br><br>

    <input type="password" name="password" placeholder="Contraseña"><br><br>

    <button type="submit">Registrarse</button>
</form>

<a href="/login">Ya tengo cuenta</a>

</body>
</html>