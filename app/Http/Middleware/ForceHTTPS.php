<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Events\SecurityEvent;

class ForceHTTPS
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // Skip HTTPS check if disabled in config
        if (!config('security.force_https', false)) {
            return $next($request);
        }

        // Skip for local development
        if (app()->environment('local') && !config('security.force_https_local', false)) {
            return $next($request);
        }

        $clientIP = $request->ip();

        // Check if request is already HTTPS
        if (!$request->isSecure()) {
            // Log insecure request attempt
            Log::channel('security')->info('HTTP request redirected to HTTPS', [
                'ip' => $clientIP,
                'url' => $request->fullUrl(),
                'user_agent' => $request->userAgent(),
                'method' => $request->method()
            ]);

            // Trigger security event for monitoring
            event(new SecurityEvent('http_to_https_redirect', $clientIP, [
                'original_url' => $request->fullUrl(),
                'method' => $request->method()
            ]));

            // Redirect to HTTPS version
            $httpsUrl = 'https://' . $request->getHttpHost() . $request->getRequestUri();

            return redirect()->to($httpsUrl, 301)
                ->header('Strict-Transport-Security', 'max-age=31536000; includeSubDomains; preload')
                ->header('X-Content-Type-Options', 'nosniff')
                ->header('X-Frame-Options', 'DENY')
                ->header('X-XSS-Protection', '1; mode=block');
        }

        // Check for mixed content issues
        if ($this->hasMixedContentIssues($request)) {
            Log::channel('security')->warning('Potential mixed content detected', [
                'ip' => $clientIP,
                'url' => $request->fullUrl(),
                'referer' => $request->header('Referer')
            ]);
        }

        // Add security headers for HTTPS requests
        $response = $next($request);

        return $this->addSecurityHeaders($response);
    }

    /**
     * Check for mixed content issues
     */
    private function hasMixedContentIssues(Request $request): bool
    {
        $referer = $request->header('Referer');

        // Check if referer is HTTP while current request is HTTPS
        if ($referer && str_starts_with($referer, 'http://')) {
            return true;
        }

        // Check for insecure content in request
        $insecurePatterns = [
            'http://',
            'ws://',  // Insecure WebSocket
        ];

        $requestContent = json_encode($request->all());

        foreach ($insecurePatterns as $pattern) {
            if (strpos($requestContent, $pattern) !== false) {
                return true;
            }
        }

        return false;
    }

    /**
     * Add security headers to response
     */
    private function addSecurityHeaders($response)
    {
        $securityHeaders = [
            // HSTS - Force HTTPS for future requests
            'Strict-Transport-Security' => 'max-age=31536000; includeSubDomains; preload',

            // Prevent MIME type sniffing
            'X-Content-Type-Options' => 'nosniff',

            // Prevent clickjacking
            'X-Frame-Options' => 'SAMEORIGIN',

            // XSS Protection
            'X-XSS-Protection' => '1; mode=block',

            // Referrer Policy
            'Referrer-Policy' => 'strict-origin-when-cross-origin',

            // Permissions Policy (formerly Feature Policy)
            'Permissions-Policy' => $this->getPermissionsPolicy(),

            // Content Security Policy
            'Content-Security-Policy' => $this->getContentSecurityPolicy()
        ];

        foreach ($securityHeaders as $header => $value) {
            $response->header($header, $value);
        }

        return $response;
    }

    /**
     * Get Permissions Policy header value
     */
    private function getPermissionsPolicy(): string
    {
        $policies = [
            'geolocation' => 'self',
            'microphone' => 'none',
            'camera' => 'none',
            'payment' => 'self',
            'usb' => 'none',
            'magnetometer' => 'none',
            'gyroscope' => 'none',
            'speaker' => 'self',
            'vibrate' => 'none',
            'fullscreen' => 'self',
            'picture-in-picture' => 'none'
        ];

        $policyStrings = [];
        foreach ($policies as $feature => $allowlist) {
            if ($allowlist === 'none') {
                $policyStrings[] = "{$feature}=()";
            } else {
                $policyStrings[] = "{$feature}=({$allowlist})";
            }
        }

        return implode(', ', $policyStrings);
    }

    /**
     * Get Content Security Policy header value
     */
    private function getContentSecurityPolicy(): string
    {
        $csp = [
            "default-src 'self'",
            "script-src 'self' 'unsafe-inline' 'unsafe-eval' https://cdn.jsdelivr.net https://cdnjs.cloudflare.com https://maps.googleapis.com",
            "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com https://cdn.jsdelivr.net https://cdnjs.cloudflare.com",
            "font-src 'self' https://fonts.gstatic.com https://cdn.jsdelivr.net",
            "img-src 'self' data: https: blob:",
            "media-src 'self' https:",
            "object-src 'none'",
            "base-uri 'self'",
            "form-action 'self'",
            "frame-ancestors 'self'",
            "connect-src 'self' https: wss:",
            "worker-src 'self' blob:",
            "manifest-src 'self'",
            "upgrade-insecure-requests"
        ];

        return implode('; ', $csp);
    }
}
