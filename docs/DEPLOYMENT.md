# Deployment Guide

Deploy the Portfolio API to **Render** using Docker. The container runs Nginx + PHP-FPM under Supervisor, handling both the web server and application in a single process.

## Architecture

```
                   Render
          ┌─────────────────────┐
          │   Docker Container  │
          │                     │
          │   Nginx (port 8080) │──┐
          │         │           │  │
          │   PHP-FPM (9000)    │  │── HTTPS (Render proxy)
          │         │           │  │
          │   Supervisor        │  │
          │         │           │──┘
          │   Entrypoint.sh     │
          │   (migrations +     │
          │    cache optimize)  │
          └─────────────────────┘
                      │
               PostgreSQL
              (third-party)
```

The `render.yaml` at the project root defines the entire infrastructure as code.

## render.yaml Reference

```yaml
services:
  - type: web
    name: portfolio-api
    runtime: docker
    plan: free
    region: frankfurt
    branch: main
    dockerfilePath: .docker/server/Dockerfile
    dockerContext: .
    healthCheckPath: /up
    envVars:
      # Application
      - key: APP_ENV
        value: "production"
      - key: APP_KEY
        sync: false              # set manually
      - key: APP_DEBUG
        value: "false"
      - key: APP_URL
        sync: false              # set after deploy

      # Database (third-party)
      - key: DB_CONNECTION
        value: "pgsql"
      - key: DB_HOST
        sync: false
      - key: DB_PORT
        value: "5432"
      - key: DB_DATABASE
        sync: false
      - key: DB_USERNAME
        sync: false
      - key: DB_PASSWORD
        sync: false

      # CORS
      - key: CORS_ALLOWED_ORIGINS
        sync: false

      # Logging
      - key: LOG_LEVEL
        value: "error"
```

## Step-by-Step

### 1. Prepare the Repository

Ensure your `main` branch has these files committed:

```
render.yaml
.docker/server/Dockerfile
.docker/server/entrypoint.sh
.docker/server/nginx.conf
.docker/server/supervisord.conf
```

### 2. Create a Render Web Service

- Log in to [Render Dashboard](https://dashboard.render.com)
- Click **New +** → **Blueprint**
- Connect your GitHub repository
- Render reads `render.yaml` and creates the service

### 3. Configure Environment Variables

After the Blueprint runs, set these **manually** in the Render dashboard (they're marked `sync: false`):

| Variable | Description | Example |
|----------|-------------|---------|
| `APP_KEY` | Laravel encryption key | Generate with `php artisan key:generate --show` |
| `APP_URL` | Your Render app URL | `https://portfolio-api.onrender.com` |
| `DB_HOST` | PostgreSQL host | Your DB provider's host |
| `DB_DATABASE` | Database name | `portfolio` |
| `DB_USERNAME` | DB user | `postgres` |
| `DB_PASSWORD` | DB password | (your password) |
| `CORS_ALLOWED_ORIGINS` | Frontend URLs | `https://your-frontend.vercel.app` |

### 4. Set Up a Database

This project uses a **third-party PostgreSQL provider** (not Render's built-in DB). You can use:

- [Neon](https://neon.tech) (free tier with 0.5GB)
- [Supabase](https://supabase.com) (free tier with 500MB)
- [Aiven](https://aiven.io)
- Any PostgreSQL provider

Once you have the credentials, add `DB_HOST`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD` in the Render env vars.

### 5. Get Your Public URL

- Render assigns a URL automatically: `https://portfolio-api.onrender.com`
- Set this as `APP_URL` in env vars
- (Optional) Configure a custom domain in Render → Settings → Custom Domain

### 6. Deploy

Push to `main` — Render auto-deploys. The entrypoint runs:

1. `php artisan migrate --force`
2. `php artisan config:cache`
3. `php artisan route:cache`
4. `php artisan view:cache`
5. `php artisan filament:optimize`
6. Starts Supervisor (Nginx + PHP-FPM)

Monitor the deploy in Render Dashboard → Deployments tab.

## Container Details

### Dockerfile (`.docker/server/Dockerfile`)

- Base: `php:8.4-fpm`
- Installs Nginx, Supervisor, PHP extensions (pdo_mysql, pdo_pgsql, mbstring, bcmath, zip, intl, gd, exif, redis)
- Runs `composer install` and `php artisan storage:link` at build time
- Exposes port **8080**
- Entrypoint runs migrations + caching, then starts Supervisor

### Nginx (`.docker/server/nginx.conf`)

- Listens on port **8080**
- Serves from `/var/www/html/public`
- Proxies PHP requests to `127.0.0.1:9000`
- `client_max_body_size 50M`

### Supervisor (`.docker/server/supervisord.conf`)

Runs two processes:
- `nginx` - daemon off
- `php-fpm` - foreground

Both log to stdout/stderr for Render log aggregation.

## Environment Variables Reference

| Variable | Required | Default | Description |
|----------|----------|---------|-------------|
| `APP_ENV` | Yes | `production` | Application environment |
| `APP_KEY` | **Yes** | — | Laravel encryption key (generate with `key:generate --show`) |
| `APP_DEBUG` | No | `false` | Enable debug mode (never `true` in production) |
| `APP_URL` | **Yes** | — | Public URL of the app |
| `DB_CONNECTION` | No | `pgsql` | Database driver |
| `DB_HOST` | **Yes** | — | Database host |
| `DB_PORT` | No | `5432` | Database port |
| `DB_DATABASE` | **Yes** | — | Database name |
| `DB_USERNAME` | **Yes** | — | Database user |
| `DB_PASSWORD` | **Yes** | — | Database password |
| `CORS_ALLOWED_ORIGINS` | **Yes** | — | Comma-separated frontend origins |
| `LOG_LEVEL` | No | `error` | Log level (production: `error`, debugging: `debug`) |
| `SESSION_DRIVER` | No | `database` | Session driver |
| `CACHE_STORE` | No | `database` | Cache driver |
| `QUEUE_CONNECTION` | No | `database` | Queue driver |

## Health Check

The service pings `GET /up`. Ensure your app responds at this path. Laravel doesn't have a built-in `/up` route — add one in `routes/web.php`:

```php
Route::get('/up', fn () => response()->json(['status' => 'ok']));
```

## Troubleshooting

| Symptom | Likely Cause | Fix |
|---------|-------------|-----|
| Build fails | Composer out of memory | Increase Render plan or optimize `composer.json` |
| Container exits immediately | Entrypoint script error | Check deploy logs; set `LOG_LEVEL=debug` temporarily |
| 502 Bad Gateway | PHP-FPM not starting | Check Supervisor logs in Render dashboard |
| 503 after deploy | Migrations failing | Run `php artisan migrate --force` via Render Shell |
| Filament no CSS | `APP_URL` mismatch | Ensure `APP_URL` matches the Render domain exactly |

### Checking Logs

In Render Dashboard:
1. Click your service → **Logs** tab
2. Toggle between **Deploy** and **Runtime** logs
3. Filter by severity or search for keywords

### Shell Access

Render doesn't provide persistent SSH. Use the **Shell** tab in the dashboard for one-off commands:
```bash
php artisan migrate --force
php artisan db:seed --force
php artisan optimize:clear
```

## Post-Deployment Checklist

- [ ] `APP_DEBUG=false`
- [ ] `APP_ENV=production`
- [ ] `APP_KEY` generated and set
- [ ] `APP_URL` matches the Render domain
- [ ] `CORS_ALLOWED_ORIGINS` set to actual frontend origin(s)
- [ ] Database migrations ran successfully
- [ ] Health check `GET /up` returns 200
- [ ] API endpoints return correct data
- [ ] Filament admin panel at `/admin` loads with styling
