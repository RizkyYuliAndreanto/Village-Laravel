<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Trust proxies for shared hosting/load balancers
        $middleware->trustProxies(at: ['*']);

        // Standard Laravel security middleware
        $middleware->web(append: [
            \App\Http\Middleware\TrustProxies::class,
        ]);

        // Rate limiting
        $middleware->throttleApi();

        // CSRF protection (default untuk web routes)
        $middleware->validateCsrfTokens(except: [
            'webhooks/*',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Use default Laravel exception handling
    })->create();
