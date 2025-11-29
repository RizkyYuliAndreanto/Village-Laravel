<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ServeCommand extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'serve 
                            {--host=127.0.0.1 : The host address to serve the application on}
                            {--port=8000 : The port to serve the application on}
                            {--tries=10 : The max number of ports to attempt to serve on}
                            {--no-reload : Do not reload the development server on .env file changes}';

    /**
     * The console command description.
     */
    protected $description = 'Railway: ServeCommand disabled - using Apache server';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('🚀 Railway Deployment Mode');
        $this->info('📦 This application is running on Apache server (port 80)');
        $this->info('⚠️  artisan serve command is disabled in production');
        $this->info('🔗 Access your application via Railway URL');
        
        return 0;
    }
}