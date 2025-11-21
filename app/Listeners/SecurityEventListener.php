<?php

namespace App\Listeners;

use App\Events\SecurityEvent;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use App\Services\SecurityService;

class SecurityEventListener
{
    protected SecurityService $securityService;

    /**
     * Create the event listener.
     */
    public function __construct(SecurityService $securityService)
    {
        $this->securityService = $securityService;
    }

    /**
     * Handle the event.
     */
    public function handle(SecurityEvent $event): void
    {
        // Log the security event
        $this->logEvent($event);

        // Increment statistics
        $this->updateStatistics($event);

        // Check for critical threats
        $this->checkCriticalThreats($event);

        // Auto-ban IPs if necessary
        $this->checkAutoBan($event);
    }

    /**
     * Log the security event
     */
    protected function logEvent(SecurityEvent $event): void
    {
        $logData = [
            'type' => $event->type,
            'ip' => $event->ip,
            'user_agent' => $event->userAgent,
            'timestamp' => $event->timestamp,
            'data' => $event->data
        ];

        switch ($event->type) {
            case 'xss_attempt':
                Log::channel('xss')->warning('XSS attempt detected', $logData);
                break;
            case 'sql_injection':
                Log::channel('sql_injection')->error('SQL injection attempt', $logData);
                break;
            case 'brute_force':
                Log::channel('brute_force')->warning('Brute force attempt', $logData);
                break;
            case 'ddos_attempt':
                Log::channel('ddos')->warning('DDoS attempt detected', $logData);
                break;
            default:
                Log::channel('security')->info('Security event', $logData);
        }
    }

    /**
     * Update security statistics
     */
    protected function updateStatistics(SecurityEvent $event): void
    {
        $statMapping = [
            'xss_attempt' => 'xss_attempts',
            'sql_injection' => 'sql_injection_attempts',
            'brute_force' => 'brute_force_attempts',
            'ddos_attempt' => 'ddos_attempts',
            'ip_banned' => 'blocked_ips'
        ];

        if (isset($statMapping[$event->type])) {
            $this->securityService->incrementSecurityStat($statMapping[$event->type]);
        }
    }

    /**
     * Check for critical security threats
     */
    protected function checkCriticalThreats(SecurityEvent $event): void
    {
        $criticalEvents = ['sql_injection', 'multiple_brute_force', 'advanced_ddos'];

        if (in_array($event->type, $criticalEvents)) {
            $this->sendCriticalAlert($event);
        }
    }

    /**
     * Check if IP should be auto-banned
     */
    protected function checkAutoBan(SecurityEvent $event): void
    {
        $ip = $event->ip;
        $autoBanRules = config('security.auto_ban', []);

        foreach ($autoBanRules as $eventType => $config) {
            if ($event->type === $eventType) {
                $key = "security_violations:{$eventType}:{$ip}";
                $violations = Cache::get($key, 0) + 1;

                Cache::put($key, $violations, now()->addHours($config['window_hours']));

                if ($violations >= $config['threshold']) {
                    $this->securityService->blacklistIP($ip, $config['ban_duration_minutes']);

                    Log::channel('security')->critical('IP auto-banned', [
                        'ip' => $ip,
                        'event_type' => $eventType,
                        'violations' => $violations,
                        'ban_duration' => $config['ban_duration_minutes']
                    ]);
                }
            }
        }
    }

    /**
     * Send critical security alert
     */
    protected function sendCriticalAlert(SecurityEvent $event): void
    {
        if (!config('security.notifications.email_alerts', false)) {
            return;
        }

        $adminEmail = config('security.notifications.admin_email');
        if (!$adminEmail) {
            return;
        }

        try {
            // Implement email notification logic here
            // You can create a Mailable class for this
            Log::channel('security')->info('Critical security alert would be sent', [
                'event' => $event->type,
                'ip' => $event->ip,
                'admin_email' => $adminEmail
            ]);
        } catch (\Exception $e) {
            Log::channel('security')->error('Failed to send security alert', [
                'error' => $e->getMessage(),
                'event' => $event->type
            ]);
        }
    }
}
