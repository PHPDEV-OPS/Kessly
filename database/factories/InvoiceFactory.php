<?php

namespace Database\Factories;

use App\Models\Invoice;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invoice>
 */
class InvoiceFactory extends Factory
{
    protected $model = Invoice::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => 'Invoice #' . $this->faker->unique()->numerify('INV-####'),
            'customer_id' => Customer::factory(),
            'amount' => $this->faker->randomFloat(2, 50, 5000),
        ];
    }

    /**
     * Create a high-value invoice.
     */
    public function highValue(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'amount' => $this->faker->randomFloat(2, 2000, 15000),
            ];
        });
    }

    /**
     * Create a low-value invoice.
     */
    public function lowValue(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'amount' => $this->faker->randomFloat(2, 10, 200),
            ];
        });
    }

    /**
     * Create an invoice for a specific customer.
     */
    public function forCustomer(Customer $customer): static
    {
        return $this->state(function (array $attributes) use ($customer) {
            return [
                'customer_id' => $customer->id,
            ];
        });
    }
}