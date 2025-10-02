<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    protected $model = Category::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $wineCategories = [
            'Red Wine',
            'White Wine',
            'Rosé Wine',
            'Sparkling Wine',
            'Fortified Wine',
            'Dessert Wine',
            'Premium Collection',
            'Vintage Wines',
            'Local Wines',
            'Imported Wines',
            'Wine Accessories',
            'Gift Sets'
        ];

        $categoryName = $this->faker->randomElement($wineCategories);

        return [
            'name' => $categoryName,
        ];
    }

    /**
     * Create a specific category with custom data.
     */
    public function withName(string $name): static
    {
        return $this->state(function (array $attributes) use ($name) {
            return [
                'name' => $name,
            ];
        });
    }
}