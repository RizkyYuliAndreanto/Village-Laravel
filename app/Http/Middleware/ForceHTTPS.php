<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class ForceHTTPS
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Skip for local development
        if (app()->environment('local')) {
            return $next($request);
        }

        // Skip HTTPS check if disabled in config
        if (!config('security.force_https', true)) {
            return $next($request);
        }

        // For Railway, trust all proxies
        if (app()->environment('production')) {
            $request->setTrustedProxies(['*'], Request::HEADER_X_FORWARDED_ALL);
        }

        // Check if request is secure
        if (!$request->isSecure() && app()->environment('production')) {
            // Log the redirect attempt
            Log::info('HTTP request redirected to HTTPS', [
                'ip' => $request->ip(),
                'url' => $request->fullUrl(),
                'headers' => $request->headers->all()
            ]);

            // Redirect to HTTPS version
            $httpsUrl = 'https://' . $request->getHttpHost() . $request->getRequestUri();
            return redirect()->to($httpsUrl, 301);
        }

        // Process request
        $response = $next($request);

        // Add minimal security headers
        if (app()->environment('production')) {
            $response->header('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
            $response->header('X-Content-Type-Options', 'nosniff');
            $response->header('X-Frame-Options', 'SAMEORIGIN');
        }

        return $response;
    }
}
