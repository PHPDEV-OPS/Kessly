<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;

?>

<div>
    <!-- Tab Navigation Card -->
    <div class="card mb-4">
        <div class="card-header border-bottom">
            <ul class="nav nav-tabs card-header-tabs" role="tablist">
                <li class="nav-item">
                    <button 
                        wire:click="setActiveTab('orders')"
                        class="nav-link <?php echo e($activeTab === 'orders' ? 'active' : ''); ?>"
                        type="button"
                        role="tab">
                        <i class="ri-file-list-3-line me-2"></i>
                        Orders
                        <span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-label-primary ms-1">
                            <?php echo e(\App\Models\Order::count()); ?>

                        </span>
                    </button>
                </li>
                <li class="nav-item">
                    <button 
                        wire:click="setActiveTab('invoices')"
                        class="nav-link <?php echo e($activeTab === 'invoices' ? 'active' : ''); ?>"
                        type="button"
                        role="tab">
                        <i class="ri-bill-line me-2"></i>
                        Invoices
                        <span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-label-primary ms-1">
                            <?php echo e(\App\Models\Invoice::count()); ?>

                        </span>
                    </button>
                </li>
                <li class="nav-item">
                    <button 
                        wire:click="setActiveTab('customers')"
                        class="nav-link <?php echo e($activeTab === 'customers' ? 'active' : ''); ?>"
                        type="button"
                        role="tab">
                        <i class="ri-team-line me-2"></i>
                        Customers
                        <span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-label-primary ms-1">
                            <?php echo e(\App\Models\Customer::count()); ?>

                        </span>
                    </button>
                </li>
            </ul>
        </div>

        <!-- Tab Content -->
        <div class="card-body p-0">
            <div class="tab-content">
                <!--[if BLOCK]><![endif]--><?php if($activeTab === 'orders'): ?>
                    <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('sales.orders', []);

$__html = app('livewire')->mount($__name, $__params, 'lw-2290647985-0', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
                <?php elseif($activeTab === 'invoices'): ?>
                    <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('sales.invoices', []);

$__html = app('livewire')->mount($__name, $__params, 'lw-2290647985-1', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
                <?php elseif($activeTab === 'customers'): ?>
                    <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('sales.customers', []);

$__html = app('livewire')->mount($__name, $__params, 'lw-2290647985-2', $__slots ?? [], get_defined_vars());

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
    </div>
</div><?php /**PATH D:\School-Projects\Software-dev\Kessly\resources\views\livewire/pages/sales.blade.php ENDPATH**/ ?>