<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Anglow</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>

<div class="form-container">

    <div class="form-card">

        <h1>Crear cuenta</h1>

        <form method="POST" action="/register">
            @csrf

            <input type="text" name="name" placeholder="Nombre" required>

            <input type="email" name="email" placeholder="Email" required>

            <input type="password" name="password" placeholder="Contraseña" required>

            <button type="submit">Registrarse</button>
        </form>

        <p style="text-align: center; margin-top: 20px;">
            <a href="/login" style="color: #4f8cff; font-weight: 500; text-decoration: none;">Ya tengo cuenta</a>
        </p>

    </div>

</div>

</body>
</html>