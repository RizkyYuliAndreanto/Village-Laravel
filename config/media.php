<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Media Storage Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains the configuration for media storage used throughout
    | the application. You can switch between different storage drivers
    | like local, MinIO, or AWS S3.
    |
    */

    // Default media disk driver
    'default_disk' => env('MEDIA_DISK_DRIVER', 'public'),

    // Storage drivers configuration
    'drivers' => [
        'public' => [
            'name' => 'Local Storage',
            'description' => 'Store files locally in storage/app/public',
            'icon' => 'heroicon-o-folder',
        ],
        'minio' => [
            'name' => 'MinIO Object Storage',
            'description' => 'Store files in MinIO compatible object storage',
            'icon' => 'heroicon-o-cloud',
        ],
        's3' => [
            'name' => 'AWS S3',
            'description' => 'Store files in Amazon S3 cloud storage',
            'icon' => 'heroicon-o-cloud-arrow-up',
        ],
    ],

    // File upload settings
    'uploads' => [
        'max_size' => env('MEDIA_MAX_SIZE', 2048), // KB
        'allowed_extensions' => ['jpg', 'jpeg', 'png', 'gif', 'webp'],
        'image_quality' => env('MEDIA_IMAGE_QUALITY', 85),
        'resize_width' => env('MEDIA_RESIZE_WIDTH', 800),
        'resize_height' => env('MEDIA_RESIZE_HEIGHT', 450),
    ],

    // Directory structure
    'directories' => [
        'berita' => 'berita/images',
        'profile' => 'profile/images',
        'documents' => 'documents',
        'temp' => 'temp',
    ],

    // MinIO specific configuration
    'minio' => [
        'console_url' => env('MINIO_CONSOLE_URL', 'http://localhost:9001'),
        'public_access' => env('MINIO_PUBLIC_ACCESS', true),
    ],

];
