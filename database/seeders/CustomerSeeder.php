<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\CustomerNote;
use App\Models\User;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create VIP customers
        $vipCustomers = Customer::factory()->vip()->count(5)->create();

        // Create business customers
        Customer::factory()->business()->active()->count(25)->create();

        // Create individual customers
        Customer::factory()->individual()->active()->count(40)->create();

        // Create some prospects
        Customer::factory()->prospect()->count(15)->create();

        // Create some inactive customers
        Customer::factory()->count(10)->create(['status' => 'inactive']);

        // Create customer notes for some customers
        $activeCustomers = Customer::where('status', 'active')->take(20)->get();
        $users = User::all();

        if ($users->isNotEmpty()) {
            foreach ($activeCustomers as $customer) {
                // Create 1-5 notes per customer
                $noteCount = rand(1, 5);
                for ($i = 0; $i < $noteCount; $i++) {
                    CustomerNote::factory()
                        ->create([
                            'customer_id' => $customer->id,
                            'user_id' => $users->random()->id,
                        ]);
                }
            }
        }

        $this->command->info('✅ Customers seeded successfully!');
    }
}