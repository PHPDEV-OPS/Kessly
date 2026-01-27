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
                                <i class="ri-store-line ri-22px"></i>
                            </span>
                        </div>
                        <div>
                            <div class="text-muted small">Total Branches</div>
                            <h5 class="mb-0"><?php echo e(\App\Models\Branch::forUser()->count()); ?></h5>
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
                                <i class="ri-checkbox-circle-line ri-22px"></i>
                            </span>
                        </div>
                        <div>
                            <div class="text-muted small">Active Branches</div>
                            <h5 class="mb-0 text-success"><?php echo e(\App\Models\Branch::forUser()->where('status', 'active')->count()); ?></h5>
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
                                <i class="ri-team-line ri-22px"></i>
                            </span>
                        </div>
                        <div>
                            <div class="text-muted small">Total Employees</div>
                            <h5 class="mb-0"><?php echo e(\App\Models\Employee::count()); ?></h5>
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
                                <i class="ri-box-3-line ri-22px"></i>
                            </span>
                        </div>
                        <div>
                            <div class="text-muted small">Total Inventory</div>
                            <h5 class="mb-0"><?php echo e(\App\Models\BranchInventory::sum('quantity')); ?></h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="card">
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
                <button wire:click.prevent="setActiveTab('branches')" 
                        class="nav-link <?php echo e($activeTab === 'branches' ? 'active' : ''); ?>" 
                        type="button">
                    <i class="ri-store-line me-2"></i>
                    Branches
                </button>
            </li>
            <li class="nav-item">
                <button wire:click.prevent="setActiveTab('inventory')" 
                        class="nav-link <?php echo e($activeTab === 'inventory' ? 'active' : ''); ?>" 
                        type="button">
                    <i class="ri-box-3-line me-2"></i>
                    Branch Inventory
                </button>
            </li>
        </ul>

        <div class="card-body">
            <!--[if BLOCK]><![endif]--><?php if($activeTab === 'branches'): ?>
                <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('branches.branch-management', []);

$__html = app('livewire')->mount($__name, $__params, 'lw-4222276970-0', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
            <?php elseif($activeTab === 'inventory'): ?>
                <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('branches.branch-inventory-management', []);

$__html = app('livewire')->mount($__name, $__params, 'lw-4222276970-1', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        </div>
    </div>
</div><?php /**PATH D:\School-Projects\Software-dev\Kessly\resources\views\livewire/pages/branches.blade.php ENDPATH**/ ?>