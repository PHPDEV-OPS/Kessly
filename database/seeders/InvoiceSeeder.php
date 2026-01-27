<?php

namespace Database\Seeders;

use App\Models\Invoice;
use App\Models\Customer;
use Illuminate\Database\Seeder;

class InvoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customers = Customer::where('status', 'active')->get();

        if ($customers->isEmpty()) {
            $this->command->warn('Active customers must exist first!');
            return;
        }

        // Create invoices for the last three months
        $now = now();
        $allCustomers = $customers->shuffle();
        for ($i = 0; $i < 90; $i++) {
            $date = $now->copy()->subDays($i);
            $customer = $allCustomers->random();
            Invoice::factory()
                ->count(rand(1, 2))
                ->create([
                    'customer_id' => $customer->id,
                    'created_at' => $date,
                    'updated_at' => $date,
                ]);
        }

        $this->command->info('✅ Invoices seeded successfully!');
    }
}