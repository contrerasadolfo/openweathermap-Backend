🌤️ OpenWeatherMap API Laravel

Proyecto Laravel para consultar el clima actual y la previsión meteorológica utilizando la API de [OpenWeatherMap](https://openweathermap.org/api).

---

## 🚀 Requisitos

- PHP >= 8.2
- Composer
- Laravel 12
- MySQL
- Laravel instalado globalmente (`laravel`)
- Opcional: Laragon, XAMPP, WAMP u otro entorno local


Pasos para ejecutar un proyecto Laravel localmente

🔽 Clonar o copiar el proyecto

git clone https://github.com/contrerasadolfo/openweathermap-Backend.git
cd nombre-del-repo

O si ya tienes el proyecto descargado, navega al directorio:

cd C:\laragon\www\nombre-del-proyecto

📦 Instalar dependencias PHP (Laravel)

composer install

⚙️ Configurar archivo .env

cp .env.example .env

En Windows (cmd o PowerShell), si cp no funciona, usa:

copy .env.example .env

🔑 Generar clave de aplicación

php artisan key:generate

🛢️ Configurar base de datos
Abre el archivo .env y ajusta:

DB_DATABASE=nombre_de_tu_base
DB_USERNAME=root
DB_PASSWORD=

🛢️ Luego ejecuta migraciones (si de aplicar)
php artisan migrate


Asegúrate de que esa base de datos exista en tu entorno (puedes crearla desde phpMyAdmin o HeidiSQL).

🚀 Levantar el servidor de desarrollo

  php artisan serve

Esto abrirá Laravel en http://127.0.0.1:8000

Si usas Laragon, también puedes acceder desde tu dominio local, como:
http://openweathermap.test

🔐 Configurar OpenWeatherMap

Agrega tu API Key al archivo .env:

OPENWEATHERMAP_API_KEY=tu_api_key


✅ Verifica los endpoints
Abre en el navegador:

Clima actual:
http://127.0.0.1:8000/api/weather/current?city=Madrid&country=ES

Previsión del clima:
http://127.0.0.1:8000/api/weather/forecast?city=Madrid&country=ES&days=3


🧪 Comandos Artisan
Puedes ejecutar los siguientes comandos para obtener información desde consola:

Clima actual: php artisan current HavanaCU --units=imperial

Previsión meteorológica: php artisan forecast MadridES --days=5 --units=metric

