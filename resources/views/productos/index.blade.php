<h1>Lista de productos</h1>
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

@foreach($productos as $producto)
    <div class="producto-item" style="margin-bottom: 20px; padding: 10px; border-radius: 6px;">
        <h3>{{ $producto->nombre }}</h3>
        
        <p style="margin: 5px 0;">
            <span style="background-color: #e0e7ff; color: #4338ca; padding: 3px 8px; border-radius: 12px; font-size: 12px; font-weight: bold;">
                <i class="fa-solid fa-tag"></i> {{ $producto->categoria?->nombre ?? 'Sin Categoría' }}
            </span>
        </p>

        <p>{{ $producto->descripcion }}</p>
        <p style="font-weight: bold; color: #10b981;">${{ number_format($producto->precio, 2) }}</p>
        <hr style="border: 0; border-top: 1px solid #e5e7eb; margin-top: 15px;">
    </div>
@endforeach