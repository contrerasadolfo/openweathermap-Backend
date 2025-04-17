<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
class WeatherController extends Controller
{
    public function current(Request $request)
    {
        $request->validate([
            'city' => 'required|string',
            'country' => 'required|string|size:2',
        ]);

        $city = $request->input('city');
        $country = strtoupper($request->input('country'));
        $units = $request->query('units', 'metric'); // imperial = °F, metric = °C

        $apiKey = config('services.openweathermap.key');

        $response = Http::get("https://api.openweathermap.org/data/2.5/weather", [
            'q' => "$city,$country",
            'appid' => $apiKey,
            'units' => $units,
            'lang' => 'es',
        ]);

        if ($response->failed()) {
            return response()->json([
                'error' => 'No se pudo obtener el clima para la ubicación especificada.',
            ], 404);
        }

        $data = $response->json();

        return response()->json([
            'city' => "{$data['name']} ({$country})",
            'date' => now()->format('M d Y'),
            'weather' => $data['weather'][0]['description'],
            'temperature' => round($data['main']['temp'], 2) . ($units === 'metric' ? '°C' : '°F'),
        ]);
    }

    public function forecast(Request $request)
    {
        try {
            $request->validate([
                'city' => 'required|string',
                'country' => 'required|string|size:2',
                'days' => [
                    'nullable',
                    'integer',
                    'min:1',
                    function ($attribute, $value, $fail) {
                        if ($value > 5) {
                            $fail('Solo se puede solicitar una previsión máxima de 5 días.');
                        }
                    }
                ],
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Error de validación.',
                'errors' => $e->errors(),
            ], 422);
        }


        $city = $request->input('city');
        $country = strtoupper($request->input('country'));
        $days = min($request->query('days', 3), 5); // max 5
        $units = $request->query('units', 'imperial'); // °F o °C

        $apiKey = config('services.openweathermap.key');

        $response = Http::get('https://api.openweathermap.org/data/2.5/forecast', [
            'q' => "$city,$country",
            'appid' => $apiKey,
            'units' => $units,
            'lang' => 'es',
        ]);

        if ($response->failed()) {
            return response()->json([
                'error' => 'No se pudo obtener la previsión del clima.',
            ], 404);
        }

        $data = $response->json();
        // Agrupar por día y tomar la media de temperatura + el primer estado del clima
        $groupedForecast = collect($data['list'])
            ->groupBy(function ($item) {
                return \Carbon\Carbon::parse($item['dt_txt'])->format('Y-m-d');
            })
            ->take($days)
            ->map(function ($dayItems) use ($units) {
                $dayData = $dayItems->first(); // Tomamos el primer bloque del día como ejemplo
                $avgTemp = $dayItems->avg('main.temp');
                return [
                    'date' => \Carbon\Carbon::parse($dayData['dt_txt'])->format('M d Y'),
                    'weather' => $dayData['weather'][0]['description'],
                    'temperature' => round($avgTemp, 2) . ($units === 'metric' ? '°C' : '°F'),
                ];
            })
            ->values();

        return response()->json([
            'city' => "{$data['city']['name']} ({$country})",
            'forecast' => $groupedForecast,
        ]);
    }

}
