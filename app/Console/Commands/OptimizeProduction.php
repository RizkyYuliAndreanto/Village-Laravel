<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\PerformanceOptimizationService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Artisan;

/**
 * Production Optimization Command
 * php artisan optimize:production
 */
class OptimizeProduction extends Command
{
    protected $signature = 'optimize:production
                          {--cache-warmup : Warm up application cache}
                          {--clear-cache : Clear all caches before optimization}
                          {--monitor : Show performance monitoring}';

    protected $description = 'Optimize application for production deployment';

    protected $performanceService;

    public function __construct(PerformanceOptimizationService $performanceService)
    {
        parent::__construct();
        $this->performanceService = $performanceService;
    }

    public function handle()
    {
        $this->info('🚀 Starting Production Optimization...');

        if ($this->option('clear-cache')) {
            $this->clearAllCaches();
        }

        // Laravel built-in optimizations
        $this->runLaravelOptimizations();

        // Setup production configurations
        $this->setupProductionConfig();

        // Cache warmup
        if ($this->option('cache-warmup')) {
            $this->warmupApplicationCache();
        }

        // Performance monitoring
        if ($this->option('monitor')) {
            $this->showPerformanceMetrics();
        }

        $this->info('✅ Production optimization completed!');
        $this->displayOptimizationSummary();
    }

    protected function clearAllCaches(): void
    {
        $this->info('🧹 Clearing all caches...');

        // Clear application cache
        Artisan::call('cache:clear');
        $this->line('   - Application cache cleared');

        // Clear config cache
        Artisan::call('config:clear');
        $this->line('   - Configuration cache cleared');

        // Clear route cache  
        Artisan::call('route:clear');
        $this->line('   - Route cache cleared');

        // Clear view cache
        Artisan::call('view:clear');
        $this->line('   - View cache cleared');
    }

    protected function runLaravelOptimizations(): void
    {
        $this->info('⚡ Running Laravel optimizations...');

        // Cache configurations
        Artisan::call('config:cache');
        $this->line('   ✅ Configuration cached');

        // Cache routes
        Artisan::call('route:cache');
        $this->line('   ✅ Routes cached');

        // Cache views
        Artisan::call('view:cache');
        $this->line('   ✅ Views cached');

        // Optimize autoloader
        $this->info('   📦 Optimizing Composer autoloader...');
        exec('composer install --optimize-autoloader --no-dev', $output, $returnCode);
        if ($returnCode === 0) {
            $this->line('   ✅ Composer autoloader optimized');
        } else {
            $this->error('   ❌ Composer optimization failed');
        }
    }

    protected function setupProductionConfig(): void
    {
        $this->info('🔧 Setting up production configurations...');

        // Setup performance optimization service
        $this->performanceService->setupProductionCache();
        $this->line('   ✅ Production cache configured');

        // Check environment configurations
        $this->checkEnvironmentConfig();
    }

    protected function checkEnvironmentConfig(): void
    {
        $this->info('📋 Checking environment configuration...');

        $recommendations = [];

        // Check cache driver
        if (config('cache.default') !== 'redis') {
            $recommendations[] = 'Set CACHE_STORE=redis for better performance';
        } else {
            $this->line('   ✅ Cache driver: Redis');
        }

        // Check session driver  
        if (config('session.driver') !== 'redis') {
            $recommendations[] = 'Set SESSION_DRIVER=redis for better session performance';
        } else {
            $this->line('   ✅ Session driver: Redis');
        }

        // Check queue driver
        if (config('queue.default') !== 'redis') {
            $recommendations[] = 'Set QUEUE_CONNECTION=redis for better queue performance';
        } else {
            $this->line('   ✅ Queue driver: Redis');
        }

        // Check APP_DEBUG
        if (config('app.debug') === true) {
            $recommendations[] = 'Set APP_DEBUG=false in production';
        } else {
            $this->line('   ✅ Debug mode: Disabled');
        }

        // Check APP_ENV
        if (config('app.env') !== 'production') {
            $recommendations[] = 'Set APP_ENV=production';
        } else {
            $this->line('   ✅ Environment: Production');
        }

        if (!empty($recommendations)) {
            $this->warn('⚠️  Production Recommendations:');
            foreach ($recommendations as $rec) {
                $this->line("   - {$rec}");
            }
        }
    }

    protected function warmupApplicationCache(): void
    {
        $this->info('🔥 Warming up application cache...');

        $this->performanceService->warmupCache();
        $this->line('   ✅ Critical caches warmed up');
    }

    protected function showPerformanceMetrics(): void
    {
        $this->info('📊 Performance Metrics:');

        $metrics = $this->performanceService->monitorPerformance();

        // Database metrics
        $this->line("   Database Response: {$metrics['db_response_time']}ms ({$metrics['db_status']})");

        // Redis metrics
        if ($metrics['redis_status'] === 'healthy') {
            $this->line("   Redis Response: {$metrics['redis_response_time']}ms ({$metrics['redis_status']})");
            if (isset($metrics['cache_hit_ratio'])) {
                $this->line("   Cache Hit Ratio: {$metrics['cache_hit_ratio']}%");
            }
        } else {
            $this->warn("   Redis: {$metrics['redis_status']}");
        }

        // Memory metrics
        $this->line("   Memory Usage: {$metrics['memory_usage']['current']}MB (Peak: {$metrics['memory_usage']['peak']}MB)");
    }

    protected function displayOptimizationSummary(): void
    {
        $this->info('📈 Optimization Summary:');
        $this->line('   ✅ Laravel caches optimized (config, routes, views)');
        $this->line('   ✅ Composer autoloader optimized');
        $this->line('   ✅ Production configurations applied');

        if ($this->option('cache-warmup')) {
            $this->line('   ✅ Application caches warmed up');
        }

        $this->info('');
        $this->info('🎯 Next Steps for Production:');
        $this->line('   1. Setup Redis server (recommended)');
        $this->line('   2. Configure queue workers: php artisan queue:work');
        $this->line('   3. Setup task scheduler: * * * * * php artisan schedule:run');
        $this->line('   4. Monitor performance: php artisan optimize:production --monitor');
        $this->line('   5. Setup log rotation and monitoring');
    }
}
