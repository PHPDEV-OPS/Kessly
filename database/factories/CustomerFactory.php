<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    protected $model = Customer::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $isCompany = $this->faker->boolean(0.4); // 40% chance of being a company
        $customerTypes = ['individual', 'business', 'enterprise'];
        $statuses = ['active', 'inactive', 'prospect', 'blocked'];
        $paymentTerms = ['Net 30', 'Net 60', 'COD', 'Net 15', '2/10 Net 30', 'Upon Receipt'];
        
        $name = $isCompany ? $this->faker->company() : $this->faker->name();
        $customerType = $isCompany ? $this->faker->randomElement(['business', 'enterprise']) : 'individual';
        
        return [
            'name' => $name,
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'mobile' => $this->faker->optional(0.8)->phoneNumber(),
            'company' => $isCompany ? $name : $this->faker->optional(0.3)->company(),
            'website' => $this->faker->optional(0.6)->url(),
            'address' => $this->faker->streetAddress(),
            'city' => $this->faker->city(),
            'state' => $this->faker->state(),
            'postal_code' => $this->faker->postcode(),
            'country' => $this->faker->country(),
            'tax_id' => $this->faker->optional(0.7)->numerify('TAX-#########'),
            'customer_type' => $customerType,
            'status' => $this->faker->randomElement($statuses),
            'credit_limit' => $this->faker->randomFloat(2, 1000, 50000),
            'payment_terms' => $this->faker->randomElement($paymentTerms),
            'notes' => $this->faker->optional(0.5)->paragraph(),
            'tags' => $this->faker->optional(0.6)->randomElements([
                'VIP', 'Wholesale', 'Retail', 'Online', 'Local', 'International',
                'High Volume', 'Seasonal', 'New', 'Returning', 'Premium'
            ], $this->faker->numberBetween(1, 3)),
            'last_contact' => $this->faker->optional(0.7)->dateTimeBetween('-6 months', 'now'),
            'total_orders' => $this->faker->numberBetween(0, 50),
            'total_spent' => $this->faker->randomFloat(2, 0, 25000),
            'avatar' => null,
        ];
    }

    /**
     * Create an active customer.
     */
    public function active(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'active',
                'last_contact' => $this->faker->dateTimeBetween('-3 months', 'now'),
                'total_orders' => $this->faker->numberBetween(1, 50),
                'total_spent' => $this->faker->randomFloat(2, 100, 25000),
            ];
        });
    }

    /**
     * Create a VIP customer.
     */
    public function vip(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'customer_type' => 'enterprise',
                'status' => 'active',
                'credit_limit' => $this->faker->randomFloat(2, 10000, 100000),
                'total_orders' => $this->faker->numberBetween(20, 100),
                'total_spent' => $this->faker->randomFloat(2, 5000, 50000),
                'tags' => ['VIP', 'High Volume', 'Premium'],
                'payment_terms' => 'Net 30',
            ];
        });
    }

    /**
     * Create a prospect customer.
     */
    public function prospect(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'prospect',
                'total_orders' => 0,
                'total_spent' => 0,
                'last_contact' => $this->faker->optional(0.5)->dateTimeBetween('-1 month', 'now'),
                'tags' => ['Prospect', 'New'],
            ];
        });
    }

    /**
     * Create an individual customer.
     */
    public function individual(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'customer_type' => 'individual',
                'company' => null,
                'website' => null,
                'credit_limit' => $this->faker->randomFloat(2, 500, 5000),
                'tags' => ['Retail', 'Individual'],
            ];
        });
    }

    /**
     * Create a business customer.
     */
    public function business(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'customer_type' => 'business',
                'company' => $this->faker->company(),
                'website' => $this->faker->url(),
                'credit_limit' => $this->faker->randomFloat(2, 2000, 20000),
                'tax_id' => $this->faker->numerify('TAX-#########'),
                'tags' => ['Business', 'Wholesale'],
            ];
        });
    }
}