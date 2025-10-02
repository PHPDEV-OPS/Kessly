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
        $wines = [
            // Red Wines
            ['name' => 'Cabernet Sauvignon Reserve', 'type' => 'Red Wine', 'origin' => 'Bordeaux, France', 'year' => '2019'],
            ['name' => 'Merlot Classic', 'type' => 'Red Wine', 'origin' => 'Tuscany, Italy', 'year' => '2020'],
            ['name' => 'Shiraz Premium', 'type' => 'Red Wine', 'origin' => 'Barossa Valley, Australia', 'year' => '2018'],
            ['name' => 'Pinot Noir Vintage', 'type' => 'Red Wine', 'origin' => 'Burgundy, France', 'year' => '2019'],
            ['name' => 'Sangiovese Estate', 'type' => 'Red Wine', 'origin' => 'Chianti, Italy', 'year' => '2020'],
            
            // White Wines
            ['name' => 'Sauvignon Blanc Crisp', 'type' => 'White Wine', 'origin' => 'Marlborough, New Zealand', 'year' => '2021'],
            ['name' => 'Chardonnay Reserve', 'type' => 'White Wine', 'origin' => 'Burgundy, France', 'year' => '2020'],
            ['name' => 'Riesling Dry', 'type' => 'White Wine', 'origin' => 'Mosel, Germany', 'year' => '2021'],
            ['name' => 'Gewürztraminer', 'type' => 'White Wine', 'origin' => 'Alsace, France', 'year' => '2020'],
            ['name' => 'Pinot Grigio Fresh', 'type' => 'White Wine', 'origin' => 'Alto Adige, Italy', 'year' => '2021'],
            
            // Rosé Wines
            ['name' => 'Provence Rosé', 'type' => 'Rosé Wine', 'origin' => 'Provence, France', 'year' => '2021'],
            ['name' => 'Rosé de Sangiovese', 'type' => 'Rosé Wine', 'origin' => 'Tuscany, Italy', 'year' => '2021'],
            
            // Sparkling Wines
            ['name' => 'Champagne Brut', 'type' => 'Sparkling Wine', 'origin' => 'Champagne, France', 'year' => '2018'],
            ['name' => 'Prosecco Extra Dry', 'type' => 'Sparkling Wine', 'origin' => 'Veneto, Italy', 'year' => '2021'],
            ['name' => 'Cava Reserva', 'type' => 'Sparkling Wine', 'origin' => 'Catalonia, Spain', 'year' => '2019'],
            
            // Local & Accessories
            ['name' => 'Kenyan Highland Red', 'type' => 'Local Wines', 'origin' => 'Naivasha, Kenya', 'year' => '2020'],
            ['name' => 'Rift Valley White', 'type' => 'Local Wines', 'origin' => 'Nakuru, Kenya', 'year' => '2021'],
            ['name' => 'Wine Decanter Crystal', 'type' => 'Wine Accessories', 'origin' => 'Czech Republic', 'year' => null],
            ['name' => 'Bordeaux Wine Glasses Set', 'type' => 'Wine Accessories', 'origin' => 'France', 'year' => null],
            ['name' => 'Wine Aerator Premium', 'type' => 'Wine Accessories', 'origin' => 'Italy', 'year' => null],
        ];

        $wine = $this->faker->randomElement($wines);
        
        // Wine pricing in KES (Kenyan Shillings)
        $priceRanges = [
            'Local Wines' => [800, 3000],
            'Red Wine' => [1500, 15000],
            'White Wine' => [1200, 12000],
            'Rosé Wine' => [1800, 8000],
            'Sparkling Wine' => [2500, 25000],
            'Fortified Wine' => [2000, 20000],
            'Dessert Wine' => [3000, 30000],
            'Wine Accessories' => [500, 5000],
            'Premium Collection' => [10000, 100000],
            'Vintage Wines' => [15000, 200000],
        ];
        
        $range = $priceRanges[$wine['type']] ?? [1000, 10000];
        $price = $this->faker->randomFloat(2, $range[0], $range[1]);
        
        $name = $wine['name'];
        if ($wine['year']) {
            $name .= ' ' . $wine['year'];
        }
        
        $descriptions = [
            "A premium wine with exceptional character and depth. Perfect for special occasions and fine dining.",
            "This wine offers a perfect balance of flavors with hints of fruit and subtle oak undertones.",
            "An elegant wine with a smooth finish, ideal for both casual and formal dining experiences.",
            "Rich and full-bodied with complex flavors that develop beautifully with proper aeration.",
            "A crisp and refreshing wine with bright acidity and delicate floral notes.",
            "This vintage showcases the best of its terroir with exceptional aging potential.",
        ];
        
        $wineDescription = $this->faker->randomElement($descriptions);
        if ($wine['year']) {
            $wineDescription .= " Vintage " . $wine['year'] . " from " . $wine['origin'] . ".";
        } else {
            $wineDescription .= " Crafted in " . $wine['origin'] . ".";
        }
        
        return [
            'name' => $name,
            'description' => $wineDescription,
            'category_id' => null, // Will be set by seeder
            'supplier_id' => null, // Will be set by seeder
            'stock' => $this->faker->numberBetween(0, 500),
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
     * Create an expensive wine (Premium/Vintage in KES).
     */
    public function expensive(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'price' => $this->faker->randomFloat(2, 25000, 200000), // Premium wines in KES
            ];
        });
    }

    /**
     * Create an affordable wine (Entry-level in KES).
     */
    public function cheap(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'price' => $this->faker->randomFloat(2, 500, 2000), // Entry-level wines in KES
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