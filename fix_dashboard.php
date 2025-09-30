<?php

use Illuminate\Support\Facades\Schema;
use App\Models\OrderItem;

// Check if order_items table exists, if not create it temporarily
if (!Schema::hasTable('order_items')) {
    try {
        Schema::create('order_items', function ($table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->integer('quantity');
            $table->decimal('unit_price', 10, 2);
            $table->decimal('total_price', 10, 2);
            $table->timestamps();

            // Add indexes for better performance
            $table->index(['order_id', 'product_id']);
            $table->index('product_id');
        });
        
        echo "✅ order_items table created successfully!\n";
    } catch (Exception $e) {
        echo "❌ Error creating order_items table: " . $e->getMessage() . "\n";
    }
} else {
    echo "✅ order_items table already exists!\n";
}

// Clear dashboard cache
try {
    cache()->forget('dashboard_analytics');
    echo "✅ Dashboard cache cleared successfully!\n";
} catch (Exception $e) {
    echo "❌ Error clearing cache: " . $e->getMessage() . "\n";
}

echo "🎉 Dashboard fixes applied successfully!\n";