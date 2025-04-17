<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Documentación API del Clima</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        pre code {
            background-color: #f8f9fa;
            padding: 1rem;
            display: block;
            border-radius: 5px;
            font-size: 0.9rem;
        }
    </style>
</head>

<body class="bg-light text-dark p-5">
    <div class="container">
        <h1 class="mb-4">📘 Documentación de la API del Clima</h1>

        {{-- Clima Actual --}}
        <section class="mb-5">
            <h2>🌤 Clima Actual</h2>

            <p><strong>Endpoint:</strong></p>
            <div class="card bg-light p-3">
                <pre><code>GET /api/weather/current</code></pre>
            </div>

            <p><strong>Parámetros:</strong></p>
            <div class="card bg-light p-3">
                <pre><code>city      (requerido) : Nombre de la ciudad, ej: Madrid
country   (requerido) : Código de país ISO 3166-1 alpha-2, ej: ES
units     (opcional)  : 'imperial' (°F) o 'metric' (°C)</code></pre>
            </div>

            <p><strong>Ejemplo de solicitud:</strong></p>
            <div class="card bg-light p-3">
                <pre><code>/api/weather/current?city=Madrid&country=ES&units=imperial</code></pre>
            </div>

            <p>
                🔗 <strong>Probar en el navegador:</strong><br>
                <a href="{{ config('app.url') }}/api/weather/current?city=Madrid&country=ES" target="_blank">
                    {{ config('app.url') }}/api/weather/current?city=Madrid&country=ES&units=metric
                </a>
            </p>

            <p><strong>Respuesta esperada:</strong></p>
            <div class="card bg-light p-3">
                <pre><code>{
    "city": "Madrid (ES)",
    "date": "Apr 17 2025",
    "weather": "clear sky",
    "temperature": "68.4°F"
}</code></pre>
            </div>
        </section>

        {{-- Previsión --}}
        <section class="mb-5">
            <h2>📅 Previsión del Clima</h2>

            <p><strong>Endpoint:</strong></p>
            <div class="card bg-light p-3">
                <pre><code>GET /api/weather/forecast</code></pre>
            </div>



            <p><strong>Parámetros:</strong></p>
            <div class="card bg-light p-3">
                <pre><code>city      (requerido) : Nombre de la ciudad, ej: Havana
country   (requerido) : Código de país ISO 3166-1 alpha-2, ej: CU
days      (opcional)  : Número de días entre 1 y 5
units     (opcional)  : 'imperial' (°F) o 'metric' (°C)</code></pre>
            </div>

            <p><strong>Ejemplo de solicitud:</strong></p>
            <div class="card bg-light p-3">
                <pre><code>/api/weather/forecast?city=Madrid&country=ES&days=3&units=imperial</code></pre>
            </div>

            <p>
                🔗 <strong>Probar en el navegador:</strong><br>
                <a href="{{ config('app.url') }}/api/weather/forecast?city=Madrid&country=ES&days=5&units=metric"
                    target="_blank">
                    {{ config('app.url') }}/api/weather/forecast?city=Madrid&country=ES&days=5&units=metric
                </a>
            </p>

            <p><strong>Respuesta esperada:</strong></p>
            <div class="card bg-light p-3">
                <pre><code>{
    "city": "Madrid (ES)",
    "forecast": [
        {
            "date": "Apr 17 2025",
            "weather": "clear sky",
            "temperature": "70.12°F"
        },
        {
            "date": "Apr 18 2025",
            "weather": "light rain",
            "temperature": "65.33°F"
        }
    ]
}</code></pre>
            </div>
        </section>
        {{-- Comandos Artisan --}}
        <section class="mb-5">
            <h2>🔧 Comandos Artisan</h2>

            <p>También puedes obtener información del clima directamente desde la terminal utilizando comandos Artisan
                personalizados:</p>

            <p><strong>Obtener clima actual:</strong></p>
            <div class="card bg-light p-3">
                <pre><code>php artisan current HavanaCU --units=imperial</code></pre>
            </div>
            <p>
                🔹 <code>HavanaCU</code>: Ciudad + código de país (2 letras).<br>
                🔹 <code>--units=imperial</code>: Retorna la temperatura en Fahrenheit (°F). Usa <code>metric</code>
                para Celsius (°C).
            </p>

            <p><strong>Obtener previsión del clima:</strong></p>
            <div class="card bg-light p-3">
                <pre><code>php artisan forecast MadridES --days=5 --units=metric</code></pre>
            </div>
            <p>
                🔹 <code>MadridES</code>: Ciudad + código de país.<br>
                🔹 <code>--days=5</code>: Número de días para la previsión (máximo 5).<br>
                🔹 <code>--units=metric</code>: Retorna la temperatura en grados Celsius (°C).
            </p>
        </section>

        <footer class="mt-5">
            <p class="text-muted">Desarrollado con Laravel & OpenWeatherMap API</p>
        </footer>
    </div>
</body>

</html>