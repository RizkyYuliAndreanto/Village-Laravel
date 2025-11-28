<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class AntiBruteForceMiddleware
{
    /**
     * Handle an incoming request untuk mencegah brute force attacks
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Skip security checks in local development
        if (app()->environment('local')) {
            return $next($request);
        }

        // Hanya check untuk login attempts
        if ($this->isLoginAttempt($request)) {
            $ip = $request->ip();
            $email = $request->input('email', '');

            // Check login attempts per IP
            $ipKey = "login_attempts_ip:{$ip}";
            $ipAttempts = Cache::get($ipKey, 0);

            // Check login attempts per email
            $emailKey = "login_attempts_email:" . md5($email);
            $emailAttempts = Cache::get($emailKey, 0);

            // Block jika terlalu banyak attempts
            if ($ipAttempts >= 5 || $emailAttempts >= 3) {
                $this->logBruteForceAttempt($request, $ipAttempts, $emailAttempts);

                // Temporary lockout
                $lockoutTime = $this->calculateLockoutTime($ipAttempts + $emailAttempts);
                Cache::put("lockout_ip:{$ip}", true, now()->addMinutes($lockoutTime));

                return response()->json([
                    'error' => "Too many failed login attempts. Please try again in {$lockoutTime} minutes.",
                    'lockout_time' => $lockoutTime
                ], 429);
            }

            // Check jika sedang dalam lockout
            if (Cache::has("lockout_ip:{$ip}")) {
                return response()->json([
                    'error' => 'Account temporarily locked due to multiple failed attempts.'
                ], 429);
            }
        }

        $response = $next($request);

        // Jika login gagal, increment counter
        if ($this->isFailedLogin($request, $response)) {
            $this->incrementFailedAttempts($request);
        }

        // Jika login berhasil, reset counter
        if ($this->isSuccessfulLogin($request, $response)) {
            $this->resetFailedAttempts($request);
        }

        return $response;
    }

    /**
     * Check apakah ini login attempt
     */
    protected function isLoginAttempt(Request $request): bool
    {
        return $request->isMethod('POST') &&
            (str_contains($request->path(), 'login') ||
                str_contains($request->path(), 'auth'));
    }

    /**
     * Check apakah login gagal
     */
    protected function isFailedLogin(Request $request, Response $response): bool
    {
        return $this->isLoginAttempt($request) &&
            ($response->getStatusCode() === 422 ||
                $response->getStatusCode() === 401 ||
                str_contains($response->getContent(), 'error'));
    }

    /**
     * Check apakah login berhasil
     */
    protected function isSuccessfulLogin(Request $request, Response $response): bool
    {
        return $this->isLoginAttempt($request) &&
            ($response->getStatusCode() === 200 ||
                $response->getStatusCode() === 302);
    }

    /**
     * Increment failed attempts counter
     */
    protected function incrementFailedAttempts(Request $request): void
    {
        $ip = $request->ip();
        $email = $request->input('email', '');

        $ipKey = "login_attempts_ip:{$ip}";
        $emailKey = "login_attempts_email:" . md5($email);

        $ipAttempts = Cache::get($ipKey, 0) + 1;
        $emailAttempts = Cache::get($emailKey, 0) + 1;

        // Store dengan expiry 1 jam
        Cache::put($ipKey, $ipAttempts, now()->addHour());
        if (!empty($email)) {
            Cache::put($emailKey, $emailAttempts, now()->addHour());
        }
    }

    /**
     * Reset failed attempts counter
     */
    protected function resetFailedAttempts(Request $request): void
    {
        $ip = $request->ip();
        $email = $request->input('email', '');

        Cache::forget("login_attempts_ip:{$ip}");
        Cache::forget("lockout_ip:{$ip}");

        if (!empty($email)) {
            Cache::forget("login_attempts_email:" . md5($email));
        }
    }

    /**
     * Calculate lockout time berdasarkan jumlah attempts
     */
    protected function calculateLockoutTime(int $attempts): int
    {
        // Progressive lockout: 5 min, 15 min, 30 min, 1 hour, 2 hours
        $lockoutTimes = [5, 15, 30, 60, 120];
        $index = min($attempts - 5, count($lockoutTimes) - 1);

        return $lockoutTimes[$index] ?? 120;
    }

    /**
     * Log brute force attempt
     */
    protected function logBruteForceAttempt(Request $request, int $ipAttempts, int $emailAttempts): void
    {
        Log::warning('Brute force login attempt detected', [
            'ip' => $request->ip(),
            'email' => $request->input('email', ''),
            'user_agent' => $request->userAgent(),
            'ip_attempts' => $ipAttempts,
            'email_attempts' => $emailAttempts,
            'url' => $request->fullUrl(),
            'timestamp' => now()->toDateTimeString()
        ]);
    }
}
