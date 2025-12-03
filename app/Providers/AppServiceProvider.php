<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Force HTTPS in production for security
        if (env('APP_ENV') === 'production') {
            URL::forceScheme('https');
        }
        
        // Set secure session cookies in production
        if (env('APP_ENV') === 'production') {
            config([
                'session.secure' => true,
                'session.http_only' => true,
                'session.same_site' => 'strict',
            ]);
        }
    }
}
