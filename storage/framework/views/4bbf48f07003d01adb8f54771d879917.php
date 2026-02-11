<div class="pos-customers">
    <div class="d-flex align-items-center justify-content-between gap-2 mb-3">
        <div>
            <h6 class="mb-1">Customer</h6>
            <small class="text-muted">Search and pick a customer for the order</small>
        </div>
    </div>

    <div class="input-group input-group-sm mb-3">
        <span class="input-group-text bg-transparent border-end-0"><i class="ri-search-line"></i></span>
        <input type="text" class="form-control border-start-0" placeholder="Search by name" wire:model.debounce.300ms="search">
    </div>

    <div class="list-group mb-3" style="max-height: 320px; overflow-y: auto;">
        <!--[if BLOCK]><![endif]--><?php $__empty_1 = true; $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <button class="list-group-item list-group-item-action d-flex justify-content-between align-items-start <?php echo e($selectedCustomer && $selectedCustomer->id === $customer->id ? 'active' : ''); ?>" wire:click="selectCustomer(<?php echo e($customer->id); ?>)">
                <div class="me-2">
                    <div class="fw-semibold"><?php echo e($customer->name); ?></div>
                    <div class="text-muted small"><?php echo e($customer->email); ?></div>
                </div>
                <span class="badge bg-label-primary">Select</span>
            </button>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="list-group-item">No customers found.</div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    </div>

    <!--[if BLOCK]><![endif]--><?php if($selectedCustomer): ?>
        <div class="alert alert-success mb-0">
            <div class="fw-semibold"><?php echo e($selectedCustomer->name); ?></div>
            <div class="small mb-1"><?php echo e($selectedCustomer->email); ?></div>
            <div class="small"><?php echo e($selectedCustomer->phone); ?></div>
        </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
</div>
<?php /**PATH D:\School-Projects\Software-dev\Kessly\resources\views/livewire/pos/customers.blade.php ENDPATH**/ ?>