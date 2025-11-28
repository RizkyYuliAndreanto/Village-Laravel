<?php

/**
 * Production-Optimized Session Configuration
 * Copy this to config/session.php for production
 */

return [
    // Use Redis for session storage in production
    'driver' => env('SESSION_DRIVER', 'redis'),

    // Optimized session lifetime (2 hours)
    'lifetime' => (int) env('SESSION_LIFETIME', 120),
    'expire_on_close' => env('SESSION_EXPIRE_ON_CLOSE', false),

    // Session encryption for security
    'encrypt' => env('SESSION_ENCRYPT', true),

    // File storage path (fallback)
    'files' => storage_path('framework/sessions'),

    // Redis connection for sessions
    'connection' => env('SESSION_CONNECTION', 'sessions'),

    // Session table (untuk database driver)
    'table' => env('SESSION_TABLE', 'sessions'),

    // Redis store untuk session
    'store' => env('SESSION_STORE', 'sessions'),

    // Optimized lottery untuk cleanup
    'lottery' => [2, 100], // 2% chance

    // Secure cookie settings untuk production
    'cookie' => env('SESSION_COOKIE', 'village_session'),
    'path' => env('SESSION_PATH', '/'),
    'domain' => env('SESSION_DOMAIN'),
    'secure' => env('SESSION_SECURE_COOKIE', true), // HTTPS only
    'http_only' => env('SESSION_HTTP_ONLY', true), // XSS protection
    'same_site' => env('SESSION_SAME_SITE', 'strict'), // CSRF protection

    // Partitioned cookies untuk enhanced security
    'partitioned' => env('SESSION_PARTITIONED_COOKIE', true),
];
