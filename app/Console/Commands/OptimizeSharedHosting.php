<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\SharedHostingOptimizationService;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Artisan;

/**
 * Shared Hosting Optimization Command
 * php artisan optimize:shared-hosting
 */
class OptimizeSharedHosting extends Command
{
    protected $signature = 'optimize:shared-hosting
                          {--setup : Setup shared hosting configurations}
                          {--cache-warmup : Warm up cache for shared hosting}
                          {--cleanup : Clean up old cache files}
                          {--monitor : Show shared hosting performance metrics}';

    protected $description = 'Optimize application for shared hosting deployment';

    protected $sharedHostingService;

    public function __construct(SharedHostingOptimizationService $sharedHostingService)
    {
        parent::__construct();
        $this->sharedHostingService = $sharedHostingService;
    }

    public function handle()
    {
        $this->info('🏠 Starting Shared Hosting Optimization...');

        if ($this->option('setup')) {
            $this->setupSharedHostingConfig();
        }

        if ($this->option('cleanup')) {
            $this->cleanupOldFiles();
        }

        // Run basic optimizations
        $this->runSharedHostingOptimizations();

        if ($this->option('cache-warmup')) {
            $this->warmupCache();
        }

        if ($this->option('monitor')) {
            $this->showPerformanceMetrics();
        }

        $this->info('✅ Shared hosting optimization completed!');
        $this->displaySharedHostingSummary();
    }

    protected function setupSharedHostingConfig(): void
    {
        $this->info('🔧 Setting up shared hosting configurations...');

        // Copy shared hosting configs
        if (File::exists(base_path('config/cache-shared-hosting.php'))) {
            File::copy(
                base_path('config/cache-shared-hosting.php'),
                base_path('config/cache.php')
            );
            $this->line('   ✅ Cache config updated for shared hosting');
        }

        if (File::exists(base_path('config/session-shared-hosting.php'))) {
            File::copy(
                base_path('config/session-shared-hosting.php'),
                base_path('config/session.php')
            );
            $this->line('   ✅ Session config updated for shared hosting');
        }

        if (File::exists(base_path('config/queue-shared-hosting.php'))) {
            File::copy(
                base_path('config/queue-shared-hosting.php'),
                base_path('config/queue.php')
            );
            $this->line('   ✅ Queue config updated for shared hosting');
        }

        // Copy environment template
        if (File::exists(base_path('.env.shared-hosting'))) {
            if (!File::exists(base_path('.env'))) {
                File::copy(
                    base_path('.env.shared-hosting'),
                    base_path('.env')
                );
                $this->line('   ✅ Environment template copied');
                $this->warn('   ⚠️  Configure database and domain settings in .env file');
            } else {
                $this->line('   ℹ️  .env file exists - manual configuration required');
            }
        }
    }

    protected function cleanupOldFiles(): void
    {
        $this->info('🧹 Cleaning up old files...');

        $this->sharedHostingService->cleanupCache();
        $this->line('   ✅ Old cache files cleaned up');

        // Clean up log files older than 7 days
        $logDir = storage_path('logs');
        if (File::isDirectory($logDir)) {
            $logFiles = File::glob($logDir . '/*.log');
            foreach ($logFiles as $file) {
                if (File::lastModified($file) < (time() - 604800)) { // 7 days
                    File::delete($file);
                }
            }
            $this->line('   ✅ Old log files cleaned up');
        }
    }

    protected function runSharedHostingOptimizations(): void
    {
        $this->info('⚡ Running shared hosting optimizations...');

        // Clear all caches first
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('route:clear');
        Artisan::call('view:clear');
        $this->line('   ✅ Caches cleared');

        // Setup shared hosting optimizations
        $this->sharedHostingService->setupSharedHostingOptimizations();
        $this->line('   ✅ Shared hosting settings applied');

        // Cache configurations (safe for shared hosting)
        Artisan::call('config:cache');
        $this->line('   ✅ Configuration cached');

        // Don't cache routes for shared hosting (can cause issues)
        $this->line('   ⚠️  Route caching skipped (shared hosting compatibility)');

        // Cache views
        Artisan::call('view:cache');
        $this->line('   ✅ Views cached');

        // Create necessary directories
        $this->createNecessaryDirectories();
    }

    protected function createNecessaryDirectories(): void
    {
        $directories = [
            storage_path('framework/cache/data'),
            storage_path('framework/cache/static'),
            storage_path('framework/sessions'),
            storage_path('logs'),
            public_path('storage'),
        ];

        foreach ($directories as $dir) {
            if (!File::isDirectory($dir)) {
                File::makeDirectory($dir, 0755, true);
            }
        }

        // Create storage symlink if it doesn't exist
        if (!File::exists(public_path('storage'))) {
            try {
                Artisan::call('storage:link');
                $this->line('   ✅ Storage symlink created');
            } catch (\Exception $e) {
                $this->warn('   ⚠️  Could not create storage symlink: ' . $e->getMessage());
            }
        }
    }

    protected function warmupCache(): void
    {
        $this->info('🔥 Warming up cache for shared hosting...');

        $this->sharedHostingService->warmupSharedHostingCache();
        $this->line('   ✅ Cache warmed up');
    }

    protected function showPerformanceMetrics(): void
    {
        $this->info('📊 Shared Hosting Performance Metrics:');

        $metrics = $this->sharedHostingService->monitorSharedHostingPerformance();

        // Database metrics
        if ($metrics['db_status'] === 'healthy') {
            $this->line("   Database Response: {$metrics['db_response_time']}ms ✅");
        } else {
            $this->error("   Database: {$metrics['db_status']} ❌");
        }

        // Cache metrics
        $this->line("   Cache Status: {$metrics['cache_status']}");
        $this->line("   Cache Files: {$metrics['cache_files_count']}");

        // Storage metrics
        $this->line("   Storage Usage: {$metrics['storage_usage_mb']}MB");

        // Memory metrics
        $memory = $metrics['memory_usage'];
        $this->line("   Memory Usage: {$memory['current']}MB / {$memory['limit']}");
        $this->line("   Peak Memory: {$memory['peak']}MB");

        // Performance recommendations
        $this->showSharedHostingRecommendations($metrics);
    }

    protected function showSharedHostingRecommendations(array $metrics): void
    {
        $this->info('💡 Shared Hosting Recommendations:');

        // Database performance
        if ($metrics['db_response_time'] > 100) {
            $this->warn('   - Database response is slow. Consider query optimization.');
        }

        // Cache files
        if ($metrics['cache_files_count'] > 1000) {
            $this->warn('   - Too many cache files. Run cleanup: php artisan optimize:shared-hosting --cleanup');
        }

        // Storage usage
        if ($metrics['storage_usage_mb'] > 100) {
            $this->warn('   - High storage usage. Consider cleaning up old logs and cache files.');
        }

        // Memory usage
        $memory = $metrics['memory_usage'];
        if ($memory['current'] > ($memory['peak'] * 0.8)) {
            $this->warn('   - High memory usage. Consider optimizing data processing.');
        }
    }

    protected function displaySharedHostingSummary(): void
    {
        $this->info('📈 Shared Hosting Optimization Summary:');
        $this->line('   ✅ File-based caching configured');
        $this->line('   ✅ Session storage optimized');
        $this->line('   ✅ Synchronous queue processing');
        $this->line('   ✅ Views and config cached');
        $this->line('   ✅ Storage directories created');

        if ($this->option('cache-warmup')) {
            $this->line('   ✅ Critical data cached');
        }

        $this->info('');
        $this->info('🎯 Shared Hosting Deployment Checklist:');
        $this->line('   1. ✅ Configure database credentials in .env');
        $this->line('   2. ✅ Set APP_URL to your domain');
        $this->line('   3. ✅ Set APP_ENV=production and APP_DEBUG=false');
        $this->line('   4. ✅ Upload files via FTP/cPanel');
        $this->line('   5. ✅ Run: php artisan key:generate');
        $this->line('   6. ✅ Run: php artisan migrate');
        $this->line('   7. ✅ Run: php artisan optimize:shared-hosting --cache-warmup');

        $this->info('');
        $this->info('📋 Shared Hosting Limitations:');
        $this->line('   • No Redis/Memcached (using file cache)');
        $this->line('   • No background queue workers (sync processing)');
        $this->line('   • Limited cron jobs (use cPanel scheduled tasks)');
        $this->line('   • File-based sessions and cache');
        $this->line('   • Conservative memory and execution limits');

        $this->info('');
        $this->info('🔄 Regular Maintenance:');
        $this->line('   • Run cache cleanup weekly: php artisan optimize:shared-hosting --cleanup');
        $this->line('   • Monitor performance: php artisan optimize:shared-hosting --monitor');
        $this->line('   • Update app: php artisan optimize:shared-hosting --cache-warmup');
    }
}
