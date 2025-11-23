<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use App\Events\SecurityEvent;

class DetectSuspiciousRequest
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // Skip security checks in local development
        if (app()->environment('local')) {
            return $next($request);
        }

        $clientIP = $request->ip();
        $suspiciousScore = 0;
        $threats = [];

        // Check for script injection
        if ($this->hasScriptInjection($request)) {
            $suspiciousScore += 10;
            $threats[] = 'script_injection';
        }

        // Check for SQL injection
        if ($this->hasSQLInjection($request)) {
            $suspiciousScore += 10;
            $threats[] = 'sql_injection';
        }

        // Check for file traversal
        if ($this->hasFileTraversal($request)) {
            $suspiciousScore += 8;
            $threats[] = 'file_traversal';
        }

        // Check for sensitive file access
        if ($this->accessingSensitiveFiles($request)) {
            $suspiciousScore += 9;
            $threats[] = 'sensitive_file_access';
        }

        // Check for abnormal REST patterns
        if ($this->hasAbnormalRESTPattern($request)) {
            $suspiciousScore += 5;
            $threats[] = 'abnormal_rest';
        }

        // Check for command injection
        if ($this->hasCommandInjection($request)) {
            $suspiciousScore += 10;
            $threats[] = 'command_injection';
        }

        // Check for header manipulation
        if ($this->hasHeaderManipulation($request)) {
            $suspiciousScore += 6;
            $threats[] = 'header_manipulation';
        }

        // Check for suspicious encoding
        if ($this->hasSuspiciousEncoding($request)) {
            $suspiciousScore += 7;
            $threats[] = 'suspicious_encoding';
        }

        // Process threat level
        if ($suspiciousScore >= 10) {
            return $this->handleHighThreat($request, $clientIP, $threats, $suspiciousScore);
        } elseif ($suspiciousScore >= 5) {
            $this->handleMediumThreat($request, $clientIP, $threats, $suspiciousScore);
        } elseif ($suspiciousScore > 0) {
            $this->handleLowThreat($request, $clientIP, $threats, $suspiciousScore);
        }

        return $next($request);
    }

    /**
     * Check for script injection
     */
    private function hasScriptInjection(Request $request): bool
    {
        $scriptPatterns = [
            '/<script[^>]*>.*?<\/script>/is',
            '/javascript:/i',
            '/vbscript:/i',
            '/onload\s*=/i',
            '/onerror\s*=/i',
            '/onclick\s*=/i',
            '/onmouseover\s*=/i',
            '/onfocus\s*=/i',
            '/onblur\s*=/i',
            '/onchange\s*=/i',
            '/onsubmit\s*=/i',
            '/<iframe[^>]*>/i',
            '/<object[^>]*>/i',
            '/<embed[^>]*>/i',
            '/<applet[^>]*>/i',
            '/document\.write/i',
            '/document\.createElement/i',
            '/innerHTML/i',
            '/eval\s*\(/i',
            '/setTimeout\s*\(/i',
            '/setInterval\s*\(/i'
        ];

        return $this->checkPatterns($request, $scriptPatterns);
    }

    /**
     * Check for SQL injection
     */
    private function hasSQLInjection(Request $request): bool
    {
        $sqlPatterns = [
            '/(\s|^)(union|select|insert|update|delete|drop|create|alter|exec|execute)\s/i',
            '/(\s|^)(or|and)\s+\d*\s*=\s*\d*/i',
            '/(\s|^)(or|and)\s+[\'"]?\w+[\'"]?\s*=\s*[\'"]?\w+[\'"]?/i',
            '/1\s*=\s*1/i',
            '/1\s*=\s*0/i',
            '/(\'|\")(\s|%20)*(or|and)(\s|%20)*\1\s*=\s*\1/i',
            '/\'\s*(or|and)\s*\'/i',
            '/"\s*(or|and)\s*"/i',
            '/(\s|^)(concat|char|ascii|substring|length|user|database|version|table_name|column_name)\s*\(/i',
            '/(\s|^)(information_schema|mysql|sys|performance_schema)/i',
            '/\s*(;|\/\*).*(-{2}|\/\*)/i',
            '/0x[0-9a-f]+/i',
            '/\s+having\s+/i',
            '/benchmark\s*\(/i',
            '/sleep\s*\(/i',
            '/waitfor\s+delay/i',
            '/load_file\s*\(/i',
            '/into\s+outfile/i',
            '/into\s+dumpfile/i'
        ];

        return $this->checkPatterns($request, $sqlPatterns);
    }

    /**
     * Check for file traversal
     */
    private function hasFileTraversal(Request $request): bool
    {
        $traversalPatterns = [
            '/\.{2}[\/\\\\]/',
            '/[\/\\\\]\.{2}/',
            '/%2e%2e[\/\\\\]/',
            '/[\/\\\\]%2e%2e/',
            '/\.\.[\/\\\\]/',
            '/[\/\\\\]\.\. /',
            '/%c0%ae%c0%ae/',
            '/%252e%252e/',
            '/\.{2,}/'
        ];

        return $this->checkPatterns($request, $traversalPatterns);
    }

    /**
     * Check for sensitive file access
     */
    private function accessingSensitiveFiles(Request $request): bool
    {
        $sensitiveFiles = [
            '\.env',
            'wp-config\.php',
            'config\.php',
            'database\.php',
            'composer\.json',
            'composer\.lock',
            'package\.json',
            'artisan',
            '\.git',
            '\.svn',
            '\.htaccess',
            '\.htpasswd',
            'web\.config',
            'phpinfo\.php',
            'info\.php',
            'test\.php',
            'debug\.php',
            'backup',
            'dump',
            'sql',
            'database',
            'admin',
            'login',
            'private',
            'secret',
            'confidential'
        ];

        $path = $request->path();
        $queryString = $request->getQueryString() ?? '';
        $fullContent = $path . ' ' . $queryString . ' ' . json_encode($request->all());

        foreach ($sensitiveFiles as $file) {
            if (preg_match('/' . $file . '/i', $fullContent)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check for abnormal REST patterns
     */
    private function hasAbnormalRESTPattern(Request $request): bool
    {
        $method = $request->method();
        $path = $request->path();

        // Suspicious method combinations
        $suspiciousPatterns = [
            // Multiple methods in query
            '/method\s*=\s*(put|delete|patch)/i',
            '/_method\s*=\s*(put|delete|patch)/i',

            // HTTP verb tampering
            '/\?(put|delete|patch|trace|options|connect)/i',

            // Unusual headers for REST
            'X-HTTP-Method-Override' => ['TRACE', 'CONNECT', 'TRACK'],

            // Suspicious query parameters
            '/\?(cmd|exec|system|shell|eval)/i',

            // Malformed REST paths
            '/\/api\/.*\?\w+=/i' // API endpoints with suspicious query params
        ];

        // Check method override headers
        $methodOverride = $request->header('X-HTTP-Method-Override');
        if ($methodOverride && in_array(strtoupper($methodOverride), ['TRACE', 'CONNECT', 'TRACK'])) {
            return true;
        }

        // Check patterns
        $content = $path . '?' . $request->getQueryString();
        foreach ($suspiciousPatterns as $pattern) {
            if (is_string($pattern) && preg_match($pattern, $content)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check for command injection
     */
    private function hasCommandInjection(Request $request): bool
    {
        $commandPatterns = [
            '/(\s|^)(cat|ls|dir|type|more|less|head|tail|pwd|whoami|id|uname|ps|netstat|ifconfig|ipconfig)\s/i',
            '/(\s|^)(wget|curl|nc|netcat|telnet|ssh|ftp)\s/i',
            '/(\s|^)(rm|del|rmdir|mkdir|touch|chmod|chown)\s/i',
            '/(\s|^)(echo|printf|print)\s/i',
            '/(\||;|&|`|\$\(|\${)/i',
            '/(\\r\\n|\\n|\\r)/i',
            '/\x00/i', // Null byte
            '/\s*(;|&&|\|\||\||&)\s*(cat|ls|wget|curl|nc|rm|echo)/i'
        ];

        return $this->checkPatterns($request, $commandPatterns);
    }

    /**
     * Check for header manipulation
     */
    private function hasHeaderManipulation(Request $request): bool
    {
        $suspiciousHeaders = [
            'X-Forwarded-For' => function ($value) {
                return substr_count($value, ',') > 5; // Too many proxies
            },
            'X-Real-IP' => function ($value) {
                return !filter_var($value, FILTER_VALIDATE_IP);
            },
            'User-Agent' => function ($value) {
                return strlen($value) > 1000 || empty($value); // Too long or empty
            },
            'Referer' => function ($value) {
                return strlen($value) > 2000; // Extremely long referer
            },
            'Cookie' => function ($value) {
                return strlen($value) > 8192; // Cookie bomb
            }
        ];

        foreach ($suspiciousHeaders as $header => $check) {
            $value = $request->header($header);
            if ($value && $check($value)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check for suspicious encoding
     */
    private function hasSuspiciousEncoding(Request $request): bool
    {
        $content = json_encode($request->all()) . $request->getQueryString();

        $suspiciousEncodings = [
            '/%[0-9a-f]{2}/i',      // URL encoding
            '/\\\\u[0-9a-f]{4}/i',   // Unicode escaping
            '/&#x?[0-9a-f]+;/i',     // HTML entity encoding
            '/%u[0-9a-f]{4}/i',      // Unicode URL encoding
            '/\+/',                  // Space encoding
            '/%20%20%20/',           // Multiple space encoding
            '/%2f%2f/',              // Double slash encoding
            '/\\\\x[0-9a-f]{2}/i'    // Hex escaping
        ];

        $encodingCount = 0;
        foreach ($suspiciousEncodings as $pattern) {
            if (preg_match_all($pattern, $content) > 5) {
                $encodingCount++;
            }
        }

        return $encodingCount >= 3; // Multiple encoding types indicate obfuscation
    }

    /**
     * Check patterns in request data
     */
    private function checkPatterns(Request $request, array $patterns): bool
    {
        $content = json_encode([
            'url' => $request->fullUrl(),
            'input' => $request->all(),
            'headers' => $request->headers->all()
        ]);

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $content)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Handle high threat level
     */
    private function handleHighThreat(Request $request, string $clientIP, array $threats, int $score)
    {
        Log::channel('security')->critical('High threat request blocked', [
            'ip' => $clientIP,
            'threats' => $threats,
            'score' => $score,
            'url' => $request->fullUrl(),
            'method' => $request->method(),
            'user_agent' => $request->userAgent(),
            'input' => $request->all()
        ]);

        event(new SecurityEvent('high_threat_blocked', $clientIP, [
            'threats' => $threats,
            'score' => $score,
            'url' => $request->fullUrl()
        ]));

        // Ban IP temporarily
        Cache::put("threat_banned_ip:{$clientIP}", true, now()->addHours(1));

        return response()->json([
            'error' => 'Request blocked',
            'message' => 'Suspicious activity detected'
        ], 403);
    }

    /**
     * Handle medium threat level
     */
    private function handleMediumThreat(Request $request, string $clientIP, array $threats, int $score): void
    {
        Log::channel('security')->warning('Medium threat request detected', [
            'ip' => $clientIP,
            'threats' => $threats,
            'score' => $score,
            'url' => $request->fullUrl(),
            'method' => $request->method()
        ]);

        event(new SecurityEvent('medium_threat_detected', $clientIP, [
            'threats' => $threats,
            'score' => $score
        ]));
    }

    /**
     * Handle low threat level
     */
    private function handleLowThreat(Request $request, string $clientIP, array $threats, int $score): void
    {
        Log::channel('security')->info('Low threat request detected', [
            'ip' => $clientIP,
            'threats' => $threats,
            'score' => $score,
            'url' => $request->fullUrl()
        ]);
    }
}
