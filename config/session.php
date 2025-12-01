<?php

/**
 * Shared Hosting Optimized Session Configuration
 * Uses file storage instead of database/Redis
 */

return [
    // File driver untuk shared hosting
    'driver' => env('SESSION_DRIVER', 'file'),

    // Session lifetime (2 hours)
    'lifetime' => (int) env('SESSION_LIFETIME', 120),
    'expire_on_close' => env('SESSION_EXPIRE_ON_CLOSE', false),

    // Enable encryption untuk security (slight performance cost untuk better security)
    'encrypt' => env('SESSION_ENCRYPT', true),

    // File storage path
    'files' => storage_path('framework/sessions'),

    // Database settings (jika menggunakan database driver)
    'connection' => env('SESSION_CONNECTION'),
    'table' => env('SESSION_TABLE', 'sessions'),
    'store' => env('SESSION_STORE'),

    // Optimized cleanup untuk shared hosting
    'lottery' => [5, 100], // 5% chance cleanup

    // Cookie settings optimized untuk shared hosting
    'cookie' => env('SESSION_COOKIE', 'village_session'),
    'path' => env('SESSION_PATH', '/'),
    'domain' => env('SESSION_DOMAIN'),
    'secure' => env('SESSION_SECURE_COOKIE', true),
    'http_only' => env('SESSION_HTTP_ONLY', true),
    'same_site' => env('SESSION_SAME_SITE', 'lax'), // More permissive for shared hosting

    // Disable partitioned cookies untuk compatibility
    'partitioned' => env('SESSION_PARTITIONED_COOKIE', false),
];
