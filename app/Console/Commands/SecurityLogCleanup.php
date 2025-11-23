<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class SecurityLogCleanup extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'security:cleanup {--days=30 : Number of days to keep logs}';

    /**
     * The console command description.
     */
    protected $description = 'Clean up old security log files';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $days = (int) $this->option('days');
        $cutoffDate = now()->subDays($days);

        $this->info("🧹 Cleaning up security logs older than {$days} days...");

        $logPath = storage_path('logs');
        $files = File::glob($logPath . '/security-*.log');
        $reportFiles = File::glob($logPath . '/security-report-*.json');

        $deletedCount = 0;

        // Clean up daily security logs
        foreach ($files as $file) {
            $fileTime = File::lastModified($file);
            if ($fileTime < $cutoffDate->timestamp) {
                File::delete($file);
                $deletedCount++;
                $this->line("Deleted: " . basename($file));
            }
        }

        // Clean up security reports
        foreach ($reportFiles as $file) {
            $fileTime = File::lastModified($file);
            if ($fileTime < $cutoffDate->timestamp) {
                File::delete($file);
                $deletedCount++;
                $this->line("Deleted: " . basename($file));
            }
        }

        if ($deletedCount === 0) {
            $this->info("✅ No old log files found to delete.");
        } else {
            $this->info("✅ Cleaned up {$deletedCount} old log files.");
        }

        // Compress remaining large log files
        $this->compressLargeLogs();
    }

    /**
     * Compress large log files
     */
    protected function compressLargeLogs(): void
    {
        $logPath = storage_path('logs');
        $files = File::glob($logPath . '/security-*.log');
        $maxSize = 50 * 1024 * 1024; // 50MB

        foreach ($files as $file) {
            if (File::size($file) > $maxSize) {
                $compressedFile = $file . '.gz';

                if (!File::exists($compressedFile)) {
                    $this->info("Compressing large log file: " . basename($file));

                    $content = File::get($file);
                    $compressed = gzencode($content, 9);
                    File::put($compressedFile, $compressed);

                    // Verify compression worked
                    if (File::exists($compressedFile)) {
                        File::delete($file);
                        $this->line("Compressed and removed: " . basename($file));
                    }
                }
            }
        }
    }
}
