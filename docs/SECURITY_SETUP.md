# Security Quick-Start

Implemented security features and how to configure them.

## Features

| Layer | Mechanism | Scope |
|-------|-----------|-------|
| CORS | Environment-driven config | `api/*` routes |
| Rate Limiting | Throttle middleware | All `/api/v1/*` routes (60 req/min default) |
| Security Headers | Custom middleware | All responses globally |
| Input Sanitization | Custom middleware | All API routes |
| Proxy Trust | Config | Behind Render reverse proxy |

## Quick Configuration

### 1. CORS

```env
CORS_ALLOWED_ORIGINS=https://your-frontend.com
```

### 2. Rate Limiting

```env
API_RATE_LIMIT=100
API_RATE_LIMIT_DECAY=1
```

### 3. Security Headers

```env
SECURITY_HSTS_ENABLED=true
SECURITY_CSP_ENABLED=true
SECURITY_CSP=default-src 'self'; script-src 'self'; style-src 'self'
```

### 4. Proxy Trust (Render)

```env
TRUST_PROXIES=true
TRUSTED_PROXIES=*
```

## Testing

```bash
# Check CORS headers
curl -I -X OPTIONS https://your-app.onrender.com/api/v1/posts \
  -H "Origin: https://your-frontend.com" \
  -H "Access-Control-Request-Method: GET"

# Test rate limiting
for i in {1..65}; do curl -I https://your-app.onrender.com/api/v1/posts 2>&1 | grep -i "HTTP/"; done

# Check security headers
curl -I https://your-app.onrender.com/
```

## Files

| File | Purpose |
|------|---------|
| `config/cors.php` | CORS configuration |
| `app/Http/Middleware/SecurityHeaders.php` | Security headers middleware |
| `app/Http/Middleware/SanitizeInput.php` | Input sanitization middleware |
| `bootstrap/app.php` | Middleware registration |

## See Also

- `docs/SECURITY.md` — Full security documentation with all configuration options
