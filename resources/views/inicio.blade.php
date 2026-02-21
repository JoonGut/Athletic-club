<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Athletic Club - Página Oficial</title>
    {{-- <link rel="stylesheet" href="{{ asset('css/estilos.css') }}"> --}}
    @vite('resources/css/estilos.css') 
    <link rel="icon" href="{{ asset('images/escudoAthletic.png') }}">
</head>
<body>

    <header>
        <div class="logo">
            <img src="{{ asset('images/escudoAthletic.png') }}" alt="Logo Athletic Club" width="60">
            <h1>Athletic Club</h1>
        </div>

        <nav>
            <ul>
                <li><a href="#">Inicio</a></li>
                <li><a href="#">Plantilla</a></li>
                <li><a href="#">Socios</a></li>
                <li><a href="#">Tienda</a></li>
            </ul>
        </nav>
    </header>

    <section class="eslogan">
        <h2>Leones de corazón</h2>
        <p>Orgullo, tradición y cantera</p>
        <button>Ver Último Partido</button>
    </section>

    <section class="noticias">
        <h2>Últimas Noticias</h2>

        <div class="cartas">
            <div class="carta">
                <h3>Victoria en San Mamés</h3>
                <p>Gran partido del equipo ante su afición en La Catedral.</p>
                <a href="#">Leer más</a>
            </div>

            <div class="carta">
                <h3>Nueva promesa de Lezama</h3>
                <p>El club apuesta fuerte por el talento joven.</p>
                <a href="#">Leer más</a>
            </div>

            <div class="carta">
                <h3>Próximo Derbi Vasco</h3>
                <p>Preparados para un duelo emocionante.</p>
                <a href="#">Leer más</a>
            </div>
        </div>
    </section>

    <footer>
        <p>© 2026 Athletic Club | Página oficial </p>
    </footer>
</body>
</html>