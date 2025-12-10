<div>
    <!-- Optimized Loading Indicator with Delay -->
    <div wire:loading.delay.longer class="position-fixed top-50 start-50 translate-middle" style="z-index: 9999;">
        <div class="text-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="mt-2 text-primary fw-semibold">Loading analytics...</p>
        </div>
    </div>
    
    <!-- Progress Bar Loading Indicator -->
    <div wire:loading.delay class="position-fixed top-0 start-0 w-100" style="z-index: 9998;">
        <div class="progress" style="height: 3px; border-radius: 0;">
            <div class="progress-bar progress-bar-striped progress-bar-animated bg-primary w-100"></div>
        </div>
    </div>

    <!-- Enhanced Controls Bar -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row g-3 align-items-end">
                <!-- Date Range -->
                <div class="col-6 col-md-3 col-lg-2">
                    <label class="form-label fw-semibold small">
                        <i class='bx bx-calendar me-1'></i><span class="d-none d-lg-inline">Date Range</span><span class="d-inline d-lg-none">Date</span>
                    </label>
                    <select wire:model.live="dateRange" class="form-select form-select-sm" wire:loading.attr="disabled">
                        <option value="today">Today</option>
                        <option value="yesterday">Yesterday</option>
                        <option value="last_7_days">Last 7 Days</option>
                        <option value="last_30_days">Last 30 Days</option>
                        <option value="last_90_days">Last 90 Days</option>
                        <option value="this_month">This Month</option>
                        <option value="last_month">Last Month</option>
                        <option value="this_year">This Year</option>
                    </select>
                </div>
                
                <!-- Branch Filter -->
                <div class="col-6 col-md-3 col-lg-2">
                    <label class="form-label fw-semibold small">
                        <i class='bx bx-buildings me-1'></i><span class="d-none d-lg-inline">Branch</span>
                    </label>
                    <select wire:model.live="selectedBranch" class="form-select form-select-sm" wire:loading.attr="disabled">
                        <option value="">All</option>
                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = \App\Models\Branch::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($branch->id); ?>"><?php echo e($branch->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                    </select>
                </div>
                
                <!-- View Mode Toggle -->
                <div class="col-6 col-md-3 col-lg-2">
                    <label class="form-label fw-semibold small d-block"><span class="d-none d-md-inline">View Mode</span><span class="d-inline d-md-none">View</span></label>
                    <div class="btn-group w-100" role="group">
                        <button type="button" wire:click="toggleViewMode" 
                                class="btn btn-sm <?php echo e($viewMode === 'grid' ? 'btn-primary' : 'btn-outline-primary'); ?>">
                            <i class='bx bx-grid-alt'></i>
                        </button>
                        <button type="button" wire:click="toggleViewMode" 
                                class="btn btn-sm <?php echo e($viewMode === 'list' ? 'btn-primary' : 'btn-outline-primary'); ?>">
                            <i class='bx bx-list-ul'></i>
                        </button>
                    </div>
                </div>
                
                <!-- Comparison Mode -->
                <div class="col-6 col-md-3 col-lg-2">
                    <div class="form-check form-switch mt-2">
                        <input class="form-check-input" type="checkbox" wire:model.live="comparisonMode" id="comparisonToggle">
                        <label class="form-check-label fw-semibold small" for="comparisonToggle">
                            <span class="d-none d-lg-inline">Compare Periods</span>
                            <span class="d-inline d-lg-none">Compare</span>
                        </label>
                    </div>
                </div>
                
                <!-- Refresh Button -->
                <div class="col-6 col-md-3 col-lg-2">
                    <button type="button" wire:click="clearCache" class="btn btn-outline-primary btn-sm w-100" title="Force refresh data">
                        <i class='bx bx-refresh'></i><span class="d-none d-xl-inline ms-1">Refresh</span>
                    </button>
                </div>
                
                <!-- Export Options -->
                <div class="col-6 col-md-3 col-lg-2">
                    <div class="dropdown">
                        <button class="btn btn-label-secondary btn-sm dropdown-toggle w-100" type="button" data-bs-toggle="dropdown">
                            <i class='bx bx-download me-1'></i><span class="d-none d-md-inline">Export</span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#" onclick="event.preventDefault(); alert('CSV export will be available soon');">
                                <i class='bx bx-file me-2'></i>Export as CSV
                            </a></li>
                            <li><a class="dropdown-item" href="#" onclick="event.preventDefault(); alert('PDF export will be available soon');">
                                <i class='bx bx-file-blank me-2'></i>Export as PDF
                            </a></li>
                            <li><a class="dropdown-item" href="#" onclick="event.preventDefault(); window.print();">
                                <i class='bx bx-printer me-2'></i>Print Report
                            </a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Insights Banner -->
    <!--[if BLOCK]><![endif]--><?php if(isset($insights) && count($insights) > 0): ?>
    <div class="row mb-4">
        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $insights; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $insight): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="col-md-4 mb-3">
            <div class="alert alert-<?php echo e($insight['type'] === 'positive' ? 'success' : ($insight['type'] === 'negative' ? 'danger' : ($insight['type'] === 'warning' ? 'warning' : 'info'))); ?> d-flex align-items-center mb-0" role="alert">
                <i class='bx bx-<?php echo e($insight['icon']); ?> fs-4 me-2'></i>
                <div>
                    <strong><?php echo e($insight['title']); ?>:</strong> <?php echo e($insight['message']); ?>

                </div>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
    </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->


    <!-- Key Business Metrics with Enhanced Cards -->
    <div class="row g-4 mb-4">
        <!-- Total Revenue Card -->
        <div class="col-xl-3 col-sm-6">
            <div class="card card-border-shadow-primary h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        <div class="avatar me-3">
                            <span class="avatar-initial rounded bg-label-primary">
                                <i class='bx bx-dollar fs-4'></i>
                            </span>
                        </div>
                        <h6 class="mb-0">Total Revenue</h6>
                    </div>
                    <div class="d-flex align-items-center">
                        <h3 class="mb-0 me-2">$<?php echo e(number_format($metrics['total_revenue'] ?? 0, 2)); ?></h3>
                        <!--[if BLOCK]><![endif]--><?php if($comparisonMode && $comparisonMetrics): ?>
                            <?php
                                $diff = ($metrics['total_revenue'] ?? 0) - ($comparisonMetrics['total_revenue'] ?? 0);
                                $percentChange = $comparisonMetrics['total_revenue'] > 0 ? ($diff / $comparisonMetrics['total_revenue']) * 100 : 0;
                            ?>
                            <small class="text-<?php echo e($percentChange >= 0 ? 'success' : 'danger'); ?>">
                                <i class='bx bx-<?php echo e($percentChange >= 0 ? 'up' : 'down'); ?>-arrow-alt'></i>
                                <?php echo e(number_format(abs($percentChange), 1)); ?>%
                            </small>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                    <small class="text-muted">vs previous period</small>
                </div>
            </div>
        </div>

        <!-- Total Orders Card -->
        <div class="col-xl-3 col-sm-6">
            <div class="card card-border-shadow-success h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        <div class="avatar me-3">
                            <span class="avatar-initial rounded bg-label-success">
                                <i class='bx bx-cart fs-4'></i>
                            </span>
                        </div>
                        <h6 class="mb-0">Total Orders</h6>
                    </div>
                    <div class="d-flex align-items-center">
                        <h3 class="mb-0 me-2"><?php echo e(number_format($metrics['total_orders'] ?? 0)); ?></h3>
                        <!--[if BLOCK]><![endif]--><?php if($comparisonMode && $comparisonMetrics): ?>
                            <?php
                                $diff = ($metrics['total_orders'] ?? 0) - ($comparisonMetrics['total_orders'] ?? 0);
                                $percentChange = $comparisonMetrics['total_orders'] > 0 ? ($diff / $comparisonMetrics['total_orders']) * 100 : 0;
                            ?>
                            <small class="text-<?php echo e($percentChange >= 0 ? 'success' : 'danger'); ?>">
                                <i class='bx bx-<?php echo e($percentChange >= 0 ? 'up' : 'down'); ?>-arrow-alt'></i>
                                <?php echo e(number_format(abs($percentChange), 1)); ?>%
                            </small>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                    <small class="text-muted">Order count</small>
                </div>
            </div>
        </div>

        <!-- Average Order Value Card -->
        <div class="col-xl-3 col-sm-6">
            <div class="card card-border-shadow-warning h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        <div class="avatar me-3">
                            <span class="avatar-initial rounded bg-label-warning">
                                <i class='bx bx-trending-up fs-4'></i>
                            </span>
                        </div>
                        <h6 class="mb-0">Avg Order Value</h6>
                    </div>
                    <div class="d-flex align-items-center">
                        <h3 class="mb-0">$<?php echo e(number_format($metrics['average_order_value'] ?? 0, 2)); ?></h3>
                    </div>
                    <small class="text-muted">Per transaction</small>
                </div>
            </div>
        </div>

        <!-- Total Customers Card -->
        <div class="col-xl-3 col-sm-6">
            <div class="card card-border-shadow-info h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        <div class="avatar me-3">
                            <span class="avatar-initial rounded bg-label-info">
                                <i class='bx bx-user fs-4'></i>
                            </span>
                        </div>
                        <h6 class="mb-0">Total Customers</h6>
                    </div>
                    <div class="d-flex align-items-center">
                        <h3 class="mb-0"><?php echo e(number_format($metrics['total_customers'] ?? 0)); ?></h3>
                    </div>
                    <small class="text-muted">Customer base</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Secondary Metrics -->
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <p class="mb-1">Products Sold</p>
                            <h4 class="mb-0"><?php echo e(number_format($metrics['total_products_sold'] ?? 0)); ?></h4>
                        </div>
                        <div class="avatar">
                            <span class="avatar-initial rounded bg-label-primary">
                                <i class='bx bx-package fs-4'></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <p class="mb-1">Inventory Value</p>
                            <h4 class="mb-0">$<?php echo e(number_format($metrics['inventory_value'] ?? 0, 2)); ?></h4>
                        </div>
                        <div class="avatar">
                            <span class="avatar-initial rounded bg-label-success">
                                <i class='bx bx-cube fs-4'></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <p class="mb-1">Low Stock Items</p>
                            <h4 class="mb-0 text-warning"><?php echo e(number_format($metrics['low_stock_items'] ?? 0)); ?></h4>
                        </div>
                        <div class="avatar">
                            <span class="avatar-initial rounded bg-label-warning">
                                <i class='bx bx-error fs-4'></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <p class="mb-1">Active Employees</p>
                            <h4 class="mb-0"><?php echo e(number_format($hrAnalytics['total_employees'] ?? 0)); ?></h4>
                        </div>
                        <div class="avatar">
                            <span class="avatar-initial rounded bg-label-info">
                                <i class='bx bx-group fs-4'></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Charts Section with Interactive Visualizations -->
    <div class="row g-4 mb-4">
        <!-- Revenue Trend Chart -->
        <div class="col-xl-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Revenue Trend</h5>
                    <div class="btn-group btn-group-sm" role="group" id="revenueChartTypeButtons">
                        <button type="button" class="btn btn-outline-primary active" data-chart-type="area">Area</button>
                        <button type="button" class="btn btn-outline-primary" data-chart-type="line">Line</button>
                        <button type="button" class="btn btn-outline-primary" data-chart-type="bar">Bar</button>
                    </div>
                </div>
                <div class="card-body">
                    <div id="revenueChart" style="min-height: 350px;"></div>
                </div>
            </div>
        </div>

        <!-- Top Products -->
        <div class="col-xl-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Top Selling Products</h5>
                </div>
                <div class="card-body">
                    <div id="topProductsChart" style="min-height: 350px;"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Orders and Performance Charts -->
    <div class="row g-4 mb-4">
        <!-- Orders Trend -->
        <div class="col-xl-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Orders Timeline</h5>
                </div>
                <div class="card-body">
                    <div id="ordersChart" style="min-height: 300px;"></div>
                </div>
            </div>
        </div>

        <!-- Department Distribution -->
        <div class="col-xl-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Department Distribution</h5>
                </div>
                <div class="card-body">
                    <div id="departmentChart" style="min-height: 300px;"></div>
                </div>
            </div>
        </div>
    </div>


    <!-- HR & Financial Analytics Grid -->
    <div class="row g-4 mb-4">
        <!-- HR Analytics Card -->
        <div class="col-xl-6">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class='bx bx-group me-2'></i>HR Analytics
                    </h5>
                    <span class="badge bg-label-primary">Live</span>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="d-flex align-items-center">
                                <div class="badge bg-label-primary p-2 rounded me-3">
                                    <i class='bx bx-user fs-5'></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Employees</small>
                                    <h5 class="mb-0"><?php echo e($hrAnalytics['total_employees'] ?? 0); ?></h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-center">
                                <div class="badge bg-label-success p-2 rounded me-3">
                                    <i class='bx bx-star fs-5'></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Managers</small>
                                    <h5 class="mb-0"><?php echo e($hrAnalytics['total_managers'] ?? 0); ?></h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-center">
                                <div class="badge bg-label-info p-2 rounded me-3">
                                    <i class='bx bx-calendar-check fs-5'></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Attendance</small>
                                    <h5 class="mb-0"><?php echo e(number_format($hrAnalytics['average_attendance_rate'] ?? 0, 1)); ?>%</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-center">
                                <div class="badge bg-label-warning p-2 rounded me-3">
                                    <i class='bx bx-wallet fs-5'></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Payroll</small>
                                    <h5 class="mb-0">$<?php echo e(number_format($hrAnalytics['total_payroll_cost'] ?? 0, 0)); ?></h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mt-3">
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar bg-success" role="progressbar" 
                                     style="width: <?php echo e($hrAnalytics['average_attendance_rate'] ?? 0); ?>%" 
                                     aria-valuenow="<?php echo e($hrAnalytics['average_attendance_rate'] ?? 0); ?>" 
                                     aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <small class="text-muted">Attendance Rate Progress</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Financial Analytics Card -->
        <div class="col-xl-6">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class='bx bx-line-chart me-2'></i>Financial Analytics
                    </h5>
                    <span class="badge bg-label-success">Live</span>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="d-flex align-items-center">
                                <div class="badge bg-label-primary p-2 rounded me-3">
                                    <i class='bx bx-money fs-5'></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Budget</small>
                                    <h5 class="mb-0">$<?php echo e(number_format($financialAnalytics['total_budget_allocated'] ?? 0, 0)); ?></h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-center">
                                <div class="badge bg-label-danger p-2 rounded me-3">
                                    <i class='bx bx-credit-card fs-5'></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Expenses</small>
                                    <h5 class="mb-0">$<?php echo e(number_format($financialAnalytics['total_expenses'] ?? 0, 0)); ?></h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-center">
                                <div class="badge bg-label-warning p-2 rounded me-3">
                                    <i class='bx bx-bar-chart fs-5'></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Utilization</small>
                                    <h5 class="mb-0"><?php echo e(number_format($financialAnalytics['budget_utilization'] ?? 0, 1)); ?>%</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-center">
                                <div class="badge bg-label-info p-2 rounded me-3">
                                    <i class='bx bx-wallet-alt fs-5'></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Payroll Exp.</small>
                                    <h5 class="mb-0">$<?php echo e(number_format($financialAnalytics['payroll_expenses'] ?? 0, 0)); ?></h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mt-3">
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar bg-<?php echo e(($financialAnalytics['budget_utilization'] ?? 0) > 80 ? 'danger' : 'primary'); ?>" 
                                     role="progressbar" 
                                     style="width: <?php echo e(min($financialAnalytics['budget_utilization'] ?? 0, 100)); ?>%" 
                                     aria-valuenow="<?php echo e($financialAnalytics['budget_utilization'] ?? 0); ?>" 
                                     aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <small class="text-muted">Budget Utilization</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Branch Performance Table -->
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class='bx bx-buildings me-2'></i>Branch Performance
            </h5>
            <button class="btn btn-sm btn-outline-primary" onclick="alert('Branch export will be available soon')">
                <i class='bx bx-download me-1'></i>Export
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Branch</th>
                            <th>Manager</th>
                            <th>Employees</th>
                            <th>Orders</th>
                            <th>Revenue</th>
                            <th>Performance</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!--[if BLOCK]><![endif]--><?php $__empty_1 = true; $__currentLoopData = $branchAnalytics; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-sm me-3">
                                            <span class="avatar-initial rounded-circle bg-label-<?php echo e(['primary', 'success', 'info', 'warning'][$index % 4]); ?>">
                                                <?php echo e(substr($branch['name'], 0, 1)); ?>

                                            </span>
                                        </div>
                                        <strong><?php echo e($branch['name']); ?></strong>
                                    </div>
                                </td>
                                <td><?php echo e($branch['manager']); ?></td>
                                <td>
                                    <span class="badge bg-label-info"><?php echo e($branch['employees_count']); ?></span>
                                </td>
                                <td><?php echo e(number_format($branch['orders_count'])); ?></td>
                                <td>
                                    <strong class="text-success">$<?php echo e(number_format($branch['revenue'], 2)); ?></strong>
                                </td>
                                <td>
                                    <?php
                                        $maxRevenue = $branchAnalytics->max('revenue');
                                        $performance = $maxRevenue > 0 ? ($branch['revenue'] / $maxRevenue) * 100 : 0;
                                    ?>
                                    <div class="d-flex align-items-center">
                                        <div class="progress flex-grow-1 me-2" style="height: 6px; width: 100px;">
                                            <div class="progress-bar" role="progressbar" 
                                                 style="width: <?php echo e($performance); ?>%" 
                                                 aria-valuenow="<?php echo e($performance); ?>" 
                                                 aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <small class="text-muted"><?php echo e(number_format($performance, 0)); ?>%</small>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="6" class="text-center text-muted">No branch data available</td>
                            </tr>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Chart Initialization Script -->
        <?php
        $__scriptKey = '4163302088-0';
        ob_start();
    ?>
    <script>
        // Initialize charts immediately when script loads
        (function() {
            // Check if ApexCharts is available
            if (typeof ApexCharts === 'undefined') {
                console.error('ApexCharts is not loaded. Make sure it is included in your build.');
                return;
            }

            const charts = {};
            
            // Small delay to ensure DOM elements are available
            setTimeout(function() {
                initAllCharts();
            }, 100);
            
            function initAllCharts() {
                initRevenueChart();
                initTopProductsChart();
                initOrdersChart();
                initDepartmentChart();
                setupChartTypeButtons();
            }
            
            // Revenue Chart
            function initRevenueChart() {
                const revenueTrend = <?php echo json_encode($trends['revenue_trend'] ?? [], 15, 512) ?>;
                const chartElement = document.querySelector("#revenueChart");
                
                if (!chartElement) {
                    console.warn('Revenue chart element not found');
                    return;
                }
                
                const options = {
                    series: [{
                        name: 'Revenue',
                        data: revenueTrend.map(item => parseFloat(item.revenue || 0))
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
                        },
                        animations: {
                            enabled: true,
                            easing: 'easeinout',
                            speed: 800
                        }
                    },
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        curve: 'smooth',
                        width: 3
                    },
                    fill: {
                        type: 'gradient',
                        gradient: {
                            shadeIntensity: 1,
                            opacityFrom: 0.7,
                            opacityTo: 0.2,
                            stops: [0, 90, 100]
                        }
                    },
                    xaxis: {
                        categories: revenueTrend.map(item => item.date || 'N/A'),
                        labels: {
                            rotate: -45
                        }
                    },
                    yaxis: {
                        labels: {
                            formatter: function(value) {
                                return '$' + (value || 0).toFixed(2);
                            }
                        }
                    },
                    colors: ['#696cff'],
                    tooltip: {
                        y: {
                            formatter: function(value) {
                                return '$' + (value || 0).toFixed(2);
                            }
                        }
                    }
                };
                
                charts.revenue = new ApexCharts(chartElement, options);
                charts.revenue.render();
            }
            
            // Top Products Chart
            function initTopProductsChart() {
                const topProducts = <?php echo json_encode($trends['top_products'] ?? [], 15, 512) ?>;
                const chartElement = document.querySelector("#topProductsChart");
                
                if (!chartElement) {
                    console.warn('Top products chart element not found');
                    return;
                }
                
                if (topProducts.length === 0) {
                    chartElement.innerHTML = '<div class="text-center py-5"><p class="text-muted">No product data available</p></div>';
                    return;
                }
                
                const options = {
                    series: [{
                        name: 'Units Sold',
                        data: topProducts.map(item => parseInt(item.total_sold || 0))
                    }],
                    chart: {
                        type: 'bar',
                        height: 350,
                        toolbar: {
                            show: false
                        }
                    },
                    plotOptions: {
                        bar: {
                            borderRadius: 8,
                            horizontal: true,
                            distributed: true,
                            dataLabels: {
                                position: 'top'
                            }
                        }
                    },
                    dataLabels: {
                        enabled: true,
                        offsetX: 30,
                        style: {
                            fontSize: '12px',
                            colors: ['#304758']
                        }
                    },
                    xaxis: {
                        categories: topProducts.map(item => item.name || 'Unknown')
                    },
                    colors: ['#696cff', '#8592a3', '#ff6384', '#ffce56', '#4bc0c0'],
                    legend: {
                        show: false
                    }
                };
                
                charts.topProducts = new ApexCharts(chartElement, options);
                charts.topProducts.render();
            }
            
            // Orders Chart
            function initOrdersChart() {
                const orderTrend = <?php echo json_encode($trends['order_trend'] ?? [], 15, 512) ?>;
                const chartElement = document.querySelector("#ordersChart");
                
                if (!chartElement) {
                    console.warn('Orders chart element not found');
                    return;
                }
                
                const options = {
                    series: [{
                        name: 'Orders',
                        data: orderTrend.map(item => parseInt(item.orders || 0))
                    }],
                    chart: {
                        type: 'line',
                        height: 300,
                        toolbar: {
                            show: false
                        },
                        sparkline: {
                            enabled: false
                        }
                    },
                    stroke: {
                        curve: 'smooth',
                        width: 3
                    },
                    markers: {
                        size: 5,
                        hover: {
                            size: 7
                        }
                    },
                    xaxis: {
                        categories: orderTrend.map(item => item.date || 'N/A'),
                        labels: {
                            rotate: -45
                        }
                    },
                    colors: ['#71dd37'],
                    grid: {
                        borderColor: '#f1f1f1'
                    }
                };
                
                charts.orders = new ApexCharts(chartElement, options);
                charts.orders.render();
            }
            
            // Department Chart
            function initDepartmentChart() {
                const departments = <?php echo json_encode($hrAnalytics['departments'] ?? [], 15, 512) ?>;
                const chartElement = document.querySelector("#departmentChart");
                
                if (!chartElement) {
                    console.warn('Department chart element not found');
                    return;
                }
                
                if (departments.length === 0) {
                    chartElement.innerHTML = '<div class="text-center py-5"><p class="text-muted">No department data available</p></div>';
                    return;
                }
                
                const options = {
                    series: departments.map(dept => parseInt(dept.count || 0)),
                    chart: {
                        type: 'donut',
                        height: 300
                    },
                    labels: departments.map(dept => dept.department || 'Unknown'),
                    colors: ['#696cff', '#8592a3', '#ff6384', '#ffce56', '#4bc0c0', '#9966ff'],
                    legend: {
                        position: 'bottom'
                    },
                    plotOptions: {
                        pie: {
                            donut: {
                                size: '70%',
                                labels: {
                                    show: true,
                                    name: {
                                        show: true
                                    },
                                    value: {
                                        show: true,
                                        fontSize: '22px',
                                        fontWeight: 600
                                    },
                                    total: {
                                        show: true,
                                        label: 'Total',
                                        formatter: function (w) {
                                            return w.globals.seriesTotals.reduce((a, b) => a + b, 0);
                                        }
                                    }
                                }
                            }
                        }
                    }
                };
                
                charts.department = new ApexCharts(chartElement, options);
                charts.department.render();
            }
            
            // Setup chart type buttons
            function setupChartTypeButtons() {
                const chartTypeButtons = document.querySelectorAll('#revenueChartTypeButtons button');
                chartTypeButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        const chartType = this.getAttribute('data-chart-type');
                        
                        // Update active state
                        chartTypeButtons.forEach(btn => btn.classList.remove('active'));
                        this.classList.add('active');
                        
                        // Update chart type
                        if (charts.revenue) {
                            charts.revenue.updateOptions({
                                chart: {
                                    type: chartType
                                }
                            });
                        }
                    });
                });
            }
            
            // Cleanup function
            window.cleanupAnalyticsCharts = function() {
                Object.values(charts).forEach(chart => {
                    if (chart && typeof chart.destroy === 'function') {
                        chart.destroy();
                    }
                });
            };
        })();
    </script>
        <?php
        $__output = ob_get_clean();

        \Livewire\store($this)->push('scripts', $__output, $__scriptKey)
    ?>
</div><?php /**PATH D:\School-Projects\Software-dev\Kessly\resources\views/livewire/analytics/business-analytics.blade.php ENDPATH**/ ?>