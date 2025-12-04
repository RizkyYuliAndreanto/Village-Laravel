<?php

/**
 * Laravel Application Entry Point for Shared Hosting
 * DENGAN AUTO STORAGE FIX - NO COMMAND NEEDED
 * 
 * Copy file ini ke public_html/index.php
 */

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// 🔧 SHARED HOSTING STORAGE FIX - AUTO CREATE FOLDERS
if (!file_exists(__DIR__ . '/storage')) {
    // Buat folder storage utama
    mkdir(__DIR__ . '/storage', 0755, true);

    // Buat subfolder yang diperlukan untuk aplikasi village
    $dirs = [
        'storage/umkm',
        'storage/umkm/logos',
        'storage/umkm/galeri',
        'storage/berita',
        'storage/galeri',
        'storage/ppid-dokumen',
        'storage/struktur-organisasi'
    ];

    foreach ($dirs as $dir) {
        $path = __DIR__ . '/' . $dir;
        if (!file_exists($path)) {
            mkdir($path, 0755, true);
        }
    }
}

// 🚀 BOOTSTRAP LARAVEL
if (file_exists($maintenance = __DIR__ . '/../laravel/storage/framework/maintenance.php')) {
    require $maintenance;
}

require __DIR__ . '/../laravel/vendor/autoload.php';

$app = require_once __DIR__ . '/../laravel/bootstrap/app.php';

$kernel = $app->make(Kernel::class);

$response = $kernel->handle(
    $request = Request::capture()
)->send();

$kernel->terminate($request, $response);
