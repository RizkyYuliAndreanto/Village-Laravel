<?php

/**
 * Shared Hosting Optimized Cache Configuration
 * Designed for shared hosting without Redis/Memcached
 */

return [
    // Use file cache sebagai default untuk shared hosting
    'default' => env('CACHE_STORE', 'file'),

    'stores' => [
        // Array cache untuk single request (sangat cepat)
        'array' => [
            'driver' => 'array',
            'serialize' => false,
        ],

        // Database cache sebagai fallback (jika diperlukan)
        'database' => [
            'driver' => 'database',
            'connection' => env('DB_CACHE_CONNECTION'),
            'table' => env('DB_CACHE_TABLE', 'cache'),
            'lock_connection' => env('DB_CACHE_LOCK_CONNECTION'),
            'lock_table' => env('DB_CACHE_LOCK_TABLE'),
        ],

        // File cache - PRIMARY untuk shared hosting (SSD Optimized)
        'file' => [
            'driver' => 'file',
            'path' => storage_path('framework/cache/data'),
            'lock_path' => storage_path('framework/cache/data'),
            'options' => [
                'compress' => env('FILE_CACHE_COMPRESSION', true), // Compress cache files
                'serialize' => env('FILE_CACHE_SERIALIZE_NATIVE', false) ? 'native' : 'php',
                'lock_timeout' => env('FILE_CACHE_LOCK_TIMEOUT', 10), // SSD optimization
            ],
        ],

        // Specialized file caches
        'views' => [
            'driver' => 'file',
            'path' => storage_path('framework/views'),
        ],

        'config' => [
            'driver' => 'file',
            'path' => storage_path('framework/cache/config'),
        ],

        'routes' => [
            'driver' => 'file',
            'path' => storage_path('framework/cache/routes'),
        ],

        // Static data cache (longer TTL)
        'static' => [
            'driver' => 'file',
            'path' => storage_path('framework/cache/static'),
            'options' => [
                'default_ttl' => 3600, // 1 hour
            ],
        ],
    ],

    // Cache prefix untuk menghindari konflik
    'prefix' => env('CACHE_PREFIX', 'village_shared'),
];
