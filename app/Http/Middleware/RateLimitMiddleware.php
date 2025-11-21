<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class RateLimitMiddleware
{
    /**
     * Handle an incoming request untuk mencegah brute force dan DDoS
     */
    public function handle(Request $request, Closure $next, $maxAttempts = 60, $decayMinutes = 1): Response
    {
        // Skip rate limiting in local development
        if (app()->environment('local')) {
            return $next($request);
        }

        $key = $this->resolveRequestSignature($request);

        $attempts = Cache::get($key, 0);

        if ($attempts >= $maxAttempts) {
            Log::warning('Rate limit exceeded', [
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'url' => $request->fullUrl(),
                'attempts' => $attempts
            ]);

            return response()->json([
                'error' => 'Too many requests. Please try again later.'
            ], 429);
        }

        Cache::put($key, $attempts + 1, now()->addMinutes($decayMinutes));

        return $next($request);
    }

    /**
     * Resolve request signature berdasarkan IP dan User Agent
     */
    protected function resolveRequestSignature(Request $request): string
    {
        return sha1(
            $request->ip() . '|' .
                $request->userAgent() . '|' .
                $request->path()
        );
    }
}
