<?php

/**
 * Production-Optimized Cache Configuration
 * Copy this to config/cache.php for production deployment
 */

return [
    // Use Redis as default cache for production
    'default' => env('CACHE_STORE', 'redis'),

    'stores' => [
        // High-performance array cache for single request
        'array' => [
            'driver' => 'array',
            'serialize' => false,
        ],

        // Database cache sebagai fallback
        'database' => [
            'driver' => 'database',
            'connection' => env('DB_CACHE_CONNECTION'),
            'table' => env('DB_CACHE_TABLE', 'cache'),
            'lock_connection' => env('DB_CACHE_LOCK_CONNECTION'),
            'lock_table' => env('DB_CACHE_LOCK_TABLE'),
        ],

        // File cache untuk shared hosting
        'file' => [
            'driver' => 'file',
            'path' => storage_path('framework/cache/data'),
            'lock_path' => storage_path('framework/cache/data'),
        ],

        // Production Redis cache - RECOMMENDED
        'redis' => [
            'driver' => 'redis',
            'connection' => env('REDIS_CACHE_CONNECTION', 'cache'),
            'lock_connection' => env('REDIS_CACHE_LOCK_CONNECTION', 'default'),
            'options' => [
                'cluster' => env('REDIS_CLUSTER', 'redis'),
                'prefix' => env('CACHE_PREFIX', 'village_cache:'),
                'serializer' => 'php', // or 'igbinary' for better performance
                'compression' => 'lz4', // Enable compression
            ],
        ],

        // Specialized caches untuk different purposes
        'sessions' => [
            'driver' => 'redis',
            'connection' => 'cache',
            'prefix' => 'sess:',
        ],

        'views' => [
            'driver' => 'redis',
            'connection' => 'cache',
            'prefix' => 'views:',
        ],

        'statistics' => [
            'driver' => 'redis',
            'connection' => 'cache',
            'prefix' => 'stats:',
        ],

        // Long-term cache untuk data yang jarang berubah
        'static' => [
            'driver' => 'redis',
            'connection' => 'cache',
            'prefix' => 'static:',
            'options' => [
                'ttl' => 86400, // 24 hours default
            ],
        ],
    ],

    // Optimized cache prefix
    'prefix' => env('CACHE_PREFIX', 'village_cache'),
];
