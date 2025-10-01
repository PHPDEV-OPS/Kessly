<?php

namespace Database\Factories;

use App\Models\OrderItem;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderItem>
 */
class OrderItemFactory extends Factory
{
    protected $model = OrderItem::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $quantity = $this->faker->numberBetween(1, 10);
        $unitPrice = $this->faker->randomFloat(2, 5, 500);
        
        return [
            'order_id' => Order::factory(),
            'product_id' => Product::factory(),
            'quantity' => $quantity,
            'unit_price' => $unitPrice,
            'total_price' => $quantity * $unitPrice,
        ];
    }

    /**
     * Create an order item with high quantity.
     */
    public function highQuantity(): static
    {
        return $this->state(function (array $attributes) {
            $quantity = $this->faker->numberBetween(10, 50);
            return [
                'quantity' => $quantity,
                'total_price' => $quantity * $attributes['unit_price'],
            ];
        });
    }

    /**
     * Create an order item for a specific order.
     */
    public function forOrder(Order $order): static
    {
        return $this->state(function (array $attributes) use ($order) {
            return [
                'order_id' => $order->id,
            ];
        });
    }

    /**
     * Create an order item for a specific product.
     */
    public function forProduct(Product $product): static
    {
        return $this->state(function (array $attributes) use ($product) {
            $quantity = $attributes['quantity'];
            return [
                'product_id' => $product->id,
                'unit_price' => $product->price,
                'total_price' => $quantity * $product->price,
            ];
        });
    }
}