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

class BusinessAnalytics extends Component
{
    public $dateRange = 'last_30_days';
    public $selectedBranch = '';
    
    public function render()
    {
        $startDate = $this->getStartDate();
        $endDate = now();

        // Core Business Metrics
        $metrics = $this->getBusinessMetrics($startDate, $endDate);
        
        // HR Analytics
        $hrAnalytics = $this->getHrAnalytics($startDate, $endDate);
        
        // Financial Analytics
        $financialAnalytics = $this->getFinancialAnalytics($startDate, $endDate);
        
        // Branch Performance
        $branchAnalytics = $this->getBranchAnalytics($startDate, $endDate);
        
        // Trends and Charts Data
        $trends = $this->getTrendData($startDate, $endDate);

        return view('livewire.analytics.business-analytics', compact(
            'metrics',
            'hrAnalytics',
            'financialAnalytics',
            'branchAnalytics',
            'trends'
        ));
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
        return Branch::with(['employees', 'orders'])
            ->get()
            ->map(function ($branch) use ($startDate, $endDate) {
                $orders = $branch->orders()
                    ->whereBetween('created_at', [$startDate, $endDate]);
                    
                return [
                    'id' => $branch->id,
                    'name' => $branch->name,
                    'employees_count' => $branch->employees()->active()->count(),
                    'orders_count' => $orders->count(),
                    'revenue' => $orders->sum('total_amount'),
                    'manager' => $branch->manager?->user?->name ?? 'Not Assigned',
                ];
            });
    }

    private function getTrendData($startDate, $endDate)
    {
        // Revenue trend
        $revenueTrend = Invoice::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(amount) as revenue')
            )
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Order trend
        $orderTrend = Order::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as orders')
            )
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Top selling products
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