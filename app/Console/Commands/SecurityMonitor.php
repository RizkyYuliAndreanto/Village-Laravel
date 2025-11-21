<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use App\Services\SecurityService;

class SecurityMonitor extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'security:monitor {--clear-cache : Clear security cache}';

    /**
     * The console command description.
     */
    protected $description = 'Monitor security events and generate reports';

    protected SecurityService $securityService;

    public function __construct(SecurityService $securityService)
    {
        parent::__construct();
        $this->securityService = $securityService;
    }

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->info('🔒 Security Monitor Started');

        if ($this->option('clear-cache')) {
            $this->clearSecurityCache();
            return;
        }

        $this->displaySecurityStats();
        $this->checkSuspiciousActivity();
        $this->generateSecurityReport();

        $this->info('✅ Security monitoring completed');
    }

    /**
     * Clear security cache
     */
    protected function clearSecurityCache(): void
    {
        // For database cache, we'll clear specific known keys
        $cacheKeys = [
            'security_stats:blocked_ips',
            'security_stats:xss_attempts',
            'security_stats:sql_injection_attempts',
            'security_stats:brute_force_attempts',
            'security_stats:ddos_attempts',
            'security_stats:total_requests'
        ];

        $cleared = 0;
        foreach ($cacheKeys as $key) {
            if (Cache::has($key)) {
                Cache::forget($key);
                $cleared++;
            }
        }

        $this->info("🧹 Security cache cleared ({$cleared} keys)");
    }

    /**
     * Display security statistics
     */
    protected function displaySecurityStats(): void
    {
        $stats = $this->securityService->getSecurityStats();

        $this->table(
            ['Security Event', 'Count'],
            [
                ['Blocked IPs', $stats['blocked_ips']],
                ['XSS Attempts', $stats['xss_attempts']],
                ['SQL Injection Attempts', $stats['sql_injection_attempts']],
                ['Brute Force Attempts', $stats['brute_force_attempts']],
                ['DDoS Attempts', $stats['ddos_attempts']],
            ]
        );
    }

    /**
     * Check for suspicious activity
     */
    protected function checkSuspiciousActivity(): void
    {
        $this->info('🔍 Checking for suspicious activity...');

        // Check for high number of blocked IPs
        $blockedIPs = Cache::get('security_stats:blocked_ips', 0);
        if ($blockedIPs > 100) {
            $this->warn("⚠️  High number of blocked IPs detected: {$blockedIPs}");
            Log::channel('security')->warning('High number of blocked IPs', ['count' => $blockedIPs]);
        }

        // Check for SQL injection attempts
        $sqlAttempts = Cache::get('security_stats:sql_injection_attempts', 0);
        if ($sqlAttempts > 10) {
            $this->error("🚨 Multiple SQL injection attempts detected: {$sqlAttempts}");
            Log::channel('security')->critical('Multiple SQL injection attempts', ['count' => $sqlAttempts]);
        }

        // Check for brute force attempts
        $bruteForceAttempts = Cache::get('security_stats:brute_force_attempts', 0);
        if ($bruteForceAttempts > 50) {
            $this->warn("⚠️  High number of brute force attempts: {$bruteForceAttempts}");
            Log::channel('security')->warning('High brute force activity', ['count' => $bruteForceAttempts]);
        }
    }

    /**
     * Generate security report
     */
    protected function generateSecurityReport(): void
    {
        $this->info('📊 Generating security report...');

        $report = [
            'timestamp' => now()->toDateTimeString(),
            'stats' => $this->securityService->getSecurityStats(),
            'active_bans' => $this->getActiveBans(),
            'recent_attacks' => $this->getRecentAttacks(),
        ];

        $reportPath = storage_path('logs/security-report-' . date('Y-m-d') . '.json');
        file_put_contents($reportPath, json_encode($report, JSON_PRETTY_PRINT));

        $this->info("📋 Security report saved to: {$reportPath}");
    }

    /**
     * Get active IP bans
     */
    protected function getActiveBans(): array
    {
        // For database cache, we can't easily iterate through keys like Redis
        // This is a simplified implementation
        $this->info('📝 Note: Active bans listing requires Redis cache for full functionality');

        return [
            'note' => 'Database cache is in use. Switch to Redis for advanced ban management.',
            'alternative' => 'Check security logs for banned IPs'
        ];
    }

    /**
     * Get recent attack attempts
     */
    protected function getRecentAttacks(): array
    {
        // Ini adalah implementasi sederhana
        // Dalam implementasi production, Anda mungkin ingin
        // menggunakan database untuk menyimpan attack logs
        return [
            'note' => 'Implement database logging for detailed attack history'
        ];
    }
}
