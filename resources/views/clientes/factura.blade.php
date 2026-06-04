<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmación de Compra #{{ $pedido->id }} - Anglow</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        .invoice-box {
            max-width: 600px;
            margin: 40px auto;
            padding: 30px;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            background: #ffffff;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }
        .invoice-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #f3f4f6;
            padding-bottom: 20px;
            margin-bottom: 20px;
        }
        .status-badge {
            background: #d1fae5;
            color: #065f46;
            padding: 6px 12px;
            border-radius: 9999px;
            font-size: 14px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .info-grid {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 30px;
            font-size: 14px;
        }
        .info-col {
            flex: 1;
        }
        .info-col h3 {
            font-size: 16px;
            color: #1f2937;
            margin-bottom: 8px;
        }
        .info-col p {
            color: #4b5563;
            margin: 4px 0;
            line-height: 1.4;
        }
        .invoice-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .invoice-table th {
            background: #f9fafb;
            text-align: left;
            padding: 12px;
            font-size: 14px;
            color: #374151;
            border-bottom: 1px solid #e5e7eb;
        }
        .invoice-table td {
            padding: 12px;
            font-size: 14px;
            border-bottom: 1px solid #f3f4f6;
            color: #4b5563;
        }
        .invoice-total {
            text-align: right;
            font-size: 18px;
            font-weight: bold;
            color: #1f2937;
            padding-top: 15px;
            border-top: 2px solid #e5e7eb;
        }
    </style>
</head>
<body>

<div class="invoice-box">
    <div class="invoice-header">
        <div>
            <h1 style="font-size: 24px; color: #4f8cff; margin: 0;">Anglow Store</h1>
            <p style="color: #6b7280; margin: 5px 0 0 0; font-size: 14px;">¡Gracias por tu compra!</p>
        </div>
        <div>
            <span class="status-badge">{{ $pedido->estado_pago }}</span>
        </div>
    </div>

    <div class="info-grid">
        <div class="info-col">
            <h3>Detalles del Recibo</h3>
            <p><strong>Pedido ID:</strong> #{{ $pedido->id }}</p>
            <p><strong>Fecha:</strong> {{ $pedido->created_at->format('d/m/Y h:i A') }}</p>
            <p><strong>Método de pago:</strong> Pasarela Simulada</p>
        </div>
        <div class="info-col">
            <h3>Datos de Envío</h3>
            <p><strong>Teléfono:</strong> {{ $pedido->telefono }}</p>
            <p><strong>Destino:</strong> {{ $pedido->ciudad_departamento }} - {{ $pedido->barrio_sector }}</p>
            <p><strong>Dirección:</strong> {{ $pedido->direccion }}</p>
            @if($pedido->notas_envio)
                <p><strong>Notas:</strong> <span style="font-style: italic;">"{{ $pedido->notas_envio }}"</span></p>
            @endif
        </div>
    </div>

    <h3 style="font-size: 16px; margin-bottom: 10px; color: #1f2937;">Resumen de Pago</h3>
    <table class="invoice-table">
        <thead>
            <tr>
                <th>Concepto</th>
                <th style="text-align: right;">Monto</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Pago de productos seleccionados en el carrito de Anglow</td>
                <td style="text-align: right;">${{ number_format($pedido->total, 2) }}</td>
            </tr>
        </tbody>
    </table>

    <div class="invoice-total">
        Total Pagado: <span style="color: #4f8cff; font-size: 22px; font-weight: 800;">${{ number_format($pedido->total, 2) }}</span>
    </div>

    <div style="text-align: center; margin-top: 40px;">
        <a href="/tienda" class="btn" style="background: #4f8cff; color: white; padding: 12px 24px; text-decoration: none; border-radius: 8px; font-weight: bold;">
            Volver a la Tienda
        </a>
    </div>
</div>

</body>
</html>