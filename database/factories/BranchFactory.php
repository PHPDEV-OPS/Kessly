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
        $kenyanCities = [
            ['city' => 'Nairobi', 'area' => 'Westlands', 'county' => 'Nairobi'],
            ['city' => 'Nairobi', 'area' => 'Karen', 'county' => 'Nairobi'],
            ['city' => 'Nairobi', 'area' => 'Lavington', 'county' => 'Nairobi'],
            ['city' => 'Mombasa', 'area' => 'Nyali', 'county' => 'Mombasa'],
            ['city' => 'Mombasa', 'area' => 'Bamburi', 'county' => 'Mombasa'],
            ['city' => 'Kisumu', 'area' => 'Milimani', 'county' => 'Kisumu'],
            ['city' => 'Nakuru', 'area' => 'Milimani', 'county' => 'Nakuru'],
            ['city' => 'Eldoret', 'area' => 'Pioneer', 'county' => 'Uasin Gishu'],
            ['city' => 'Thika', 'area' => 'Makongeni', 'county' => 'Kiambu'],
            ['city' => 'Machakos', 'area' => 'Town Center', 'county' => 'Machakos']
        ];

        $location = $this->faker->randomElement($kenyanCities);
        $branchName = 'Kessly Wine ' . $location['area'] . ' Store';

        return [
            'name' => $branchName,
            'code' => strtoupper(substr($location['city'], 0, 3)) . $this->faker->unique()->numerify('##'),
            'address' => $this->faker->streetName() . ' Road, ' . $location['area'],
            'city' => $location['city'],
            'state' => $location['county'],
            'postal_code' => $this->faker->numerify('#####'),
            'phone' => $this->faker->numerify('+254 20 ### ####'),
            'email' => strtolower(str_replace([' ', '-'], ['', ''], $location['area'])) . '@kessly.co.ke',
            'manager_id' => null, // Will be set after employees are created
            'status' => $this->faker->randomElement(['active', 'inactive']),
            'established_date' => $this->faker->dateTimeBetween('-5 years', '-1 year'),
            'description' => $this->faker->optional(0.8)->randomElement([
                'Premium wine store serving the local community with curated wine selection.',
                'Full-service wine shop with tasting room and wine education services.',
                'Wine distribution center with retail showroom and corporate sales.',
                'Boutique wine store specializing in fine wines and accessories.',
                'Wine superstore with extensive local and international wine collection.'
            ]),
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
     * Create the main headquarters branch.
     */
    public function headquarters(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'Kessly Wine Headquarters',
                'code' => 'HQ01',
                'address' => 'Westlands Business District, Ring Road',
                'city' => 'Nairobi',
                'state' => 'Nairobi',
                'phone' => '+254 20 444 5555',
                'email' => 'headquarters@kessly.co.ke',
                'status' => 'active',
                'description' => 'Main headquarters and distribution center for Kessly Wine Distribution with executive offices, main warehouse, and flagship showroom.',
            ];
        });
    }
}