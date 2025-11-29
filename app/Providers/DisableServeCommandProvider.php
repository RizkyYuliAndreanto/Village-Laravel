<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Console\ServeCommand;
use Illuminate\Console\Application as Artisan;

class DisableServeCommandProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Only disable in production/Railway environment
        if (app()->environment('production') || 
            isset($_ENV['RAILWAY_PROJECT_ID']) || 
            isset($_ENV['USE_APACHE_ONLY'])) {
            
            // Override the serve command with our custom one
            $this->app->bind('command.serve', function () {
                return new \App\Console\Commands\ServeCommand();
            });
        }
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Additional boot logic if needed
        if (app()->environment('production')) {
            // Log that serve command is disabled
            logger('ServeCommand disabled - using Apache server in production');
        }
    }
}