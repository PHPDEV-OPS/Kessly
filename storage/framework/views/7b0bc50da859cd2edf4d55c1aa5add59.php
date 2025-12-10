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
                        wire:click="setActiveTab('products')"
                        class="nav-link <?php echo e($activeTab === 'products' ? 'active' : ''); ?>"
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
                        wire:click="setActiveTab('categories')"
                        class="nav-link <?php echo e($activeTab === 'categories' ? 'active' : ''); ?>"
                        type="button"
                        role="tab">
                        <i class="ri-folder-line me-2"></i>
                        Categories
                        <span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-label-primary ms-1">
                            <?php echo e(\App\Models\Category::count()); ?>

                        </span>
                    </button>
                </li>
                <li class="nav-item">
                    <button 
                        wire:click="setActiveTab('suppliers')"
                        class="nav-link <?php echo e($activeTab === 'suppliers' ? 'active' : ''); ?>"
                        type="button"
                        role="tab">
                        <i class="ri-truck-line me-2"></i>
                        Suppliers
                        <span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-label-primary ms-1">
                            <?php echo e(\App\Models\Supplier::count()); ?>

                        </span>
                    </button>
                </li>
            </ul>
        </div>

        <!-- Tab Content -->
        <div class="card-body p-0">
            <div class="tab-content">
                <?php if($activeTab === 'products'): ?>
                    <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('inventory.products', []);

$__html = app('livewire')->mount($__name, $__params, 'products-'.now()->timestamp, $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
                <?php elseif($activeTab === 'categories'): ?>
                    <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('inventory.categories', []);

$__html = app('livewire')->mount($__name, $__params, 'categories-'.now()->timestamp, $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
                <?php elseif($activeTab === 'suppliers'): ?>
                    <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('inventory.suppliers', []);

$__html = app('livewire')->mount($__name, $__params, 'suppliers-'.now()->timestamp, $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div><?php /**PATH D:\School-Projects\Software-dev\Kessly\resources\views\livewire\pages\inventory.blade.php ENDPATH**/ ?>