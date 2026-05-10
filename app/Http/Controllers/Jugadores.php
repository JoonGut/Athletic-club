<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class Jugadores extends Controller
{
	public function index()
	{
		[$equipo, $jugadores, $error] = $this->cargarJugadoresAthletic();

		return view('jugadores', compact('equipo', 'jugadores', 'error'));
	}

	private function cargarJugadoresAthletic(): array
	{
		$token = config('services.football_data.token');
		$competitionCode = 'PD';

		if (empty($token)) {
			return [null, [], 'No se ha configurado la API key de football-data.'];
		}

		try {
			$cliente = Http::withHeaders([
				'X-Auth-Token' => $token,
			]);

			$teamsResponse = $cliente->get("https://api.football-data.org/v4/competitions/{$competitionCode}/teams");

			if (! $teamsResponse->successful()) {
				return [null, [], 'No se pudo cargar la lista de equipos. Código: ' . $teamsResponse->status()];
			}

			$equipoAthletic = collect($teamsResponse->json('teams', []))
				->first(function (array $team): bool {
					$nombre = mb_strtolower($team['name'] ?? '');

					return $nombre === 'athletic club' || mb_strpos($nombre, 'athletic') !== false;
				});

			if (empty($equipoAthletic['id'])) {
				return [null, [], 'No se encontró el Athletic Club dentro de la competición.'];
			}

			$teamResponse = $cliente->get('https://api.football-data.org/v4/teams/' . $equipoAthletic['id']);

			if (! $teamResponse->successful()) {
				return [null, [], 'No se pudo cargar la plantilla del Athletic Club. Código: ' . $teamResponse->status()];
			}

			$equipo = $teamResponse->json();

			$jugadores = collect($equipo['squad'] ?? [])
				->map(function (array $jugador): array {
					$posicion = $jugador['position'] ?? null;
					$numero = $jugador['shirtNumber'] ?? null;
					$nombre = $jugador['name'] ?? 'Jugador';

					return [
						'name' => $nombre,
						'position' => $posicion,
						'position_label' => $this->etiquetaPosicion($posicion),
						'shirt_number' => $numero,
						'nationality' => $jugador['nationality'] ?? 'Desconocida',
						'birth_date' => $this->formatearFecha($jugador['dateOfBirth'] ?? null),
						'initials' => $this->obtenerInicialesJugador($nombre),
						'sort_key' => sprintf(
							'%02d-%03d-%s',
							$this->ordenPosicion($posicion),
							$numero ?? 999,
							mb_strtolower($nombre)
						),
					];
				})
				->sortBy('sort_key')
				->values()
				->all();

			return [$equipo, $jugadores, null];
		} catch (\Throwable $exception) {
			return [null, [], 'Error al conectar con football-data.'];
		}
	}

	private function etiquetaPosicion(?string $position): string
	{
		return match ($position) {
			'Goalkeeper' => 'Portero',
			'Defence' => 'Defensa',
			'Midfield' => 'Centrocampista',
			'Offence' => 'Delantero',
			default => 'Plantilla',
		};
	}

	private function ordenPosicion(?string $position): int
	{
		return match ($position) {
			'Goalkeeper' => 1,
			'Defence' => 2,
			'Midfield' => 3,
			'Offence' => 4,
			default => 9,
		};
	}

	private function formatearFecha(?string $fecha): ?string
	{
		if (empty($fecha)) {
			return null;
		}

		try {
			return \Illuminate\Support\Carbon::parse($fecha)->format('d/m/Y');
		} catch (\Throwable $exception) {
			return $fecha;
		}
	}

	private function obtenerInicialesJugador(string $nombre): string
	{
		$palabras = preg_split('/\s+/', trim($nombre)) ?: [];
		$iniciales = '';

		foreach ($palabras as $palabra) {
			if ($palabra === '') {
				continue;
			}

			$iniciales .= mb_strtoupper(mb_substr($palabra, 0, 1));

			if (mb_strlen($iniciales) >= 2) {
				break;
			}
		}

		return $iniciales !== '' ? $iniciales : 'AC';
	}
}
