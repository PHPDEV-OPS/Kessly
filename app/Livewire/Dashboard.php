<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Dashboard extends Component
{
    private function getTopSellingProducts()
    {
        try {
            // Check if order_items table exists
            return Product::select('products.*', DB::raw('COALESCE(SUM(order_items.quantity), 0) as total_sold'))
                ->leftJoin('order_items', 'products.id', '=', 'order_items.product_id')
                ->groupBy('products.id')
                ->orderBy('total_sold', 'desc')
                ->limit(5)
                ->get();
        } catch (\Exception $e) {
            // If order_items table doesn't exist, return products ordered by stock 
            return Product::orderBy('stock', 'desc')
                ->limit(5)
                ->get()
                ->map(function ($product) {
                    $product->total_sold = 0;
                    return $product;
                });
        }
    }

    private function getMonthlyRevenueTrend()
    {
        try {
            // Use SQLite-compatible date formatting
            return Invoice::select(
                    DB::raw("strftime('%Y-%m', created_at) as month"),
                    DB::raw('SUM(amount) as total')
                )
                ->where('created_at', '>=', now()->subMonths(6))
                ->groupBy('month')
                ->orderBy('month')
                ->get();
        } catch (\Exception $e) {
            // Return empty collection if there's an error
            return collect([]);
        }
    }

    public function getAnalytics()
    {
        // Cache the analytics for better performance
        return cache()->remember('dashboard_analytics', now()->addMinutes(5), function () {
            return [
                'total_products' => Product::count(),
                'total_categories' => Category::count(),
                'total_suppliers' => Supplier::count(),
                'total_customers' => Customer::count(),
                'total_orders' => Order::count(),
                'low_stock_count' => Product::where('stock', '<=', 5)->count(),
                'out_of_stock_count' => Product::where('stock', 0)->count(),
                'revenue_30_days' => Invoice::where('created_at', '>=', now()->subDays(30))->sum('amount'),
                'revenue_7_days' => Invoice::where('created_at', '>=', now()->subDays(7))->sum('amount'),
                'revenue_today' => Invoice::whereDate('created_at', today())->sum('amount'),
                'orders_today' => Order::whereDate('order_date', today())->count(),
                'top_selling_products' => $this->getTopSellingProducts(),
                'recent_orders' => Order::with('customer')
                    ->latest()
                    ->limit(5)
                    ->get(),
                'recent_invoices' => Invoice::with('customer')
                    ->latest()
                    ->limit(5)
                    ->get(),
                'low_stock_products' => Product::with(['category', 'supplier'])
                    ->where('stock', '<=', 5)
                    ->orderBy('stock')
                    ->limit(10)
                    ->get(),
                'monthly_revenue_trend' => $this->getMonthlyRevenueTrend(),
            ];
        });
    }
    
    public function refreshAnalytics()
    {
        // Clear the cache and refresh
        cache()->forget('dashboard_analytics');
        $this->dispatch('analytics-refreshed');
    }

    public function mount()
    {
        // Clear cache on mount to ensure fresh data
        cache()->forget('dashboard_analytics');
    }

    public function render()
    {
        $analytics = $this->getAnalytics();
        
        return view('livewire.dashboard', compact('analytics'));
    }
}
