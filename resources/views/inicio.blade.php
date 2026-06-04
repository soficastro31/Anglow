<!DOCTYPE html>

<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anglow</title>

<link rel="stylesheet" href="{{ asset('css/app.css') }}">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">


</head>

<body>

<header>

<div class="logo">

    <img src="{{ asset('img/anglow.png') }}" alt="Anglow">


</div>

<nav>

    <a href="/login" class="btn-login">
        Iniciar sesión
    </a>

    <a href="/tienda">
        Tienda
    </a>

    <a href="#">
        Ofertas
    </a>

    <a href="#">
        Contacto
    </a>

    <input
        class="buscar"
        type="text"
        placeholder="Buscar productos..."
    >

</nav>

</header>

<section class="hero">

<div class="hero-text">

    <h1>
        Encuentra todo para estudiar,
        trabajar y crear
    </h1>

    <p>
        Papelería, tecnología, accesorios y
        productos útiles para tu día a día,
        todo en una sola tienda.
    </p>

    <a href="/tienda" class="btn-hero">
        Ver productos
    </a>

</div>

<div class="hero-image">

    <img
        src="{{ asset('img/miselanea.png') }}"
        alt="Miscelánea Anglow"
    >

</div>

</section>

<section class="categorias">

<div class="titulo-seccion">

    <h2>Categorías</h2>

</div>

<div class="grid-categorias">

    <div class="card-categoria">

        <img src="https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?q=80&w=800">

        <div class="card-info">

            <h3>Papelería</h3>

            <p>
                Cuadernos, marcadores,
                lápices y útiles escolares.
            </p>

        </div>

    </div>

    <div class="card-categoria">

        <img src="https://images.unsplash.com/photo-1505740420928-5e560c06d30e?q=80&w=800">

        <div class="card-info">

            <h3>Tecnología</h3>

            <p>
                Audífonos, accesorios
                y artículos tecnológicos.
            </p>

        </div>

    </div>

    <div class="card-categoria">

        <img src="https://images.unsplash.com/photo-1511499767150-a48a237f0083?q=80&w=800">

        <div class="card-info">

            <h3>Accesorios</h3>

            <p>
                Productos modernos para
                complementar tu estilo.
            </p>

        </div>

    </div>

</div>
```

</section>

<section class="beneficios">

```
<div class="titulo-seccion">

    <h2>¿Por qué elegir Anglow?</h2>

</div>

<div class="grid-categorias">

    <div class="card-categoria">

        <div class="card-info">

            <h3>🚚 Entrega rápida</h3>

            <p>
                Procesamos tus pedidos de forma eficiente.
            </p>

        </div>

    </div>

    <div class="card-categoria">

        <div class="card-info">

            <h3>💙 Calidad garantizada</h3>

            <p>
                Productos seleccionados cuidadosamente.
            </p>

        </div>

    </div>

    <div class="card-categoria">

        <div class="card-info">

            <h3>🛍️ Variedad</h3>

            <p>
                Todo lo que necesitas en un solo lugar.
            </p>

        </div>

    </div>

</div>
```

</section>

<footer class="footer">

```
<p>
    © 2026 Anglow · Papelería, tecnología y accesorios.
</p>

<p>
    Todos los derechos reservados.
</p>
```

</footer>

</body>
</html>
