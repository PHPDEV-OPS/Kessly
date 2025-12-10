<?php

namespace App\Livewire\Reports;

use App\Models\Product;
use App\Models\Category;
use App\Models\BranchInventory;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class StockReport extends Component
{
    public $filterBy = 'all'; // all, low_stock, out_of_stock, overstocked
    public $selectedCategory = '';
    public $sortBy = 'name';
    public $sortDirection = 'asc';
    
    public function render()
    {
        $data = [
            'summary' => $this->getStockSummary(),
            'products' => $this->getProducts(),
            'categories' => $this->getCategoryStock(),
            'stockMovement' => $this->getStockMovement(),
            'alerts' => $this->getStockAlerts(),
        ];
        
        return view('livewire.reports.stock-report', $data);
    }
    
    public function exportReport()
    {
        $this->dispatch('print-report');
    }
    
    public function sortBy($field)
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $field;
            $this->sortDirection = 'asc';
        }
    }
    
    private function getStockSummary()
    {
        return [
            'total_products' => Product::count(),
            'total_stock' => Product::sum('stock'),
            'total_stock_value' => Product::sum(DB::raw('stock * price')),
            'low_stock' => Product::where('stock', '>', 0)->where('stock', '<=', 10)->count(),
            'out_of_stock' => Product::where('stock', 0)->count(),
            'total_categories' => Category::count(),
        ];
    }
    
    private function getProducts()
    {
        $query = Product::with(['category', 'supplier']);
        
        // Apply filters
        if ($this->filterBy === 'low_stock') {
            $query->where('stock', '>', 0)->where('stock', '<=', 5);
        } elseif ($this->filterBy === 'out_of_stock') {
            $query->where('stock', 0);
        } elseif ($this->filterBy === 'overstocked') {
            $query->where('stock', '>', 100);
        }
        
        if ($this->selectedCategory) {
            $query->where('category_id', $this->selectedCategory);
        }
        
        // Apply sorting
        $query->orderBy($this->sortBy, $this->sortDirection);
        
        return $query->limit(50)->get();
    }
    
    private function getCategoryStock()
    {
        return Category::select(
                'categories.id',
                'categories.name',
                DB::raw('COUNT(products.id) as product_count'),
                DB::raw('COALESCE(SUM(products.stock), 0) as total_stock'),
                DB::raw('COALESCE(SUM(products.stock * products.price), 0) as stock_value')
            )
            ->leftJoin('products', 'categories.id', '=', 'products.category_id')
            ->groupBy('categories.id', 'categories.name')
            ->get()
            ->map(function($category) {
                return [
                    'category_name' => $category->name,
                    'total_stock' => $category->total_stock,
                    'product_count' => $category->product_count,
                    'stock_value' => $category->stock_value,
                ];
            });
    }
    
    private function getStockMovement()
    {
        return DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->select(
                DB::raw('DATE(orders.created_at) as date'),
                DB::raw('SUM(order_items.quantity) as items_sold')
            )
            ->where('orders.created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();
    }
    
    private function getStockAlerts()
    {
        return [
            'danger' => Product::where('stock', 0)
                ->get()
                ->map(fn($p) => ['id' => $p->id, 'name' => $p->name])
                ->toArray(),
            'warning' => Product::where('stock', '>', 0)
                ->where('stock', '<=', 10)
                ->get()
                ->map(fn($p) => ['id' => $p->id, 'name' => $p->name, 'stock' => $p->stock])
                ->toArray(),
        ];
    }
}
