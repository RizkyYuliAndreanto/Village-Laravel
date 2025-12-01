<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Throwable;

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
        // Trust all proxies for Railway
        $middleware->trustProxies(at: ['*']);

        // Simplified middleware stack for web
        $middleware->web(append: [
            \App\Http\Middleware\ForceHTTPS::class,
        ]);

        // Minimal API middleware
        $middleware->api(append: [
            \App\Http\Middleware\ForceHTTPS::class,
        ]);

        // Aliases
        $middleware->alias([
            'force.https' => \App\Http\Middleware\ForceHTTPS::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Handle errors in production
        $exceptions->render(function (Throwable $e, $request) {
            if (app()->environment('production')) {
                \Log::error('Application Error: ' . $e->getMessage(), [
                    'exception' => $e,
                    'url' => $request->fullUrl(),
                    'method' => $request->method(),
                    'ip' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                ]);
                
                // Return custom error page for production
                if ($request->expectsJson()) {
                    return response()->json([
                        'message' => 'An error occurred. Please try again later.',
                        'error_id' => Str::uuid()
                    ], 500);
                }
                
                return response()->view('errors.500', [], 500);
            }
            
            return null;
        });
    })->create();
