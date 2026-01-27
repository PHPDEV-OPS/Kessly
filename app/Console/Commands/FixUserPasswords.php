<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class FixUserPasswords extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fix-user-passwords {--default-password=password : Default password to use for plain text passwords}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix users with improperly hashed passwords';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $defaultPassword = $this->option('default-password');

        $this->info('🔍 Checking for users with non-bcrypt passwords...');

        $users = User::all();
        $fixedCount = 0;

        foreach ($users as $user) {
            // Check if password is not bcrypt hashed (bcrypt hashes start with $2y$, $2a$, or $2b$)
            if (!preg_match('/^\$2[ayb]\$.{56}$/', $user->password)) {
                $this->warn("⚠️  User {$user->email} has non-bcrypt password. Fixing...");

                // If it's a plain text password that matches our default, hash it
                // Otherwise, set it to the default password
                if ($user->password === $defaultPassword) {
                    $user->password = Hash::make($defaultPassword);
                } else {
                    // For security, set unknown passwords to default
                    $this->warn("   Setting password to default for: {$user->email}");
                    $user->password = Hash::make($defaultPassword);
                }

                $user->save();
                $fixedCount++;

                $this->info("✅ Fixed password for: {$user->email}");
            }
        }

        if ($fixedCount === 0) {
            $this->info('✅ All user passwords are properly hashed!');
        } else {
            $this->info("🔧 Fixed {$fixedCount} user password(s)");
            $this->warn("⚠️  Default password is: {$defaultPassword}");
            $this->warn("🔑 Users can now login with: {$defaultPassword}");
        }

        return 0;
    }
}
