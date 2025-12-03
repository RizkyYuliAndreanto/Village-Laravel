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
            'requests' => 60, // Standard Laravel rate limiting
            'minutes' => 1,
        ],
        'login' => [
            'requests' => 5, // Standard login rate limiting
            'minutes' => 1,
        ],
        'api' => [
            'requests' => 60, // API rate limiting
            'minutes' => 1,
        ],
    ],

    'brute_force' => [
        'max_attempts' => 10, // Diperlonggar dari 5 ke 10
        'lockout_duration' => 5, // Diperpendek dari 15 ke 5 menit
        'progressive_lockout' => false, // Dinonaktifkan
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
        'enabled' => false, // Dinonaktifkan sementara untuk troubleshooting
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
        'enabled' => false, // Dinonaktifkan sementara untuk troubleshooting
        'log_attempts' => true,
        'block_requests' => false, // Ubah ke false
    ],

    'xss_protection' => [
        'enabled' => true, // Tetap aktif untuk keamanan
        'sanitize_input' => true, // Tetap aktif
        'allowed_tags' => '<p><br><strong><em><u><ol><ul><li><a><img><h1><h2><h3><h4><h5><h6>',
        'log_attempts' => true, // Tetap log tapi tidak block
        'block_requests' => false, // Dinonaktifkan blocking sementara
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
        // IP whitelist dinonaktifkan untuk kemudahan akses
    ],

    'ip_blacklist' => [
        // IP addresses yang selalu diblokir
    ],

    /*
    |--------------------------------------------------------------------------
    | Auto-Ban Configuration - DILONGGARKAN SEMENTARA
    |--------------------------------------------------------------------------
    */
    'auto_ban' => [
        'sql_injection' => [
            'threshold' => 999, // Dinaikkan dari 3 ke 999
            'window_hours' => 1,
            'ban_duration_minutes' => 5, // Diperpendek dari 1440 ke 5
        ],
        'xss_attempt' => [
            'threshold' => 999, // Dinaikkan dari 5 ke 999
            'window_hours' => 1,
            'ban_duration_minutes' => 5, // Diperpendek dari 720 ke 5
        ],
        'brute_force' => [
            'threshold' => 999, // Dinaikkan dari 10 ke 999
            'window_hours' => 1,
            'ban_duration_minutes' => 5, // Diperpendek dari 360 ke 5
        ],
        'ddos_attempt' => [
            'threshold' => 999, // Dinaikkan dari 50 ke 999
            'window_hours' => 1,
            'ban_duration_minutes' => 5, // Diperpendek dari 180 ke 5
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
        // IP allowlist dinonaktifkan untuk kemudahan akses
    ],

    // Mode enforcement untuk pemerintahan desa
    'admin_ip_enforcement' => [
        'mode' => env('ADMIN_IP_MODE', 'disabled'), // 'disabled' untuk menonaktifkan
        'auto_learn_ips' => false,
        'grace_period_hours' => 0,
        'max_learned_ips' => 0,
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
    | Bot Protection Configuration - DINONAKTIFKAN SEMENTARA
    |--------------------------------------------------------------------------
    */
    'blocked_user_agents' => [
        // Dinonaktifkan sementara untuk troubleshooting 403
        // 'sqlmap',
        // 'nmap',
        // 'masscan',
        // 'nikto',
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
    | HTTPS Configuration - Dinonaktifkan untuk kemudahan
    |--------------------------------------------------------------------------
    */
    'force_https' => false,
    'force_https_local' => false,

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
