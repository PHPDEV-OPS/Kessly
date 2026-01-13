<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;

?>

<div>
    <!-- Enhanced Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-gradient-primary text-white">
                <div class="card-body p-3 p-md-4">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
                        <div>
                            <h4 class="text-white fw-bold mb-2">
                                <i class='bx bx-file-blank me-2'></i>Reports & Analytics
                            </h4>
                            <p class="text-white-50 mb-0 small d-none d-sm-block">
                                Comprehensive business reports and insights
                            </p>
                        </div>
                        <div class="no-print">
                            <button class="btn btn-light btn-sm" onclick="window.print()">
                                <i class='bx bx-printer me-1'></i><span class="d-none d-sm-inline">Print Report</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tab Navigation -->
    <div class="card mb-4 no-print">
        <div class="card-body p-0">
            <nav class="nav nav-pills nav-justified overflow-auto flex-nowrap" role="tablist">
                <button wire:click="setActiveTab('sales')" type="button"
                    class="nav-link <?php echo e($activeTab === 'sales' ? 'active' : ''); ?> rounded-0 border-0 d-flex align-items-center justify-content-center py-3">
                    <div class="text-center">
                        <i class='bx bx-cart fs-4 d-block mb-1'></i>
                        <span class="d-none d-sm-inline">Sales Reports</span>
                        <span class="d-inline d-sm-none small">Sales</span>
                    </div>
                </button>

                <button wire:click="setActiveTab('inventory')" type="button"
                    class="nav-link <?php echo e($activeTab === 'inventory' ? 'active' : ''); ?> rounded-0 border-0 d-flex align-items-center justify-content-center py-3">
                    <div class="text-center">
                        <i class='bx bx-package fs-4 d-block mb-1'></i>
                        <span class="d-none d-sm-inline">Inventory Reports</span>
                        <span class="d-inline d-sm-none small">Inventory</span>
                    </div>
                </button>

                <button wire:click="setActiveTab('financial')" type="button"
                    class="nav-link <?php echo e($activeTab === 'financial' ? 'active' : ''); ?> rounded-0 border-0 d-flex align-items-center justify-content-center py-3">
                    <div class="text-center">
                        <i class='bx bx-dollar-circle fs-4 d-block mb-1'></i>
                        <span class="d-none d-sm-inline">Financial Reports</span>
                        <span class="d-inline d-sm-none small">Financial</span>
                    </div>
                </button>

                <button wire:click="setActiveTab('custom')" type="button"
                    class="nav-link <?php echo e($activeTab === 'custom' ? 'active' : ''); ?> rounded-0 border-0 d-flex align-items-center justify-content-center py-3">
                    <div class="text-center">
                        <i class='bx bx-customize fs-4 d-block mb-1'></i>
                        <span class="d-none d-sm-inline">Custom Reports</span>
                        <span class="d-inline d-sm-none small">Custom</span>
                    </div>
                </button>
            </nav>
        </div>
    </div>

    <!-- Tab Content -->
    <div class="tab-content">
        <!-- Sales Reports Tab -->
        <div class="tab-pane fade <?php echo e($activeTab === 'sales' ? 'show active' : ''); ?>">
            <?php if($activeTab === 'sales'): ?>
                <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('reports.sales-report', []);

$__html = app('livewire')->mount($__name, $__params, 'sales-'.now(), $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
            <?php endif; ?>
        </div>

        <!-- Inventory Reports Tab -->
        <div class="tab-pane fade <?php echo e($activeTab === 'inventory' ? 'show active' : ''); ?>">
            <?php if($activeTab === 'inventory'): ?>
                <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('reports.stock-report', []);

$__html = app('livewire')->mount($__name, $__params, 'inventory-'.now(), $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
            <?php endif; ?>
        </div>

        <!-- Financial Reports Tab -->
        <div class="tab-pane fade <?php echo e($activeTab === 'financial' ? 'show active' : ''); ?>">
            <?php if($activeTab === 'financial'): ?>
                <div class="card">
                    <div class="card-body text-center py-5">
                        <div class="mb-3">
                            <i class='bx bx-dollar-circle display-1 text-success'></i>
                        </div>
                        <h4 class="mb-2">Financial Reports</h4>
                        <p class="text-muted mb-4">
                            Detailed financial statements, profit & loss, balance sheets, and cash flow reports.
                        </p>
                        <div class="row g-3 text-start">
                            <div class="col-md-4">
                                <div class="card bg-label-success">
                                    <div class="card-body text-center">
                                        <i class='bx bx-line-chart fs-1 mb-2'></i>
                                        <h6>Profit & Loss</h6>
                                        <small>Income vs Expenses</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card bg-label-primary">
                                    <div class="card-body text-center">
                                        <i class='bx bx-receipt fs-1 mb-2'></i>
                                        <h6>Balance Sheet</h6>
                                        <small>Assets & Liabilities</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card bg-label-info">
                                    <div class="card-body text-center">
                                        <i class='bx bx-wallet fs-1 mb-2'></i>
                                        <h6>Cash Flow</h6>
                                        <small>Money In & Out</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <!-- Custom Reports Tab -->
        <div class="tab-pane fade <?php echo e($activeTab === 'custom' ? 'show active' : ''); ?>">
            <?php if($activeTab === 'custom'): ?>
                <div class="card">
                    <div class="card-body text-center py-5">
                        <div class="mb-3">
                            <i class='bx bx-customize display-1 text-warning'></i>
                        </div>
                        <h4 class="mb-2">Custom Report Builder</h4>
                        <p class="text-muted mb-4">
                            Create custom reports tailored to your specific business needs with advanced filters and grouping.
                        </p>
                        <div class="row g-3 text-start">
                            <div class="col-md-3">
                                <div class="card bg-label-warning">
                                    <div class="card-body text-center">
                                        <i class='bx bx-filter fs-1 mb-2'></i>
                                        <h6>Advanced Filters</h6>
                                        <small>Custom criteria</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-label-info">
                                    <div class="card-body text-center">
                                        <i class='bx bx-group fs-1 mb-2'></i>
                                        <h6>Grouping</h6>
                                        <small>Organize data</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-label-success">
                                    <div class="card-body text-center">
                                        <i class='bx bx-save fs-1 mb-2'></i>
                                        <h6>Save Templates</h6>
                                        <small>Reuse reports</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-label-danger">
                                    <div class="card-body text-center">
                                        <i class='bx bx-calendar fs-1 mb-2'></i>
                                        <h6>Schedule</h6>
                                        <small>Auto-generate</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <style>
        .bg-gradient-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .nav-pills .nav-link {
            transition: all 0.3s ease;
        }
        
        .nav-pills .nav-link:hover:not(.active) {
            background-color: rgba(0,0,0,0.05);
        }
        
        .nav-pills .nav-link.active {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white !important;
        }
        
        .tab-pane {
            animation: fadeIn 0.5s ease-in;
        }
        
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        /* Print Styles */
        @media print {
            @page {
                size: A4;
                margin: 2cm;
            }
            
            body {
                font-size: 12pt;
                line-height: 1.5;
            }
            
            .no-print {
                display: none !important;
            }
            
            .card {
                box-shadow: none !important;
                border: 1px solid #dee2e6 !important;
                page-break-inside: avoid;
                margin-bottom: 1rem !important;
            }
            
            .card-header {
                background-color: #f8f9fa !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            
            h1, h2, h3, h4, h5, h6 {
                page-break-after: avoid;
            }
            
            table {
                page-break-inside: auto;
            }
            
            tr {
                page-break-inside: avoid;
                page-break-after: auto;
            }
            
            /* Company header for print */
            body::before {
                content: \"Kessly Business Reports\";
                display: block;
                text-align: center;
                font-size: 28pt;
                font-weight: bold;
                margin-bottom: 10pt;
            }
            
            body::after {
                content: \"Generated on \" attr(data-print-date);
                display: block;
                text-align: center;
                font-size: 10pt;
                color: #666;
                margin-top: 20pt;
                padding-top: 10pt;
                border-top: 1px solid #dee2e6;
            }
        }
    </style>
    
    <script>
        // Set print date
        document.body.setAttribute('data-print-date', new Date().toLocaleString());
    </script>
</div><?php /**PATH D:\School-Projects\Software-dev\Kessly\resources\views\livewire\pages\reports.blade.php ENDPATH**/ ?>