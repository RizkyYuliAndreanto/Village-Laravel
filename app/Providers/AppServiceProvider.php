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

        // 🔧 SHARED HOSTING STORAGE FIX - LANGSUNG DI ENV
        if (env('SHARED_HOSTING_MODE', false)) {
            // Override filesystem config untuk shared hosting
            config([
                'filesystems.disks.public.root' => public_path('storage'),
                'filesystems.disks.public.url' => config('app.url') . '/storage',
            ]);

            // Auto create directories jika belum ada
            $directories = [
                'umkm/logos',
                'umkm/galeri',
                'berita',
                'galeri',
                'ppid-dokumen',
                'struktur-organisasi'
            ];

            foreach ($directories as $dir) {
                $path = public_path('storage/' . $dir);
                if (!file_exists($path)) {
                    @mkdir($path, 0755, true);
                }
            }
        }
    }
}
