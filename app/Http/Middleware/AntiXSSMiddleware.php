<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use App\Events\SecurityEvent;

class AntiXSSMiddleware
{
    /**
     * Handle an incoming request untuk mencegah XSS
     */
    public function handle(Request $request, Closure $next): Response
    {
        $input = $request->all();

        // Clean input data untuk mencegah XSS
        $cleanInput = $this->cleanInput($input);
        $request->merge($cleanInput);

        // Check untuk suspicious patterns (skip in local development)
        if ($this->containsSuspiciousContent($input) && !app()->environment('local')) {
            // Fire security event
            SecurityEvent::dispatch('xss_attempt', $request->ip(), [
                'url' => $request->fullUrl(),
                'input' => $input,
                'blocked' => false
            ]);

            Log::warning('Suspicious XSS attempt detected', [
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'url' => $request->fullUrl(),
                'input' => $input
            ]);
        }

        return $next($request);
    }

    /**
     * Clean input data dari potensi XSS
     */
    protected function cleanInput($data): array
    {
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                if (is_array($value)) {
                    $data[$key] = $this->cleanInput($value);
                } else {
                    $data[$key] = $this->sanitizeString($value);
                }
            }
        }

        return $data;
    }

    /**
     * Sanitize string dari XSS
     */
    protected function sanitizeString($value): string
    {
        if (!is_string($value)) {
            return $value;
        }

        // Remove dangerous tags dan scripts
        $value = preg_replace('/<script\b[^<]*(?:(?!<\/script>)<[^<]*)*<\/script>/i', '', $value);
        $value = preg_replace('/<iframe\b[^<]*(?:(?!<\/iframe>)<[^<]*)*<\/iframe>/i', '', $value);
        $value = preg_replace('/on\w+\s*=\s*["\']?[^"\']*["\']?/i', '', $value);
        $value = preg_replace('/javascript:/i', '', $value);
        $value = preg_replace('/vbscript:/i', '', $value);
        $value = preg_replace('/data:/i', '', $value);

        return strip_tags($value, '<p><br><strong><em><u><ol><ul><li><a><img><h1><h2><h3><h4><h5><h6>');
    }

    /**
     * Check apakah input mengandung konten mencurigakan
     */
    protected function containsSuspiciousContent($data): bool
    {
        $suspicious = [
            '<script',
            '</script>',
            'javascript:',
            'vbscript:',
            'onload=',
            'onerror=',
            'onclick=',
            'eval(',
            'alert(',
            'document.cookie',
            'window.location'
        ];

        $content = is_array($data) ? json_encode($data) : (string) $data;
        $content = strtolower($content);

        foreach ($suspicious as $pattern) {
            if (strpos($content, strtolower($pattern)) !== false) {
                return true;
            }
        }

        return false;
    }
}
