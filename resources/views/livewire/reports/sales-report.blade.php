<div>
    <!-- Filters Card -->
    <div class="card mb-4 no-print">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label small text-muted mb-1">Date Range</label>
                    <select wire:model.live="dateRange" class="form-select">
                        <option value="today">Today</option>
                        <option value="week">This Week</option>
                        <option value="month">This Month</option>
                        <option value="quarter">This Quarter</option>
                        <option value="year">This Year</option>
                        <option value="all">All Time</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label small text-muted mb-1">Group By</label>
                    <select wire:model.live="groupBy" class="form-select">
                        <option value="day">Daily</option>
                        <option value="week">Weekly</option>
                        <option value="month">Monthly</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label small text-muted mb-1">Customer</label>
                    <select wire:model.live="selectedCustomer" class="form-select">
                        <option value="">All Customers</option>
                        @foreach(\App\Models\Customer::all() as $customer)
                            <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label small text-muted mb-1">Product</label>
                    <select wire:model.live="selectedProduct" class="form-select">
                        <option value="">All Products</option>
                        @foreach(\App\Models\Product::all() as $product)
                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Loading State -->
    <div wire:loading.delay class="text-center py-4">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
        <p class="text-muted mt-2">Loading sales data...</p>
    </div>

    <div wire:loading.remove.delay id="salesReportContent">
        <!-- Summary Cards -->
        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="avatar avatar-lg bg-label-primary rounded">
                                    <i class='bx bx-cart fs-3'></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <small class="text-muted d-block">Total Orders</small>
                                <h4 class="mb-0">{{ number_format($summary['total_orders']) }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="avatar avatar-lg bg-label-success rounded">
                                    <i class='bx bx-dollar fs-3'></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <small class="text-muted d-block">Total Revenue</small>
                                <h4 class="mb-0">${{ number_format($summary['total_revenue'], 2) }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="avatar avatar-lg bg-label-info rounded">
                                    <i class='bx bx-trending-up fs-3'></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <small class="text-muted d-block">Average Order</small>
                                <h4 class="mb-0">${{ number_format($summary['avg_order_value'], 2) }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sales Trend Chart -->
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Sales Trend</h5>
                <div class="no-print">
                    <button class="btn btn-sm btn-outline-secondary me-2" wire:click="exportReport">
                        <i class='bx bx-printer me-1'></i>Print Report
                    </button>
                    <button class="btn btn-sm btn-primary" wire:click="exportReport">
                        <i class='bx bx-download me-1'></i>Export PDF
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div id="salesTrendChart"></div>
            </div>
        </div>

        <div class="row g-4 mb-4">
            <!-- Top Products -->
            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="mb-0">Top Products</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th class="text-end">Orders</th>
                                        <th class="text-end">Revenue</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($topProducts as $product)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar avatar-sm bg-label-primary rounded me-2">
                                                        <i class='bx bx-package'></i>
                                                    </div>
                                                    <span>{{ $product->name }}</span>
                                                </div>
                                            </td>
                                            <td class="text-end">{{ number_format($product->total_orders) }}</td>
                                            <td class="text-end fw-semibold">${{ number_format($product->total_revenue, 2) }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center text-muted">No data available</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Top Customers -->
            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="mb-0">Top Customers</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Customer</th>
                                        <th class="text-end">Orders</th>
                                        <th class="text-end">Total Spent</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($topCustomers as $customer)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar avatar-sm bg-label-success rounded me-2">
                                                        <i class='bx bx-user'></i>
                                                    </div>
                                                    <span>{{ $customer->name }}</span>
                                                </div>
                                            </td>
                                            <td class="text-end">{{ number_format($customer->total_orders) }}</td>
                                            <td class="text-end fw-semibold">${{ number_format($customer->total_spent, 2) }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center text-muted">No data available</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Orders -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Recent Orders</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Customer</th>
                                <th>Date</th>
                                <th>Items</th>
                                <th class="text-end">Amount</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentOrders as $order)
                                <tr>
                                    <td><span class="badge bg-label-secondary">#{{ $order->id }}</span></td>
                                    <td>{{ $order->customer?->name ?? 'Walk-in' }}</td>
                                    <td>{{ $order->created_at->format('M d, Y') }}</td>
                                    <td>{{ $order->order_items_count }} items</td>
                                    <td class="text-end fw-semibold">${{ number_format($order->total_amount, 2) }}</td>}}</td>
                                    <td>
                                        <span class="badge bg-success">
                                            Completed
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">No orders found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @script
    <script>
        let salesChart = null;

        function initSalesChart() {
            const trends = @json($trends);

            if (document.getElementById('salesTrendChart')) {
                const options = {
                    series: [{
                        name: 'Revenue',
                        data: trends.map(t => parseFloat(t.revenue))
                    }],
                    chart: {
                        type: 'area',
                        height: 350,
                        toolbar: {
                            show: true,
                            tools: {
                                download: true,
                                zoom: true,
                                zoomin: true,
                                zoomout: true,
                                pan: true,
                                reset: true
                            }
                        }
                    },
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        curve: 'smooth',
                        width: 3
                    },
                    xaxis: {
                        categories: trends.map(t => t.period),
                        labels: {
                            rotate: -45,
                            rotateAlways: false
                        }
                    },
                    yaxis: {
                        labels: {
                            formatter: function(val) {
                                return '$' + val.toFixed(2);
                            }
                        }
                    },
                    tooltip: {
                        y: {
                            formatter: function(val) {
                                return '$' + val.toFixed(2);
                            }
                        }
                    },
                    colors: ['#667eea'],
                    fill: {
                        type: 'gradient',
                        gradient: {
                            shadeIntensity: 1,
                            opacityFrom: 0.7,
                            opacityTo: 0.3,
                        }
                    },
                    grid: {
                        borderColor: '#e7e7e7',
                        row: {
                            colors: ['transparent', 'transparent'],
                            opacity: 0.5
                        }
                    }
                };

                const chart = new ApexCharts(document.querySelector("#salesTrendChart"), options);
                chart.render();
            }
        }
    </script>
    @endscript

    <style>
        .avatar {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 3rem;
            height: 3rem;
        }
        
        .avatar-sm {
            width: 2rem;
            height: 2rem;
        }
        
        .avatar-lg {
            width: 4rem;
            height: 4rem;
        }
        
        .bg-label-primary {
            background-color: rgba(102, 126, 234, 0.12) !important;
            color: #667eea !important;
        }
        
        .bg-label-success {
            background-color: rgba(40, 199, 111, 0.12) !important;
            color: #28c76f !important;
        }
        
        .bg-label-info {
            background-color: rgba(0, 207, 232, 0.12) !important;
            color: #00cfe8 !important;
        }
        
        .bg-label-secondary {
            background-color: rgba(130, 134, 139, 0.12) !important;
            color: #82868b !important;
        }
        
        .card {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        
        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1) !important;
        }
        
        /* Print Styles */
        @media print {
            .no-print {
                display: none !important;
            }
            
            .card {
                box-shadow: none !important;
                border: 1px solid #dee2e6 !important;
                page-break-inside: avoid;
                break-inside: avoid;
            }
            
            .card-header {
                background-color: #f8f9fa !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            
            .row {
                page-break-inside: avoid;
            }
            
            h1, h2, h3, h4, h5 {
                page-break-after: avoid;
            }
            
            table {
                page-break-inside: auto;
            }
            
            tr {
                page-break-inside: avoid;
                page-break-after: auto;
            }
            
            @page {
                size: A4;
                margin: 1.5cm;
            }
            
            body {
                font-size: 11pt;
            }
            
            #salesReportContent::before {
                content: "Sales Report - " attr(data-date);
                display: block;
                text-align: center;
                font-size: 18pt;
                font-weight: bold;
                margin-bottom: 20pt;
                padding-bottom: 10pt;
                border-bottom: 2px solid #000;
            }
        }
    </style>
    
    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('print-report', () => {
                const reportContent = document.getElementById('salesReportContent');
                if (reportContent) {
                    reportContent.setAttribute('data-date', 'Generated on ' + new Date().toLocaleDateString());
                }
                setTimeout(() => window.print(), 100);
            });
        });
    </script>
</div>
