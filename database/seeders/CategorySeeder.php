<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create predefined categories
        $categories = [
            'Electronics',
            'Clothing & Fashion',
            'Home & Garden', 
            'Sports & Outdoors',
            'Books & Media',
            'Health & Beauty',
            'Automotive',
            'Toys & Games',
            'Office Supplies',
            'Food & Beverages',
            'Furniture',
            'Tools & Hardware',
        ];

        foreach ($categories as $categoryName) {
            Category::firstOrCreate(
                ['name' => $categoryName]
            );
        }

        $this->command->info('✅ Categories seeded successfully!');
    }
}