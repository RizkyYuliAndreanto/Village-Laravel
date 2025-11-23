<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Events\SecurityEvent;

class AdminIPAllowlist
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if this is admin route
        if (!$this->isAdminRoute($request)) {
            return $next($request);
        }

        $clientIP = $this->getClientIP($request);
        $allowedIPs = config('security.admin_ip_allowlist', []);

        // Skip IP allowlist in local development
        if (app()->environment('local')) {
            return $next($request);
        }

        // If no allowlist configured, allow all (but log warning)
        if (empty($allowedIPs)) {
            Log::channel('security')->warning('Admin access without IP allowlist configured', [
                'ip' => $clientIP,
                'route' => $request->path(),
                'user_agent' => $request->userAgent()
            ]);
            return $next($request);
        }

        // Check if IP is in allowlist
        if (!$this->isIPAllowed($clientIP, $allowedIPs)) {
            // Log unauthorized admin access attempt
            Log::channel('security')->critical('Unauthorized admin access attempt', [
                'ip' => $clientIP,
                'route' => $request->path(),
                'user_agent' => $request->userAgent(),
                'allowed_ips' => $allowedIPs
            ]);

            // Trigger security event
            event(new SecurityEvent('admin_access_denied', $clientIP, [
                'route' => $request->path(),
                'reason' => 'IP not in allowlist'
            ]));

            return response()->json([
                'error' => 'Access denied',
                'message' => 'Your IP address is not authorized to access admin panel'
            ], 403);
        }

        // Log successful admin access
        Log::channel('security')->info('Admin access granted', [
            'ip' => $clientIP,
            'route' => $request->path()
        ]);

        return $next($request);
    }

    /**
     * Check if current route is admin route
     */
    private function isAdminRoute(Request $request): bool
    {
        $adminRoutes = config('security.admin_routes', [
            'admin',
            'dashboard',
            'filament',
            'manage',
            'control-panel'
        ]);

        $path = $request->path();

        foreach ($adminRoutes as $adminRoute) {
            if (str_starts_with($path, $adminRoute)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get real client IP address
     */
    private function getClientIP(Request $request): string
    {
        $headers = [
            'HTTP_CF_CONNECTING_IP',     // Cloudflare
            'HTTP_X_FORWARDED_FOR',      // Load balancer/proxy
            'HTTP_X_FORWARDED',          // Proxy
            'HTTP_X_CLUSTER_CLIENT_IP',  // Cluster
            'HTTP_FORWARDED_FOR',        // Proxy
            'HTTP_FORWARDED',            // Proxy
            'REMOTE_ADDR'                // Standard
        ];

        foreach ($headers as $header) {
            if (!empty($_SERVER[$header])) {
                $ips = explode(',', $_SERVER[$header]);
                $ip = trim($ips[0]);

                if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
                    return $ip;
                }
            }
        }

        return $request->ip();
    }

    /**
     * Check if IP is allowed
     */
    private function isIPAllowed(string $clientIP, array $allowedIPs): bool
    {
        foreach ($allowedIPs as $allowedIP) {
            // Support CIDR notation
            if (strpos($allowedIP, '/') !== false) {
                if ($this->ipInRange($clientIP, $allowedIP)) {
                    return true;
                }
            } else {
                // Exact IP match
                if ($clientIP === $allowedIP) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Check if IP is in CIDR range
     */
    private function ipInRange(string $ip, string $range): bool
    {
        list($subnet, $bits) = explode('/', $range);

        if ($bits === null) {
            $bits = 32;
        }

        $ip = ip2long($ip);
        $subnet = ip2long($subnet);
        $mask = -1 << (32 - (int)$bits);
        $subnet &= $mask;

        return ($ip & $mask) == $subnet;
    }
}
