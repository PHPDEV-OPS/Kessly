<div class="pos-products">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-3">
        <div>
            <h5 class="mb-1">Products</h5>
            <small class="text-muted">Browse and add items to the cart</small>
        </div>
        <div class="d-flex flex-wrap gap-2 w-100 w-md-auto">
            <div class="input-group input-group-sm w-100" style="min-width: 220px;">
                <span class="input-group-text bg-transparent border-end-0"><i class="ri-search-line"></i></span>
                <input type="search" class="form-control border-start-0" placeholder="Search products" wire:model.debounce.300ms="search">
            </div>
        </div>
    </div>

    <!--[if BLOCK]><![endif]--><?php if($categories->count()): ?>
        <div class="d-flex flex-wrap gap-2 mb-3">
            <button class="btn btn-sm <?php echo e($categoryId ? 'btn-outline-secondary' : 'btn-primary'); ?>" wire:click="$set('categoryId', null)">All</button>
            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <button class="btn btn-sm <?php echo e($categoryId === $category->id ? 'btn-primary' : 'btn-outline-secondary'); ?>" wire:click="$set('categoryId', <?php echo e($category->id); ?>)"><?php echo e($category->name); ?></button>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
        </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

    <div class="row g-3">
        <!--[if BLOCK]><![endif]--><?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="col-12 col-sm-6 col-lg-4 col-xxl-3">
                <div class="card h-100 shadow-sm product-tile">
                    <div class="card-body d-flex flex-column gap-2">
                        <div class="d-flex justify-content-between align-items-start gap-2">
                            <h6 class="mb-0"><?php echo e($product->name); ?></h6>
                            <!--[if BLOCK]><![endif]--><?php if(isset($cart[$product->id])): ?>
                                <span class="badge bg-success"><?php echo e($cart[$product->id]['quantity']); ?> in cart</span>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                        <div class="text-muted small"><?php echo e($product->category?->name ?? 'Uncategorized'); ?></div>
                        <div class="fw-semibold h5 mb-0">Ksh <?php echo e(number_format($product->price, 2)); ?></div>
                        <div class="d-flex justify-content-between align-items-center mt-auto">
                            <small class="text-muted">Stock: <?php echo e($product->stock ?? 0); ?></small>
                            <button class="btn btn-sm btn-primary" wire:click="addToCart(<?php echo e($product->id); ?>)">
                                <i class="ri-add-line me-1"></i>Add
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="col-12">
                <div class="alert alert-info mb-0">No products found.</div>
            </div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    </div>
</div>
<?php /**PATH D:\School-Projects\Software-dev\Kessly\resources\views/livewire/pos/products.blade.php ENDPATH**/ ?>