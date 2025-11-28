<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Artisan;

/**
 * Pre-Deployment Optimization Command
 * Prepare Laravel project for shared hosting deployment
 */
class PreDeploymentOptimize extends Command
{
    protected $signature = 'optimize:pre-deploy 
                            {--cleanup : Clean development files}
                            {--permissions : Fix directory permissions}
                            {--cache-clear : Clear all caches}
                            {--security-check : Verify security configurations}
                            {--all : Run all optimization steps}';

    protected $description = 'Optimize Laravel project for shared hosting deployment';

    public function handle(): int
    {
        $this->info('🚀 Pre-Deployment Optimization for Village Web');
        $this->info('==============================================');

        if ($this->option('all')) {
            $this->runAllOptimizations();
        } else {
            $this->runSelectedOptimizations();
        }

        $this->newLine();
        $this->info('✅ Pre-deployment optimization completed!');
        $this->displayDeploymentTips();

        return 0;
    }

    protected function runAllOptimizations(): void
    {
        $this->cleanDevelopmentFiles();
        $this->createRequiredDirectories();
        $this->clearAllCaches();
        $this->verifySecurityConfiguration();
        $this->optimizeForSharedHosting();
    }

    protected function runSelectedOptimizations(): void
    {
        if ($this->option('cleanup')) {
            $this->cleanDevelopmentFiles();
        }

        if ($this->option('permissions')) {
            $this->createRequiredDirectories();
        }

        if ($this->option('cache-clear')) {
            $this->clearAllCaches();
        }

        if ($this->option('security-check')) {
            $this->verifySecurityConfiguration();
        }

        // Always run basic optimizations
        $this->optimizeForSharedHosting();
    }

    protected function cleanDevelopmentFiles(): void
    {
        $this->info('🧹 Cleaning development files...');

        $developmentFiles = [
            'package.json',
            'package-lock.json',
            'yarn.lock',
            'webpack.mix.js',
            'vite.config.js',
            'tailwind.config.js',
            'postcss.config.js',
            'phpunit.xml',
            '.env.example',
            'docker-compose.yml',
            'Dockerfile',
        ];

        $cleaned = 0;
        foreach ($developmentFiles as $file) {
            if (File::exists(base_path($file))) {
                File::delete(base_path($file));
                $this->line("   ✅ Removed: {$file}");
                $cleaned++;
            }
        }

        $developmentDirectories = [
            'node_modules',
            'tests',
            '.git',
            '.github',
        ];

        foreach ($developmentDirectories as $dir) {
            if (File::isDirectory(base_path($dir))) {
                File::deleteDirectory(base_path($dir));
                $this->line("   ✅ Removed directory: {$dir}");
                $cleaned++;
            }
        }

        $this->line("   📦 Cleaned {$cleaned} development files/directories");
    }

    protected function createRequiredDirectories(): void
    {
        $this->info('📁 Creating required directories...');

        $directories = [
            storage_path('framework/cache/data'),
            storage_path('framework/cache/static'),
            storage_path('framework/sessions'),
            storage_path('framework/views'),
            storage_path('logs/daily'),
            storage_path('app/public'),
            storage_path('app/security'),
            base_path('bootstrap/cache'),
        ];

        $created = 0;
        foreach ($directories as $dir) {
            if (!File::isDirectory($dir)) {
                File::makeDirectory($dir, 0755, true);
                $this->line("   ✅ Created: " . str_replace(base_path(), '', $dir));
                $created++;
            }
        }

        $this->line("   📂 Created {$created} directories");
    }

    protected function clearAllCaches(): void
    {
        $this->info('🗑️ Clearing all caches...');

        try {
            Artisan::call('cache:clear');
            $this->line('   ✅ Application cache cleared');

            Artisan::call('config:clear');
            $this->line('   ✅ Configuration cache cleared');

            Artisan::call('view:clear');
            $this->line('   ✅ View cache cleared');

            Artisan::call('route:clear');
            $this->line('   ✅ Route cache cleared');

            // Clear compiled views
            $viewPath = storage_path('framework/views');
            if (File::isDirectory($viewPath)) {
                File::cleanDirectory($viewPath);
                $this->line('   ✅ Compiled views cleared');
            }
        } catch (\Exception $e) {
            $this->warn('   ⚠️ Some caches could not be cleared: ' . $e->getMessage());
        }
    }

    protected function verifySecurityConfiguration(): void
    {
        $this->info('🛡️ Verifying security configuration...');

        // Check critical security files
        $securityFiles = [
            'app/Http/Middleware/SecurityHeaders.php',
            'app/Http/Middleware/AdminIPAllowlist.php',
            'config/security.php',
            'public/.htaccess',
        ];

        $missing = [];
        foreach ($securityFiles as $file) {
            if (!File::exists(base_path($file))) {
                $missing[] = $file;
            }
        }

        if (!empty($missing)) {
            $this->warn('   ⚠️ Missing security files:');
            foreach ($missing as $file) {
                $this->line("     ❌ {$file}");
            }
        } else {
            $this->line('   ✅ All security files present');
        }

        // Check .env template exists
        if (!File::exists(base_path('.env.shared-hosting'))) {
            $this->warn('   ⚠️ Missing .env.shared-hosting template');
        } else {
            $this->line('   ✅ Shared hosting .env template found');
        }
    }

    protected function optimizeForSharedHosting(): void
    {
        $this->info('⚡ Optimizing for shared hosting...');

        try {
            // Run shared hosting optimization if available
            if (class_exists('App\Console\Commands\OptimizeSharedHosting')) {
                Artisan::call('optimize:shared-hosting', ['--cache-warmup' => true]);
                $this->line('   ✅ Shared hosting optimizations applied');
            }

            // Generate optimized autoloader
            if (File::exists(base_path('composer.json'))) {
                $this->line('   📦 Composer autoloader optimization recommended');
                $this->line('      Run: composer install --no-dev --optimize-autoloader');
            }
        } catch (\Exception $e) {
            $this->warn('   ⚠️ Some optimizations failed: ' . $e->getMessage());
        }
    }

    protected function displayDeploymentTips(): void
    {
        $this->newLine();
        $this->info('📋 DEPLOYMENT CHECKLIST:');
        $this->line('1. ✅ Upload files to shared hosting');
        $this->line('2. ✅ Copy .env.shared-hosting to .env');
        $this->line('3. ✅ Edit .env with real database credentials');
        $this->line('4. ✅ Run: php artisan key:generate');
        $this->line('5. ✅ Run: php artisan migrate --force');
        $this->line('6. ✅ Run: php artisan storage:link');
        $this->line('7. ✅ Set permissions: chmod 755 storage/ bootstrap/cache/');
        $this->line('8. ✅ Test website functionality');

        $this->newLine();
        $this->comment('🎯 Ready for shared hosting deployment!');
    }
}
