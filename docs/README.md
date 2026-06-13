# Portfolio API

A RESTful API backend for a personal portfolio site — serves projects, work experience, skills, blog posts, and contact info to a frontend SPA. Built with Laravel 13, PostgreSQL, and Filament admin.

## Features

- **Public REST API** — 11 endpoints serving portfolio data
- **Filament Admin Panel** — `/admin` for managing all content (posts, projects, experiences, skills, general info)
- **Security** — CORS, rate limiting, security headers, input sanitization
- **Docker Local Dev** — `docker compose` with PHP-FPM, Nginx, PostgreSQL
- **Render Deployment** — Docker-based single-container deploy with Nginx + PHP-FPM via Supervisor

## API Endpoints

All endpoints are public (no auth), prefixed with `/api/v1`, and rate-limited (default: 60 req/min).

| Resource | Endpoint | Description |
|----------|----------|-------------|
| Portfolio | `GET /api/v1/portfolio` | Active portfolio info with social links |
| General | `GET /api/v1/general-infos` | All general info records |
| Experiences | `GET /api/v1/experiences` | All experiences with achievement bullets |
| Experiences | `GET /api/v1/experiences/{id}` | Single experience by UUID |
| Projects | `GET /api/v1/projects` | All projects with tech stacks |
| Projects | `GET /api/v1/projects/featured` | Featured projects only |
| Skills | `GET /api/v1/skills` | All skills |
| Skills | `GET /api/v1/skills/grouped` | Skills grouped by category |
| Posts | `GET /api/v1/posts` | All posts |
| Posts | `GET /api/v1/posts/published` | Published posts only |
| Posts | `GET /api/v1/posts/{slug}` | Single post by slug |

All responses follow a consistent envelope:
```json
{
  "success": true,
  "data": { ... }
}
```

## Tech Stack

| Layer | Technology |
|-------|-----------|
| Framework | Laravel 13 |
| Language | PHP 8.4 |
| Database | PostgreSQL |
| Admin Panel | Filament 4 |
| Local Dev | Docker Compose (PHP-FPM + Nginx + PostgreSQL) |
| Production | Docker (single container: Nginx + PHP-FPM + Supervisor) |
| Hosting | Render |
| Code Style | Laravel Pint |

## Local Development

### Prerequisites

- PHP 8.4+, Composer, PostgreSQL — or — Docker + Docker Compose

### Manual Setup

```bash
composer install
cp .env.example .env
php artisan key:generate
# configure DB in .env, then:
php artisan migrate
php artisan db:seed       # optional
php artisan serve         # http://localhost:8000
```

### Docker Setup

```bash
./docker-start.sh
# App + Nginx at http://localhost:8080
# PostgreSQL at localhost:5432
```

### Tests

```bash
php artisan test
```

### Code Style

```bash
composer lint     # check
composer lint:fix # auto-fix
```

## Project Structure

```
app/
  Actions/            # Single-purpose query classes (GetAllPostsAction, etc.)
  Filament/Resources/ # Admin panel CRUD resources (5 resources)
  Http/
    Controllers/Api/  # API controllers (5 controllers)
    Middleware/        # SecurityHeaders, SanitizeInput
  Models/             # Eloquent models (8 models)
  Services/           # Business logic layer (5 services)
config/               # Application configuration
database/
  migrations/         # 11 migration files
  seeders/            # Database seeders
  factories/          # Model factories
docs/                 # Documentation
routes/
  api.php             # API route definitions
tests/                # PHPUnit tests
.docker/
  local/              # Docker Compose for local dev
  server/             # Single-container Dockerfile for Render
```

## Architecture

Controllers handle HTTP, delegate to Services, which call Actions for single database queries. Models use UUIDs (`HasUuids` trait) and follow `HasFactory` for testing.

## Security

- **CORS** — Configurable allowed origins via env vars
- **Rate Limiting** — 60 req/min per IP (configurable)
- **Security Headers** — X-Frame-Options, HSTS, CSP, Referrer-Policy, Permissions-Policy
- **Input Sanitization** — Trims whitespace, removes null bytes, optional HTML stripping
- **Trusted Proxies** — Configurable for load balancers

See `docs/SECURITY.md` for details.

## Deployment

Deploy to Render using the Docker setup in `.docker/server/`:

1. Push to `main` branch
2. Render auto-detects `render.yaml` and builds the Docker image
3. Container starts Nginx + PHP-FPM via Supervisor on port 8080
4. Entrypoint runs migrations and production caching

See `docs/DEPLOYMENT.md` for the full guide.
