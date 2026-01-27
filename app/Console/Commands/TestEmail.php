<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class TestEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:test-email {email? : The email address to send test to}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a test email to verify Brevo integration';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email') ?? 'test@example.com';

        $this->info('Sending test email to: ' . $email);

        try {
            Mail::raw('This is a test email from Kessly to verify Brevo integration is working correctly.', function ($message) use ($email) {
                $message->to($email)
                        ->subject('Kessly - Brevo Integration Test');
            });

            $this->info('✅ Test email sent successfully!');
            $this->info('Check your inbox at: ' . $email);

        } catch (\Exception $e) {
            $this->error('❌ Failed to send test email: ' . $e->getMessage());
            return 1;
        }

        return 0;
    }
}
