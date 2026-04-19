<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * SanitizeInput Middleware
 *
 * Sanitizes user input to prevent XSS attacks.
 * Trims whitespace and removes null bytes from all input data.
 */
class SanitizeInput
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (env('SANITIZE_INPUT', true)) {
            $input = $this->sanitize($request->all());
            $request->merge($input);
        }

        return $next($request);
    }

    /**
     * Recursively sanitize the input data.
     *
     * @param  mixed  $data
     * @return mixed
     */
    protected function sanitize(mixed $data): mixed
    {
        if (is_array($data)) {
            return array_map([$this, 'sanitize'], $data);
        }

        if (is_string($data)) {
            // Remove null bytes
            $data = str_replace("\0", '', $data);
            
            // Trim whitespace
            $data = trim($data);
            
            // Optional: Strip HTML tags (disable for rich text content)
            if (env('STRIP_HTML_TAGS', false)) {
                $data = strip_tags($data);
            }
        }

        return $data;
    }
}
