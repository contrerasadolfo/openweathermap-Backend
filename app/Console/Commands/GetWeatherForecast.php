<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class GetWeatherForecast extends Command
{
    protected $signature = 'forecast {location} {--days=3} {--units=metric}';
    protected $description = 'Obtiene la previsión del clima (máx. 5 días)';
    public function handle()
    {
        $location = $this->argument('location');
        $days = min((int) $this->option('days'), 5);
        $units = $this->option('units');

        preg_match('/^([a-zA-Z\s]+)([a-zA-Z]{2})$/', $location, $matches);

        if (count($matches) !== 3) {
            $this->error('Formato inválido. Usa: city + country code (ej: MadridES)');
            return;
        }

        [$_, $city, $country] = $matches;

        $baseUrl = app()->runningInConsole()
            ? config('app.url')
            : request()->getSchemeAndHttpHost(); // detecta automáticamente el dominio

        $url = $baseUrl . '/api/weather/forecast';

        // Llamar al endpoint interno de Laravel
        $response = Http::get($url, [
            'city' => $city,
            'country' => $country,
            'days' => $days,
            'units' => $units,
        ]);


        if ($response->failed()) {
            $this->error('No se pudo obtener la previsión del clima.');
            return;
        }

        $forecastData = $response->json();
        $this->info(json_encode($forecastData, JSON_PRETTY_PRINT));

    }

}
