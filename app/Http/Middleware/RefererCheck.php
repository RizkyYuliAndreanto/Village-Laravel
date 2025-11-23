<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Events\SecurityEvent;

class RefererCheck
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // Skip referer checks in local development
        if (app()->environment('local')) {
            return $next($request);
        }

        $referer = $request->header('Referer');
        $host = $request->getHost();
        $clientIP = $request->ip();

        // Check for hotlinking (direct access to assets)
        if ($this->isAssetRequest($request) && $this->isHotlinking($referer, $host)) {
            Log::channel('security')->warning('Hotlinking attempt detected', [
                'ip' => $clientIP,
                'referer' => $referer,
                'requested_file' => $request->path(),
                'user_agent' => $request->userAgent()
            ]);

            event(new SecurityEvent('hotlinking_attempt', $clientIP, [
                'referer' => $referer,
                'file' => $request->path()
            ]));

            return response('Hotlinking not allowed', 403);
        }

        // Check for unauthorized embedding
        if ($this->isEmbedAttempt($request, $referer, $host)) {
            Log::channel('security')->warning('Unauthorized embed attempt', [
                'ip' => $clientIP,
                'referer' => $referer,
                'url' => $request->fullUrl(),
                'user_agent' => $request->userAgent()
            ]);

            event(new SecurityEvent('unauthorized_embed', $clientIP, [
                'referer' => $referer,
                'url' => $request->fullUrl()
            ]));

            return response('Embedding not allowed', 403);
        }

        // Check for suspicious referer patterns
        if ($this->hasSuspiciousReferer($referer)) {
            Log::channel('security')->info('Suspicious referer detected', [
                'ip' => $clientIP,
                'referer' => $referer,
                'url' => $request->fullUrl()
            ]);
        }

        return $next($request);
    }

    /**
     * Check if request is for assets
     */
    private function isAssetRequest(Request $request): bool
    {
        $assetExtensions = config('security.protected_assets', [
            'jpg',
            'jpeg',
            'png',
            'gif',
            'webp',
            'svg',
            'pdf',
            'doc',
            'docx',
            'xls',
            'xlsx',
            'ppt',
            'pptx',
            'mp4',
            'avi',
            'mov',
            'wmv',
            'flv',
            'mp3',
            'wav',
            'ogg',
            'flac',
            'zip',
            'rar',
            '7z',
            'tar',
            'gz'
        ]);

        $path = $request->path();
        $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));

        return in_array($extension, $assetExtensions);
    }

    /**
     * Check if request is hotlinking
     */
    private function isHotlinking(?string $referer, string $host): bool
    {
        // No referer might indicate direct access or hotlinking
        if (empty($referer)) {
            return true;
        }

        $allowedReferers = config('security.allowed_referers', []);
        $allowedReferers[] = $host; // Always allow same domain

        $refererHost = parse_url($referer, PHP_URL_HOST);

        // Check if referer is in allowed list
        foreach ($allowedReferers as $allowedReferer) {
            if ($this->matchesRefererPattern($refererHost, $allowedReferer)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Check if request is attempting to embed content
     */
    private function isEmbedAttempt(Request $request, ?string $referer, string $host): bool
    {
        // Check for iframe or embed attempts
        $embedIndicators = [
            $request->header('Sec-Fetch-Dest') === 'iframe',
            $request->header('Sec-Fetch-Mode') === 'navigate',
            strpos($request->header('Accept', ''), 'text/html') !== false &&
                !empty($referer) && parse_url($referer, PHP_URL_HOST) !== $host
        ];

        // Check if this is a page that shouldn't be embedded
        $noEmbedPaths = config('security.no_embed_paths', [
            'admin',
            'dashboard',
            'login',
            'register',
            'profile',
            'settings'
        ]);

        $path = $request->path();
        $isProtectedPath = false;

        foreach ($noEmbedPaths as $protectedPath) {
            if (str_starts_with($path, $protectedPath)) {
                $isProtectedPath = true;
                break;
            }
        }

        return $isProtectedPath && (
            in_array(true, $embedIndicators) ||
            $this->hasEmbedHeaders($request)
        );
    }

    /**
     * Check for embed-related headers
     */
    private function hasEmbedHeaders(Request $request): bool
    {
        $embedHeaders = [
            'X-Frame-Options' => false, // Should not be present in embed requests
            'Sec-Fetch-Dest' => 'iframe',
            'Sec-Fetch-Site' => 'cross-site'
        ];

        foreach ($embedHeaders as $header => $expectedValue) {
            $headerValue = $request->header($header);

            if ($expectedValue === false && $headerValue) {
                continue;
            }

            if ($headerValue === $expectedValue) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check for suspicious referer patterns
     */
    private function hasSuspiciousReferer(?string $referer): bool
    {
        if (empty($referer)) {
            return false;
        }

        $suspiciousPatterns = [
            // Suspicious domains
            'bit.ly',
            'tinyurl.com',
            't.co',
            'goo.gl',
            'ow.ly',

            // Suspicious keywords
            'hack',
            'exploit',
            'phishing',
            'malware',
            'virus',
            'trojan',

            // Suspicious TLDs
            '.tk',
            '.ml',
            '.ga',
            '.cf'
        ];

        $refererLower = strtolower($referer);

        foreach ($suspiciousPatterns as $pattern) {
            if (strpos($refererLower, $pattern) !== false) {
                return true;
            }
        }

        return false;
    }

    /**
     * Match referer against pattern (supports wildcards)
     */
    private function matchesRefererPattern(string $refererHost, string $pattern): bool
    {
        // Remove protocol if present
        $pattern = preg_replace('/^https?:\/\//', '', $pattern);

        // Convert wildcard pattern to regex
        if (strpos($pattern, '*') !== false) {
            $pattern = str_replace('*', '.*', $pattern);
            return preg_match('/^' . $pattern . '$/i', $refererHost);
        }

        // Exact match or subdomain match
        return $refererHost === $pattern || str_ends_with($refererHost, '.' . $pattern);
    }
}
