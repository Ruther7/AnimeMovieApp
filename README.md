# Anime Movie App

A full-stack anime discovery and watchlist application.

## Tech Stack

- Backend: Laravel 13 + MySQL + Eloquent REST API
- Frontend: Vue 3 + Quasar + TypeScript + Vite
- HTTP client: Axios

## Prerequisites

- PHP 8.3+
- Composer
- Node.js 18+
- npm 9+
- MySQL 8+
- Laragon (recommended for Windows)

## Project Structure

```
AnimeMovieApp/
  backend/          Laravel application
  frontend/         Vue 3 + Quasar application
  project-prompt.txt
```

## Backend Setup

1. Open Laragon and click Start All.
2. Configure the database in `backend/.env`:
   - `DB_CONNECTION=mysql`
   - `DB_DATABASE=anime_movie_app`
   - `DB_USERNAME=root`
   - `DB_PASSWORD=`
3. Create the database:
   - `mysql -u root -e "CREATE DATABASE IF NOT EXISTS anime_movie_app CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"`
4. Install dependencies:
   - `cd backend`
   - `composer install`
5. Run migrations and seeders:
   - `php artisan migrate --force`
   - `php artisan db:seed --class=AnimeSeeder --force`
6. Start the backend server:
   - `php artisan serve --host=0.0.0.0 --port=8000`

The API will be available at `http://localhost:8000/api`.

## Frontend Setup

1. Install dependencies:
   - `cd frontend`
   - `npm install`
2. Start the dev server:
   - `npm run dev`

The frontend will be available at `http://localhost:9000` (or another Vite port) and proxies `/api` requests to the Laravel backend.

## API Endpoints

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/api/anime` | List anime (supports `search`, `genre`, `status` query params) |
| POST | `/api/anime` | Create anime |
| GET | `/api/anime/{id}` | Get anime details |
| PUT | `/api/anime/{id}` | Update anime |
| DELETE | `/api/anime/{id}` | Delete anime |
| GET | `/api/watchlist` | List watchlist |
| POST | `/api/watchlist` | Add to watchlist (`anime_id`) |
| GET | `/api/watchlist/{id}` | Get watchlist item |
| DELETE | `/api/watchlist/{id}` | Remove from watchlist |

## Notes

- The backend uses MySQL by default.
- The frontend runs on Vite and proxies API requests to the Laravel dev server.
- Do not commit `.env` files.
- Sample anime data is seeded via `AnimeSeeder`.

## Testing

- Backend API has been verified by browser requests returning seeded JSON.
- Frontend build has been verified with `npm run build`.
