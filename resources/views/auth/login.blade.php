<link rel="stylesheet" href="{{ asset('css/app.css') }}">

<div class="form-container">

    <div class="form-card">

        <h1>Login</h1>

        @if(session('error'))
            <p style="color: red; text-align: center; margin-bottom: 15px;">
                {{ session('error') }}
            </p>
        @endif

        @if(session('success'))
            <p style="color: green; text-align: center; margin-bottom: 15px;">
                {{ session('success') }}
            </p>
        @endif

        <form method="POST" action="/login">
            @csrf

            <input type="email" name="email" placeholder="Email" required>
            
            <input type="password" name="password" placeholder="Password" required>

            <button type="submit">Entrar</button>
        </form>

        <div style="margin-top: 15px; text-align: center;">
            <a href="/recovery" style="color: #4f8cff; font-size: 0.9rem; text-decoration: none; font-weight: 500;">
                ¿Olvidaste tu contraseña?
            </a>
        </div>

        <p style="text-align: center; margin-top: 20px;">
            ¿No tienes cuenta?
            <a href="/register" style="color: #4f8cff; font-weight: 500; text-decoration: none;">Regístrate aquí</a>
        </p>

    </div>

</div>