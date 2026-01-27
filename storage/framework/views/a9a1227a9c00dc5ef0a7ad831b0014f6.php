<div class="row" style="margin-top: 2rem;">
    <div class="col-md-8">
        <div class="card mb-3">
            <div class="card-header bg-primary text-white">Products</div>
            <div class="card-body">
                <div class="row g-3">
                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-6 col-md-4 col-lg-3 mb-3">
                            <div class="card h-100 border shadow-sm">
                                <div class="card-body p-2 d-flex flex-column align-items-center justify-content-between">
                                    <h6 class="mb-1 text-center"><?php echo e($product->name); ?></h6>
                                    <div class="mb-2 text-muted">$<?php echo e(number_format($product->price, 2)); ?></div>
                                    <button type="button" class="btn btn-sm btn-primary w-100 mt-auto" wire:click="addToCart(<?php echo e($product->id); ?>)">Add</button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card mb-3">
            <div class="card-header bg-secondary text-white">Customer Details</div>
            <div class="card-body">
                <form method="POST" action="<?php echo e(route('pesapal.pay')); ?>" autocomplete="off">
                    <?php echo csrf_field(); ?>
                    <div class="mb-3">
                        <label for="customer_name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="customer_name" name="customer_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="customer_email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="customer_email" name="customer_email" required>
                    </div>
                    <div class="mb-3">
                        <label for="customer_phone" class="form-label">Phone</label>
                        <input type="text" class="form-control" id="customer_phone" name="customer_phone" required>
                    </div>
                    <div class="card mb-3">
                        <div class="card-header">Cart</div>
                        <div class="card-body">
                            <!--[if BLOCK]><![endif]--><?php if(count($cart)): ?>
                                <ul class="list-group mb-3">
                                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $cart; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span><?php echo e($item['name']); ?> x<?php echo e($item['qty']); ?></span>
                                            <span>$<?php echo e(number_format($item['price'] * $item['qty'], 2)); ?></span>
                                        </li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                </ul>
                                <div class="mb-3">
                                    <strong>Total: $<?php echo e(number_format($total, 2)); ?></strong>
                                </div>
                                <input type="hidden" name="amount" value="<?php echo e($total); ?>">
                                <button type="submit" class="btn btn-success w-100">Checkout with Pesapal</button>
                            <?php else: ?>
                                <div class="text-muted">Cart is empty.</div>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!--[if BLOCK]><![endif]--><?php if(session('error')): ?>
            <div class="alert alert-danger mt-2"><?php echo e(session('error')); ?></div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    </div>
</div>
<?php /**PATH D:\School-Projects\Software-dev\Kessly\resources\views/livewire/pos.blade.php ENDPATH**/ ?>