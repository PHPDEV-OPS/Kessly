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
            // Get products with their total sales from order items
            return Product::select(
                    'products.*',
                    DB::raw('COALESCE(SUM(order_items.quantity), 0) as total_sold')
                )
                ->leftJoin('order_items', 'products.id', '=', 'order_items.product_id')
                ->groupBy('products.id', 'products.name', 'products.description', 'products.category_id', 'products.supplier_id', 'products.stock', 'products.price', 'products.created_at', 'products.updated_at')
                ->orderByDesc(DB::raw('COALESCE(SUM(order_items.quantity), 0)'))
                ->limit(5)
                ->get();
        } catch (\Exception $e) {
            // Fallback to products ordered by stock if there's an issue
            return Product::orderByDesc('stock')
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
            try {
                return [
                    'total_products' => Product::count(),
                    'total_categories' => Category::count(),
                    'total_suppliers' => Supplier::count(),
                    'total_customers' => Customer::count(),
                    'total_orders' => Order::count(),
                    'low_stock_count' => Product::where('stock', '<=', 5)->count(),
                    'out_of_stock_count' => Product::where('stock', '=', 0)->count(),
                    'revenue_30_days' => (float) Invoice::where('created_at', '>=', now()->subDays(30))->sum('amount') ?? 0,
                    'revenue_7_days' => (float) Invoice::where('created_at', '>=', now()->subDays(7))->sum('amount') ?? 0,
                    'revenue_today' => (float) Invoice::whereDate('created_at', today())->sum('amount') ?? 0,
                    'orders_today' => Order::whereDate('created_at', today())->count(),
                    'top_selling_products' => $this->getTopSellingProducts(),
                    'recent_orders' => Order::with('customer')
                        ->latest('created_at')
                        ->limit(5)
                        ->get(),
                    'recent_invoices' => Invoice::with('customer')
                        ->latest('created_at')
                        ->limit(5)
                        ->get(),
                    'low_stock_products' => Product::with(['category', 'supplier'])
                        ->where('stock', '<=', 5)
                        ->orderBy('stock', 'asc')
                        ->limit(10)
                        ->get(),
                    'monthly_revenue_trend' => $this->getMonthlyRevenueTrend(),
                ];
            } catch (\Exception $e) {
                // Return safe defaults if there are any database issues
                return [
                    'total_products' => 0,
                    'total_categories' => 0,
                    'total_suppliers' => 0,
                    'total_customers' => 0,
                    'total_orders' => 0,
                    'low_stock_count' => 0,
                    'out_of_stock_count' => 0,
                    'revenue_30_days' => 0,
                    'revenue_7_days' => 0,
                    'revenue_today' => 0,
                    'orders_today' => 0,
                    'top_selling_products' => collect([]),
                    'recent_orders' => collect([]),
                    'recent_invoices' => collect([]),
                    'low_stock_products' => collect([]),
                    'monthly_revenue_trend' => collect([]),
                ];
            }
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
