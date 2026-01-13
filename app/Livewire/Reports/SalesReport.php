<?php

namespace App\Livewire\Reports;

use App\Models\Order;
use App\Models\Invoice;
use App\Models\Customer;
use App\Models\Product;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SalesReport extends Component
{
    public $dateRange = 'last_30_days';
    public $groupBy = 'daily';
    public $selectedCustomer = '';
    public $selectedProduct = '';
    
    public function render()
    {
        $dates = $this->getDateRange();
        
        $data = [
            'summary' => $this->getSalesSummary($dates['start'], $dates['end']),
            'trends' => $this->getSalesTrends($dates['start'], $dates['end']),
            'topProducts' => $this->getTopProducts($dates['start'], $dates['end']),
            'topCustomers' => $this->getTopCustomers($dates['start'], $dates['end']),
            'recentOrders' => $this->getRecentOrders($dates['start'], $dates['end']),
        ];
        
        return view('livewire.reports.sales-report', $data);
    }
    
    public function exportReport()
    {
        $this->dispatch('print-report');
    }
    
    private function getDateRange()
    {
        return match($this->dateRange) {
            'today' => ['start' => now()->startOfDay(), 'end' => now()],
            'yesterday' => ['start' => now()->subDay()->startOfDay(), 'end' => now()->subDay()->endOfDay()],
            'last_7_days' => ['start' => now()->subDays(7), 'end' => now()],
            'last_30_days' => ['start' => now()->subDays(30), 'end' => now()],
            'this_month' => ['start' => now()->startOfMonth(), 'end' => now()],
            'last_month' => ['start' => now()->subMonth()->startOfMonth(), 'end' => now()->subMonth()->endOfMonth()],
            'this_year' => ['start' => now()->startOfYear(), 'end' => now()],
            default => ['start' => now()->subDays(30), 'end' => now()],
        };
    }
    
    private function getSalesSummary($start, $end)
    {
        $query = Order::whereBetween('created_at', [$start, $end]);
        
        if ($this->selectedCustomer) {
            $query->where('customer_id', $this->selectedCustomer);
        }
        
        return [
            'total_orders' => $query->count(),
            'total_revenue' => $query->sum('total_amount') ?? 0,
            'avg_order_value' => $query->avg('total_amount') ?? 0,
            'total_items_sold' => DB::table('order_items')
                ->join('orders', 'order_items.order_id', '=', 'orders.id')
                ->whereBetween('orders.created_at', [$start, $end])
                ->sum('order_items.quantity'),
        ];
    }
    
    private function getSalesTrends($start, $end)
    {
        $groupByColumn = match($this->groupBy) {
            'hourly' => "strftime('%Y-%m-%d %H:00', created_at)",
            'daily' => "DATE(created_at)",
            'weekly' => "strftime('%Y-W%W', created_at)",
            'monthly' => "strftime('%Y-%m', created_at)",
            default => "DATE(created_at)",
        };
        
        return Order::select(
                DB::raw("{$groupByColumn} as period"),
                DB::raw('COUNT(*) as orders'),
                DB::raw('SUM(total_amount) as revenue')
            )
            ->whereBetween('created_at', [$start, $end])
            ->groupBy('period')
            ->orderBy('period')
            ->get();
    }
    
    private function getTopProducts($start, $end)
    {
        return DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->select(
                'products.name',
                DB::raw('SUM(order_items.quantity) as total_quantity'),
                DB::raw('SUM(order_items.unit_price * order_items.quantity) as total_revenue'),
                DB::raw('COUNT(DISTINCT orders.id) as total_orders')
            )
            ->whereBetween('orders.created_at', [$start, $end])
            ->groupBy('products.id', 'products.name')
            ->orderBy('total_revenue', 'desc')
            ->limit(10)
            ->get();
    }
    
    private function getTopCustomers($start, $end)
    {
        return Customer::select(
                'customers.*',
                DB::raw('COUNT(orders.id) as total_orders'),
                DB::raw('SUM(orders.total_amount) as total_spent')
            )
            ->join('orders', 'customers.id', '=', 'orders.customer_id')
            ->whereBetween('orders.created_at', [$start, $end])
            ->groupBy('customers.id', 'customers.name', 'customers.email', 'customers.phone', 'customers.address', 'customers.created_at', 'customers.updated_at')
            ->orderBy('total_spent', 'desc')
            ->limit(10)
            ->get();
    }
    
    private function getRecentOrders($start, $end)
    {
        return Order::with(['customer', 'orderItems'])
            ->withCount('orderItems')
            ->whereBetween('created_at', [$start, $end])
            ->orderBy('created_at', 'desc')
            ->limit(15)
            ->get();
    }
}
