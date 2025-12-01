<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\SSDOptimizedFileService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class MonitorSSDPerformance extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'ssd:monitor 
                            {--cleanup : Clean up old files}
                            {--stats : Show storage statistics}
                            {--cache-info : Show cache performance}';

    /**
     * The console command description.
     */
    protected $description = 'Monitor dan optimize SSD performance untuk shared hosting';

    protected $fileService;

    public function __construct(SSDOptimizedFileService $fileService)
    {
        parent::__construct();
        $this->fileService = $fileService;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🏠 SSD Performance Monitor - Shared Hosting Optimization');
        $this->info('========================================================');

        if ($this->option('cleanup')) {
            $this->cleanupOldFiles();
        }

        if ($this->option('stats')) {
            $this->showStorageStats();
        }

        if ($this->option('cache-info')) {
            $this->showCacheInfo();
        }

        if (!$this->option('cleanup') && !$this->option('stats') && !$this->option('cache-info')) {
            $this->showOverview();
        }

        return Command::SUCCESS;
    }

    /**
     * Show SSD performance overview
     */
    protected function showOverview(): void
    {
        $this->info('📊 SSD Performance Overview:');
        $this->newLine();

        // Storage stats
        $stats = $this->fileService->getStorageStats();
        $this->line("   📁 Total Files: {$stats['total_files']}");
        $this->line("   💾 Total Size: {$stats['total_size_mb']} MB");
        $this->line("   📍 Storage Path: " . Storage::disk('public')->path(''));

        $this->newLine();

        // Cache stats
        $this->showCacheInfo();

        $this->newLine();

        // SSD Health recommendations
        $this->showSSDRecommendations($stats);
    }

    /**
     * Show cache performance info
     */
    protected function showCacheInfo(): void
    {
        $this->info('🔥 Cache Performance:');

        // File cache directory size
        $cachePath = storage_path('framework/cache/data');
        $cacheSize = $this->getDirectorySize($cachePath);
        $this->line("   📦 Cache Size: " . $this->formatBytes($cacheSize));

        // Cache file count
        $cacheFiles = glob($cachePath . '/*');
        $this->line("   📄 Cache Files: " . count($cacheFiles));

        // Session files
        $sessionPath = storage_path('framework/sessions');
        $sessionFiles = glob($sessionPath . '/*');
        $sessionSize = $this->getDirectorySize($sessionPath);
        $this->line("   👥 Sessions: " . count($sessionFiles) . " files, " . $this->formatBytes($sessionSize));

        // View cache
        $viewPath = storage_path('framework/views');
        $viewSize = $this->getDirectorySize($viewPath);
        $this->line("   👀 View Cache: " . $this->formatBytes($viewSize));
    }

    /**
     * Show storage statistics
     */
    protected function showStorageStats(): void
    {
        $this->info('📊 Detailed Storage Statistics:');
        $this->newLine();

        $stats = $this->fileService->getStorageStats();

        $this->table(
            ['Metric', 'Value'],
            [
                ['Total Files', $stats['total_files']],
                ['Total Size (Bytes)', number_format($stats['total_size_bytes'])],
                ['Total Size (MB)', $stats['total_size_mb']],
                ['Storage Path', $stats['disk_path']],
                ['Last Check', $stats['last_check']]
            ]
        );

        // File type breakdown
        $this->analyzeFileTypes();
    }

    /**
     * Analyze file types in storage
     */
    protected function analyzeFileTypes(): void
    {
        $this->info('📁 File Type Analysis:');

        $disk = Storage::disk('public');
        $files = $disk->allFiles();
        $typeStats = [];

        foreach ($files as $file) {
            $extension = pathinfo($file, PATHINFO_EXTENSION);
            $extension = $extension ?: 'no-extension';
            $size = $disk->size($file);

            if (!isset($typeStats[$extension])) {
                $typeStats[$extension] = ['count' => 0, 'size' => 0];
            }

            $typeStats[$extension]['count']++;
            $typeStats[$extension]['size'] += $size;
        }

        // Sort by size
        uasort($typeStats, function ($a, $b) {
            return $b['size'] <=> $a['size'];
        });

        $tableData = [];
        foreach (array_slice($typeStats, 0, 10) as $ext => $data) {
            $tableData[] = [
                $ext,
                $data['count'],
                $this->formatBytes($data['size'])
            ];
        }

        $this->table(['Extension', 'Files', 'Total Size'], $tableData);
    }

    /**
     * Cleanup old files
     */
    protected function cleanupOldFiles(): void
    {
        $this->info('🧹 Cleaning up old files...');

        $daysOld = $this->ask('How many days old files to cleanup?', '30');
        $cleaned = $this->fileService->cleanupOldFiles((int)$daysOld);

        $this->info('   ✅ Cleaned ' . count($cleaned) . ' old files');

        if (count($cleaned) > 0 && $this->confirm('Show cleaned files list?', false)) {
            foreach ($cleaned as $file) {
                $this->line("   🗑️  {$file}");
            }
        }
    }

    /**
     * Show SSD optimization recommendations
     */
    protected function showSSDRecommendations(array $stats): void
    {
        $this->info('💡 SSD Optimization Recommendations:');

        // Storage size recommendations
        if ($stats['total_size_mb'] > 500) {
            $this->warn('   ⚠️  High storage usage. Consider cleanup or compression.');
        } else {
            $this->line('   ✅ Storage usage is optimal for shared hosting.');
        }

        // File count recommendations
        if ($stats['total_files'] > 10000) {
            $this->warn('   ⚠️  Many files detected. Consider organizing in subdirectories.');
        } else {
            $this->line('   ✅ File count is manageable.');
        }

        // Cache recommendations
        $cachePath = storage_path('framework/cache/data');
        $cacheSize = $this->getDirectorySize($cachePath);

        if ($cacheSize > 100 * 1024 * 1024) { // 100MB
            $this->warn('   ⚠️  Large cache size. Run: php artisan cache:clear');
        } else {
            $this->line('   ✅ Cache size is reasonable.');
        }

        $this->newLine();
        $this->info('🎯 Quick Optimization Commands:');
        $this->line('   php artisan optimize:shared-hosting --cleanup');
        $this->line('   php artisan ssd:monitor --cleanup');
        $this->line('   php artisan cache:clear');
        $this->line('   php artisan view:clear');
    }

    /**
     * Get directory size recursively
     */
    protected function getDirectorySize(string $directory): int
    {
        $size = 0;

        if (!is_dir($directory)) {
            return $size;
        }

        $files = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($directory, \RecursiveDirectoryIterator::SKIP_DOTS)
        );

        foreach ($files as $file) {
            $size += $file->getSize();
        }

        return $size;
    }

    /**
     * Format bytes to human readable format
     */
    protected function formatBytes(int $bytes, int $precision = 2): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, $precision) . ' ' . $units[$i];
    }
}
