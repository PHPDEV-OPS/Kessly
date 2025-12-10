<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;

?>

<div>
    <!-- Statistics Cards -->
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar me-3">
                            <span class="avatar-initial rounded-circle bg-label-primary">
                                <i class="ri-money-dollar-circle-line ri-22px"></i>
                            </span>
                        </div>
                        <div>
                            <div class="text-muted small">Total Payrolls</div>
                            <h5 class="mb-0"><?php echo e(\App\Models\Payroll::count()); ?></h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar me-3">
                            <span class="avatar-initial rounded-circle bg-label-success">
                                <i class="ri-check-double-line ri-22px"></i>
                            </span>
                        </div>
                        <div>
                            <div class="text-muted small">Processed</div>
                            <h5 class="mb-0 text-success"><?php echo e(\App\Models\Payroll::where('status', 'processed')->count()); ?></h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar me-3">
                            <span class="avatar-initial rounded-circle bg-label-info">
                                <i class="ri-file-chart-line ri-22px"></i>
                            </span>
                        </div>
                        <div>
                            <div class="text-muted small">Total Budgets</div>
                            <h5 class="mb-0"><?php echo e(\App\Models\Budget::count()); ?></h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar me-3">
                            <span class="avatar-initial rounded-circle bg-label-warning">
                                <i class="ri-wallet-3-line ri-22px"></i>
                            </span>
                        </div>
                        <div>
                            <div class="text-muted small">Pending Expenses</div>
                            <h5 class="mb-0 text-warning"><?php echo e(\App\Models\Expense::where('status', 'pending')->count()); ?></h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tab Navigation Card -->
    <div class="card">
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
                <button wire:click.prevent="setActiveTab('payroll')" 
                        class="nav-link <?php echo e($activeTab === 'payroll' ? 'active' : ''); ?>" 
                        type="button">
                    <i class="ri-money-dollar-circle-line me-2"></i>
                    Payroll
                </button>
            </li>
            <li class="nav-item">
                <button wire:click.prevent="setActiveTab('budgets')" 
                        class="nav-link <?php echo e($activeTab === 'budgets' ? 'active' : ''); ?>" 
                        type="button">
                    <i class="ri-file-chart-line me-2"></i>
                    Budgets
                </button>
            </li>
            <li class="nav-item">
                <button wire:click.prevent="setActiveTab('expenses')" 
                        class="nav-link <?php echo e($activeTab === 'expenses' ? 'active' : ''); ?>" 
                        type="button">
                    <i class="ri-wallet-3-line me-2"></i>
                    Expenses
                </button>
            </li>
        </ul>

        <!-- Tab Content -->
        <div class="card-body">
            <!--[if BLOCK]><![endif]--><?php if($activeTab === 'payroll'): ?>
                <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('finance.payroll-management', []);

$__html = app('livewire')->mount($__name, $__params, 'lw-1549341805-0', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
            <?php elseif($activeTab === 'budgets'): ?>
                <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('finance.budget-management', []);

$__html = app('livewire')->mount($__name, $__params, 'lw-1549341805-1', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
            <?php elseif($activeTab === 'expenses'): ?>
                <div class="text-center py-5">
                    <div class="avatar avatar-xl mx-auto mb-3">
                        <span class="avatar-initial rounded-circle bg-label-warning">
                            <i class="ri-wallet-3-line ri-48px"></i>
                        </span>
                    </div>
                    <h5 class="mb-2">Expense Management</h5>
                    <p class="text-muted mb-0">Track and approve company expenses.</p>
                </div>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        </div>
    </div>
</div><?php /**PATH D:\School-Projects\Software-dev\Kessly\resources\views\livewire/pages/finance.blade.php ENDPATH**/ ?>