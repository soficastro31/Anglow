<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anglow</title>

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>
<body>

    <header>
        <div class="logo">
            Anglow
        </div>
        <nav>
            <a href="/login" class="btn btn-login">Iniciar sesión</a>
            <a href="">Ofertas</a>
            <a href="">Contacto</a>
            <input class="buscar" type="text" placeholder="Buscar...">
        </nav>
    </header>

    <section class="hero">
        <div class="hero-text">
            <h1>Todo lo que necesitas en un solo lugar</h1>
            <p>Descubre productos modernos, útiles escolares, accesorios y tecnología.</p>
            <a href="#productos-seccion" class="btn btn-hero">Ver productos</a>
        </div>
        <div class="hero-image">
            <img src="{{ asset('miselanea.jpg') }}" alt="miscelania">
        </div>
    </section>

    <section class="categorias">
        <div class="titulo-seccion">
            <h2>Categorías</h2>
        </div>
        <div class="grid-categorias">
            <div class="card-categoria">
                <img src="https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?q=80&w=800" alt="Papelería">
                <div class="card-info">
                    <h3>Papelería</h3>
                    <p>Cuadernos, marcadores y útiles escolares.</p>
                </div>
            </div>

            <div class="card-categoria">
                <img src="https://images.unsplash.com/photo-1505740420928-5e560c06d30e?q=80&w=800" alt="Tecnología">
                <div class="card-info">
                    <h3>Tecnología</h3>
                    <p>Audífonos, accesorios y más.</p>
                </div>
            </div>

            <div class="card-categoria">
                <img src="https://images.unsplash.com/photo-1511499767150-a48a237f0083?q=80&w=800" alt="Accesorios">
                <div class="card-info">
                    <h3>Accesorios</h3>
                    <p>Productos modernos para tu día a día.</p>
                </div>
            </div>
        </div>
    </section>
    <footer>
        <p>© 2026 Miscelánea Manualidades y Variedades Danna | Todos los derechos reservados</p>
    </footer>

</body>
</html>