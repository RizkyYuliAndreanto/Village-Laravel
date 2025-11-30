<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
        then: function () {
            Route::middleware(['web'])
                ->group(base_path('routes/admin.php'));
        }
    )
    ->withMiddleware(function (Middleware $middleware): void {

        // =========================================================
        // PENTING: Menambahkan TrustProxies sebagai middleware global
        // Ini memastikan Laravel mengenali HTTPS dari Railway
        // (Solusi untuk error CSP Violation & Mixed Content)
        // =========================================================
        $middleware->trustProxies(at: [
            '*',
        ]);

        // --- Middleware Web Stack ---
        $middleware->web(append: [
            // Pastikan TrustProxies berjalan sebelum ForceHTTPS
            // Jika Anda memiliki middleware SecurityHeaders, pastikan tidak ada CSP ganda
            \App\Http\Middleware\ForceHTTPS::class, // Harus memercayai proxy dulu
        ]);

        // API Middleware Stack (Dipertahankan)
        $middleware->api(append: [
            \App\Http\Middleware\ForceHTTPS::class,
            \App\Http\Middleware\BlockMaliciousBots::class,
            \App\Http\Middleware\DetectSuspiciousRequest::class,
            \App\Http\Middleware\AntiDDoSMiddleware::class,
            \App\Http\Middleware\RateLimitMiddleware::class . ':30,1',
            \App\Http\Middleware\AntiXSSMiddleware::class,
            \App\Http\Middleware\AntiSQLInjectionMiddleware::class,
        ]);

        // Alias (Dipertahankan)
        $middleware->alias([
            'security.headers' => \App\Http\Middleware\SecurityHeaders::class,
            'admin.ip' => \App\Http\Middleware\AdminIPAllowlist::class,
            'block.bots' => \App\Http\Middleware\BlockMaliciousBots::class,
            'referer.check' => \App\Http\Middleware\RefererCheck::class,
            'force.https' => \App\Http\Middleware\ForceHTTPS::class,
            'detect.suspicious' => \App\Http\Middleware\DetectSuspiciousRequest::class,
            'anti.ddos' => \App\Http\Middleware\AntiDDoSMiddleware::class,
            'rate.limit' => \App\Http\Middleware\RateLimitMiddleware::class,
            'anti.xss' => \App\Http\Middleware\AntiXSSMiddleware::class,
            'anti.sqli' => \App\Http\Middleware\AntiSQLInjectionMiddleware::class,
            'anti.bruteforce' => \App\Http\Middleware\AntiBruteForceMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
