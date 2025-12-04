<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\SharedHostingStorageService;

class SyncSharedHostingStorage extends Command
{
    protected $signature = 'storage:sync-shared-hosting {--initial : Perform initial sync with directory creation}';

    protected $description = 'Sync storage files to public_html/storage for shared hosting';

    protected SharedHostingStorageService $storageService;

    public function __construct(SharedHostingStorageService $storageService)
    {
        parent::__construct();
        $this->storageService = $storageService;
    }

    public function handle(): int
    {
        $this->info('🔄 Syncing storage files for shared hosting...');

        // Check status
        $status = $this->storageService->checkSync();

        $this->table(['Check', 'Status'], [
            ['Shared Hosting Mode', $status['shared_hosting_mode'] ? '✅ Enabled' : '❌ Disabled'],
            ['Source Directory', $status['source_exists'] ? '✅ Exists' : '❌ Missing'],
            ['Public Directory', $status['public_exists'] ? '✅ Exists' : '❌ Missing'],
            ['Public Writable', $status['public_writable'] ? '✅ Writable' : '❌ Not Writable'],
            ['Is Symlink', $status['symlink_exists'] ? '✅ Yes' : '❌ No (Manual folder)'],
        ]);

        if ($this->option('initial')) {
            $this->info('🏗️ Performing initial sync...');

            if ($this->storageService->initialSync()) {
                $this->info('✅ Initial sync completed successfully!');
            } else {
                $this->error('❌ Initial sync failed. Check logs for details.');
                return 1;
            }
        } else {
            $this->info('🔄 Syncing existing files...');

            if ($this->storageService->syncDirectory()) {
                $this->info('✅ Storage sync completed successfully!');
            } else {
                $this->error('❌ Storage sync failed. Check logs for details.');
                return 1;
            }
        }

        $this->newLine();
        $this->comment('💡 Tips for shared hosting:');
        $this->line('1. Run "php artisan storage:sync-shared-hosting --initial" setelah upload');
        $this->line('2. Set SHARED_HOSTING_MODE=true di .env');
        $this->line('3. Pastikan public_html/storage/ writable (chmod 755)');

        return 0;
    }
}
