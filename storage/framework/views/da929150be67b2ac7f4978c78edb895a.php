<div>
    <h5 class="mb-3">Cart</h5>
    <!--[if BLOCK]><![endif]--><?php if($order): ?>
        <div class="alert alert-success">
            <h6>Order Complete!</h6>
            <div>Order #: <strong><?php echo e($order->id); ?></strong></div>
            <div>Total: <strong>Ksh <?php echo e(number_format($order->total_amount, 2)); ?></strong></div>
        </div>
    <?php elseif(empty($cart)): ?>
        <div class="alert alert-info">Your cart is empty.</div>
    <?php else: ?>
        <div class="mb-3">
            <h6>Customer Details</h6>
            <?php
                $customer = $customerId ? \App\Models\Customer::find($customerId) : null;
            ?>
            <!--[if BLOCK]><![endif]--><?php if($customer): ?>
                <div class="border rounded p-2 mb-2">
                    <div><strong>Name:</strong> <?php echo e($customer->name); ?></div>
                    <div><strong>Email:</strong> <?php echo e($customer->email); ?></div>
                    <div><strong>Phone:</strong> <?php echo e($customer->phone); ?></div>
                </div>
            <?php else: ?>
                <div class="text-danger">No customer selected.</div>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        </div>
        <table class="table table-bordered align-middle">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Qty</th>
                    <th>Subtotal</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $cart; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($item['name']); ?></td>
                        <td>Ksh <?php echo e(number_format($item['price'], 2)); ?></td>
                        <td>
                            <button class="btn btn-sm btn-light" wire:click="decrement(<?php echo e($item['id']); ?>)">-</button>
                            <span class="mx-2"><?php echo e($item['quantity']); ?></span>
                            <button class="btn btn-sm btn-light" wire:click="increment(<?php echo e($item['id']); ?>)">+</button>
                        </td>
                        <td>Ksh <?php echo e(number_format($item['price'] * $item['quantity'], 2)); ?></td>
                        <td>
                            <button class="btn btn-danger btn-sm" wire:click="removeFromCart(<?php echo e($item['id']); ?>)">Remove</button>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
            </tbody>
        </table>
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h6>Total: <span class="text-success">Ksh <?php echo e(number_format($total, 2)); ?></span></h6>
        </div>
        <!--[if BLOCK]><![endif]--><?php if($customerId): ?>
            <form method="POST" action="<?php echo e(route('pesapal.pay')); ?>" autocomplete="off">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="amount" value="<?php echo e($total); ?>">
                <input type="hidden" name="customer_id" value="<?php echo e($customerId); ?>">
                <!--[if BLOCK]><![endif]--><?php if($customer): ?>
                    <input type="hidden" name="customer_name" value="<?php echo e($customer->name); ?>">
                    <input type="hidden" name="customer_email" value="<?php echo e($customer->email); ?>">
                    <input type="hidden" name="customer_phone" value="<?php echo e($customer->phone); ?>">
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                <button type="submit" class="btn btn-success w-100">Checkout with Pesapal</button>
            </form>
        <?php else: ?>
            <span class="text-danger">Select a customer to checkout</span>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
</div>
<?php /**PATH D:\School-Projects\Software-dev\Kessly\resources\views/livewire/pos/cart.blade.php ENDPATH**/ ?>