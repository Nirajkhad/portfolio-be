# Security Configuration Guide

This Laravel application implements comprehensive security measures including CORS, rate limiting, security headers, and other best practices.

## Security Features Implemented

### 1. Cross-Origin Resource Sharing (CORS)

**Configuration File:** `config/cors.php`

CORS is configured via environment variables for flexibility across environments.

**Environment Variables:**
```env
CORS_ALLOWED_ORIGINS=http://localhost:3000,http://localhost:5173
CORS_ALLOWED_METHODS=GET,POST,PUT,PATCH,DELETE,OPTIONS
CORS_ALLOWED_HEADERS=Content-Type,Authorization,X-Requested-With,Accept,Origin
CORS_EXPOSED_HEADERS=
CORS_MAX_AGE=3600
CORS_SUPPORTS_CREDENTIALS=false
```

**Production Example:**
```env
CORS_ALLOWED_ORIGINS=https://yourfrontend.com,https://app.yourfrontend.com
CORS_ALLOWED_METHODS=GET,POST,PUT,PATCH,DELETE,OPTIONS
CORS_ALLOWED_HEADERS=Content-Type,Authorization,X-Requested-With
CORS_MAX_AGE=86400
CORS_SUPPORTS_CREDENTIALS=true
```

### 2. API Rate Limiting

Rate limiting is applied to all API routes to prevent abuse and DoS attacks.

**Configuration:**
```env
API_RATE_LIMIT=60          # Requests per decay period
API_RATE_LIMIT_DECAY=1     # Decay period in minutes
```

**Default:** 60 requests per minute per IP address

**Production Recommendations:**
- Public APIs: 60-100 requests/minute
- Authenticated APIs: 100-1000 requests/minute
- Adjust based on your application's needs

### 3. Security Headers

**Middleware:** `App\Http\Middleware\SecurityHeaders`

The following security headers are automatically added to all responses:

#### X-Frame-Options
```
X-Frame-Options: DENY
```
Prevents clickjacking attacks by disallowing the page to be embedded in frames.

#### X-Content-Type-Options
```
X-Content-Type-Options: nosniff
```
Prevents MIME type sniffing attacks.

#### X-XSS-Protection
```
X-XSS-Protection: 1; mode=block
```
Enables browser XSS filtering (legacy browser support).

#### Referrer-Policy
```env
SECURITY_REFERRER_POLICY=strict-origin-when-cross-origin
```
Controls how much referrer information is sent with requests.

Options: `no-referrer`, `no-referrer-when-downgrade`, `origin`, `origin-when-cross-origin`, `same-origin`, `strict-origin`, `strict-origin-when-cross-origin`

#### Content Security Policy (CSP)
```env
SECURITY_CSP_ENABLED=false
SECURITY_CSP=default-src 'self'; script-src 'self' 'unsafe-inline'; style-src 'self' 'unsafe-inline'
```

**Production Example:**
```env
SECURITY_CSP_ENABLED=true
SECURITY_CSP=default-src 'self'; script-src 'self'; style-src 'self'; img-src 'self' data: https:; font-src 'self'; connect-src 'self' https://api.yourapp.com
```

#### HTTP Strict Transport Security (HSTS)
```env
SECURITY_HSTS_ENABLED=false      # Enable only when using HTTPS
SECURITY_HSTS_MAX_AGE=31536000   # 1 year in seconds
SECURITY_HSTS_SUBDOMAINS=true    # Apply to subdomains
SECURITY_HSTS_PRELOAD=false      # Include in browser preload list
```

**Production (HTTPS only):**
```env
SECURITY_HSTS_ENABLED=true
SECURITY_HSTS_MAX_AGE=31536000
SECURITY_HSTS_SUBDOMAINS=true
SECURITY_HSTS_PRELOAD=true
```

⚠️ **Warning:** Only enable HSTS when your application is fully running on HTTPS. Enabling it on HTTP will break your application.

#### Permissions Policy
```env
SECURITY_PERMISSIONS_POLICY=geolocation=(), microphone=(), camera=()
```

Controls which browser features and APIs can be used.

### 4. Trusted Proxies & Hosts

**For applications behind load balancers or reverse proxies:**

```env
TRUST_PROXIES=true
TRUSTED_PROXIES=*  # Or comma-separated list of proxy IPs
```

**To prevent host header attacks:**

```env
TRUST_HOSTS=true
TRUSTED_HOSTS_LIST=yourdomain.com,www.yourdomain.com,api.yourdomain.com
```

## Additional Security Best Practices

### 1. Laravel Built-in Security

Laravel provides these security features out of the box:

- **SQL Injection Protection:** Eloquent ORM and Query Builder use PDO parameter binding
- **CSRF Protection:** Automatic CSRF tokens for web routes (not needed for stateless APIs)
- **Password Hashing:** Bcrypt/Argon2 hashing via `Hash` facade
- **Encryption:** AES-256-CBC encryption via `Crypt` facade
- **XSS Protection:** Blade template engine automatically escapes output

### 2. Environment Configuration

```env
# Never set to true in production
APP_DEBUG=false

# Use strong bcrypt rounds (minimum 10, recommended 12+)
BCRYPT_ROUNDS=12

# Production logging
LOG_CHANNEL=daily
LOG_LEVEL=warning
```

### 3. HTTPS Enforcement

For production, always use HTTPS. In your web server configuration:

**Nginx:**
```nginx
server {
    listen 80;
    server_name yourdomain.com;
    return 301 https://$server_name$request_uri;
}

server {
    listen 443 ssl http2;
    server_name yourdomain.com;
    
    ssl_certificate /path/to/cert.pem;
    ssl_certificate_key /path/to/key.pem;
    
    # Strong SSL configuration
    ssl_protocols TLSv1.2 TLSv1.3;
    ssl_ciphers HIGH:!aNULL:!MD5;
    ssl_prefer_server_ciphers on;
}
```

### 4. Input Validation

Always validate and sanitize user input using Laravel's validation:

```php
$request->validate([
    'email' => 'required|email|max:255',
    'name' => 'required|string|max:100|regex:/^[a-zA-Z\s]+$/',
    'url' => 'required|url',
]);
```

### 5. Database Security

- Use parameterized queries (Eloquent does this automatically)
- Limit database user permissions
- Never expose database credentials in version control
- Regularly backup your database
- Use read replicas when possible

### 6. API Authentication

Consider implementing authentication for sensitive endpoints:

```php
// Install Laravel Sanctum
composer require laravel/sanctum

// Or use JWT
composer require tymon/jwt-auth
```

### 7. File Upload Security

If handling file uploads:

```php
$request->validate([
    'file' => 'required|file|mimes:jpg,png,pdf|max:2048',
]);

// Store outside public directory
$path = $request->file('file')->store('uploads', 'private');
```

### 8. Error Handling

Never expose sensitive information in error messages:

```env
# Production
APP_DEBUG=false
LOG_LEVEL=error
```

## Production Deployment Checklist

- [ ] Set `APP_ENV=production`
- [ ] Set `APP_DEBUG=false`
- [ ] Generate new `APP_KEY`
- [ ] Configure proper CORS origins (no wildcards)
- [ ] Enable HSTS if using HTTPS
- [ ] Enable CSP headers
- [ ] Set up rate limiting appropriate for your traffic
- [ ] Configure trusted proxies if behind load balancer
- [ ] Set up proper logging and monitoring
- [ ] Enable SSL/TLS certificates
- [ ] Configure firewall rules
- [ ] Set up automated backups
- [ ] Implement API authentication
- [ ] Review and update trusted hosts
- [ ] Set appropriate session and cache drivers
- [ ] Configure proper file permissions (755 for directories, 644 for files)
- [ ] Disable directory listing in web server
- [ ] Keep dependencies updated

## Security Headers Testing

Test your security headers using:
- [SecurityHeaders.com](https://securityheaders.com/)
- [Mozilla Observatory](https://observatory.mozilla.org/)
- Browser DevTools Network tab

## Monitoring & Logging

Monitor for:
- Failed authentication attempts
- Rate limit violations
- Unusual traffic patterns
- Error spikes
- Slow queries

Use Laravel's built-in logging or integrate with services like:
- Sentry
- Bugsnag
- New Relic
- Datadog

## Updates & Maintenance

1. Regularly update dependencies:
   ```bash
   composer update
   npm update
   ```

2. Review security advisories:
   ```bash
   composer audit
   npm audit
   ```

3. Monitor Laravel security releases: https://laravel.com/docs/releases

## Support

For security vulnerabilities, please email security@yourapp.com instead of using the issue tracker.

## References

- [OWASP Top 10](https://owasp.org/www-project-top-ten/)
- [Laravel Security Best Practices](https://laravel.com/docs/security)
- [MDN Web Security](https://developer.mozilla.org/en-US/docs/Web/Security)
