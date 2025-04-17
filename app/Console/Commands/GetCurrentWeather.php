<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
class GetCurrentWeather extends Command
{
    protected $signature = 'current {location} {--units=imperial}';
    protected $description = 'Obtiene el clima actual desde el endpoint interno /api/weather/current';

    public function handle()
    {
        $location = $this->argument('location');
        $units = $this->option('units');

        // Extraer ciudad y país (ej: "MadridES" => "Madrid", "ES")
        preg_match('/^([a-zA-Z\s]+)([a-zA-Z]{2})$/', $location, $matches);
        if (count($matches) !== 3) {
            $this->error('Formato inválido. Usa: city + country code (ej: MadridES)');
            return;
        }

        \Log::info($matches);

        [$_, $city, $country] = $matches;

        $baseUrl = app()->runningInConsole()
            ? config('app.url')
            : request()->getSchemeAndHttpHost(); // detecta automáticamente el dominio

        $url = $baseUrl . '/api/weather/current';

        // Llamar al endpoint interno de Laravel
        $response = Http::get($url, [
            'city' => $city,
            'country' => $country,
            'units' => $units,
        ]);

        if ($response->failed()) {
            $this->error('No se pudo obtener el clima actual desde el endpoint.');
            return;
        }

        $data = $response->json();

        // Mostrar los datos
        $this->info(json_encode($data, JSON_PRETTY_PRINT));

    }
}
