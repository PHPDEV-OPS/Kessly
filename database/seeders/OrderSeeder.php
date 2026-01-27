<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Branch;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customers = Customer::where('status', 'active')->get();
        $products = Product::where('stock', '>', 0)->get();
        $branches = Branch::all();

        if ($customers->isEmpty() || $products->isEmpty() || $branches->isEmpty()) {
            $this->command->warn('Active customers, products with stock, and branches must exist first!');
            return;
        }

        // Create orders for the last three months
        $allOrders = collect();
        $now = now();
        for ($i = 0; $i < 90; $i++) {
            $date = $now->copy()->subDays($i);
            $ordersForDay = Order::factory()
                ->count(rand(1, 3))
                ->create([
                    'customer_id' => $customers->random()->id,
                    'branch_id' => $branches->random()->id,
                    'order_date' => $date,
                ]);
            $allOrders = $allOrders->merge($ordersForDay);
        }

        // Create order items for each order
        foreach ($allOrders as $order) {
            $itemCount = rand(1, 5); // 1-5 items per order
            $totalAmount = 0;

            for ($i = 0; $i < $itemCount; $i++) {
                $product = $products->random();
                $quantity = rand(1, min(10, $product->stock)); // Don't exceed available stock
                
                $orderItem = OrderItem::factory()
                    ->forOrder($order)
                    ->forProduct($product)
                    ->create(['quantity' => $quantity]);

                $totalAmount += $orderItem->total_price;
                
                // Reduce product stock
                $product->decrement('stock', $quantity);
            }

            // Update order total
            $order->update(['total_amount' => $totalAmount]);
        }

        // Update customer totals
        foreach ($customers as $customer) {
            $customer->updateTotals();
        }

        $this->command->info('✅ Orders and order items seeded successfully!');
    }
}