<div class="space-y-8">
    <!-- Heading -->
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold">Dashboard</h1>
    </div>

    <!-- KPIs -->
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
        <!-- Products -->
        <div class="rounded-lg bg-white p-5 shadow">
            <div class="text-sm text-gray-500">Products</div>
            <div class="mt-2 flex items-end justify-between">
                <div class="text-3xl font-semibold">{{ \App\Models\Product::count() }}</div>
            </div>
        </div>

        <!-- Categories -->
        <div class="rounded-lg bg-white p-5 shadow">
            <div class="text-sm text-gray-500">Categories</div>
            <div class="mt-2 text-3xl font-semibold">{{ \App\Models\Category::count() }}</div>
        </div>

        <!-- Suppliers -->
        <div class="rounded-lg bg-white p-5 shadow">
            <div class="text-sm text-gray-500">Suppliers</div>
            <div class="mt-2 text-3xl font-semibold">{{ \App\Models\Supplier::count() }}</div>
        </div>

        <!-- Customers -->
        <div class="rounded-lg bg-white p-5 shadow">
            <div class="text-sm text-gray-500">Customers</div>
            <div class="mt-2 text-3xl font-semibold">{{ \App\Models\Customer::count() }}</div>
        </div>

        <!-- Orders -->
        <div class="rounded-lg bg-white p-5 shadow">
            <div class="text-sm text-gray-500">Orders</div>
            <div class="mt-2 text-3xl font-semibold">{{ \App\Models\Order::count() }}</div>
        </div>

        <!-- Revenue (last 30 days) -->
        <div class="rounded-lg bg-white p-5 shadow">
            <div class="text-sm text-gray-500">Revenue (Last 30 days)</div>
            <div class="mt-2 text-3xl font-semibold">
                $ {{ number_format(\App\Models\Invoice::where('created_at', '>=', now()->subDays(30))->sum('amount'), 2) }}
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
        <!-- Recent Orders -->
        <div class="rounded-lg bg-white shadow">
            <div class="border-b p-4">
                <h2 class="text-lg font-semibold">Recent Orders</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Order #</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Customer</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                        @foreach (\App\Models\Order::with('customer')->latest()->limit(5)->get() as $order)
                            <tr>
                                <td class="px-4 py-3 font-medium text-gray-900">{{ $order->order_number }}</td>
                                <td class="px-4 py-3">{{ $order->customer?->name ?? '—' }}</td>
                                <td class="px-4 py-3">{{ $order->order_date?->format('M d, Y') }}</td>
                                <td class="px-4 py-3 text-right">$ {{ number_format($order->total_amount, 2) }}</td>
                            </tr>
                        @endforeach
                        @if (\App\Models\Order::count() === 0)
                            <tr><td colspan="4" class="px-4 py-6 text-center text-gray-500">No orders yet.</td></tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Recent Invoices -->
        <div class="rounded-lg bg-white shadow">
            <div class="border-b p-4">
                <h2 class="text-lg font-semibold">Recent Invoices</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Customer</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Amount</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                        @foreach (\App\Models\Invoice::with('customer')->latest()->limit(5)->get() as $invoice)
                            <tr>
                                <td class="px-4 py-3 font-medium text-gray-900">{{ $invoice->name }}</td>
                                <td class="px-4 py-3">{{ $invoice->customer?->name ?? '—' }}</td>
                                <td class="px-4 py-3">{{ $invoice->created_at?->format('M d, Y') }}</td>
                                <td class="px-4 py-3 text-right">$ {{ number_format($invoice->amount, 2) }}</td>
                            </tr>
                        @endforeach
                        @if (\App\Models\Invoice::count() === 0)
                            <tr><td colspan="4" class="px-4 py-6 text-center text-gray-500">No invoices yet.</td></tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Low Stock Products -->
    <div class="rounded-lg bg-white shadow">
        <div class="border-b p-4">
            <h2 class="text-lg font-semibold">Low Stock Products</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Product</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Category</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Supplier</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Stock</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                    @php($lowStock = \App\Models\Product::with(['category','supplier'])->where('stock', '<=', 5)->orderBy('stock')->limit(10)->get())
                    @forelse ($lowStock as $p)
                        <tr>
                            <td class="px-4 py-3 font-medium text-gray-900">{{ $p->name }}</td>
                            <td class="px-4 py-3">{{ $p->category?->name ?? '—' }}</td>
                            <td class="px-4 py-3">{{ $p->supplier?->name ?? '—' }}</td>
                            <td class="px-4 py-3">{{ $p->stock }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="px-4 py-6 text-center text-gray-500">All products are sufficiently stocked.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
