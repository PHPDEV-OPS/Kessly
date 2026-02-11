<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;

?>

<div class="pos-page">
    <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
        <div>
            <h4 class="mb-1">Point of Sale</h4>
            <small class="text-muted">Process orders, add items, and checkout customers</small>
        </div>
        <div class="d-flex flex-wrap gap-2">
            <span class="badge bg-label-primary">Customers: <?php echo e(\App\Models\Customer::count()); ?></span>
            <span class="badge bg-label-primary">Products: <?php echo e(\App\Models\Product::count()); ?></span>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card h-100">
                <div class="card-body">
                    <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('pos.products', []);

$__html = app('livewire')->mount($__name, $__params, 'lw-1713630923-0', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="position-sticky" style="top: 88px;">
                <div class="card mb-3">
                    <div class="card-body">
                        <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('pos.customers', []);

$__html = app('livewire')->mount($__name, $__params, 'lw-1713630923-1', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><?php /**PATH D:\School-Projects\Software-dev\Kessly\resources\views\livewire/pages/pos.blade.php ENDPATH**/ ?>