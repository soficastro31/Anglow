<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de {{ $cliente->name }} - Anglow</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Estilos rápidos para la tabla de historial */
        .tabla-historial { width: 100%; border-collapse: collapse; margin-top: 10px; background: white; }
        .tabla-historial th, .tabla-historial td { padding: 12px; border: 1px solid #e5e7eb; text-align: left; font-size: 14px; }
        .tabla-historial th { background: #f8f9fa; color: #4b5563; font-weight: 600; }
        .badge-pago { padding: 4px 8px; border-radius: 12px; font-size: 12px; font-weight: bold; display: inline-block; background: #d1e7dd; color: #0f5132; }
    </style>
</head>
<body>

<nav>
    <div>
        <a href="/admin/clientes"><strong>← Volver a Clientes</strong></a>
    </div>
    <div>
        <span style="margin-right:15px;">👤 {{ Auth::user()->name }}</span>
    </div>
</nav>

<div class="container" style="margin-top: 30px; max-width: 700px;">
    
    <div style="margin-bottom: 25px;">
        <h1>Perfil del Cliente</h1>
        <p style="color: #6b7280;">Detalles y cuenta del cliente</p>
    </div>

    <div class="producto-card" style="padding: 40px; background: white; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.06);">
        
        <div style="text-align: center; margin-bottom: 30px;">
            <div style="font-size: 80px; color: #4f8cff;">
                <i class="fa-solid fa-circle-user"></i>
            </div>
            <h2 style="margin-top: 15px;">{{ $cliente->name }}</h2>
            <span style="background: #eef2ff; color: #4f8cff; padding: 5px 15px; border-radius: 20px; font-size: 14px; font-weight: bold;">
                {{ ucfirst($cliente->rol) }}
            </span>
        </div>

        <table style="width: 100%; border-collapse: collapse; margin-top: 20px; margin-bottom: 30px;">
            <tr style="border-bottom: 1px solid #f3f4f6;">
                <td style="padding: 15px; font-weight: bold; color: #374151;">Correo Electrónico:</td>
                <td style="padding: 15px; text-align: right;">{{ $cliente->email }}</td>
            </tr>
            <tr style="border-bottom: 1px solid #f3f4f6;">
                <td style="padding: 15px; font-weight: bold; color: #374151;">Fecha de registro:</td>
                <td style="padding: 15px; text-align: right;">{{ $cliente->created_at->format('d/m/Y') }}</td>
            </tr>
            <tr style="border-bottom: 1px solid #f3f4f6;">
                <td style="padding: 15px; font-weight: bold; color: #374151;">Última actualización:</td>
                <td style="padding: 15px; text-align: right;">{{ $cliente->updated_at->format('d/m/Y') }}</td>
            </tr>
        </table>

        <div style="display: flex; gap: 10px; justify-content: center;">
            <a href="https://mail.google.com/mail/?view=cm&fs=1&to={{ $cliente->email }}" 
               target="_blank" 
               style="display: inline-block; background: #ea4335; color: white; padding: 12px 25px; border-radius: 6px; text-decoration: none; font-weight: bold;">
                <i class="fa-solid fa-envelope"></i> Enviar con Gmail
            </a>
            <a href="/admin/clientes" 
               style="text-decoration: none; background: #6b7280; color: white; padding: 12px 25px; border-radius: 6px; font-weight: bold;">
                Volver
            </a>
        </div>
    </div>
