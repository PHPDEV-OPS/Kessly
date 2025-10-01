<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $productNames = [
            // Electronics
            'Wireless Bluetooth Headphones', 'Smart Phone Case', 'USB-C Cable', 'Portable Power Bank', 'LED Monitor',
            'Wireless Mouse', 'Mechanical Keyboard', 'Gaming Laptop', 'Tablet Stand', 'Phone Charger',
            
            // Clothing
            'Cotton T-Shirt', 'Denim Jeans', 'Running Shoes', 'Baseball Cap', 'Leather Wallet',
            'Winter Jacket', 'Cotton Hoodie', 'Sports Socks', 'Casual Sneakers', 'Canvas Backpack',
            
            // Home & Garden
            'Coffee Maker', 'Kitchen Knife Set', 'Garden Hose', 'Plant Pot', 'LED Light Bulb',
            'Vacuum Cleaner', 'Blender', 'Dining Chair', 'Throw Pillow', 'Wall Clock',
            
            // Sports & Outdoors
            'Yoga Mat', 'Water Bottle', 'Tennis Racket', 'Basketball', 'Camping Tent',
            'Hiking Boots', 'Fitness Tracker', 'Gym Bag', 'Resistance Bands', 'Bicycle Helmet',
            
            // Office Supplies
            'Notebook', 'Ballpoint Pen', 'Stapler', 'Paper Clips', 'Desk Organizer',
            'Filing Cabinet', 'Office Chair', 'Desk Lamp', 'Whiteboard', 'Calculator',
        ];

        $name = $this->faker->randomElement($productNames);
        $price = $this->faker->randomFloat(2, 5, 500);
        
        return [
            'name' => $name,
            'description' => $this->faker->paragraph(2),
            'category_id' => null, // Will be set by seeder
            'supplier_id' => null, // Will be set by seeder
            'stock' => $this->faker->numberBetween(0, 100),
            'price' => $price,
        ];
    }

    /**
     * Create a low stock product.
     */
    public function lowStock(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'stock' => $this->faker->numberBetween(0, 5),
            ];
        });
    }

    /**
     * Create an out of stock product.
     */
    public function outOfStock(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'stock' => 0,
            ];
        });
    }

    /**
     * Create a high stock product.
     */
    public function highStock(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'stock' => $this->faker->numberBetween(50, 200),
            ];
        });
    }

    /**
     * Create an expensive product.
     */
    public function expensive(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'price' => $this->faker->randomFloat(2, 200, 2000),
            ];
        });
    }

    /**
     * Create a cheap product.
     */
    public function cheap(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'price' => $this->faker->randomFloat(2, 1, 25),
            ];
        });
    }

    /**
     * Create a product with specific category.
     */
    public function forCategory(Category $category): static
    {
        return $this->state(function (array $attributes) use ($category) {
            return [
                'category_id' => $category->id,
            ];
        });
    }

    /**
     * Create a product with specific supplier.
     */
    public function fromSupplier(Supplier $supplier): static
    {
        return $this->state(function (array $attributes) use ($supplier) {
            return [
                'supplier_id' => $supplier->id,
            ];
        });
    }
}