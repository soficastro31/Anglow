<!DOCTYPE html>
<html lang="es">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Miscelánea Manualidades y Variedades Danna</title>

    <!-- FUENTE -->

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <style>

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family:'Poppins', sans-serif;
        }

        body{
            background:linear-gradient(to right, #eef7ff, #dcecff);
            color:#333;
        }

        /* NAVBAR */

        header{
            width:100%;
            background:rgba(255,255,255,0.8);
            backdrop-filter:blur(10px);
            padding:20px 8%;
            display:flex;
            justify-content:space-between;
            align-items:center;
            position:sticky;
            top:0;
            box-shadow:0 2px 10px rgba(0,0,0,0.05);
        }

        .logo{
            font-size:28px;
            font-weight:600;
            color:#6daee6;
        }

        nav{
            display:flex;
            align-items:center;
            gap:25px;
        }

        nav a{
            text-decoration:none;
            color:#444;
            font-weight:500;
            transition:0.3s;
        }

        nav a:hover{
            color:#6daee6;
        }

        .buscar{
            padding:10px 15px;
            border:none;
            border-radius:12px;
            outline:none;
            background:#f4f8ff;
        }

        /* HERO */

        .hero{
            min-height:90vh;
            display:flex;
            justify-content:center;
            align-items:center;
            gap:50px;
            padding:50px 8%;
        }

        .hero-text{
            flex:1;
        }

        .hero-text h1{
            font-size:60px;
            color:#3d5f7a;
            margin-bottom:20px;
        }

        .hero-text p{
            font-size:18px;
            color:#666;
            line-height:1.8;
            margin-bottom:30px;
        }

        .hero-text button{
            padding:15px 35px;
            border:none;
            border-radius:15px;
            background:#b9dcff;
            cursor:pointer;
            font-size:16px;
            transition:0.3s;
        }

        .hero-text button:hover{
            background:#9fcdff;
            transform:translateY(-3px);
        }

        .hero-image{
            flex:1;
            display:flex;
            justify-content:center;
        }

        .hero-image img{
            width:90%;
            border-radius:30px;
            box-shadow:0 15px 35px rgba(0,0,0,0.08);
        }

        /* CATEGORÍAS */

        .categorias{
            padding:80px 8%;
        }

        .titulo{
            text-align:center;
            margin-bottom:50px;
        }

        .titulo h2{
            font-size:40px;
            color:#3d5f7a;
        }

        .cards{
            display:flex;
            justify-content:center;
            align-items:center;
            flex-wrap:wrap;
            gap:25px;
        }

        .card{
            width:260px;
            background:rgba(255,255,255,0.7);
            backdrop-filter:blur(10px);
            border-radius:25px;
            padding:25px;
            text-align:center;
            box-shadow:0 8px 25px rgba(0,0,0,0.05);
            transition:0.3s;
        }

        .card:hover{
            transform:translateY(-10px);
        }

        .card img{
            width:100%;
            height:180px;
            object-fit:cover;
            border-radius:18px;
            margin-bottom:20px;
        }

        .card h3{
            margin-bottom:10px;
            color:#456;
        }

        .card p{
            color:#777;
        }

        /* PRODUCTOS */

        .productos{
            padding:80px 8%;
        }

        .producto-card{
            width:260px;
            background:white;
            border-radius:25px;
            overflow:hidden;
            box-shadow:0 8px 25px rgba(0,0,0,0.05);
            transition:0.3s;
        }

        .producto-card:hover{
            transform:scale(1.03);
        }

        .producto-card img{
            width:100%;
            height:220px;
            object-fit:cover;
        }

        .producto-info{
            padding:20px;
        }

        .producto-info h3{
            margin-bottom:10px;
        }

        .precio{
            color:#6daee6;
            font-size:22px;
            font-weight:600;
            margin-bottom:15px;
        }

        .producto-info button{
            width:100%;
            padding:12px;
            border:none;
            border-radius:12px;
            background:#dcecff;
            cursor:pointer;
            transition:0.3s;
        }

        .producto-info button:hover{
            background:#b9dcff;
        }

        /* FOOTER */

        footer{
            margin-top:50px;
            padding:30px;
            text-align:center;
            color:#666;
        }

        /* RESPONSIVE */

        @media(max-width:900px){

            .hero{
                flex-direction:column;
                text-align:center;
            }

            .hero-text h1{
                font-size:40px;
            }

            nav{
                display:none;
            }

        }

    </style>

</head>

<body>

    <!-- NAVBAR -->

    <header>

        <div class="logo">
            MYVD
        </div>

        <nav>

            <a href="">Inicio</a>
            <a href="">Productos</a>
            <a href="">Ofertas</a>
            <a href="">Contacto</a>

            <input class="buscar" type="text" placeholder="Buscar...">

        </nav>

    </header>

    <!-- HERO -->

    <section class="hero">

        <div class="hero-text">

            <h1>
                Todo lo que necesitas en un solo lugar
            </h1>

            <p>
                Descubre productos modernos, útiles escolares,
                accesorios y tecnologí.
            </p>

            <button>
                Ver productos
            </button>

        </div>

        <div class="hero-image">

         <img src="miselanea.jpg" alt="miscelania">

        </div>

    </section>

    <!-- CATEGORÍAS -->

    <section class="categorias">

        <div class="titulo">
            <h2>Categorías</h2>
        </div>

        <div class="cards">

            <div class="card">

                <img src="https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?q=80&w=800">

                <h3>Papelería</h3>

                <p>
                    Cuadernos, marcadores y útiles escolares.
                </p>

            </div>

            <div class="card">

                <img src="https://images.unsplash.com/photo-1505740420928-5e560c06d30e?q=80&w=800">

                <h3>Tecnología</h3>

                <p>
                    Audífonos, accesorios y más.
                </p>

            </div>

            <div class="card">

                <img src="https://images.unsplash.com/photo-1511499767150-a48a237f0083?q=80&w=800">

                <h3>Accesorios</h3>

                <p>
                    Productos modernos para tu día a día.
                </p>

            </div>

        </div>

    </section>

    <!-- PRODUCTOS -->

    <section class="productos">

        <div class="titulo">
            <h2>Productos destacados</h2>
        </div>

        <div class="cards">

            <!-- PRODUCTO 1 -->

            <div class="producto-card">

                <img src="https://images.unsplash.com/photo-1583485088034-697b5bc54ccd?q=80&w=800">

                <div class="producto-info">

                    <h3>Cuaderno Minimalista</h3>

                    <p class="precio">
                        $15.000
                    </p>

                    <button>
                        Comprar
                    </button>

                </div>

            </div>

            <!-- PRODUCTO 2 -->

            <div class="producto-card">

                <img src="https://images.unsplash.com/photo-1518444065439-e933c06ce9cd?q=80&w=800">

                <div class="producto-info">

                    <h3>Audífonos</h3>

                    <p class="precio">
                        $45.000
                    </p>

                    <button>
                        Comprar
                    </button>

                </div>

            </div>

            <!-- PRODUCTO 3 -->

            <div class="producto-card">

                <img src="https://images.unsplash.com/photo-1585386959984-a4155224a1ad?q=80&w=800">

                <div class="producto-info">

                    <h3>Perfume</h3>

                    <p class="precio">
                        $12.000
                    </p>

                    <button>
                        Comprar
                    </button>

                </div>

            </div>

        </div>

    </section>

    <!-- FOOTER -->

    <footer>

        <p>
            © 2026 Miscelánea Manualidades y Variedades Danna | Todos los derechos reservados
        </p>

    </footer>

</body>
</html>