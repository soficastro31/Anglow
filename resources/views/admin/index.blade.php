<h1>Panel Admin</h1>

<link rel="stylesheet" href="{{ asset('css/app.css') }}">

<a href="/productos/create" class="btn crear">
    Crear producto
</a>

<hr>

<div class="container">

@foreach($productos as $producto)

    <div class="card">

        <h3>{{ $producto->nombre }}</h3>

        <p class="precio">${{ $producto->precio }}</p>
        <p class="desc">{{ $producto->descripcion }}</p>

        <div class="acciones">

            <!-- EDITAR -->
            <a href="/productos/edit/{{ $producto->id }}" class="btn editar">
                Editar
            </a>

            <!-- ELIMINAR -->
            <form action="/productos/{{ $producto->id }}" method="POST"
                  onsubmit="return confirm('¿Seguro que quieres eliminar este producto?')">

                @csrf
                @method('DELETE')

                <button type="submit" class="btn eliminar">
                    Eliminar
                </button>

            </form>

        </div>

    </div>

@endforeach

</div>