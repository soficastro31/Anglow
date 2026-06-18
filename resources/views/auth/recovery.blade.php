<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Contraseña - Anglow</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f3f4f6;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .recovery-card {
            background: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            max-width: 400px;
            width: 100%;
            text-align: center;
        }
        .recovery-card img {
            max-width: 150px;
            margin-bottom: 20px;
        }
        .recovery-card h2 {
            color: #1f2937;
            margin-bottom: 10px;
            font-size: 1.6rem;
        }
        .recovery-card p {
            color: #6b7280;
            font-size: 0.9rem;
            margin-bottom: 25px;
            line-height: 1.5;
        }
        .form-group {
            text-align: left;
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #4b5563;
            font-size: 0.9rem;
        }
        .form-group input {
            width: 100%;
            padding: 12px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            box-sizing: border-box;
        }
        .btn-recovery {
            width: 100%;
            padding: 12px;
            background-color: #4f8cff;
            color: white;
            border: none;
            border-radius: 6px;
            font-weight: 500;
            cursor: pointer;
            font-size: 1rem;
            transition: background 0.3s;
        }
        .btn-recovery:hover {
            background-color: #3b76e0;
        }
        .back-link {
            display: inline-block;
            margin-top: 20px;
            color: #9ca3af;
            text-decoration: none;
            font-size: 0.9rem;
        }
        .back-link:hover {
            color: #6b7280;
        }
    </style>
</head>
<body>

<div class="recovery-card">
    <img src="{{ asset('img/anglow.png') }}" alt="Anglow">
    
    <h2>¿Problemas para entrar?</h2>
    <p>Introduce tu correo electrónico y te enviaremos las instrucciones para restablecer tu contraseña y recuperar el acceso a tu cuenta.</p>

    <form onsubmit="alert('Correo de recuperación enviado con éxito.'); return false;">
        <div class="form-group">
            <label for="email">Correo Electrónico</label>
            <input type="email" id="email" placeholder="ejemplo@correo.com" required>
        </div>
        
        <button type="submit" class="btn-recovery">Enviar enlace de acceso</button>
    </form>

    <a href="/login" class="back-link">Volver al inicio de sesión</a>
</div>

</body>
</html>