<?php

namespace Database\Factories;

use App\Models\Branch;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Branch>
 */
class BranchFactory extends Factory
{
    protected $model = Branch::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $cities = [
            'New York', 'Los Angeles', 'Chicago', 'Houston', 'Phoenix',
            'Philadelphia', 'San Antonio', 'San Diego', 'Dallas', 'San Jose',
            'Austin', 'Jacksonville', 'Fort Worth', 'Columbus', 'Charlotte',
            'Seattle', 'Denver', 'El Paso', 'Detroit', 'Boston'
        ];

        $city = $this->faker->randomElement($cities);

        return [
            'name' => $city . ' Branch',
            'code' => strtoupper(substr($city, 0, 3)) . $this->faker->unique()->numerify('###'),
            'address' => $this->faker->streetAddress(),
            'city' => $city,
            'state' => $this->faker->state(),
            'postal_code' => $this->faker->postcode(),
            'phone' => $this->faker->phoneNumber(),
            'email' => strtolower(str_replace(' ', '', $city)) . '@kessly.com',
            'manager_id' => null, // Will be set after employees are created
            'status' => $this->faker->randomElement(['active', 'inactive']),
            'established_date' => $this->faker->dateTimeBetween('-5 years', '-1 year'),
            'description' => $this->faker->optional(0.7)->paragraph(),
        ];
    }

    /**
     * Create an active branch.
     */
    public function active(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'active',
                'established_date' => $this->faker->dateTimeBetween('-3 years', '-6 months'),
            ];
        });
    }

    /**
     * Create an inactive branch.
     */
    public function inactive(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'inactive',
            ];
        });
    }

    /**
     * Create a main branch (headquarters).
     */
    public function headquarters(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'Headquarters',
                'code' => 'HQ001',
                'city' => 'New York',
                'state' => 'New York',
                'status' => 'active',
                'description' => 'Main headquarters office',
            ];
        });
    }
}