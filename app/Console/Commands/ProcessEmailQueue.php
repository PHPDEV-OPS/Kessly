<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class ProcessEmailQueue extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'queue:process-emails {--stop : Stop the queue worker} {--status : Show queue status}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process email queues for better performance';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if ($this->option('status')) {
            return $this->showQueueStatus();
        }

        if ($this->option('stop')) {
            return $this->stopQueueWorker();
        }

        $this->info('🚀 Starting email queue processor...');
        $this->info('📧 Processing queued emails in the background');
        $this->info('⚡ This will improve email sending performance');
        $this->newLine();

        // Start the queue worker
        Artisan::call('queue:work', [
            '--queue' => 'default',
            '--sleep' => 3,
            '--tries' => 3,
            '--max-jobs' => 1000,
            '--stop-when-empty' => false,
            '--verbose' => true,
        ]);

        return 0;
    }

    private function showQueueStatus()
    {
        $this->info('📊 Email Queue Status');
        $this->newLine();

        // Check pending jobs
        $pendingJobs = \DB::table('jobs')->count();
        $this->info("📋 Pending jobs: {$pendingJobs}");

        // Check failed jobs
        $failedJobs = \DB::table('failed_jobs')->count();
        $this->warn("❌ Failed jobs: {$failedJobs}");

        // Show queue configuration
        $this->info("🔧 Queue connection: " . config('queue.default'));
        $this->info("📧 Mail driver: " . config('mail.default'));

        return 0;
    }

    private function stopQueueWorker()
    {
        $this->info('🛑 Stopping email queue processor...');

        // This would typically send a signal to stop the worker
        // For now, we'll just show a message
        $this->warn('⚠️  To stop the queue worker, press Ctrl+C in the terminal where it\'s running');
        $this->info('💡 Consider running: php artisan queue:restart');

        return 0;
    }
}
