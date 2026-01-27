<div>
    <h5 class="mb-3">Select Customer</h5>
    <input type="text" class="form-control mb-3" placeholder="Search customer by name..." wire:model.debounce.300ms="search">
    <div class="list-group mb-3">
        <!--[if BLOCK]><![endif]--><?php $__empty_1 = true; $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <button class="list-group-item list-group-item-action <?php if($selectedCustomer && $selectedCustomer->id === $customer->id): ?> active <?php endif; ?>" wire:click="selectCustomer(<?php echo e($customer->id); ?>)">
                <?php echo e($customer->name); ?>

                <span class="text-muted small"><?php echo e($customer->email); ?></span>
            </button>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="list-group-item">No customers found.</div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    </div>
    <!--[if BLOCK]><![endif]--><?php if($selectedCustomer): ?>
        <div class="alert alert-success">
            Selected: <strong><?php echo e($selectedCustomer->name); ?></strong>
        </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
</div>
<?php /**PATH D:\School-Projects\Software-dev\Kessly\resources\views/livewire/pos/customers.blade.php ENDPATH**/ ?>