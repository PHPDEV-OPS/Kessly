<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Invoice;
use App\Models\Employee;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function globalSearch(Request $request)
    {
        $query = $request->input('query', '');
        
        if (strlen($query) < 2) {
            return response()->json([
                'results' => [],
                'message' => 'Please enter at least 2 characters'
            ]);
        }

        $results = [
            'products' => [],
            'customers' => [],
            'orders' => [],
            'invoices' => [],
            'employees' => [],
            'suppliers' => []
        ];

        // Search Products
        $results['products'] = Product::where('name', 'like', "%{$query}%")
            ->orWhere('description', 'like', "%{$query}%")
            ->limit(5)
            ->get()
            ->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'description' => $product->description,
                    'price' => $product->price,
                    'stock' => $product->stock,
                    'url' => route('inventory')
                ];
            });

        // Search Customers
        $results['customers'] = Customer::where('name', 'like', "%{$query}%")
            ->orWhere('email', 'like', "%{$query}%")
            ->orWhere('phone', 'like', "%{$query}%")
            ->limit(5)
            ->get()
            ->map(function ($customer) {
                return [
                    'id' => $customer->id,
                    'name' => $customer->name,
                    'email' => $customer->email,
                    'phone' => $customer->phone,
                    'url' => route('customers')
                ];
            });

        // Search Orders
        $results['orders'] = Order::where('order_number', 'like', "%{$query}%")
            ->orWhereHas('customer', function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%");
            })
            ->with('customer')
            ->limit(5)
            ->get()
            ->map(function ($order) {
                return [
                    'id' => $order->id,
                    'order_number' => $order->order_number,
                    'customer' => $order->customer->name ?? 'N/A',
                    'total_amount' => $order->total_amount,
                    'order_date' => $order->order_date,
                    'url' => route('orders')
                ];
            });

        // Search Invoices
        $results['invoices'] = Invoice::where('name', 'like', "%{$query}%")
            ->orWhereHas('customer', function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%");
            })
            ->with('customer')
            ->limit(5)
            ->get()
            ->map(function ($invoice) {
                return [
                    'id' => $invoice->id,
                    'name' => $invoice->name,
                    'customer' => $invoice->customer->name ?? 'N/A',
                    'amount' => $invoice->amount,
                    'url' => route('invoices')
                ];
            });

        // Search Employees
        $results['employees'] = Employee::where('name', 'like', "%{$query}%")
            ->orWhere('email', 'like', "%{$query}%")
            ->orWhere('phone', 'like', "%{$query}%")
            ->limit(5)
            ->get()
            ->map(function ($employee) {
                return [
                    'id' => $employee->id,
                    'name' => $employee->name,
                    'email' => $employee->email,
                    'position' => $employee->position,
                    'url' => route('employees')
                ];
            });

        // Search Suppliers
        $results['suppliers'] = Supplier::where('name', 'like', "%{$query}%")
            ->orWhere('email', 'like', "%{$query}%")
            ->orWhere('phone', 'like', "%{$query}%")
            ->limit(5)
            ->get()
            ->map(function ($supplier) {
                return [
                    'id' => $supplier->id,
                    'name' => $supplier->name,
                    'email' => $supplier->email,
                    'phone' => $supplier->phone,
                    'url' => route('inventory')
                ];
            });

        $totalResults = collect($results)->sum(fn($items) => count($items));

        return response()->json([
            'results' => $results,
            'total' => $totalResults,
            'query' => $query
        ]);
    }
}
