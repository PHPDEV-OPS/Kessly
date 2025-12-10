<div>
    <!-- Action Buttons -->
    <div class="d-flex flex-column flex-sm-row justify-content-end gap-2 mb-4">
        <button 
            wire:click="refreshAnalytics"
            class="btn btn-sm btn-label-secondary"
            title="Refresh dashboard data"
        >
            <i class="ri-refresh-line me-1"></i>
            <span class="d-none d-sm-inline">Refresh</span>
        </button>
        <a 
            href="{{ route('inventory') }}" 
            wire:navigate
            class="btn btn-sm btn-primary"
        >
            <i class="ri-stack-line me-1"></i>
            <span class="d-none d-sm-inline">Manage </span>Inventory
        </a>
    </div>

    <!-- KPI Cards -->
    <div class="row g-4 mb-4">
        <!-- Total Products Card -->
        <div class="col-sm-6 col-lg-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="avatar avatar-md">
                            <div class="avatar-initial bg-label-primary rounded">
                                <i class="ri-stack-line ri-24px"></i>
                            </div>
                        </div>
                        <span class="badge bg-label-primary">Total</span>
                    </div>
                    <h5 class="mb-1">{{ number_format($analytics['total_products']) }}</h5>
                    <p class="mb-2 text-muted">Products</p>
                    @if($analytics['out_of_stock_count'] > 0)
                        <small class="text-warning">{{ $analytics['out_of_stock_count'] }} out of stock</small>
                    @else
                        <small class="text-success">All in stock</small>
                    @endif
                </div>
            </div>
        </div>

        <!-- Revenue Card -->
        <div class="col-sm-6 col-lg-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="avatar avatar-md">
                            <div class="avatar-initial bg-label-success rounded">
                                <i class="ri-money-dollar-circle-line ri-24px"></i>
                            </div>
                        </div>
                        <span class="badge bg-label-success">30 Days</span>
                    </div>
                    <h5 class="mb-1">${{ number_format($analytics['revenue_30_days'], 0) }}</h5>
                    <p class="mb-2 text-muted">Revenue</p>
                    <small class="text-success">Today: ${{ number_format($analytics['revenue_today'], 2) }}</small>
                </div>
            </div>
        </div>

        <!-- Orders Card -->
        <div class="col-sm-6 col-lg-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="avatar avatar-md">
                            <div class="avatar-initial bg-label-info rounded">
                                <i class="ri-shopping-cart-line ri-24px"></i>
                            </div>
                        </div>
                        <span class="badge bg-label-info">Total</span>
                    </div>
                    <h5 class="mb-1">{{ number_format($analytics['total_orders']) }}</h5>
                    <p class="mb-2 text-muted">Orders</p>
                    <small class="text-info">Today: {{ $analytics['orders_today'] }} orders</small>
                </div>
            </div>
        </div>

        <!-- Stock Alert Card -->
        <div class="col-sm-6 col-lg-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="avatar avatar-md">
                            <div class="avatar-initial bg-label-warning rounded">
                                <i class="ri-alert-line ri-24px"></i>
                            </div>
                        </div>
                        @if($analytics['low_stock_count'] > 0)
                            <span class="badge bg-label-danger">Alert</span>
                        @else
                            <span class="badge bg-label-success">Good</span>
                        @endif
                    </div>
                    <h5 class="mb-1">{{ $analytics['low_stock_count'] }}</h5>
                    <p class="mb-2 text-muted">Low Stock</p>
                    <small class="text-warning">{{ $analytics['out_of_stock_count'] }} out of stock</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Secondary Metrics -->
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar avatar-lg me-3">
                            <div class="avatar-initial bg-label-primary rounded">
                                <i class="ri-user-line ri-26px"></i>
                            </div>
                        </div>
                        <div>
                            <p class="mb-0 text-muted">Total Customers</p>
                            <h4 class="mb-0">{{ number_format($analytics['total_customers']) }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar avatar-lg me-3">
                            <div class="avatar-initial bg-label-success rounded">
                                <i class="ri-folder-line ri-26px"></i>
                            </div>
                        </div>
                        <div>
                            <p class="mb-0 text-muted">Categories</p>
                            <h4 class="mb-0">{{ number_format($analytics['total_categories']) }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar avatar-lg me-3">
                            <div class="avatar-initial bg-label-info rounded">
                                <i class="ri-building-line ri-26px"></i>
                            </div>
                        </div>
                        <div>
                            <p class="mb-0 text-muted">Suppliers</p>
                            <h4 class="mb-0">{{ number_format($analytics['total_suppliers']) }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts and Activity -->
    <div class="row g-4 mb-4">
        <!-- Revenue Overview Chart -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <div>
                        <h5 class="card-title mb-1">Revenue Overview</h5>
                        <p class="card-subtitle mb-0 text-muted">Monthly revenue trend</p>
                    </div>
                    <div class="dropdown">
                        <button class="btn btn-text-secondary rounded-pill text-muted border-0 p-2 me-n1" type="button" id="revenueChartDropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="ri-more-2-line ri-20px"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="revenueChartDropdown">
                            <a class="dropdown-item" href="javascript:void(0);">Last 6 Months</a>
                            <a class="dropdown-item" href="javascript:void(0);">Last Year</a>
                            <a class="dropdown-item" href="javascript:void(0);">All Time</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if($analytics['monthly_revenue_trend']->count() > 0)
                        <!-- ApexCharts Container -->
                        <div id="revenueChart" style="min-height: 280px;"></div>
                        
                        <!-- Revenue Summary Cards -->
                        <div class="row g-3 mt-3">
                            <div class="col-md-4">
                                <div class="d-flex align-items-center">
                                    <div class="avatar flex-shrink-0 me-3">
                                        <span class="avatar-initial rounded bg-label-success">
                                            <i class="ri-money-dollar-circle-line ri-24px"></i>
                                        </span>
                                    </div>
                                    <div>
                                        <p class="mb-0 text-muted small">Today</p>
                                        <h5 class="mb-0">${{ number_format($analytics['revenue_today'], 0) }}</h5>
                                        <small class="text-success">
                                            <i class="ri-arrow-up-line"></i> Active
                                            <span class="badge rounded-pill bg-label-success ms-1 pulse-badge">Live</span>
                                        </small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="d-flex align-items-center">
                                    <div class="avatar flex-shrink-0 me-3">
                                        <span class="avatar-initial rounded bg-label-primary">
                                            <i class="ri-calendar-line ri-24px"></i>
                                        </span>
                                    </div>
                                    <div>
                                        <p class="mb-0 text-muted small">7 Days</p>
                                        <h5 class="mb-0">${{ number_format($analytics['revenue_7_days'], 0) }}</h5>
                                        <small class="text-primary"><i class="ri-arrow-up-line"></i> Trending</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="d-flex align-items-center">
                                    <div class="avatar flex-shrink-0 me-3">
                                        <span class="avatar-initial rounded bg-label-info">
                                            <i class="ri-calendar-2-line ri-24px"></i>
                                        </span>
                                    </div>
                                    <div>
                                        <p class="mb-0 text-muted small">30 Days</p>
                                        <h5 class="mb-0">${{ number_format($analytics['revenue_30_days'], 0) }}</h5>
                                        <small class="text-info"><i class="ri-line-chart-line"></i> Growing</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <script>
                            let revenueChart = null;

                            function initRevenueChart() {
                                const revenueData = @json($analytics['monthly_revenue_trend']->pluck('total')->toArray());
                                const revenueMonths = @json($analytics['monthly_revenue_trend']->map(function($item) {
                                    return \Carbon\Carbon::parse($item->month)->format('M Y');
                                })->toArray());

                                const revenueChartEl = document.querySelector('#revenueChart');

                                if (revenueChartEl && typeof ApexCharts !== 'undefined') {
                                    // Destroy existing chart if it exists
                                    if (revenueChart) {
                                        revenueChart.destroy();
                                    }

                                    const revenueChartConfig = {
                                        chart: {
                                            type: 'area',
                                            height: 280,
                                            parentHeightOffset: 0,
                                            toolbar: {
                                                show: false
                                            },
                                            sparkline: {
                                                enabled: false
                                            },
                                            animations: {
                                                enabled: true,
                                                easing: 'easeinout',
                                                speed: 800,
                                                animateGradually: {
                                                    enabled: true,
                                                    delay: 150
                                                },
                                                dynamicAnimation: {
                                                    enabled: true,
                                                    speed: 350
                                                }
                                            }
                                        },
                                        series: [{
                                            name: 'Revenue',
                                            data: revenueData
                                        }],
                                        colors: ['#7367F0'],
                                        fill: {
                                            type: 'gradient',
                                            gradient: {
                                                shade: 'light',
                                                type: 'vertical',
                                                shadeIntensity: 0.4,
                                                gradientToColors: ['#9055FD'],
                                                inverseColors: false,
                                                opacityFrom: 0.7,
                                                opacityTo: 0.2,
                                                stops: [0, 90, 100]
                                            }
                                        },
                                        stroke: {
                                            curve: 'smooth',
                                            width: 3
                                        },
                                        dataLabels: {
                                            enabled: false
                                        },
                                        series: [{
                                            name: 'Revenue',
                                            data: revenueData
                                        }],
                                        colors: ['#7367F0'],
                                        xaxis: {
                                            categories: revenueMonths,
                                            axisBorder: {
                                                show: false
                                            },
                                            axisTicks: {
                                                show: false
                                            },
                                            labels: {
                                                style: {
                                                    fontSize: '12px',
                                                    colors: '#a1acb8'
                                                }
                                            }
                                        },
                                        yaxis: {
                                            labels: {
                                                formatter: function (val) {
                                                    return "$" + val.toLocaleString();
                                                },
                                                style: {
                                                    fontSize: '12px',
                                                    colors: '#a1acb8'
                                                }
                                            }
                                        },
                                        grid: {
                                            show: true,
                                            borderColor: '#f1f1f1',
                                            strokeDashArray: 4,
                                            padding: {
                                                top: 0,
                                                right: 10,
                                                bottom: 0,
                                                left: 10
                                            }
                                        },
                                        tooltip: {
                                            enabled: true,
                                            shared: true,
                                            followCursor: true,
                                            intersect: false,
                                            theme: 'light',
                                            style: {
                                                fontSize: '12px'
                                            },
                                            y: {
                                                formatter: function (val) {
                                                    return "$" + val.toLocaleString();
                                                }
                                            },
                                            marker: {
                                                show: true
                                            }
                                        },
                                        markers: {
                                            size: 6,
                                            colors: ['#fff'],
                                            strokeColors: ['#7367F0'],
                                            strokeWidth: 3,
                                            hover: {
                                                size: 8
                                            }
                                        }
                                    };

                                    revenueChart = new ApexCharts(revenueChartEl, revenueChartConfig);
                                    revenueChart.render();
                                }
                            }

                            // Initialize chart on page load and Livewire navigation
                            function initializeCharts() {
                                if (typeof ApexCharts !== 'undefined') {
                                    initRevenueChart();
                                } else {
                                    // Retry after a short delay if ApexCharts is not loaded yet
                                    setTimeout(initializeCharts, 100);
                                }
                            }

                            document.addEventListener('DOMContentLoaded', initializeCharts);
                            document.addEventListener('livewire:navigated', initializeCharts);
                        </script>
                    @else
                        <div class="text-center py-5">
                            <div class="avatar avatar-xl mx-auto mb-3">
                                <span class="avatar-initial rounded bg-label-secondary">
                                    <i class="ri-bar-chart-box-line ri-36px"></i>
                                </span>
                            </div>
                            <h6 class="mb-1">No revenue data available</h6>
                            <p class="text-muted small mb-0">Start making sales to see revenue trends</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Top Selling Products -->
        <div class="col-lg-4">
            <div class="card h-100">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <div>
                        <h5 class="card-title mb-1">Top Products</h5>
                        <p class="card-subtitle mb-0 text-muted">Best sellers this month</p>
                    </div>
                    <div class="avatar avatar-sm">
                        <span class="avatar-initial rounded bg-label-warning">
                            <i class="ri-trophy-line ri-20px"></i>
                        </span>
                    </div>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        @forelse($analytics['top_selling_products'] as $index => $product)
                            @php
                                $maxRevenue = $analytics['top_selling_products']->max(function($p) {
                                    return ($p->price ?? 0) * ($p->total_sold ?? 0);
                                });
                                $productRevenue = ($product->price ?? 0) * ($product->total_sold ?? 0);
                                $percentage = $maxRevenue > 0 ? ($productRevenue / $maxRevenue) * 100 : 0;
                            @endphp
                            <li class="mb-3 pb-3 {{ !$loop->last ? 'border-bottom' : '' }} product-item">
                                <div class="d-flex align-items-center mb-2">
                                    <div class="avatar avatar-sm me-3">
                                        @if($index == 0)
                                            <span class="avatar-initial rounded bg-label-warning">
                                                <i class="ri-medal-line ri-20px"></i>
                                            </span>
                                        @elseif($index == 1)
                                            <span class="avatar-initial rounded bg-label-info">
                                                <i class="ri-award-line ri-20px"></i>
                                            </span>
                                        @elseif($index == 2)
                                            <span class="avatar-initial rounded bg-label-secondary">
                                                <i class="ri-star-line ri-20px"></i>
                                            </span>
                                        @else
                                            <span class="avatar-initial rounded bg-label-primary">
                                                {{ $index + 1 }}
                                            </span>
                                        @endif
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-0">{{ Str::limit($product->name ?? 'Unknown Product', 25) }}</h6>
                                        <small class="text-muted">
                                            <i class="ri-shopping-cart-line me-1"></i>{{ $product->total_sold ?? 0 }} sold
                                        </small>
                                    </div>
                                    <div class="text-end">
                                        <h6 class="mb-0">${{ number_format($product->price ?? 0, 2) }}</h6>
                                        @if($product->total_sold ?? 0 > 0)
                                            <small class="text-success">
                                                <i class="ri-arrow-up-line"></i>
                                                ${{ number_format($productRevenue, 0) }}
                                            </small>
                                        @endif
                                    </div>
                                </div>
                                <!-- Animated progress bar -->
                                <div class="progress" style="height: 4px;">
                                    <div class="progress-bar 
                                        @if($index == 0) bg-warning
                                        @elseif($index == 1) bg-info
                                        @elseif($index == 2) bg-secondary
                                        @else bg-primary
                                        @endif" 
                                        role="progressbar" 
                                        style="width: {{ $percentage }}%; transition: width 1s ease-in-out;" 
                                        aria-valuenow="{{ $percentage }}" 
                                        aria-valuemin="0" 
                                        aria-valuemax="100">
                                    </div>
                                </div>
                            </li>
                        @empty
                            <li class="text-center py-5">
                                <div class="avatar avatar-xl mx-auto mb-3">
                                    <span class="avatar-initial rounded bg-label-secondary">
                                        <i class="ri-shopping-bag-line ri-36px"></i>
                                    </span>
                                </div>
                                <h6 class="mb-1">No sales data available</h6>
                                <p class="text-muted small mb-0">Products will appear here once sales are recorded</p>
                            </li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="row g-4 mb-4">
        <!-- Recent Orders -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <div>
                        <h5 class="card-title mb-1">Recent Orders</h5>
                        <p class="card-subtitle mb-0 text-muted">Latest transactions</p>
                    </div>
                    <a href="{{ route('sales') }}" wire:navigate class="btn btn-sm btn-label-primary">
                        <i class="ri-arrow-right-line"></i>
                    </a>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        @forelse ($analytics['recent_orders'] as $order)
                            <li class="mb-3 pb-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                                <div class="d-flex align-items-start">
                                    <div class="avatar avatar-sm flex-shrink-0 me-3">
                                        <div class="avatar-initial bg-label-primary rounded">
                                            <i class="ri-receipt-line ri-20px"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="d-flex align-items-center justify-content-between mb-1">
                                            <h6 class="mb-0">{{ $order->order_number }}</h6>
                                            <span class="badge bg-label-success">${{ number_format($order->total_amount, 2) }}</span>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <small class="text-muted me-2">
                                                <i class="ri-user-line me-1"></i>{{ Str::limit($order->customer?->name ?? 'Guest', 20) }}
                                            </small>
                                            <small class="text-muted">
                                                <i class="ri-time-line me-1"></i>{{ $order->order_date?->diffForHumans() }}
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @empty
                            <li class="text-center py-5">
                                <div class="avatar avatar-xl mx-auto mb-3">
                                    <span class="avatar-initial rounded bg-label-secondary">
                                        <i class="ri-shopping-cart-line ri-36px"></i>
                                    </span>
                                </div>
                                <h6 class="mb-1">No orders yet</h6>
                                <p class="text-muted small mb-0">Orders will appear here once you start selling</p>
                            </li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>

        <!-- Recent Invoices -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <div>
                        <h5 class="card-title mb-1">Recent Invoices</h5>
                        <p class="card-subtitle mb-0 text-muted">Latest billing documents</p>
                    </div>
                    <a href="{{ route('sales') }}" wire:navigate class="btn btn-sm btn-label-primary">
                        <i class="ri-arrow-right-line"></i>
                    </a>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        @forelse ($analytics['recent_invoices'] as $invoice)
                            <li class="mb-3 pb-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                                <div class="d-flex align-items-start">
                                    <div class="avatar avatar-sm flex-shrink-0 me-3">
                                        <div class="avatar-initial bg-label-success rounded">
                                            <i class="ri-file-text-line ri-20px"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="d-flex align-items-center justify-content-between mb-1">
                                            <h6 class="mb-0">{{ $invoice->name }}</h6>
                                            <span class="badge bg-label-primary">${{ number_format($invoice->amount, 2) }}</span>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <small class="text-muted me-2">
                                                <i class="ri-user-line me-1"></i>{{ Str::limit($invoice->customer?->name ?? 'No customer', 20) }}
                                            </small>
                                            <small class="text-muted">
                                                <i class="ri-time-line me-1"></i>{{ $invoice->created_at?->diffForHumans() }}
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @empty
                            <li class="text-center py-5">
                                <div class="avatar avatar-xl mx-auto mb-3">
                                    <span class="avatar-initial rounded bg-label-secondary">
                                        <i class="ri-file-text-line ri-36px"></i>
                                    </span>
                                </div>
                                <h6 class="mb-1">No invoices yet</h6>
                                <p class="text-muted small mb-0">Invoices will appear here once you create them</p>
                            </li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Inventory Alert -->
    @if($analytics['low_stock_count'] > 0)
        <div class="card border-warning">
            <div class="card-header bg-label-warning">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <div class="avatar avatar-md me-3">
                            <span class="avatar-initial rounded bg-warning">
                                <i class="ri-error-warning-line ri-24px text-white"></i>
                            </span>
                        </div>
                        <div>
                            <h5 class="mb-0">Inventory Alert</h5>
                            <p class="mb-0 text-muted small">
                                <i class="ri-box-3-line me-1"></i>{{ $analytics['low_stock_count'] }} product{{ $analytics['low_stock_count'] > 1 ? 's' : '' }} need{{ $analytics['low_stock_count'] == 1 ? 's' : '' }} restocking
                            </p>
                        </div>
                    </div>
                    <a href="{{ route('inventory') }}" wire:navigate class="btn btn-sm btn-warning">
                        <i class="ri-stack-line me-1"></i>
                        Manage Inventory
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    @foreach ($analytics['low_stock_products'] as $product)
                        <div class="col-md-6">
                            <div class="d-flex align-items-center p-3 border rounded hover-shadow-sm">
                                <div class="avatar avatar-md me-3 flex-shrink-0">
                                    @if($product->stock === 0)
                                        <span class="avatar-initial rounded bg-danger">
                                            <i class="ri-close-circle-line ri-24px text-white"></i>
                                        </span>
                                    @elseif($product->stock <= 2)
                                        <span class="avatar-initial rounded bg-warning">
                                            <i class="ri-error-warning-line ri-24px text-white"></i>
                                        </span>
                                    @else
                                        <span class="avatar-initial rounded bg-info">
                                            <i class="ri-information-line ri-24px text-white"></i>
                                        </span>
                                    @endif
                                </div>
                                <div class="flex-grow-1 me-2">
                                    <h6 class="mb-1">{{ Str::limit($product->name, 30) }}</h6>
                                    <div class="d-flex align-items-center">
                                        <small class="text-muted me-2">
                                            <i class="ri-price-tag-3-line me-1"></i>{{ $product->category?->name ?? 'No category' }}
                                        </small>
                                    </div>
                                </div>
                                <div class="text-end flex-shrink-0">
                                    @if($product->stock === 0)
                                        <span class="badge bg-danger mb-1">OUT OF STOCK</span>
                                        <div><small class="text-danger fw-bold">{{ $product->stock }} units</small></div>
                                    @elseif($product->stock <= 2)
                                        <span class="badge bg-warning mb-1">CRITICAL</span>
                                        <div><small class="text-warning fw-bold">{{ $product->stock }} unit{{ $product->stock > 1 ? 's' : '' }}</small></div>
                                    @else
                                        <span class="badge bg-info mb-1">LOW STOCK</span>
                                        <div><small class="text-info fw-bold">{{ $product->stock }} units</small></div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @else
        <div class="card border-success">
            <div class="card-body text-center py-5">
                <div class="avatar avatar-xl mx-auto mb-4">
                    <span class="avatar-initial rounded bg-label-success">
                        <i class="ri-checkbox-circle-line ri-48px"></i>
                    </span>
                </div>
                <h4 class="mb-2">
                    <i class="ri-check-line text-success"></i>
                    Inventory Healthy
                </h4>
                <p class="text-muted mb-0">All your products are sufficiently stocked. Great job maintaining your inventory!</p>
            </div>
        </div>
    @endif
</div>

@push('styles')
<style>
    .hover-shadow-sm {
        transition: all 0.2s ease-in-out;
    }
    .hover-shadow-sm:hover {
        box-shadow: 0 0.125rem 0.5rem rgba(0, 0, 0, 0.08);
        transform: translateY(-2px);
    }
    
    /* Pulse animation for live badge */
    @keyframes pulse {
        0%, 100% {
            opacity: 1;
            transform: scale(1);
        }
        50% {
            opacity: 0.7;
            transform: scale(0.95);
        }
    }
    
    /* Slide in animation for cards */
    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    /* Product item hover effect */
    .product-item {
        transition: all 0.3s ease;
        padding: 8px;
        margin: 0 -8px;
        border-radius: 8px;
    }
    
    .product-item:hover {
        background: rgba(115, 103, 240, 0.05);
        transform: translateX(5px);
    }
    
    /* Progress bar animation */
    .progress-bar {
        transition: width 1s ease-in-out;
    }
    
    /* Card animations */
    .card {
        animation: slideIn 0.5s ease-out;
    }
    
    .card:hover {
        box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.1);
        transition: box-shadow 0.3s ease;
    }
    
    /* Inventory alert hover */
    .inventory-alert-item {
        transition: transform 0.2s ease;
    }
    
    .inventory-alert-item:hover {
        transform: translateX(5px);
    }
    
    /* Live badge pulse */
    .pulse-badge {
        animation: pulse 2s infinite;
    }
</style>
@endpush
