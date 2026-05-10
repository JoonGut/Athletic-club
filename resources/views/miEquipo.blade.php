<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Athletic Club - Página Oficial</title>
    @vite('resources/css/estilos.css') 
    @vite('resources/css/miEquipo.css') 
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
                <li><a href="{{ url('/inicio') }}">Inicio</a></li>
                <li><a href="{{ url('/login') }}">Socios</a></li>
                <li><a href="{{ url('/jugadores') }}">Jugadores</a></li>
                <li><a href="{{ url('/tienda') }}">Tienda</a></li>
            </ul>
        </nav>
    </header>

    <main class="equipo-main">
        <section class="equipo-section">
            <h1 class="equipo-titulo">Listado de equipos</h1>

            @if (!empty($competition))
                <p class="equipo-competicion">
                    Clasificación de {{ $competition['name'] ?? 'La Liga' }}
                </p>
            @endif

            @if ($error)
                <p class="equipo-estado equipo-error">{{ $error }}</p>
            @endif
        </section>

        <section class="equipo-section equipos-listado">
            <h2 class="equipo-subtitulo-seccion">Ordenados por clasificación</h2>

            @if (!empty($equipos) && is_array($equipos))
                <div class="equipos-grid-lista">
                    @foreach ($equipos as $equipo)
                        <article class="equipo-mini-card">
                            <div class="equipo-mini-foto-wrap">
                                <span class="equipo-mini-posicion">#{{ $equipo['position'] ?? '-' }}</span>
                                @if (!empty($equipo['photo']))
                                    <img class="equipo-mini-foto" src="{{ $equipo['photo'] }}" alt="Foto de {{ $equipo['name'] }}">
                                @endif
                            </div>

                            <div class="equipo-mini-cabecera">
                                @if (!empty($equipo['crest']))
                                    <img class="equipo-mini-escudo" src="{{ $equipo['crest'] }}" alt="Escudo de {{ $equipo['name'] }}">
                                @endif

                                <div class="equipo-mini-datos">
                                    <h3>{{ $equipo['name'] ?? 'Equipo' }}</h3>
                                    <p>{{ $equipo['venue'] ?? $equipo['area']['name'] ?? 'Espana' }}</p>
                                </div>
                            </div>

                            <dl class="equipo-mini-estadisticas">
                                <div>
                                    <dt>Puntos</dt>
                                    <dd>{{ $equipo['points'] ?? 0 }}</dd>
                                </div>
                                <div>
                                    <dt>Jugados</dt>
                                    <dd>{{ $equipo['playedGames'] ?? 0 }}</dd>
                                </div>
                                <div>
                                    <dt>Goles</dt>
                                    <dd>{{ $equipo['goalsFor'] ?? 0 }} / {{ $equipo['goalsAgainst'] ?? 0 }}</dd>
                                </div>
                                <div>
                                    <dt>Dif.</dt>
                                    <dd>{{ $equipo['goalDifference'] ?? 0 }}</dd>
                                </div>
                            </dl>
                        </article>
                    @endforeach
                </div>
            @else
                <p class="equipo-estado">No se han cargado equipos para listar.</p>
            @endif
        </section>
    </main>

    </body>
</html>