<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Customer;
use Illuminate\Database\Seeder;

class OrderItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Only seed if we have products and customers
        if (Product::count() > 0 && Customer::count() > 0 && Order::count() > 0) {
            
            $orders = Order::all();
            $products = Product::all();
            
            foreach ($orders as $order) {
                // Create 1-3 random items per order
                $itemCount = rand(1, 3);
                $orderTotal = 0;
                
                for ($i = 0; $i < $itemCount; $i++) {
                    $product = $products->random();
                    $quantity = rand(1, 5);
                    $unitPrice = $product->price;
                    $totalPrice = $quantity * $unitPrice;
                    
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'quantity' => $quantity,
                        'unit_price' => $unitPrice,
                        'total_price' => $totalPrice,
                    ]);
                    
                    $orderTotal += $totalPrice;
                }
                
                // Update order total
                $order->update(['total_amount' => $orderTotal]);
            }
            
            $this->command->info('Order items seeded successfully!');
        } else {
            $this->command->info('Skipping order items seeding - need products, customers, and orders first.');
        }
    }
}