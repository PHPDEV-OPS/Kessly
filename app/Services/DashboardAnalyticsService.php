<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class DashboardAnalyticsService
{
    /**
     * dashboard analytics data
     */
    public function getAnalytics(): array
    {
        // Cache analytics
        return cache()->remember('dashboard_analytics', now()->addMinutes(5), function () {
            try {
                return [
                    'total_products' => $this->getTotalProducts(),
                    'total_categories' => $this->getTotalCategories(),
                    'total_suppliers' => $this->getTotalSuppliers(),
                    'total_customers' => $this->getTotalCustomers(),
                    'total_orders' => $this->getTotalOrders(),
                    'low_stock_count' => $this->getLowStockCount(),
                    'out_of_stock_count' => $this->getOutOfStockCount(),
                    'revenue_30_days' => $this->getRevenue(30),
                    'revenue_7_days' => $this->getRevenue(7),
                    'revenue_today' => $this->getRevenueToday(),
                    'orders_today' => $this->getOrdersToday(),
                    'top_selling_products' => $this->getTopSellingProducts(),
                    'recent_orders' => $this->getRecentOrders(),
                    'recent_invoices' => $this->getRecentInvoices(),
                    'low_stock_products' => $this->getLowStockProducts(),
                    'monthly_revenue_trend' => $this->getMonthlyRevenueTrend(),
                ];
            } catch (\Exception $e) {
                return $this->getDefaultAnalytics();
            }
        });
    }

    /**
     * Clear analytics cache
     */
    public function clearCache(): void
    {
        cache()->forget('dashboard_analytics');
    }

    /**
     * Get top selling products based on order quantities
     */
    private function getTopSellingProducts(): Collection
    {
        try {
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
            return Product::orderByDesc('stock')
                ->limit(5)
                ->get()
                ->map(function ($product) {
                    $product->total_sold = 0;
                    return $product;
                });
        }
    }

    /**
     * Get monthly revenue for last 6 months
     */
    private function getMonthlyRevenueTrend(): Collection
    {
        try {
            return Invoice::select(
                    DB::raw("strftime('%Y-%m', created_at) as month"),
                    DB::raw('SUM(amount) as total')
                )
                ->where('created_at', '>=', now()->subMonths(6))
                ->groupBy('month')
                ->orderBy('month')
                ->get();
        } catch (\Exception $e) {
            return collect([]);
        }
    }

    private function getTotalProducts(): int
    {
        return Product::count();
    }

    private function getTotalCategories(): int
    {
        return Category::count();
    }

    private function getTotalSuppliers(): int
    {
        return Supplier::count();
    }

    private function getTotalCustomers(): int
    {
        return Customer::count();
    }

    private function getTotalOrders(): int
    {
        return Order::count();
    }

    private function getLowStockCount(): int
    {
        return Product::where('stock', '<=', 5)->count();
    }

    private function getOutOfStockCount(): int
    {
        return Product::where('stock', '=', 0)->count();
    }

    private function getRevenue(int $days): float
    {
        return (float) Invoice::where('created_at', '>=', now()->subDays($days))->sum('amount') ?? 0;
    }

    private function getRevenueToday(): float
    {
        return (float) Invoice::whereDate('created_at', today())->sum('amount') ?? 0;
    }

    private function getOrdersToday(): int
    {
        return Order::whereDate('created_at', today())->count();
    }

    private function getRecentOrders(): Collection
    {
        return Order::with('customer')
            ->latest('created_at')
            ->limit(5)
            ->get();
    }

    private function getRecentInvoices(): Collection
    {
        return Invoice::with('customer')
            ->latest('created_at')
            ->limit(5)
            ->get();
    }

    private function getLowStockProducts(): Collection
    {
        return Product::with(['category', 'supplier'])
            ->where('stock', '<=', 5)
            ->orderBy('stock', 'asc')
            ->limit(10)
            ->get();
    }

    /**
     * Return safe defaults if there are any database issues
     */
    private function getDefaultAnalytics(): array
    {
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
}