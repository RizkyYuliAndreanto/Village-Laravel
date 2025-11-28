<?php

/**
 * Production-Optimized Queue Configuration
 * Supports both Redis (recommended) and Database queues
 */

return [
    // Use Redis for production queues
    'default' => env('QUEUE_CONNECTION', 'redis'),

    'connections' => [
        // Synchronous queue untuk development
        'sync' => [
            'driver' => 'sync',
        ],

        // Database queue sebagai fallback
        'database' => [
            'driver' => 'database',
            'connection' => env('DB_QUEUE_CONNECTION'),
            'table' => env('DB_QUEUE_TABLE', 'jobs'),
            'queue' => env('DB_QUEUE', 'default'),
            'retry_after' => (int) env('DB_QUEUE_RETRY_AFTER', 90),
            'after_commit' => false,
        ],

        // Redis queue - PRODUCTION RECOMMENDED
        'redis' => [
            'driver' => 'redis',
            'connection' => env('REDIS_QUEUE_CONNECTION', 'default'),
            'queue' => env('REDIS_QUEUE', 'default'),
            'retry_after' => (int) env('REDIS_QUEUE_RETRY_AFTER', 90),
            'block_for' => 5, // Block for 5 seconds untuk job baru
            'after_commit' => false,
        ],

        // High priority queue untuk critical jobs
        'high' => [
            'driver' => 'redis',
            'connection' => env('REDIS_QUEUE_CONNECTION', 'default'),
            'queue' => 'high',
            'retry_after' => 60,
            'block_for' => 2,
        ],

        // Low priority queue untuk background tasks
        'low' => [
            'driver' => 'redis',
            'connection' => env('REDIS_QUEUE_CONNECTION', 'default'),
            'queue' => 'low',
            'retry_after' => 300,
            'block_for' => 10,
        ],

        // Email queue terpisah
        'emails' => [
            'driver' => 'redis',
            'connection' => env('REDIS_QUEUE_CONNECTION', 'default'),
            'queue' => 'emails',
            'retry_after' => 120,
            'block_for' => 3,
        ],
    ],

    // Job batching dengan Redis
    'batching' => [
        'database' => env('DB_CONNECTION', 'mysql'),
        'table' => 'job_batches',
    ],

    // Failed job configuration
    'failed' => [
        'driver' => env('QUEUE_FAILED_DRIVER', 'database-uuids'),
        'database' => env('DB_CONNECTION', 'mysql'),
        'table' => 'failed_jobs',
    ],
];
