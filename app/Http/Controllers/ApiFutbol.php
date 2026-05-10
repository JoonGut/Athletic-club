<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class ApiFutbol extends Controller
{
    public function miEquipo()
    {
        $codCompeticion = 'PD';
        [$competition, $equipos, $error] = $this->cargarClasificacionLiga($codCompeticion);

        return view('miEquipo', compact('competition', 'equipos', 'error'));
    }

    public function equiposLiga()
    {
        return $this->miEquipo();
    }

    private function cargarClasificacionLiga(string $codCompeticion): array
    {
        $token = config('services.football_data.token');

        $competition = null;
        $equipos = [];
        $error = null;

        if (empty($token)) {
            return [null, [], 'No se ha configurado la API key de football-data.'];
        }

        try {
            $cliente = Http::withHeaders([
                'X-Auth-Token' => $token,
            ]);

            $competitionResponse = $cliente->get("https://api.football-data.org/v4/competitions/{$codCompeticion}");
            $teamsResponse = $cliente->get("https://api.football-data.org/v4/competitions/{$codCompeticion}/teams");
            $standingsResponse = $cliente->get("https://api.football-data.org/v4/competitions/{$codCompeticion}/standings");

            if (! $competitionResponse->successful()) {
                return [null, [], 'No se pudo cargar la competición. Código: ' . $competitionResponse->status()];
            }

            if (! $teamsResponse->successful()) {
                return [null, [], 'No se pudo cargar los equipos. Código: ' . $teamsResponse->status()];
            }

            if (! $standingsResponse->successful()) {
                return [null, [], 'No se pudo cargar la clasificación. Código: ' . $standingsResponse->status()];
            }

            $competition = $competitionResponse->json();
            $teamsById = collect($teamsResponse->json('teams', []))->keyBy('id');
            $table = collect($standingsResponse->json('standings.0.table', []))->sortBy('position')->values();

            $equipos = $table->map(function (array $row) use ($teamsById) {
                $teamId = $row['team']['id'] ?? null;
                $team = $teamId ? ($teamsById->get($teamId) ?? $row['team']) : $row['team'];
                $name = $team['name'] ?? 'Equipo';

                return [
                    'position' => $row['position'] ?? null,
                    'name' => $name,
                    'area' => $team['area'] ?? $row['team']['area'] ?? [],
                    'crest' => $team['crest'] ?? $row['team']['crest'] ?? null,
                    'venue' => $team['venue'] ?? null,
                    'points' => $row['points'] ?? 0,
                    'playedGames' => $row['playedGames'] ?? 0,
                    'goalDifference' => $row['goalDifference'] ?? 0,
                    'goalsFor' => $row['goalsFor'] ?? 0,
                    'goalsAgainst' => $row['goalsAgainst'] ?? 0,
                    'photo' => $this->crearImagenEquipo($name, $row['position'] ?? null),
                ];
            })->all();
        } catch (\Throwable $exception) {
            $error = 'Error al conectar con football-data.';
        }

        return [$competition, $equipos, $error];
    }

    private function crearImagenEquipo(string $nombre, ?int $posicion): string
    {
        $paletas = [
            ['#0f172a', '#2563eb'],
            ['#7f1d1d', '#f97316'],
            ['#064e3b', '#10b981'],
            ['#1e3a8a', '#38bdf8'],
            ['#4c1d95', '#c084fc'],
            ['#7c2d12', '#f59e0b'],
            ['#111827', '#6b7280'],
            ['#312e81', '#ec4899'],
        ];

        $indice = $nombre === '' ? 0 : abs(crc32($nombre)) % count($paletas);

        if ($posicion !== null) {
            $indice = ($indice + $posicion) % count($paletas);
        }

        [$primary, $secondary] = $paletas[$indice];
        $iniciales = $this->obtenerInicialesEquipo($nombre);

        $svg = sprintf(
            '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 360" role="img" aria-label="Foto de %s"><defs><linearGradient id="bg" x1="0" y1="0" x2="1" y2="1"><stop offset="0%%" stop-color="%s"/><stop offset="100%%" stop-color="%s"/></linearGradient></defs><rect width="640" height="360" rx="32" fill="url(#bg)"/><circle cx="520" cy="90" r="110" fill="rgba(255,255,255,0.14)"/><circle cx="110" cy="280" r="120" fill="rgba(255,255,255,0.08)"/><rect x="44" y="44" width="552" height="272" rx="24" fill="rgba(255,255,255,0.08)" stroke="rgba(255,255,255,0.2)"/><text x="50%%" y="46%%" text-anchor="middle" font-family="Arial, sans-serif" font-size="72" font-weight="700" fill="#ffffff">%s</text><text x="50%%" y="62%%" text-anchor="middle" font-family="Arial, sans-serif" font-size="24" fill="rgba(255,255,255,0.9)">Clasificación liga</text></svg>',
            htmlspecialchars($nombre, ENT_QUOTES, 'UTF-8'),
            $primary,
            $secondary,
            $iniciales
        );

        return 'data:image/svg+xml;charset=UTF-8,' . rawurlencode($svg);
    }

    private function obtenerInicialesEquipo(string $nombre): string
    {
        $palabras = preg_split('/\s+/', trim($nombre)) ?: [];
        $iniciales = '';

        foreach ($palabras as $palabra) {
            if ($palabra === '') {
                continue;
            }

            $iniciales .= mb_strtoupper(mb_substr($palabra, 0, 1));

            if (mb_strlen($iniciales) >= 3) {
                break;
            }
        }

        return $iniciales !== '' ? $iniciales : 'FC';
    }
}
