<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Security Configuration
    |--------------------------------------------------------------------------
    |
    | Konfigurasi keamanan untuk aplikasi Laravel
    |
    */

    'csrf' => [
        'enabled' => true,
        'expire' => 120, // CSRF token expire dalam menit
    ],

    'rate_limiting' => [
        'global' => [
            'requests' => 60,
            'minutes' => 1,
        ],
        'login' => [
            'requests' => 5,
            'minutes' => 1,
        ],
        'api' => [
            'requests' => 30,
            'minutes' => 1,
        ],
    ],

    'brute_force' => [
        'max_attempts' => 5,
        'lockout_duration' => 15, // dalam menit
        'progressive_lockout' => true,
    ],

    'security_headers' => [
        'hsts' => [
            'enabled' => true,
            'max_age' => 31536000, // 1 tahun
            'include_subdomains' => true,
        ],
        'csp' => [
            'enabled' => true,
            'report_only' => false,
        ],
        'x_frame_options' => 'DENY',
        'x_content_type_options' => 'nosniff',
        'x_xss_protection' => '1; mode=block',
        'referrer_policy' => 'strict-origin-when-cross-origin',
    ],

    'ddos_protection' => [
        'enabled' => true,
        'max_requests_per_minute' => 100,
        'ban_duration' => 30, // dalam menit
        'suspicious_paths' => [
            'admin',
            'wp-admin',
            'phpmyadmin',
            '.env',
            'config',
            'backup',
            'test',
            'debug',
            'api/debug'
        ],
        'suspicious_user_agents' => [
            'nikto',
            'sqlmap',
            'nmap',
            'masscan',
            'curl',
            'wget',
            'python-requests'
        ],
    ],

    'sql_injection' => [
        'enabled' => true,
        'log_attempts' => true,
        'block_requests' => true,
    ],

    'xss_protection' => [
        'enabled' => true,
        'sanitize_input' => true,
        'allowed_tags' => '<p><br><strong><em><u><ol><ul><li><a><img><h1><h2><h3><h4><h5><h6>',
        'log_attempts' => true,
    ],

    'file_upload' => [
        'max_size' => 2048, // KB
        'allowed_extensions' => ['jpg', 'jpeg', 'png', 'gif', 'pdf', 'doc', 'docx'],
        'scan_uploads' => true,
    ],

    'logging' => [
        'security_events' => true,
        'failed_logins' => true,
        'suspicious_activity' => true,
        'retention_days' => 30,
    ],

    'ip_whitelist' => [
        // IP addresses yang selalu diizinkan
        // '127.0.0.1',
        // '::1',
    ],

    'ip_blacklist' => [
        // IP addresses yang selalu diblokir
    ],

    /*
    |--------------------------------------------------------------------------
    | Auto-Ban Configuration
    |--------------------------------------------------------------------------
    */
    'auto_ban' => [
        'sql_injection' => [
            'threshold' => 3,
            'window_hours' => 1,
            'ban_duration_minutes' => 1440, // 24 hours
        ],
        'xss_attempt' => [
            'threshold' => 5,
            'window_hours' => 1,
            'ban_duration_minutes' => 720, // 12 hours
        ],
        'brute_force' => [
            'threshold' => 10,
            'window_hours' => 1,
            'ban_duration_minutes' => 360, // 6 hours
        ],
        'ddos_attempt' => [
            'threshold' => 50,
            'window_hours' => 1,
            'ban_duration_minutes' => 180, // 3 hours
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Admin IP Allowlist Configuration - GOVERNMENT FRIENDLY
    |--------------------------------------------------------------------------
    | 
    | Untuk Pemerintahan Desa:
    | - 'enforcement_mode' => 'warning' = Log saja, tidak block (RECOMMENDED)
    | - 'enforcement_mode' => 'strict' = Block akses dari IP tidak dikenal
    | - 'auto_learn_ips' => true = Otomatis belajar IP yang sering digunakan
    | - 'grace_period_hours' => 24 = Masa tenggang untuk IP baru
    |
    */
    'admin_ip_allowlist' => [
        // Default: Kantor Desa + Rumah Kades/Sekdes (opsional)
        // '127.0.0.1',           // Localhost (development)
        // '192.168.1.0/24',      // Jaringan WiFi kantor desa
        // 'YOUR_OFFICE_IP',      // IP Internet kantor desa
        // 'KADES_HOME_IP',       // IP rumah Kepala Desa (opsional)
        // 'SEKDES_HOME_IP',      // IP rumah Sekretaris Desa (opsional)
    ],

    // Mode enforcement untuk pemerintahan desa
    'admin_ip_enforcement' => [
        'mode' => env('ADMIN_IP_MODE', 'warning'), // 'warning' or 'strict'
        'auto_learn_ips' => env('ADMIN_IP_AUTO_LEARN', true),
        'grace_period_hours' => env('ADMIN_IP_GRACE_PERIOD', 24),
        'max_learned_ips' => 10, // Maksimal IP yang dipelajari otomatis
        'government_friendly' => true, // Mode khusus pemerintahan
    ],

    'admin_routes' => [
        'admin',
        'dashboard',
        'filament',
        'manage',
        'control-panel'
    ],

    /*
    |--------------------------------------------------------------------------
    | Bot Protection Configuration
    |--------------------------------------------------------------------------
    */
    'blocked_user_agents' => [
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
        'curl',
        'wget',
        'python-requests',
        'scrapy',
        'bot',
        'crawler',
        'spider',
        'headless',
        'selenium'
    ],

    /*
    |--------------------------------------------------------------------------
    | Referer Protection Configuration
    |--------------------------------------------------------------------------
    */
    'allowed_referers' => [
        // 'yourdomain.com',
        // '*.yourdomain.com',
    ],

    'protected_assets' => [
        'jpg',
        'jpeg',
        'png',
        'gif',
        'webp',
        'svg',
        'pdf',
        'doc',
        'docx',
        'xls',
        'xlsx',
        'ppt',
        'pptx',
        'mp4',
        'avi',
        'mov',
        'wmv',
        'flv',
        'mp3',
        'wav',
        'ogg',
        'flac',
        'zip',
        'rar',
        '7z',
        'tar',
        'gz'
    ],

    'no_embed_paths' => [
        'admin',
        'dashboard',
        'login',
        'register',
        'profile',
        'settings'
    ],

    /*
    |--------------------------------------------------------------------------
    | HTTPS Configuration
    |--------------------------------------------------------------------------
    */
    'force_https' => env('FORCE_HTTPS', false),
    'force_https_local' => env('FORCE_HTTPS_LOCAL', false),

    /*
    |--------------------------------------------------------------------------
    | Notification Configuration
    |--------------------------------------------------------------------------
    */
    'notifications' => [
        'email_alerts' => env('SECURITY_EMAIL_ALERTS', false),
        'admin_email' => env('SECURITY_ADMIN_EMAIL', null),
        'slack_webhook' => env('SECURITY_SLACK_WEBHOOK', null),
    ],
];
