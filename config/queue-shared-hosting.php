<?php

/**
 * Shared Hosting Optimized Queue Configuration  
 * Uses sync driver (no background processing)
 */

return [
    // Sync driver untuk shared hosting (no background workers)
    'default' => env('QUEUE_CONNECTION', 'sync'),

    'connections' => [
        // Synchronous processing (immediate execution)
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

        // Deferred processing (Laravel 11+)
        'deferred' => [
            'driver' => 'deferred',
        ],
    ],

    // Job batching (simplified untuk shared hosting)
    'batching' => [
        'database' => env('DB_CONNECTION', 'mysql'),
        'table' => 'job_batches',
    ],

    // Failed jobs
    'failed' => [
        'driver' => env('QUEUE_FAILED_DRIVER', 'database-uuids'),
        'database' => env('DB_CONNECTION', 'mysql'),
        'table' => 'failed_jobs',
    ],
];
