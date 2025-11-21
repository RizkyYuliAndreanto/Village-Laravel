<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use App\Events\SecurityEvent;

class BlockMaliciousBots
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // Skip bot checking in local development
        if (app()->environment('local')) {
            return $next($request);
        }

        $userAgent = $request->userAgent() ?? '';
        $clientIP = $request->ip();

        // Check if bot is blocked
        if ($this->isMaliciousBot($userAgent)) {
            // Log malicious bot attempt
            Log::channel('security')->warning('Malicious bot blocked', [
                'ip' => $clientIP,
                'user_agent' => $userAgent,
                'url' => $request->fullUrl(),
                'method' => $request->method()
            ]);

            // Trigger security event
            event(new SecurityEvent('malicious_bot_blocked', $clientIP, [
                'user_agent' => $userAgent,
                'bot_type' => $this->detectBotType($userAgent)
            ]));

            // Ban IP temporarily
            $this->banBotIP($clientIP, $userAgent);

            return response()->json([
                'error' => 'Access denied',
                'message' => 'Automated requests are not allowed'
            ], 403);
        }

        // Check for suspicious bot behavior
        if ($this->isSuspiciousBot($userAgent, $request)) {
            $this->logSuspiciousActivity($clientIP, $userAgent, $request);
        }

        return $next($request);
    }

    /**
     * Check if user agent is malicious bot
     */
    private function isMaliciousBot(string $userAgent): bool
    {
        $maliciousBots = config('security.blocked_user_agents', [
            // Security scanners
            'sqlmap',
            'nmap',
            'masscan',
            'nikto',
            'dirb',
            'dirbuster',
            'gobuster',
            'wpscan',
            'nuclei',
            'burpsuite',
            'owasp',
            'acunetix',
            'nessus',
            'openvas',
            'skipfish',
            'w3af',

            // Automated tools
            'curl',
            'wget',
            'python-requests',
            'python-urllib',
            'go-http-client',
            'java/',
            'apache-httpclient',
            'okhttp',
            'python/3',
            'python/2',
            'ruby',
            'perl',
            'php/',
            'node-fetch',
            'axios',

            // Scraping tools
            'scrapy',
            'beautiful',
            'selenium',
            'phantomjs',
            'headless',
            'crawler',
            'spider',
            'bot',
            'scraper',

            // Vulnerability scanners
            'zaproxy',
            'grabber',
            'x-scan',
            'vega',
            'paros',
            'grendel',
            'websecurify',
            'n-stalker',
            'pmafind',
            'attacks',
            'exploit',
            'payload',
            'injection',

            // Generic suspicious
            'test',
            'scan',
            'hack',
            'exploit',
            'attack',
            'penetration'
        ]);

        $userAgentLower = strtolower($userAgent);

        foreach ($maliciousBots as $botPattern) {
            if (strpos($userAgentLower, $botPattern) !== false) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check for suspicious bot behavior
     */
    private function isSuspiciousBot(string $userAgent, Request $request): bool
    {
        $suspiciousPatterns = [
            // Empty or very short user agents
            'length_too_short' => strlen($userAgent) < 10,

            // Missing common browser identifiers
            'no_browser_info' => !preg_match('/(mozilla|webkit|chrome|firefox|safari|edge|opera)/i', $userAgent),

            // Suspicious request patterns
            'suspicious_headers' => $this->hasSuspiciousHeaders($request),

            // High frequency requests
            'high_frequency' => $this->isHighFrequencyRequest($request->ip()),

            // Accessing sensitive paths
            'sensitive_paths' => $this->isAccessingSensitivePaths($request->path())
        ];

        return array_sum($suspiciousPatterns) >= 2; // Threshold: 2 or more suspicious indicators
    }

    /**
     * Check for suspicious headers
     */
    private function hasSuspiciousHeaders(Request $request): bool
    {
        $suspiciousHeaders = [
            'X-Scanner',
            'X-Forwarded-For' => function ($value) {
                // Multiple proxies or suspicious IPs
                return substr_count($value, ',') > 3;
            },
            'Accept' => function ($value) {
                // Very generic or missing accept headers
                return empty($value) || $value === '*/*';
            }
        ];

        foreach ($suspiciousHeaders as $header => $check) {
            $value = $request->header($header);

            if (is_callable($check)) {
                if ($value && $check($value)) {
                    return true;
                }
            } else {
                if ($value) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Check for high frequency requests
     */
    private function isHighFrequencyRequest(string $ip): bool
    {
        $key = "bot_frequency:{$ip}";
        $requests = Cache::get($key, 0);

        Cache::put($key, $requests + 1, now()->addMinutes(5));

        return $requests > 50; // More than 50 requests in 5 minutes
    }

    /**
     * Check if accessing sensitive paths
     */
    private function isAccessingSensitivePaths(string $path): bool
    {
        $sensitivePaths = [
            '.env',
            'wp-admin',
            'wp-login',
            'admin',
            'phpmyadmin',
            'config',
            'backup',
            'database',
            'storage',
            'vendor',
            '.git',
            '.svn',
            'composer.json',
            'artisan'
        ];

        foreach ($sensitivePaths as $sensitivePath) {
            if (strpos($path, $sensitivePath) !== false) {
                return true;
            }
        }

        return false;
    }

    /**
     * Detect bot type for logging
     */
    private function detectBotType(string $userAgent): string
    {
        $botTypes = [
            'scanner' => ['sqlmap', 'nmap', 'masscan', 'nikto', 'dirb', 'nuclei'],
            'crawler' => ['scrapy', 'crawler', 'spider', 'bot'],
            'http_client' => ['curl', 'wget', 'python-requests', 'java/', 'okhttp'],
            'browser_automation' => ['selenium', 'phantomjs', 'headless'],
            'penetration_tool' => ['burpsuite', 'owasp', 'acunetix', 'zaproxy']
        ];

        $userAgentLower = strtolower($userAgent);

        foreach ($botTypes as $type => $patterns) {
            foreach ($patterns as $pattern) {
                if (strpos($userAgentLower, $pattern) !== false) {
                    return $type;
                }
            }
        }

        return 'unknown';
    }

    /**
     * Ban bot IP temporarily
     */
    private function banBotIP(string $ip, string $userAgent): void
    {
        $banDuration = $this->getBanDuration($userAgent);
        Cache::put("banned_bot_ip:{$ip}", true, now()->addMinutes($banDuration));

        Log::channel('security')->info('Bot IP banned', [
            'ip' => $ip,
            'duration_minutes' => $banDuration,
            'user_agent' => $userAgent
        ]);
    }

    /**
     * Get ban duration based on bot type
     */
    private function getBanDuration(string $userAgent): int
    {
        $severeBots = ['sqlmap', 'nmap', 'masscan', 'nikto', 'nuclei', 'burpsuite'];

        foreach ($severeBots as $bot) {
            if (strpos(strtolower($userAgent), $bot) !== false) {
                return 1440; // 24 hours for severe bots
            }
        }

        return 60; // 1 hour for other bots
    }

    /**
     * Log suspicious activity
     */
    private function logSuspiciousActivity(string $ip, string $userAgent, Request $request): void
    {
        Log::channel('security')->info('Suspicious bot activity detected', [
            'ip' => $ip,
            'user_agent' => $userAgent,
            'url' => $request->fullUrl(),
            'method' => $request->method(),
            'headers' => $request->headers->all()
        ]);
    }
}
