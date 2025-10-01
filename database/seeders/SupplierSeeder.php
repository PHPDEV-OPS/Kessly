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
        // Create high-volume suppliers
        Supplier::factory()->active()->highVolume()->count(3)->create();

        // Create regular active suppliers
        Supplier::factory()->active()->count(12)->create();

        // Create some inactive suppliers
        Supplier::factory()->inactive()->count(3)->create();

        $this->command->info('✅ Suppliers seeded successfully!');
    }
}