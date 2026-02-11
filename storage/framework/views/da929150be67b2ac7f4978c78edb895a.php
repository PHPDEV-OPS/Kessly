<div class="pos-cart">
    <div class="d-flex align-items-center justify-content-between gap-2 mb-3">
        <div>
            <h6 class="mb-1">Cart</h6>
            <small class="text-muted">Review items before checkout</small>
        </div>
        <!--[if BLOCK]><![endif]--><?php if($cart): ?>
            <span class="badge bg-label-primary"><?php echo e(count($cart)); ?> items</span>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    </div>

    <!--[if BLOCK]><![endif]--><?php if($order): ?>
        <div class="alert alert-success">
            <h6 class="mb-1">Order Complete</h6>
            <div class="small">Order #: <strong><?php echo e($order->id); ?></strong></div>
            <div class="small">Total: <strong>Ksh <?php echo e(number_format($order->total_amount, 2)); ?></strong></div>
        </div>
    <?php elseif(empty($cart)): ?>
        <div class="alert alert-info mb-0">Your cart is empty.</div>
    <?php else: ?>
        <div class="mb-3">
            <h6 class="mb-2">Customer</h6>
            <?php
                $customer = $customerId ? \App\Models\Customer::find($customerId) : null;
            ?>
            <!--[if BLOCK]><![endif]--><?php if($customer): ?>
                <div class="border rounded p-2 bg-light">
                    <div class="fw-semibold"><?php echo e($customer->name); ?></div>
                    <div class="small text-muted"><?php echo e($customer->email); ?></div>
                    <div class="small text-muted"><?php echo e($customer->phone); ?></div>
                </div>
            <?php else: ?>
                <div class="text-danger">No customer selected.</div>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        </div>

        <div class="table-responsive mb-3">
            <table class="table table-sm table-borderless align-middle mb-0 table-stacked">
                <thead class="border-bottom">
                    <tr>
                        <th>Item</th>
                        <th class="text-end">Price</th>
                        <th class="text-center">Qty</th>
                        <th class="text-end">Subtotal</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $cart; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td data-label="Item" class="fw-semibold"><?php echo e($item['name']); ?></td>
                            <td data-label="Price" class="text-end">Ksh <?php echo e(number_format($item['price'], 2)); ?></td>
                            <td data-label="Qty" class="text-center">
                                <div class="btn-group btn-group-sm" role="group">
                                    <button class="btn btn-outline-secondary" wire:click="decrement(<?php echo e($item['id']); ?>)">-</button>
                                    <span class="btn btn-outline-secondary disabled" style="min-width: 30px;"><?php echo e($item['quantity']); ?></span>
                                    <button class="btn btn-outline-secondary" wire:click="increment(<?php echo e($item['id']); ?>)">+</button>
                                </div>
                            </td>
                            <td data-label="Subtotal" class="text-end">Ksh <?php echo e(number_format($item['price'] * $item['quantity'], 2)); ?></td>
                            <td data-label="Actions" class="text-end">
                                <button class="btn btn-link text-danger p-0" wire:click="removeFromCart(<?php echo e($item['id']); ?>)"><i class="ri-delete-bin-line"></i></button>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-between align-items-center border-top pt-3 mb-3">
            <span class="fw-semibold">Total</span>
            <span class="h5 mb-0 text-success">Ksh <?php echo e(number_format($total, 2)); ?></span>
        </div>

        <!--[if BLOCK]><![endif]--><?php if($customerId): ?>
            <form method="POST" action="<?php echo e(route('pesapal.pay')); ?>" autocomplete="off" class="d-grid gap-2">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="amount" value="<?php echo e($total); ?>">
                <input type="hidden" name="customer_id" value="<?php echo e($customerId); ?>">
                <!--[if BLOCK]><![endif]--><?php if($customer): ?>
                    <input type="hidden" name="customer_name" value="<?php echo e($customer->name); ?>">
                    <input type="hidden" name="customer_email" value="<?php echo e($customer->email); ?>">
                    <input type="hidden" name="customer_phone" value="<?php echo e($customer->phone); ?>">
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                <button type="submit" class="btn btn-success">Checkout with Pesapal</button>
            </form>
        <?php else: ?>
            <div class="text-danger">Select a customer to checkout</div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
</div>
<?php /**PATH D:\School-Projects\Software-dev\Kessly\resources\views/livewire/pos/cart.blade.php ENDPATH**/ ?>