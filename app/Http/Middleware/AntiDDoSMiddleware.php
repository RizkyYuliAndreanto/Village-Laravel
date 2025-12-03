<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class AntiDDoSMiddleware
{
    /**
     * Handle an incoming request untuk mencegah DDoS attacks
     */
    public function handle(Request $request, Closure $next): Response
    {
        // SEMENTARA DINONAKTIFKAN untuk troubleshooting 403 error
        return $next($request);
    }
        /*
        // Skip DDoS protection in local development
        if (app()->environment('local', 'development')) {
            return $next($request);
        }

        $ip = $request->ip();
        $userAgent = $request->userAgent();

        // Check untuk suspicious patterns
        if ($this->isSuspiciousRequest($request)) {
            $this->logSuspiciousActivity($request);

            // Temporary ban untuk IP yang mencurigakan
            $banKey = "banned_ip:{$ip}";
            Cache::put($banKey, true, now()->addMinutes(30));

            return response()->json([
                'error' => 'Request blocked due to suspicious activity.'
            ], 403);
        }

        // Check jika IP sudah di-ban
        if (Cache::has("banned_ip:{$ip}")) {
            return response()->json([
                'error' => 'IP address temporarily banned.'
            ], 403);
        }

        // Rate limiting per IP
        $requestKey = "requests:{$ip}";
        $requests = Cache::get($requestKey, 0);

        // Allow maksimal 100 requests per menit per IP
        if ($requests >= 100) {
            Log::warning('DDoS attempt detected - Rate limit exceeded', [
                'ip' => $ip,
                'requests' => $requests,
                'user_agent' => $userAgent
            ]);

            return response()->json([
                'error' => 'Too many requests from your IP address.'
            ], 429);
        }

        Cache::put($requestKey, $requests + 1, now()->addMinute());

        return $next($request);
    }

    /**
     * Check apakah request mencurigakan
     */
    protected function isSuspiciousRequest(Request $request): bool
    {
        $userAgent = $request->userAgent();
        $ip = $request->ip();

        // Check untuk bot patterns yang mencurigakan
        $suspiciousBots = [
            'nikto',
            'sqlmap',
            'nmap',
            'masscan',
            'curl',
            'wget',
            'python-requests',
            'bot',
            'crawler',
            'spider'
        ];

        foreach ($suspiciousBots as $bot) {
            if (stripos($userAgent, $bot) !== false) {
                return true;
            }
        }

        // Check untuk request patterns yang tidak normal
        $path = $request->path();
        $suspiciousPaths = [
            'admin',
            'wp-admin',
            'phpmyadmin',
            '.env',
            'config',
            'backup',
            'test',
            'debug',
            'api/debug'
        ];

        foreach ($suspiciousPaths as $suspiciousPath) {
            if (stripos($path, $suspiciousPath) !== false) {
                return true;
            }
        }

        // Check untuk high frequency requests dari IP yang sama
        $frequencyKey = "frequency:{$ip}";
        $frequency = Cache::get($frequencyKey, 0);

        if ($frequency > 20) { // Lebih dari 20 requests dalam 10 detik
            return true;
        }

        Cache::put($frequencyKey, $frequency + 1, now()->addSeconds(10));

        return false;
    }

    /**
     * Log suspicious activity
     */
    protected function logSuspiciousActivity(Request $request): void
    {
        Log::warning('Suspicious DDoS activity detected', [
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'url' => $request->fullUrl(),
            'method' => $request->method(),
            'headers' => $request->headers->all(),
            'timestamp' => now()->toDateTimeString()
        ]);
    }
}
