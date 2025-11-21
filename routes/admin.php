<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes - Protected by IP Allowlist
|--------------------------------------------------------------------------
|
| These routes are protected by AdminIPAllowlist middleware
| Only IPs configured in security.admin_ip_allowlist can access
|
*/

Route::middleware('admin.ip')->group(function () {

    // Security Dashboard - moved to /security to avoid conflict with Filament
    Route::get('/security', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    // Management Routes
    Route::prefix('security-admin')->name('admin.')->group(function () {

        // Security Management
        Route::get('/dashboard', function () {
            return view('admin.security.index');
        })->name('security.index');

        Route::get('/security/logs', function () {
            $logs = file_get_contents(storage_path('logs/security-' . date('Y-m-d') . '.log'));
            return response($logs, 200, ['Content-Type' => 'text/plain']);
        })->name('security.logs');

        Route::get('/security/banned-ips', function () {
            $bannedIPs = [];

            // Get banned IPs from cache
            $cacheStore = app('cache')->store();

            if (method_exists($cacheStore, 'getRedis')) {
                $keys = $cacheStore->getRedis()->keys('banned_ip:*');
                foreach ($keys as $key) {
                    $ip = str_replace('banned_ip:', '', $key);
                    $ttl = $cacheStore->getRedis()->ttl($key);
                    $bannedIPs[] = [
                        'ip' => $ip,
                        'expires_in' => $ttl > 0 ? $ttl . ' seconds' : 'permanent'
                    ];
                }
            }

            return response()->json(['banned_ips' => $bannedIPs]);
        })->name('security.banned-ips');

        // System Management
        Route::get('/system/info', function () {
            return response()->json([
                'php_version' => PHP_VERSION,
                'laravel_version' => app()->version(),
                'server_time' => now()->toDateTimeString(),
                'app_env' => app()->environment(),
                'app_debug' => config('app.debug'),
                'security_features' => [
                    'force_https' => config('security.force_https'),
                    'admin_ip_allowlist' => !empty(config('security.admin_ip_allowlist')),
                    'bot_protection' => true,
                    'xss_protection' => true,
                    'sql_injection_protection' => true,
                    'brute_force_protection' => true,
                    'ddos_protection' => true,
                    'referer_check' => true,
                    'suspicious_request_detection' => true,
                ]
            ]);
        })->name('system.info');

        // Configuration Management
        Route::get('/config/security', function () {
            return response()->json(config('security'));
        })->name('config.security');
    });

    // Filament Admin (if using Filament)
    Route::prefix('filament')->group(function () {
        // Filament routes will be automatically registered here
    });
});

/*
|--------------------------------------------------------------------------
| Management Routes - Additional Protection
|--------------------------------------------------------------------------
*/

Route::middleware(['admin.ip', 'auth'])->group(function () {

    Route::prefix('manage')->name('manage.')->group(function () {

        // User Management
        Route::get('/users', function () {
            return 'User Management Panel';
        })->name('users.index');

        // Content Management
        Route::get('/content', function () {
            return 'Content Management Panel';
        })->name('content.index');

        // Settings
        Route::get('/settings', function () {
            return 'Settings Panel';
        })->name('settings.index');
    });
});
