<?php

use App\Http\Middleware\SanitizeInput;
use App\Http\Middleware\SecurityHeaders;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Middleware\HandleCors;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        apiPrefix: 'api/v1',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // CORS handling (must be before other middleware)
        $middleware->prepend(HandleCors::class);

        // Global security headers (safe for all routes)
        $middleware->append(SecurityHeaders::class);

        // API-specific middleware
        $middleware->api(append: [
            // Input sanitization (only for API routes, not Filament admin)
            SanitizeInput::class,
            // Rate limiting
            'throttle:' . env('API_RATE_LIMIT', '60') . ',' . env('API_RATE_LIMIT_DECAY', '1'),
        ]);

        // Trust proxies (for load balancers, reverse proxies)
        if (env('TRUST_PROXIES', false)) {
            $middleware->trustProxies(at: env('TRUSTED_PROXIES', '*'));
        }

        // Trust hosts (prevent host header attacks)
        if (env('TRUST_HOSTS', false)) {
            $trustedHosts = array_filter(array_map('trim', explode(',', env('TRUSTED_HOSTS_LIST', ''))));
            if (! empty($trustedHosts)) {
                $middleware->trustHosts(at: $trustedHosts);
            }
        }
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
