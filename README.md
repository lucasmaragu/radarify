# 📡 Radarify - Real-Time Spotify Proximity Radar

![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![Vue.js](https://img.shields.io/badge/Vue.js-35495E?style=for-the-badge&logo=vuedotjs&logoColor=4FC08D)
![PostgreSQL](https://img.shields.io/badge/PostgreSQL_+-PostGIS-316192?style=for-the-badge&logo=postgresql&logoColor=white)
![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)
![Spotify](https://img.shields.io/badge/Spotify_API-1DB954?style=for-the-badge&logo=spotify&logoColor=white)

Radarify es una aplicación web *mobile-first* que actúa como un radar social musical. Te permite descubrir en tiempo real qué están escuchando en Spotify las personas que se encuentran físicamente cerca de ti (en un radio de 100 metros).

## ✨ Características Principales

* **Autenticación Segura (OAuth2):** Inicio de sesión nativo e integración directa con la API de Spotify.
* **Motor Geoespacial (PostGIS):** Cálculo de distancias preciso teniendo en cuenta la curvatura de la Tierra mediante `ST_DWithin` y `ST_Distance`.
* **Sincronización Asíncrona:** * Motor de polling por intervalos para mantener actualizado el estado de reproducción (canción actual).
    * Motor reactivo basado en eventos (`watchPosition`) para actualizar la ubicación solo cuando el usuario se mueve en el mundo real, optimizando el rendimiento.
* **Arquitectura Limpia (SOLID):** Backend estructurado en Laravel utilizando *Single Action Controllers* (Controladores Invokables) y *Actions* dedicadas, logrando un desacoplamiento total entre la lógica musical y la de geolocalización.
* **UI/UX Mobile-First:** Interfaz oscura, minimalista y moderna construida con Vue 3 (Composition API), Inertia.js y Tailwind CSS, diseñada para sentirse como una app nativa.

## 🛠️ Stack Tecnológico

**Backend:**
* Laravel 11
* PostgreSQL + extensión PostGIS (Manejo de coordenadas geográficas)
* Laravel Sail (Entorno Dockerizado)

**Frontend:**
* Vue 3 (Composition API)
* Inertia.js (Enrutamiento monolítico sin API REST intermedia)
* Tailwind CSS v4
* Lucide Icons

---

## 🚀 Instalación y Despliegue Local

### Requisitos Previos
* Docker y Docker Compose instalados.
* Node.js y NPM.
* Una cuenta de desarrollador en [Spotify for Developers](https://developer.spotify.com/dashboard) para obtener tu `Client ID` y `Client Secret`.

### Pasos para levantar el proyecto

1. **Clona el repositorio:**
   ```bash
   git clone [https://github.com/tu-usuario/radarify.git](https://github.com/tu-usuario/radarify.git)
   cd radarify

2. **Instala las dependencias de PHP (usando un contenedor temporal):**
   ```bash
   docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php83-composer:latest \
    composer install --ignore-platform-reqs

3. **Configura el entorno:**
   Copia el archivo de ejemplo y configura tus variables. Añadiendo tus credenciales de Spotify en el .env.
   ```bash
    cp .env.example .env
    SPOTIFY_CLIENT_ID=tu_client_id
    SPOTIFY_CLIENT_SECRET=tu_client_secret
    SPOTIFY_REDIRECT_URI=http://localhost:8000/auth/spotify/callback
    
5. **Levanta los contenedores con Laravel Sail:**
   ```bash
   ./vendor/bin/sail up -d
   
6. **Prepara la Base de Datos:**
   Genera la clave de la app y ejecuta las migraciones (esto creará las tablas con soporte PostGIS).
   ```bash
   ./vendor/bin/sail artisan key:generate
   ./vendor/bin/sail artisan migrate
   
7. **Compila el Frontend:**
   Debido a que el proyecto utiliza Vite 7 (Tailwind 4) y el plugin oficial de Vue requiere Vite 6, es necesario usar el flag de dependencias      legacy durante la instalación:
   ```bash
   npm install --legacy-peer-deps
   npm run dev

## 🤝 Contribuciones

¡Las contribuciones son bienvenidas! Si tienes alguna idea para mejorar el radar o añadir nuevas funcionalidades (como reproducir la canción al hacer clic en un usuario), siéntete libre de abrir una Issue o un Pull Request.

## 📄 Licencia

Este proyecto está bajo la Licencia MIT.
