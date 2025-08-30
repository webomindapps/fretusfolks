<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\Process\Process;

class SafeQueueWorker extends Command
{
    protected $signature = 'queue:safe-work';
    protected $description = 'Run queue worker without overlapping';

    public function handle()
    {
        $lock = Cache::lock('queue-worker-lock', 180); // Lock for 180 seconds

        if ($lock->get()) {
            $this->info('Starting queue worker...');

            try {
                $process = Process::fromShellCommandline('php artisan queue:work --timeout=30 --tries=3');
                $process->run();
            } finally {
                $lock->release();
            }

            return Command::SUCCESS;
        } else {
            $this->info('Queue worker is already running. Exiting.');
            return Command::SUCCESS;
        }
    }
}
