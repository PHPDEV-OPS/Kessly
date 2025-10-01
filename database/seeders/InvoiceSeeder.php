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

        // Create high-value invoices for VIP customers
        $vipCustomers = $customers->where('customer_type', 'enterprise');
        if ($vipCustomers->isNotEmpty()) {
            foreach ($vipCustomers as $customer) {
                Invoice::factory()
                    ->highValue()
                    ->forCustomer($customer)
                    ->count(rand(3, 8))
                    ->create();
            }
        }

        // Create regular invoices for business customers
        $businessCustomers = $customers->where('customer_type', 'business');
        foreach ($businessCustomers->take(20) as $customer) {
            Invoice::factory()
                ->forCustomer($customer)
                ->count(rand(2, 6))
                ->create();
        }

        // Create low-value invoices for individual customers
        $individualCustomers = $customers->where('customer_type', 'individual');
        foreach ($individualCustomers->take(30) as $customer) {
            Invoice::factory()
                ->lowValue()
                ->forCustomer($customer)
                ->count(rand(1, 4))
                ->create();
        }

        $this->command->info('✅ Invoices seeded successfully!');
    }
}