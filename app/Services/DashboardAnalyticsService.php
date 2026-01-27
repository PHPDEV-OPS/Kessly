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
    private $branchId = null;

    /**
     * Set branch filter for analytics
     */
    public function setBranch($branchId)
    {
        $this->branchId = $branchId;
        return $this;
    }

    /**
     * dashboard analytics data
     */
    public function getAnalytics(): array
    {
        // Create cache key based on branch
        $cacheKey = $this->branchId ? "dashboard_analytics_branch_{$this->branchId}" : 'dashboard_analytics';

        // Cache analytics for 30 minutes instead of 5
        return cache()->remember($cacheKey, now()->addMinutes(30), function () {
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
        // Also clear any branch-specific caches
        if ($this->branchId) {
            cache()->forget("dashboard_analytics_branch_{$this->branchId}");
        }
    }

    /**
     * Get top selling products based on order quantities
     */
    private function getTopSellingProducts(): Collection
    {
        try {
            $query = Product::select(
                    'products.*',
                    DB::raw('COALESCE(SUM(order_items.quantity), 0) as total_sold')
                )
                ->leftJoin('order_items', 'products.id', '=', 'order_items.product_id');

            if ($this->branchId) {
                $query->leftJoin('orders', 'order_items.order_id', '=', 'orders.id')
                      ->where('orders.branch_id', $this->branchId);
            }

            return $query->groupBy('products.id', 'products.name', 'products.description', 'products.category_id', 'products.supplier_id', 'products.stock', 'products.price', 'products.created_at', 'products.updated_at')
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
            $query = Invoice::select(
                    DB::raw("strftime('%Y-%m', created_at) as month"),
                    DB::raw('SUM(amount) as total')
                )
                ->where('created_at', '>=', now()->subMonths(6));

            if ($this->branchId) {
                $query->whereHas('customer.orders', function ($subQuery) {
                    $subQuery->where('branch_id', $this->branchId);
                });
            }

            return $query->groupBy('month')
                ->orderBy('month')
                ->get();
        } catch (\Exception $e) {
            return collect([]);
        }
    }

    private function getTotalProducts(): int
    {
        if ($this->branchId) {
            return \App\Models\BranchInventory::where('branch_id', $this->branchId)->count();
        }
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
        if ($this->branchId) {
            return Customer::whereHas('orders', function ($query) {
                $query->where('branch_id', $this->branchId);
            })->count();
        }
        return Customer::count();
    }

    private function getTotalOrders(): int
    {
        if ($this->branchId) {
            return Order::where('branch_id', $this->branchId)->count();
        }
        return Order::count();
    }

    private function getLowStockCount(): int
    {
        if ($this->branchId) {
            return \App\Models\BranchInventory::where('branch_id', $this->branchId)
                ->whereRaw('quantity <= min_stock_level')
                ->count();
        }
        return Product::where('stock', '<=', 5)->count();
    }

    private function getOutOfStockCount(): int
    {
        if ($this->branchId) {
            return \App\Models\BranchInventory::where('branch_id', $this->branchId)
                ->where('quantity', '=', 0)
                ->count();
        }
        return Product::where('stock', '=', 0)->count();
    }

    private function getRevenue(int $days): float
    {
        if ($this->branchId) {
            return (float) Invoice::whereHas('customer.orders', function ($query) use ($days) {
                $query->where('branch_id', $this->branchId)
                      ->where('created_at', '>=', now()->subDays($days));
            })->where('created_at', '>=', now()->subDays($days))->sum('amount') ?? 0;
        }
        return (float) Invoice::where('created_at', '>=', now()->subDays($days))->sum('amount') ?? 0;
    }

    private function getRevenueToday(): float
    {
        if ($this->branchId) {
            return (float) Invoice::whereHas('customer.orders', function ($query) {
                $query->where('branch_id', $this->branchId)
                      ->whereDate('created_at', today());
            })->whereDate('created_at', today())->sum('amount') ?? 0;
        }
        return (float) Invoice::whereDate('created_at', today())->sum('amount') ?? 0;
    }

    private function getOrdersToday(): int
    {
        if ($this->branchId) {
            return Order::where('branch_id', $this->branchId)
                ->whereDate('created_at', today())
                ->count();
        }
        return Order::whereDate('created_at', today())->count();
    }

    private function getRecentOrders(): Collection
    {
        $query = Order::with('customer');
        if ($this->branchId) {
            $query->where('branch_id', $this->branchId);
        }
        return $query->latest('created_at')
            ->limit(5)
            ->get();
    }

    private function getRecentInvoices(): Collection
    {
        $query = Invoice::with('customer');
        if ($this->branchId) {
            $query->whereHas('customer.orders', function ($subQuery) {
                $subQuery->where('branch_id', $this->branchId);
            });
        }
        return $query->latest('created_at')
            ->limit(5)
            ->get();
    }

    private function getLowStockProducts(): Collection
    {
        if ($this->branchId) {
            return \App\Models\BranchInventory::with(['product.category', 'product.supplier'])
                ->where('branch_id', $this->branchId)
                ->whereRaw('quantity <= min_stock_level')
                ->orderBy('quantity', 'asc')
                ->limit(10)
                ->get()
                ->map(function ($branchInventory) {
                    $product = $branchInventory->product;
                    $product->current_stock = $branchInventory->quantity;
                    $product->min_stock_level = $branchInventory->min_stock_level;
                    return $product;
                });
        }
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