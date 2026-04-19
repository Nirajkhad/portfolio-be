<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * SecurityHeaders Middleware
 *
 * Adds security headers to all responses for enhanced application security.
 * Protects against common vulnerabilities like XSS, clickjacking, and MIME sniffing.
 */
class SecurityHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Prevent clickjacking attacks
        $response->headers->set('X-Frame-Options', 'DENY');

        // Prevent MIME type sniffing
        $response->headers->set('X-Content-Type-Options', 'nosniff');

        // Enable XSS protection (legacy browsers)
        $response->headers->set('X-XSS-Protection', '1; mode=block');

        // Referrer policy - control referrer information
        $response->headers->set('Referrer-Policy', env('SECURITY_REFERRER_POLICY', 'strict-origin-when-cross-origin'));

        // Content Security Policy
        if (env('SECURITY_CSP_ENABLED', false)) {
            $response->headers->set('Content-Security-Policy', env('SECURITY_CSP', "default-src 'self'"));
        }

        // Strict Transport Security (HSTS) - Force HTTPS
        if (env('SECURITY_HSTS_ENABLED', false)) {
            $maxAge = env('SECURITY_HSTS_MAX_AGE', 31536000); // 1 year
            $includeSubDomains = env('SECURITY_HSTS_SUBDOMAINS', true) ? '; includeSubDomains' : '';
            $preload = env('SECURITY_HSTS_PRELOAD', false) ? '; preload' : '';
            
            $response->headers->set('Strict-Transport-Security', "max-age={$maxAge}{$includeSubDomains}{$preload}");
        }

        // Permissions Policy (formerly Feature Policy)
        $permissionsPolicy = env('SECURITY_PERMISSIONS_POLICY', 'geolocation=(), microphone=(), camera=()');
        if ($permissionsPolicy) {
            $response->headers->set('Permissions-Policy', $permissionsPolicy);
        }

        return $response;
    }
}
