<?php

namespace Database\Factories;

use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Supplier>
 */
class SupplierFactory extends Factory
{
    protected $model = Supplier::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $companyName = $this->faker->company();
        
        return [
            'name' => $companyName,
            'contact_email' => $this->faker->unique()->companyEmail(),
            'phone' => $this->faker->phoneNumber(),
            'address' => $this->faker->address(),
            'notes' => $this->faker->optional(0.6)->paragraph(),
        ];
    }

    /**
     * Create an active supplier.
     */
    public function active(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'notes' => 'Active supplier - ' . $this->faker->sentence(),
            ];
        });
    }

    /**
     * Create an inactive supplier.
     */
    public function inactive(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'notes' => 'Inactive supplier - ' . $this->faker->sentence(),
            ];
        });
    }

    /**
     * Create a high-volume supplier.
     */
    public function highVolume(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'notes' => 'High-volume supplier - ' . $this->faker->sentence(),
            ];
        });
    }
}