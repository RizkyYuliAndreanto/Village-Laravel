<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class SecurityService
{
    /**
     * Check apakah IP address di blacklist
     */
    public function isBlacklisted(string $ip): bool
    {
        $blacklist = config('security.ip_blacklist', []);
        return in_array($ip, $blacklist) || Cache::has("blacklisted_ip:{$ip}");
    }

    /**
     * Check apakah IP address di whitelist
     */
    public function isWhitelisted(string $ip): bool
    {
        $whitelist = config('security.ip_whitelist', []);
        return in_array($ip, $whitelist);
    }

    /**
     * Add IP ke blacklist temporary
     */
    public function blacklistIP(string $ip, int $duration = 60): void
    {
        Cache::put("blacklisted_ip:{$ip}", true, now()->addMinutes($duration));

        Log::warning("IP address blacklisted", [
            'ip' => $ip,
            'duration' => $duration,
            'timestamp' => now()->toDateTimeString()
        ]);
    }

    /**
     * Remove IP dari blacklist
     */
    public function removeFromBlacklist(string $ip): void
    {
        Cache::forget("blacklisted_ip:{$ip}");
    }

    /**
     * Sanitize input untuk mencegah XSS
     */
    public function sanitizeInput($input): string|array
    {
        if (is_array($input)) {
            return array_map([$this, 'sanitizeInput'], $input);
        }

        if (!is_string($input)) {
            return $input;
        }

        // Remove dangerous patterns
        $input = preg_replace('/<script\b[^<]*(?:(?!<\/script>)<[^<]*)*<\/script>/i', '', $input);
        $input = preg_replace('/on\w+\s*=\s*["\']?[^"\']*["\']?/i', '', $input);
        $input = str_replace(['javascript:', 'vbscript:', 'data:'], '', $input);

        return htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
    }

    /**
     * Validate file upload
     */
    public function validateFileUpload($file): bool
    {
        if (!$file || !$file->isValid()) {
            return false;
        }

        $maxSize = config('security.file_upload.max_size', 2048) * 1024; // Convert to bytes
        $allowedExtensions = config('security.file_upload.allowed_extensions', []);

        // Check file size
        if ($file->getSize() > $maxSize) {
            return false;
        }

        // Check file extension
        $extension = strtolower($file->getClientOriginalExtension());
        if (!in_array($extension, $allowedExtensions)) {
            return false;
        }

        // Check MIME type
        $allowedMimes = [
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
            'pdf' => 'application/pdf',
            'doc' => 'application/msword',
            'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
        ];

        $mimeType = $file->getMimeType();
        if (isset($allowedMimes[$extension]) && $mimeType !== $allowedMimes[$extension]) {
            return false;
        }

        return true;
    }

    /**
     * Generate secure random string
     */
    public function generateSecureToken(int $length = 32): string
    {
        return bin2hex(random_bytes($length));
    }

    /**
     * Hash password dengan algoritma yang aman
     */
    public function hashPassword(string $password): string
    {
        return password_hash($password, PASSWORD_ARGON2ID, [
            'memory_cost' => 65536, // 64 MB
            'time_cost' => 4,       // 4 iterations
            'threads' => 3,         // 3 threads
        ]);
    }

    /**
     * Verify password hash
     */
    public function verifyPassword(string $password, string $hash): bool
    {
        return password_verify($password, $hash);
    }

    /**
     * Log security event
     */
    public function logSecurityEvent(string $event, array $data = []): void
    {
        if (config('security.logging.security_events', true)) {
            Log::channel('security')->info($event, array_merge($data, [
                'timestamp' => now()->toDateTimeString(),
                'ip' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]));
        }
    }

    /**
     * Get security statistics
     */
    public function getSecurityStats(): array
    {
        return [
            'blocked_ips' => Cache::get('security_stats:blocked_ips', 0),
            'xss_attempts' => Cache::get('security_stats:xss_attempts', 0),
            'sql_injection_attempts' => Cache::get('security_stats:sql_injection_attempts', 0),
            'brute_force_attempts' => Cache::get('security_stats:brute_force_attempts', 0),
            'ddos_attempts' => Cache::get('security_stats:ddos_attempts', 0),
        ];
    }

    /**
     * Increment security stat
     */
    public function incrementSecurityStat(string $stat): void
    {
        $key = "security_stats:{$stat}";
        $current = Cache::get($key, 0);
        Cache::put($key, $current + 1, now()->addDays(30));
    }
}
