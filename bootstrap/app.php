<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
        then: function () {
            \Illuminate\Support\Facades\Route::middleware(['web'])
                ->group(base_path('routes/admin.php'));
        }
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Security Middleware Stack
        $middleware->web(append: [
            \App\Http\Middleware\ForceHTTPS::class,
            \App\Http\Middleware\SecurityHeaders::class,
            \App\Http\Middleware\BlockMaliciousBots::class,
            \App\Http\Middleware\RefererCheck::class,
            \App\Http\Middleware\DetectSuspiciousRequest::class,
            \App\Http\Middleware\AntiDDoSMiddleware::class,
            \App\Http\Middleware\RateLimitMiddleware::class,
            \App\Http\Middleware\AntiXSSMiddleware::class,
            \App\Http\Middleware\AntiSQLInjectionMiddleware::class,
            \App\Http\Middleware\AntiBruteForceMiddleware::class,
        ]);

        // API Middleware Stack dengan rate limiting yang lebih ketat
        $middleware->api(append: [
            \App\Http\Middleware\ForceHTTPS::class,
            \App\Http\Middleware\SecurityHeaders::class,
            \App\Http\Middleware\BlockMaliciousBots::class,
            \App\Http\Middleware\DetectSuspiciousRequest::class,
            \App\Http\Middleware\AntiDDoSMiddleware::class,
            \App\Http\Middleware\RateLimitMiddleware::class . ':30,1', // 30 requests per minute
            \App\Http\Middleware\AntiXSSMiddleware::class,
            \App\Http\Middleware\AntiSQLInjectionMiddleware::class,
        ]);

        // Alias untuk middleware yang bisa digunakan di routes
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
