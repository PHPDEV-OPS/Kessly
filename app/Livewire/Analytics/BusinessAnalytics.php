<?php

namespace App\Livewire\Analytics;

use App\Models\Employee;
use App\Models\Branch;
use App\Models\Product;
use App\Models\Order;
use App\Models\Invoice;
use App\Models\Payroll;
use App\Models\Budget;
use App\Models\Expense;
use App\Models\Attendance;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

/**
 * Business Analytics Component
 * 
 * Performance Optimizations:
 * - 5-minute caching for all analytics data
 * - Eager loading for relationships
 * - Database-level aggregations instead of collection operations
 * - Limited data points (30 max) for trend charts
 * - Conditional loading of comparison data
 * 
 * Recommended Database Indexes:
 * - invoices: index on (created_at, amount)
 * - orders: index on (created_at, branch_id, total_amount)
 * - order_items: composite index on (order_id, product_id, quantity)
 * - employees: index on (employment_status, branch_id, hire_date)
 * - attendances: index on (date, status)
 */
class BusinessAnalytics extends Component
{
    public $dateRange = 'last_30_days';
    public $selectedBranch = '';
    public $comparisonMode = false;
    public $viewMode = 'grid'; // grid or list
    public $refreshInterval = 0; // in seconds, 0 means no auto-refresh
    
    protected $listeners = ['refreshAnalytics' => '$refresh'];
    
    public function mount()
    {
        // Initialize with default values
    }
    
    public function clearCache()
    {
        // Clear all analytics cache
        $patterns = ['analytics_*'];
        foreach ($patterns as $pattern) {
            cache()->forget($pattern);
        }
        
        // Force refresh
        $this->dispatch('analytics-cache-cleared');
    }
    
    public function toggleComparison()
    {
        $this->comparisonMode = !$this->comparisonMode;
    }
    
    public function toggleViewMode()
    {
        $this->viewMode = $this->viewMode === 'grid' ? 'list' : 'grid';
    }
    
    public function exportData($format = 'csv')
    {
        // This will be handled by JavaScript
        $this->dispatch('export-analytics', format: $format);
    }
    
    public function render()
    {
        $startDate = $this->getStartDate();
        $endDate = now();
        
        // Create a cache key based on filters
        $cacheKey = 'analytics_' . $this->dateRange . '_' . $this->selectedBranch . '_' . ($this->comparisonMode ? '1' : '0');

        // Cache results for 5 minutes to improve performance
        $data = cache()->remember($cacheKey, now()->addMinutes(5), function() use ($startDate, $endDate) {
            // Core Business Metrics
            $metrics = $this->getBusinessMetrics($startDate, $endDate);
            
            // Comparison metrics if enabled
            $comparisonMetrics = null;
            if ($this->comparisonMode) {
                $comparisonMetrics = $this->getComparisonMetrics($startDate, $endDate);
            }
            
            // HR Analytics
            $hrAnalytics = $this->getHrAnalytics($startDate, $endDate);
            
            // Financial Analytics
            $financialAnalytics = $this->getFinancialAnalytics($startDate, $endDate);
            
            // Branch Performance (optimized with eager loading)
            $branchAnalytics = $this->getBranchAnalytics($startDate, $endDate);
            
            // Trends and Charts Data
            $trends = $this->getTrendData($startDate, $endDate);
            
            return compact('metrics', 'comparisonMetrics', 'hrAnalytics', 'financialAnalytics', 'branchAnalytics', 'trends');
        });
        
        // Extract cached data
        extract($data);
        
        // Additional insights (lightweight, no caching needed)
        $insights = $this->getBusinessInsights($metrics, $trends);

        return view('livewire.analytics.business-analytics', compact(
            'metrics',
            'comparisonMetrics',
            'hrAnalytics',
            'financialAnalytics',
            'branchAnalytics',
            'trends',
            'insights'
        ));
    }
    
    private function getComparisonMetrics($startDate, $endDate)
    {
        $daysDiff = $startDate->diffInDays($endDate);
        $comparisonStart = $startDate->copy()->subDays($daysDiff);
        $comparisonEnd = $startDate->copy()->subDay();
        
        return $this->getBusinessMetrics($comparisonStart, $comparisonEnd);
    }
    
    private function getBusinessInsights($metrics, $trends)
    {
        $insights = [];
        
        // Revenue growth insight
        if (count($trends['revenue_trend']) >= 2) {
            $recentRevenue = $trends['revenue_trend']->last()->revenue ?? 0;
            $previousRevenue = $trends['revenue_trend']->first()->revenue ?? 1;
            $growth = $previousRevenue > 0 ? (($recentRevenue - $previousRevenue) / $previousRevenue) * 100 : 0;
            
            $insights[] = [
                'type' => $growth >= 0 ? 'positive' : 'negative',
                'icon' => $growth >= 0 ? 'trending-up' : 'trending-down',
                'title' => 'Revenue Trend',
                'message' => abs(round($growth, 1)) . '% ' . ($growth >= 0 ? 'increase' : 'decrease') . ' in revenue'
            ];
        }
        
        // Stock alert insight
        if (($metrics['low_stock_items'] ?? 0) > 0) {
            $insights[] = [
                'type' => 'warning',
                'icon' => 'alert-triangle',
                'title' => 'Stock Alert',
                'message' => $metrics['low_stock_items'] . ' items running low on stock'
            ];
        }
        
        // Top product insight
        if ($trends['top_products']->isNotEmpty()) {
            $topProduct = $trends['top_products']->first();
            $insights[] = [
                'type' => 'info',
                'icon' => 'star',
                'title' => 'Best Seller',
                'message' => $topProduct->name . ' leads with ' . $topProduct->total_sold . ' units sold'
            ];
        }
        
        return $insights;
    }

    private function getStartDate()
    {
        return match($this->dateRange) {
            'today' => now()->startOfDay(),
            'yesterday' => now()->subDay()->startOfDay(),
            'last_7_days' => now()->subDays(7),
            'last_30_days' => now()->subDays(30),
            'last_90_days' => now()->subDays(90),
            'this_month' => now()->startOfMonth(),
            'last_month' => now()->subMonth()->startOfMonth(),
            'this_year' => now()->startOfYear(),
            default => now()->subDays(30),
        };
    }

    private function getBusinessMetrics($startDate, $endDate)
    {
        $query = function($model) use ($startDate, $endDate) {
            return $model::whereBetween('created_at', [$startDate, $endDate]);
        };

        $branchQuery = $this->selectedBranch ? 
            function($model) use ($startDate, $endDate) {
                return $model::where('branch_id', $this->selectedBranch)
                           ->whereBetween('created_at', [$startDate, $endDate]);
            } : $query;

        return [
            'total_revenue' => $query(Invoice::class)->sum('amount'),
            'total_orders' => $query(Order::class)->count(),
            'average_order_value' => $query(Order::class)->avg('total_amount') ?? 0,
            'total_customers' => $query(\App\Models\Customer::class)->count(),
            'total_products_sold' => DB::table('order_items')
                ->join('orders', 'order_items.order_id', '=', 'orders.id')
                ->whereBetween('orders.created_at', [$startDate, $endDate])
                ->sum('order_items.quantity'),
            'inventory_value' => Product::sum(DB::raw('stock * price')),
            'low_stock_items' => Product::where('stock', '<=', 5)->count(),
        ];
    }

    private function getHrAnalytics($startDate, $endDate)
    {
        return [
            'total_employees' => Employee::active()->count(),
            'total_managers' => Employee::managers()->active()->count(),
            'total_staff' => Employee::staff()->active()->count(),
            'average_attendance_rate' => $this->calculateAttendanceRate($startDate, $endDate),
            'total_payroll_cost' => Payroll::processed()
                ->whereBetween('pay_period_start', [$startDate, $endDate])
                ->sum('net_pay'),
            'departments' => Employee::select('department', DB::raw('count(*) as count'))
                ->active()
                ->groupBy('department')
                ->get(),
            'recent_hires' => Employee::whereBetween('hire_date', [$startDate, $endDate])->count(),
        ];
    }

    private function getFinancialAnalytics($startDate, $endDate)
    {
        return [
            'total_budget_allocated' => Budget::where('status', 'approved')
                ->whereBetween('period_start', [$startDate, $endDate])
                ->sum('allocated_amount'),
            'total_expenses' => Expense::approved()
                ->whereBetween('expense_date', [$startDate, $endDate])
                ->sum('amount'),
            'budget_utilization' => $this->calculateBudgetUtilization($startDate, $endDate),
            'payroll_expenses' => Payroll::processed()
                ->whereBetween('pay_period_start', [$startDate, $endDate])
                ->sum('net_pay'),
            'expense_categories' => Expense::select('category', DB::raw('sum(amount) as total'))
                ->approved()
                ->whereBetween('expense_date', [$startDate, $endDate])
                ->groupBy('category')
                ->get(),
        ];
    }

    private function getBranchAnalytics($startDate, $endDate)
    {
        // Optimized query with aggregations in database instead of multiple queries
        return Branch::query()
            ->withCount(['employees' => function ($query) {
                $query->where('employment_status', 'active');
            }])
            ->withCount(['orders' => function ($query) use ($startDate, $endDate) {
                $query->whereBetween('created_at', [$startDate, $endDate]);
            }])
            ->withSum(['orders' => function ($query) use ($startDate, $endDate) {
                $query->whereBetween('created_at', [$startDate, $endDate]);
            }], 'total_amount')
            ->with('manager.user:id,name')
            ->get()
            ->map(function ($branch) {
                return [
                    'id' => $branch->id,
                    'name' => $branch->name,
                    'employees_count' => $branch->employees_count ?? 0,
                    'orders_count' => $branch->orders_count ?? 0,
                    'revenue' => $branch->orders_sum_total_amount ?? 0,
                    'manager' => $branch->manager?->user?->name ?? 'Not Assigned',
                ];
            });
    }

    private function getTrendData($startDate, $endDate)
    {
        // Optimize by limiting data points for better performance
        // Revenue trend - limit to last 30 data points
        $revenueTrend = Invoice::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(amount) as revenue')
            )
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->limit(30)
            ->get()
            ->reverse()
            ->values();

        // Order trend - limit to last 30 data points
        $orderTrend = Order::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as orders')
            )
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->limit(30)
            ->get()
            ->reverse()
            ->values();

        // Top selling products - already optimized
        $topProducts = DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->select('products.name', DB::raw('SUM(order_items.quantity) as total_sold'))
            ->whereBetween('orders.created_at', [$startDate, $endDate])
            ->groupBy('products.id', 'products.name')
            ->orderBy('total_sold', 'desc')
            ->limit(10)
            ->get();

        return [
            'revenue_trend' => $revenueTrend,
            'order_trend' => $orderTrend,
            'top_products' => $topProducts,
        ];
    }

    private function calculateAttendanceRate($startDate, $endDate)
    {
        $totalWorkingDays = $this->getWorkingDaysBetween($startDate, $endDate);
        $totalEmployees = Employee::active()->count();
        $totalExpectedAttendance = $totalWorkingDays * $totalEmployees;
        
        if ($totalExpectedAttendance == 0) return 0;

        $actualAttendance = Attendance::whereBetween('date', [$startDate, $endDate])
            ->whereIn('status', ['present', 'late'])
            ->count();

        return round(($actualAttendance / $totalExpectedAttendance) * 100, 2);
    }

    private function calculateBudgetUtilization($startDate, $endDate)
    {
        $totalBudget = Budget::where('status', 'approved')
            ->whereBetween('period_start', [$startDate, $endDate])
            ->sum('allocated_amount');
            
        if ($totalBudget == 0) return 0;

        $totalSpent = Budget::where('status', 'approved')
            ->whereBetween('period_start', [$startDate, $endDate])
            ->sum('spent_amount');

        return round(($totalSpent / $totalBudget) * 100, 2);
    }

    private function getWorkingDaysBetween($startDate, $endDate)
    {
        $start = Carbon::parse($startDate);
        $end = Carbon::parse($endDate);
        $workingDays = 0;

        while ($start->lte($end)) {
            if ($start->isWeekday()) {
                $workingDays++;
            }
            $start->addDay();
        }

        return $workingDays;
    }
}