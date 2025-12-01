<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use App\Events\SecurityEvent;

class ForceHTTPS
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Wajib: Percayai Proxy untuk mendapatkan protokol HTTPS yang benar dari Railway
        // Ini mengatasi masalah mixed content (HTTP di HTTPS)
        if (config('app.env') !== 'local' && !$request->headers->has('X-Forwarded-Proto')) {
            // Jika header X-Forwarded-Proto hilang (hanya untuk debugging di PaaS)
            $request->setTrustedProxies(
                ['0.0.0.0/0'],
                Request::HEADER_X_FORWARDED_FOR |
                    Request::HEADER_X_FORWARDED_HOST |
                    Request::HEADER_X_FORWARDED_PORT |
                    Request::HEADER_X_FORWARDED_PROTO
            );
        }

        // Skip HTTPS check if disabled in config
        if (!config('security.force_https', true)) {
            return $next($request);
        }

        // Skip for local development
        if (app()->environment('local')) {
            return $next($request);
        }

        $clientIP = $request->ip();

        // 2. Cek dan Redirect jika masih HTTP
        if (!$request->isSecure()) {
            Log::channel('security')->info('HTTP request redirected to HTTPS', [
                'ip' => $clientIP,
                'url' => $request->fullUrl()
            ]);

            // Redirect to HTTPS version
            $httpsUrl = 'https://' . $request->getHttpHost() . $request->getRequestUri();

            return redirect()->to($httpsUrl, 301)
                ->header('Strict-Transport-Security', 'max-age=31536000; includeSubDomains; preload')
                ->header('X-Content-Type-Options', 'nosniff')
                ->header('X-Frame-Options', 'DENY')
                ->header('X-XSS-Protection', '1; mode=block');
        }

        // 3. Tambahkan Security Headers setelah permintaan sudah HTTPS
        $response = $next($request);

        return $this->addSecurityHeaders($response);
    }

    /**
     * Check for mixed content issues (diperbarui)
     */
    private function hasMixedContentIssues(Request $request): bool
    {
        // Logika ini bisa dihilangkan jika TrustProxies bekerja, karena APP_URL sudah benar
        // Tapi kita biarkan untuk keamanan tambahan.
        $referer = $request->header('Referer');

        if ($referer && str_starts_with($referer, '') && $request->isSecure()) {
            return true;
        }

        $requestContent = json_encode($request->all());
        $insecurePatterns = ['http://', 'ws://'];

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
            'Strict-Transport-Security' => 'max-age=31536000; includeSubDomains; preload',
            'X-Content-Type-Options' => 'nosniff',
            // Gunakan SAMEORIGIN untuk Filament/Admin Panel
            'X-Frame-Options' => 'SAMEORIGIN',
            'X-XSS-Protection' => '1; mode=block',
            'Referrer-Policy' => 'strict-origin-when-cross-origin',
            'Permissions-Policy' => $this->getPermissionsPolicy(),
            'Content-Security-Policy' => $this->getContentSecurityPolicy()
        ];

        foreach ($securityHeaders as $header => $value) {
            $response->header($header, $value);
        }

        return $response;
    }

    /**
     * Get Permissions Policy header value (Tidak Berubah)
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
     * Get Content Security Policy header value (Diperbarui untuk Connect-Src)
     */
    private function getContentSecurityPolicy(): string
    {
        $csp = [
            "default-src 'self'",
            // Tambahkan semua sumber yang diperlukan oleh Vite/Filament/Livewire
            "script-src 'self' 'unsafe-inline' 'unsafe-eval' https://cdn.jsdelivr.net https://cdnjs.cloudflare.com https://maps.googleapis.com",
            "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com https://cdn.jsdelivr.net https://cdnjs.cloudflare.com",
            "font-src 'self' https://fonts.gstatic.com https://cdn.jsdelivr.net",
            "img-src 'self' data: https: blob:",
            "media-src 'self' https:",
            "object-src 'none'",
            "base-uri 'self'",
            "form-action 'self'",
            "frame-ancestors 'self'",
            // PENTING: Connect-src diubah untuk menangani panggilan API dan Livewire (wss:)
            // Memasukkan http: 'self' dan https: akan mengizinkan panggilan API yang sebelumnya gagal (jika TrustProxies gagal memaksakan HTTPS).
            "connect-src 'self' http: https: wss:",
            "worker-src 'self' blob:",
            "manifest-src 'self'",
            "upgrade-insecure-requests"
        ];

        return implode('; ', $csp);
    }
}
