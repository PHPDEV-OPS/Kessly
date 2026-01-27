<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;

?>

<div>
    <!-- Tab Navigation Card for POS -->
    <div class="card mb-4">
        <div class="card-header border-bottom">
            <ul class="nav nav-tabs card-header-tabs" role="tablist">
                <li class="nav-item">
                    <button 
                        wire:click="setActiveTab('customers')"
                        class="nav-link <?php echo e($activeTab === 'customers' ? 'active' : ''); ?>"
                        type="button"
                        role="tab">
                        <i class="ri-user-line me-2"></i>
                        Customer
                        <span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-label-primary ms-1">
                            <?php echo e(\App\Models\Customer::count()); ?>

                        </span>
                    </button>
                </li>
                <li class="nav-item">
                    <button 
                        wire:click="setActiveTab('pos-products')"
                        class="nav-link <?php echo e($activeTab === 'pos-products' ? 'active' : ''); ?>"
                        type="button"
                        role="tab">
                        <i class="ri-stack-line me-2"></i>
                        Products
                        <span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-label-primary ms-1">
                            <?php echo e(\App\Models\Product::count()); ?>

                        </span>
                    </button>
                </li>
                <li class="nav-item">
                    <button 
                        wire:click="setActiveTab('cart')"
                        class="nav-link <?php echo e($activeTab === 'cart' ? 'active' : ''); ?>"
                        type="button"
                        role="tab">
                        <i class="ri-shopping-cart-line me-2"></i>
                        Cart
                        <span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-label-primary ms-1">
                            <?php echo e(is_array($cart ?? null) ? count($cart) : 0); ?>

                        </span>
                    </button>
                </li>
            </ul>
        </div>

        <!-- Tab Content -->
        <div class="card-body p-0">
            <div class="tab-content">
                <!--[if BLOCK]><![endif]--><?php if($activeTab === 'customers'): ?>
                    <!-- POS Customer Selection -->
                    <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('pos.customers', []);

$__html = app('livewire')->mount($__name, $__params, 'lw-1713630923-0', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
                <?php elseif($activeTab === 'pos-products'): ?>
                    <!-- POS Product Grid or List -->
                    <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('pos.products', []);

$__html = app('livewire')->mount($__name, $__params, 'lw-1713630923-1', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
                <?php elseif($activeTab === 'cart'): ?>
                    <!-- POS Cart View -->
                    <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('pos.cart', []);

$__html = app('livewire')->mount($__name, $__params, 'lw-1713630923-2', $__slots ?? [], get_defined_vars());

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
</div><?php /**PATH D:\School-Projects\Software-dev\Kessly\resources\views\livewire/pages/pos.blade.php ENDPATH**/ ?>