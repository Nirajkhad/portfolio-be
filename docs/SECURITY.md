# Security Configuration

This document describes the security measures implemented in the Portfolio API. The application applies defense-in-depth through CORS, rate limiting, security headers, input sanitization, and proxy trust configuration.

## CORS (Cross-Origin Resource Sharing)

**File:** `config/cors.php`

CORS is configured entirely through environment variables, making it adaptable across environments (local, staging, production).

```env
# Comma-separated list of allowed origins (no trailing slashes)
CORS_ALLOWED_ORIGINS=http://localhost:3000,http://localhost:5173

CORS_ALLOWED_METHODS=GET,POST,PUT,PATCH,DELETE,OPTIONS
CORS_ALLOWED_HEADERS=Content-Type,Authorization,X-Requested-With,Accept,Origin
CORS_EXPOSED_HEADERS=
CORS_MAX_AGE=3600
CORS_SUPPORTS_CREDENTIALS=false
```

**Production:**
```env
CORS_ALLOWED_ORIGINS=https://your-frontend.vercel.app
```

Laravel's `HandleCors` middleware is registered globally (prepended) and applies to `api/*` paths.

## Rate Limiting

Applied to all `/api/v1/*` routes via the `throttle` middleware.

```env
API_RATE_LIMIT=60        # requests per decay period
API_RATE_LIMIT_DECAY=1   # decay period in minutes
```

**Behavior:**
- Tracks requests by client IP
- Returns `429 Too Many Requests` when exceeded
- Includes `X-RateLimit-Limit`, `X-RateLimit-Remaining`, and `Retry-After` headers

Rate limit configuration is read dynamically in `bootstrap/app.php` and passed to the API middleware group.

## Security Headers

**Middleware:** `App\Http\Middleware\SecurityHeaders`

Applied globally to all responses. Each header is configurable via environment variables.

| Header | Default Value | Config Key | Purpose |
|--------|--------------|------------|---------|
| `X-Frame-Options` | `DENY` | — | Prevents clickjacking |
| `X-Content-Type-Options` | `nosniff` | — | Prevents MIME sniffing |
| `X-XSS-Protection` | `1; mode=block` | — | Legacy XSS filter |
| `Referrer-Policy` | `strict-origin-when-cross-origin` | `SECURITY_REFERRER_POLICY` | Controls referrer header |
| `Permissions-Policy` | `geolocation=(), microphone=(), camera=()` | `SECURITY_PERMISSIONS_POLICY` | Restricts browser APIs |
| `Content-Security-Policy` | (configurable) | `SECURITY_CSP`, `SECURITY_CSP_ENABLED` | Controls resource loading |
| `Strict-Transport-Security` | (configurable) | `SECURITY_HSTS_ENABLED`, `SECURITY_HSTS_MAX_AGE`, `SECURITY_HSTS_SUBDOMAINS`, `SECURITY_HSTS_PRELOAD` | Forces HTTPS |

### CSP

Disabled by default. Enable in production:

```env
SECURITY_CSP_ENABLED=true
SECURITY_CSP=default-src 'self'; script-src 'self'; style-src 'self'
```

### HSTS

Enable only when the app is served over HTTPS (Render handles this automatically):

```env
SECURITY_HSTS_ENABLED=true
SECURITY_HSTS_MAX_AGE=31536000
SECURITY_HSTS_SUBDOMAINS=true
```

## Input Sanitization

**Middleware:** `App\Http\Middleware\SanitizeInput`

Applied to all API routes. Performs:
- Trims whitespace from all string inputs
- Removes null bytes
- Optionally strips HTML tags (disabled by default)

```env
SANITIZE_INPUT=true
STRIP_HTML_TAGS=false
```

## Trusted Proxies

Required when running behind Render's reverse proxy to generate correct URLs and respect forwarded headers:

```env
TRUST_PROXIES=true
TRUSTED_PROXIES=*
```

Laravel's `HandleInertiaRequests` middleware is used to trust proxies when `TRUST_PROXIES` is enabled.

## Laravel Built-in Protections

- **SQL Injection** — Eloquent ORM uses PDO parameter binding
- **CSRF** — Tokens for web routes (stateless API routes are exempt)
- **Password Hashing** — Bcrypt via `Hash` facade (12 rounds)
- **Encryption** — AES-256-CBC via `Crypt` facade
- **XSS** — Blade auto-escapes output (admin panel only; API returns JSON)
- **Session** — `database` driver (not `file`)
- **Cache/Queue** — `database` driver (not `file`)

## Production Checklist

- [ ] `APP_DEBUG=false`
- [ ] `APP_ENV=production`
- [ ] `APP_KEY` generated and set (never committed)
- [ ] `CORS_ALLOWED_ORIGINS` restricted to specific origins (no `*`)
- [ ] Rate limiting tuned for expected traffic
- [ ] HSTS enabled (Render provides HTTPS)
- [ ] CSP enabled with restrictive policy
- [ ] `TRUST_PROXIES=true` (Render proxy)
- [ ] `LOG_LEVEL=error`
- [ ] Dependencies kept current (`composer audit`)
