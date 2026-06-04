<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pasarela de Pago - Anglow</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body style="background-color: #f3f4f6;">

<div class="container" style="text-align: center; margin-top: 80px;">
    
    <div class="form-card" style="display: inline-block; max-width: 480px; width: 100%; padding: 40px; border-top: 5px solid #4f8cff; background: #ffffff; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);">
        
        <div style="font-size: 45px; margin-bottom: 15px;">Pago</div>
        
        <h2 style="color: #1f2937; margin-bottom: 5px; font-size: 22px;">Entorno Seguro de Pago</h2>
        <p style="color: #6b7280; font-size: 14px; margin-bottom: 25px;">Estás a un paso de completar tu compra en <strong>Anglow</strong>.</p>
        
        <p style="color: #4b5563; font-size: 13px; margin-top: -15px; margin-bottom: 20px;">
            Orden de Compra: <strong>#{{ $pedido->id }}</strong>
        </p>

        <div style="background: #e8f1ff; padding: 20px; border-radius: 10px; margin-bottom: 30px;">
            <span style="font-size: 13px; color: #4b5563; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px;">
                TOTAL A TRANSFERIR
            </span>
            <h1 style="color: #4f8cff; margin: 8px 0 0 0; font-size: 32px; font-weight: 800;">
                ${{ number_format($pedido->total, 2) }}
            </h1>
        </div>

        <div style="margin-bottom: 25px; text-align: left; font-size: 13px; color: #6b7280; line-height: 1.5;">
            <p>🔒 Conexión cifrada de extremo a extremo.</p>
            <p>Al hacer clic en el botón inferior, se procesará el pago y se agendará tu envío con los datos ingresados.</p>
        </div>

        <form action="{{ route('checkout.simular-pago', ['id' => $pedido->id]) }}" method="POST">
            @csrf
            <button type="submit" class="btn crear" style="border: none; width: 100%; display: block; background: #2ec4b6; color: white; font-weight: bold; padding: 14px; border-radius: 8px; font-size: 16px; transition: background 0.2s; cursor: pointer;">
                Simular Pago Exitoso
            </button>
        </form>

        <p style="margin-top: 20px; font-size: 14px;">
            <a href="/checkout" style="color: #ef4444; text-decoration: none;">Cancelar y regresar</a>
        </p>

    </div>
    
</div>

</body>
</html>