<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::all();
        $suppliers = Supplier::all();

        if ($categories->isEmpty() || $suppliers->isEmpty()) {
            $this->command->warn('Categories and suppliers must be seeded first!');
            return;
        }

        // Create products for each category
        foreach ($categories as $category) {
            $randomSupplier = $suppliers->random();
            
            // Create 8-12 products per category
            $productCount = rand(8, 12);
            
            for ($i = 0; $i < $productCount; $i++) {
                Product::factory()
                    ->create([
                        'category_id' => $category->id,
                        'supplier_id' => $randomSupplier->id,
                    ]);
            }
        }

        // Create some specific product variations using existing categories/suppliers
        Product::factory()->lowStock()->count(15)->create([
            'category_id' => $categories->random()->id,
            'supplier_id' => $suppliers->random()->id,
        ]);
        Product::factory()->outOfStock()->count(8)->create([
            'category_id' => $categories->random()->id,
            'supplier_id' => $suppliers->random()->id,
        ]);
        Product::factory()->expensive()->count(10)->create([
            'category_id' => $categories->random()->id,
            'supplier_id' => $suppliers->random()->id,
        ]);
        Product::factory()->cheap()->count(20)->create([
            'category_id' => $categories->random()->id,
            'supplier_id' => $suppliers->random()->id,
        ]);

        $this->command->info('✅ Products seeded successfully!');
    }
}