<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create premium wine suppliers
        Supplier::factory()->premium()->count(3)->create();

        // Create international wine suppliers
        Supplier::factory()->international()->count(8)->create();

        // Create local Kenyan suppliers
        Supplier::factory()->local()->count(3)->create();

        // Create regular wine suppliers
        Supplier::factory()->count(6)->create();

        $this->command->info('✅ Wine suppliers seeded successfully!');
    }
}