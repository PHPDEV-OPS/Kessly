<div>
    <!-- Filters Card -->
    <div class="card mb-4 no-print">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label small text-muted mb-1">Filter By</label>
                    <select wire:model.live="filterBy" class="form-select">
                        <option value="all">All Products</option>
                        <option value="low_stock">Low Stock</option>
                        <option value="out_of_stock">Out of Stock</option>
                        <option value="in_stock">In Stock</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label small text-muted mb-1">Category</label>
                    <select wire:model.live="selectedCategory" class="form-select">
                        <option value="">All Categories</option>
                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = \App\Models\Category::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($category->id); ?>"><?php echo e($category->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label small text-muted mb-1">Sort By</label>
                    <select wire:model.live="sortBy" class="form-select">
                        <option value="name">Product Name</option>
                        <option value="stock">Stock Level</option>
                        <option value="price">Price</option>
                        <option value="updated_at">Last Updated</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label small text-muted mb-1">Order</label>
                    <select wire:model.live="sortDirection" class="form-select">
                        <option value="asc">Ascending</option>
                        <option value="desc">Descending</option>
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
        <p class="text-muted mt-2">Loading inventory data...</p>
    </div>

    <div wire:loading.remove.delay id="stockReportContent">
        <!-- Summary Cards -->
        <div class="row g-4 mb-4">
            <div class="col-md-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="avatar avatar-lg bg-label-primary rounded">
                                    <i class='bx bx-package fs-3'></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <small class="text-muted d-block">Total Products</small>
                                <h4 class="mb-0"><?php echo e(number_format($summary['total_products'])); ?></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="avatar avatar-lg bg-label-success rounded">
                                    <i class='bx bx-box fs-3'></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <small class="text-muted d-block">Total Stock</small>
                                <h4 class="mb-0"><?php echo e(number_format($summary['total_stock'])); ?></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="avatar avatar-lg bg-label-warning rounded">
                                    <i class='bx bx-error fs-3'></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <small class="text-muted d-block">Low Stock</small>
                                <h4 class="mb-0"><?php echo e(number_format($summary['low_stock'])); ?></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="avatar avatar-lg bg-label-danger rounded">
                                    <i class='bx bx-x-circle fs-3'></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <small class="text-muted d-block">Out of Stock</small>
                                <h4 class="mb-0"><?php echo e(number_format($summary['out_of_stock'])); ?></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stock Alerts -->
        <!--[if BLOCK]><![endif]--><?php if(count($alerts['danger']) > 0 || count($alerts['warning']) > 0): ?>
            <div class="card mb-4 border-0 shadow-sm overflow-hidden">
                <div class="card-header bg-gradient-danger text-white border-0">
                    <h5 class="mb-0 fw-bold">
                        <i class='bx bx-error-circle me-2'></i>Stock Alerts
                        <span class="badge bg-white text-danger ms-2">
                            <?php echo e(count($alerts['danger']) + count($alerts['warning'])); ?>

                        </span>
                    </h5>
                </div>
                <div class="card-body p-0">
                    <?php if(count($alerts['danger']) > 0): ?>
                        <div class="alert-section border-bottom">
                            <div class="d-flex align-items-start p-3 bg-danger bg-opacity-10">
                                <div class="flex-shrink-0">
                                    <div class="alert-icon bg-danger text-white rounded-circle d-flex align-items-center justify-content-center">
                                        <i class='bx bx-x-circle fs-4'></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="fw-bold text-danger mb-2">
                                        Critical: <?php echo e(count($alerts['danger'])); ?> Product(s) Out of Stock
                                    </h6>
                                    <div class="d-flex flex-wrap gap-2">
                                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $alerts['danger']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <span class="badge bg-danger"><?php echo e($product['name']); ?></span>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                    <!--[if BLOCK]><![endif]--><?php if(count($alerts['warning']) > 0): ?>
                        <div class="alert-section">
                            <div class="d-flex align-items-start p-3 bg-warning bg-opacity-10">
                                <div class="flex-shrink-0">
                                    <div class="alert-icon bg-warning text-white rounded-circle d-flex align-items-center justify-content-center">
                                        <i class='bx bx-error fs-4'></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="fw-bold text-warning mb-2">
                                        Warning: <?php echo e(count($alerts['warning'])); ?> Product(s) Low on Stock
                                    </h6>
                                    <div class="d-flex flex-wrap gap-2">
                                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $alerts['warning']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <span class="badge bg-warning">
                                                <?php echo e($product['name']); ?> 
                                                <span class="badge bg-white text-warning ms-1"><?php echo e($product['stock']); ?></span>
                                            </span>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </div>
            </div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

        <div class="row g-4 mb-4">
            <!-- Stock Movement Chart -->
            <div class="col-md-8">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="mb-0">Stock Movement (Last 30 Days)</h5>
                    </div>
                    <div class="card-body">
                        <div id="stockMovementChart"></div>
                    </div>
                </div>
            </div>

            <!-- Category Distribution -->
            <div class="col-md-4">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="mb-0">Stock by Category</h5>
                    </div>
                    <div class="card-body">
                        <div id="categoryStockChart"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Products Table -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Product Inventory</h5>
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
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Category</th>
                                <th class="text-end">Stock</th>
                                <th class="text-end">Price</th>
                                <th>Status</th>
                                <th>Last Updated</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!--[if BLOCK]><![endif]--><?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-sm bg-label-primary rounded me-2">
                                                <i class='bx bx-package'></i>
                                            </div>
                                            <span class="fw-medium"><?php echo e($product->name); ?></span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-label-info"><?php echo e($product->category?->name ?? 'Uncategorized'); ?></span>
                                    </td>
                                    <td class="text-end">
                                        <span class="fw-semibold"><?php echo e(number_format($product->stock)); ?></span>
                                    </td>
                                    <td class="text-end">
                                        $<?php echo e(number_format($product->price, 2)); ?>

                                    </td>
                                    <td>
                                        <!--[if BLOCK]><![endif]--><?php if($product->stock == 0): ?>
                                            <span class="badge bg-danger">Out of Stock</span>
                                        <?php elseif($product->stock < 10): ?>
                                            <span class="badge bg-warning">Low Stock</span>
                                        <?php else: ?>
                                            <span class="badge bg-success">In Stock</span>
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    </td>
                                    <td><?php echo e($product->updated_at->diffForHumans()); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="6" class="text-center text-muted">No products found</td>
                                </tr>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

        <?php
        $__scriptKey = '1557451793-0';
        ob_start();
    ?>
    <script>
        let movementChart = null;
        let categoryChart = null;

        function initStockCharts() {
            const movement = <?php echo json_encode($stockMovement, 15, 512) ?>;
            const categoryStock = <?php echo json_encode($categories, 15, 512) ?>;
            
            // Stock Movement Chart
            if (document.getElementById('stockMovementChart')) {
                const movementOptions = {
                    series: [{
                        name: 'Stock Level',
                        data: movement.map(m => parseInt(m.stock))
                    }],
                    chart: {
                        type: 'line',
                        height: 300,
                        toolbar: {
                            show: true
                        }
                    },
                    stroke: {
                        curve: 'smooth',
                        width: 3
                    },
                    xaxis: {
                        categories: movement.map(m => m.date),
                        labels: {
                            rotate: -45
                        }
                    },
                    yaxis: {
                        title: {
                            text: 'Total Stock'
                        }
                    },
                    colors: ['#28c76f'],
                    markers: {
                        size: 5,
                        colors: ['#28c76f'],
                        strokeColors: '#fff',
                        strokeWidth: 2,
                        hover: {
                            size: 7
                        }
                    },
                    grid: {
                        borderColor: '#e7e7e7'
                    }
                };

                const movementChart = new ApexCharts(document.querySelector("#stockMovementChart"), movementOptions);
                movementChart.render();
            }

            // Category Stock Chart
            if (document.getElementById('categoryStockChart')) {
                const categoryOptions = {
                    series: categoryStock.map(c => parseInt(c.total_stock)),
                    chart: {
                        type: 'donut',
                        height: 300
                    },
                    labels: categoryStock.map(c => c.category_name),
                    colors: ['#667eea', '#28c76f', '#00cfe8', '#ff9f43', '#ea5455'],
                    legend: {
                        position: 'bottom'
                    },
                    plotOptions: {
                        pie: {
                            donut: {
                                size: '70%',
                                labels: {
                                    show: true,
                                    total: {
                                        show: true,
                                        label: 'Total Stock',
                                        formatter: function (w) {
                                            return w.globals.seriesTotals.reduce((a, b) => a + b, 0)
                                        }
                                    }
                                }
                            }
                        }
                    }
                };

                const categoryChart = new ApexCharts(document.querySelector("#categoryStockChart"), categoryOptions);
                categoryChart.render();
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            initStockCharts();
        });

        document.addEventListener('livewire:navigated', function() {
            initStockCharts();
        });
    </script>
        <?php
        $__output = ob_get_clean();

        \Livewire\store($this)->push('scripts', $__output, $__scriptKey)
    ?>

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
        
        .bg-label-warning {
            background-color: rgba(255, 159, 67, 0.12) !important;
            color: #ff9f43 !important;
        }
        
        .bg-label-danger {
            background-color: rgba(234, 84, 85, 0.12) !important;
            color: #ea5455 !important;
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
        
        /* Alert Styling */
        .bg-gradient-danger {
            background: linear-gradient(135deg, #ea5455 0%, #d63031 100%);
        }
        
        .alert-icon {
            width: 48px;
            height: 48px;
            min-width: 48px;
        }
        
        .alert-section:last-child {
            border-bottom: none !important;
        }
        
        .badge {
            font-weight: 500;
            padding: 0.5rem 0.75rem;
            font-size: 0.875rem;
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
            
            .bg-gradient-danger {
                background: #dc3545 !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            
            .badge {
                border: 1px solid #000;
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
            
            #stockReportContent::before {
                content: "Inventory Report - " attr(data-date);
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
                const reportContent = document.getElementById('stockReportContent');
                if (reportContent) {
                    reportContent.setAttribute('data-date', 'Generated on ' + new Date().toLocaleDateString());
                }
                setTimeout(() => window.print(), 100);
            });
        });
    </script>
</div>
<?php /**PATH D:\School-Projects\Software-dev\Kessly\resources\views/livewire/reports/stock-report.blade.php ENDPATH**/ ?>