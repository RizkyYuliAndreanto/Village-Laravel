<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class AntiSQLInjectionMiddleware
{
    /**
     * Handle an incoming request untuk mencegah SQL Injection
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Skip security checks in local development
        if (app()->environment('local')) {
            return $next($request);
        }

        $input = $request->all();

        // Check untuk SQL injection patterns
        if ($this->containsSQLInjection($input)) {
            Log::critical('SQL Injection attempt detected', [
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'url' => $request->fullUrl(),
                'input' => $input
            ]);

            // Block the request
            return response()->json([
                'error' => 'Invalid request detected.'
            ], 400);
        }

        return $next($request);
    }

    /**
     * Check apakah input mengandung SQL injection patterns
     */
    protected function containsSQLInjection($data): bool
    {
        $sqlPatterns = [
            '/(\b(SELECT|INSERT|UPDATE|DELETE|DROP|CREATE|ALTER|EXEC|EXECUTE|UNION|SCRIPT)\b)/i',
            '/(\b(OR|AND)\s+\d+\s*=\s*\d+)/i',
            '/(\b(OR|AND)\s+["\']?\w+["\']?\s*=\s*["\']?\w+["\']?)/i',
            '/(-{2}|#|\/\*|\*\/)/i',
            '/(CHAR\(|ASCII\(|ORD\(|HEX\()/i',
            '/(BENCHMARK\(|SLEEP\(|DELAY\()/i',
            '/(\bUNION\b.*\bSELECT\b)/i',
            '/(\bINTO\s+OUTFILE\b)/i',
            '/(\bLOAD_FILE\b)/i',
            '/(\bSYSTEM\b)/i'
        ];

        $content = is_array($data) ? json_encode($data) : (string) $data;

        foreach ($sqlPatterns as $pattern) {
            if (preg_match($pattern, $content)) {
                return true;
            }
        }

        return false;
    }
}
