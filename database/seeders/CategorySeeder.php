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
            'Red Wine',
            'White Wine',
            'Rose Wine', 
            'Sparkling Wine',
            'Dessert Wine',
            'Fortified Wine',
            'Beer',
            'Spirits',
            'Cocktails',
            'Non-Alcoholic Beverages',
            'Whiskey',
            'Cognac',
        ];

        foreach ($categories as $categoryName) {
            Category::firstOrCreate(
                ['name' => $categoryName]
            );
        }

        $this->command->info('✅ Categories seeded successfully!');
    }
}