<div>
    <h5 class="mb-3">Products</h5>
    <div class="row">
        <!--[if BLOCK]><![endif]--><?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="col-md-3 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h6 class="card-title"><?php echo e($product->name); ?></h6>
                        <p class="card-text">Ksh <?php echo e(number_format($product->price, 2)); ?></p>
                        <button class="btn btn-primary btn-sm" wire:click="addToCart(<?php echo e($product->id); ?>)">
                            Add to Cart
                            <!--[if BLOCK]><![endif]--><?php if(isset($cart[$product->id])): ?>
                                <span class="badge bg-success ms-2"><?php echo e($cart[$product->id]['quantity']); ?></span>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </button>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="col-12">
                <div class="alert alert-info">No products found.</div>
            </div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    </div>
</div>
<?php /**PATH D:\School-Projects\Software-dev\Kessly\resources\views/livewire/pos/products.blade.php ENDPATH**/ ?>