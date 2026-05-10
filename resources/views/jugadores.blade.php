<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Athletic Club - Jugadores</title>
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
				<li><a href="{{ url('/inicio') }}">Inicio</a></li>
				<li><a href="{{ url('/login') }}">Socios</a></li>
				<li><a href="{{ url('/jugadores') }}">Jugadores</a></li>
				<li><a href="{{ url('/miEquipo') }}">Mi equipo</a></li>
                <li><a href="{{ url('/tienda') }}">Tienda</a></li>
			</ul>
		</nav>
	</header>

	<main class="jugadores-main">
		<section class="jugadores-hero">
			<div class="jugadores-hero-texto">
				<p class="jugadores-etiqueta">Plantilla oficial</p>
				<h1 class="jugadores-titulo">Jugadores del Athletic Club</h1>
				<p class="jugadores-descripcion">
					Lista completa de la plantilla obtenida desde football-data y ordenada por posición.
				</p>
			</div>

			@if (!empty($equipo['crest']))
				<img class="jugadores-escudo" src="{{ $equipo['crest'] }}" alt="Escudo del Athletic Club">
			@endif
		</section>

		@if ($error)
			<section class="jugadores-estado jugadores-error">
				{{ $error }}
			</section>
		@endif

		@if (!empty($equipo))
			<section class="jugadores-resumen">
				<article class="jugadores-resumen-card">
					<span>Equipo</span>
					<strong>{{ $equipo['name'] ?? 'Athletic Club' }}</strong>
				</article>
				<article class="jugadores-resumen-card">
					<span>Estadio</span>
					<strong>{{ $equipo['venue'] ?? 'San Mamés' }}</strong>
				</article>
				<article class="jugadores-resumen-card">
					<span>Plantilla</span>
					<strong>{{ count($jugadores ?? []) }} jugadores</strong>
				</article>
				<article class="jugadores-resumen-card">
					<span>Entrenador</span>
					<strong>{{ $equipo['coach']['name'] ?? 'No disponible' }}</strong>
				</article>
			</section>
		@endif

		<section class="jugadores-listado">
			<div class="jugadores-listado-titulo">
				<h2>Todos los jugadores</h2>
				<p>Ordenados por posición, dorsal y nombre.</p>
			</div>

			@if (!empty($jugadores))
				<div class="jugadores-grid">
					@foreach ($jugadores as $jugador)
						<article class="jugador-card">
							<div class="jugador-avatar">{{ $jugador['initials'] }}</div>

							<div class="jugador-contenido">
								<div class="jugador-cabecera">
									<span class="jugador-dorsal">#{{ $jugador['shirt_number'] ?? '--' }}</span>
									<span class="jugador-posicion">{{ $jugador['position_label'] }}</span>
								</div>

								<h3>{{ $jugador['name'] }}</h3>

								<dl class="jugador-detalles">
									<div>
										<dt>Nacionalidad</dt>
										<dd>{{ $jugador['nationality'] }}</dd>
									</div>
									<div>
										<dt>Nacimiento</dt>
										<dd>{{ $jugador['birth_date'] ?? 'No disponible' }}</dd>
									</div>
								</dl>
							</div>
						</article>
					@endforeach
				</div>
			@else
				<p class="jugadores-estado">No se han podido cargar jugadores para mostrar.</p>
			@endif
		</section>
	</main>
</body>
</html>
