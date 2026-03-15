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
                <li><a href="{{ url('/login') }}">Socios</a></li>
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
                <h3>Tour por el nuestra historia</h3>
                <img src="{{ asset('images/museoathletic.webp') }}" alt="Museo Athletic Club" width="60">
                <p>Tour por el museo del Athletic Club</p>
                <a href="https://www.athletic-club.eus/entradas/museo-tour/?utm_source=google-ads&utm_medium=cpc&utm_campaign=ticketing-museo&utm_content=euskadi&gad_source=1&gad_campaignid=15387496283">Leer más</a>
            </div>

            <div class="carta">
                <h3>Nueva promesa de Lezama</h3>
                <img src="{{ asset('images/banderaAthletic.jpg') }}" alt="Bandera Athletic Club" width="60">
                <p>El club apuesta fuerte por el talento joven.</p>
                <a href="https://www.athletic-club.eus/equipos/lezama/">Leer más</a>
            </div>
            

            <div class="carta">
                <h3>Unique in the world</h3>
                 <img src="{{ asset('images/uniqueInTheWorld.jpg') }}" alt="Unique in the world" width="60">
                <p>Un club con una filosofia unica</p>
                <a href="https://contenidos.athletic-club.eus/unique-in-the-world">Leer más</a>
            </div>
        </div>
    </section>

    <footer>
        <p>© 2026 Athletic Club | Página oficial </p>
    </footer>
</body>
</html>