<h1>Login</h1>
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
</a>
@if(session('error'))
    <p style="color:red">{{ session('error') }}</p>
@endif

<form method="POST" action="/login">
    @csrf

    <input type="email" name="email" placeholder="Email">
    <br><br>

    <input type="password" name="password" placeholder="Password">
    <br><br>

    <button type="submit">Entrar</button>
</form>
<p>
    ¿No tienes cuenta?
    <a href="/register">Regístrate aquí</a>
</p>