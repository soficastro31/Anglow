<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Carrito - Anglow</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        .quantity-control {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 15px 0;
        }
        .btn-qty {
            display: inline-block;
            background: #e5e7eb;
            color: #1f2937;
            text-decoration: none;
            padding: 4px 12px;
            border-radius: 6px;
            font-weight: bold;
            font-size: 16px;
            transition: background 0.2s;
        }
        .btn-qty:hover {
            background: #d1d5db;
        }
        .qty-number {
            font-size: 16px;
            font-weight: 700;
            color: #374151;
            min-width: 20px;
            text-align: center;
        }
        /* Alerta para errores de stock al incrementar */
        .alert-error {
            background-color: #f8d7da;
            color: #721c14;
            padding: 12px 15px;
            border-radius: 6px;
            margin-bottom: 20px;
            border: 1px solid #f5c6cb;
            font-weight: 500;
        }
    </style>
</head>
<body>

<div class="container" style="max-width: 800px; margin: 40px auto; padding: 0 20px;">

    <h1 style="color: #1f2937; margin-bottom: 25px;">Tu carrito</h1>

    @if(session('error'))
        <div class="alert-error">
            ⚠️ {{ session('error') }}
        </div>
    @endif

    @php
        $carrito = session('carrito', []);
        $total = 0;
    @endphp

    @if(empty($carrito))
        <div style="background: #ffffff; padding: 30px; border-radius: 8px; text-align: center; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
            <p style="color: #6b7280; font-size: 16px; margin-bottom: 20px;">No tienes productos en el carrito</p>
            <a href="/tienda" class="btn" style="text-decoration: none; background: #4f8cff; color: white; padding: 10px 20px; border-radius: 6px; font-weight: bold;">Ir a la tienda</a>
        </div>
    @else

        @foreach($carrito as $id => $item)

            <div class="card" style="background: white; padding: 20px; border-radius: 8px; margin-bottom: 15px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); position: relative;">
                <h3 style="color: #1f2937; margin-top: 0; margin-bottom: 10px;">{{ $item['nombre'] }}</h3>
                
                <p style="color: #6b7280; margin: 5px 0;">Precio Unitario: ${{ number_format($item['precio'], 2) }}</p>

                <div class="quantity-control">
                    <span style="color: #4b5563; font-size: 14px;">Cantidad:</span>
                    <a href="{{ route('carrito.disminuir', ['id' => $id]) }}" class="btn-qty">-</a>
                    
                    <span class="qty-number">{{ $item['cantidad'] }}</span>
                    
                    <a href="{{ route('carrito.incrementar', ['id' => $id]) }}" class="btn-qty">+</a>
                </div>

                <p style="font-weight: bold; color: #1f2937; margin: 10px 0;">
                    Subtotal: <span style="color: #4f8cff;">${{ number_format($item['precio'] * $item['cantidad'], 2) }}</span>
                </p>

                <div style="margin-top: 15px;">
                    <a href="/carrito/eliminar/{{ $id }}" style="text-decoration: none;">
                        <button style="background: #ef4444; color: white; border: none; padding: 8px 14px; border-radius: 6px; font-weight: bold; cursor: pointer;">Eliminar del todo</button>
                    </a>
                </div>

                @php
                    $total += $item['precio'] * $item['cantidad'];
                @endphp
            </div>

        @endforeach

        <div style="background: white; padding: 20px; border-radius: 8px; margin-top: 25px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); display: flex; justify-content: space-between; align-items: center;">
            <h2 style="margin: 0; color: #1f2937; font-size: 22px;">Total General: <span style="color: #4f8cff;">${{ number_format($total, 2) }}</span></h2>
            
            <div style="display: flex; gap: 10px; align-items: center;">
                <a href="/tienda" style="text-decoration: none;">
                    <button style="background: #6b7280; color: white; border: none; padding: 12px 20px; border-radius: 6px; font-weight: bold; cursor: pointer; font-size: 16px;">Seguir Comprando</button>
                </a>

                <a href="/carrito/vaciar" style="text-decoration: none;">
                    <button style="background: #9ca3af; color: white; border: none; padding: 12px 20px; border-radius: 6px; font-weight: bold; cursor: pointer; font-size: 16px;">Vaciar</button>
                </a>

                <a href="/checkout" style="text-decoration: none;">
                    <button style="background: #2ec4b6; color: white; border: none; padding: 12px 24px; border-radius: 6px; font-weight: bold; cursor: pointer; font-size: 16px;">Ir a pagar 💳</button>
                </a>
            </div>
        </div>

    @endif

</div>

</body>
</html>