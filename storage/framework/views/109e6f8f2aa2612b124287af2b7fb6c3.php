

<?php $__env->startSection('content'); ?>
    <div class="container py-5 text-center">
        <h2>Payment Status</h2>
        <?php if(isset($status)): ?>
            <?php if($status === 'COMPLETED'): ?>
                <div class="alert alert-success">Payment successful and verified!</div>
            <?php elseif($status === 'FAILED'): ?>
                <div class="alert alert-danger">Payment failed. Please try again.</div>
            <?php else: ?>
                <div class="alert alert-warning">Payment status: <?php echo e($status); ?></div>
            <?php endif; ?>
        <?php else: ?>
            <div class="alert alert-secondary">Payment status could not be verified.</div>
        <?php endif; ?>

        <?php if(!empty($details) && is_array($details)): ?>
            <div class="mt-3 text-start d-inline-block">
                <h6>Details</h6>
                <ul class="list-unstyled mb-0">
                    <?php $__currentLoopData = $details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><strong><?php echo e(ucfirst(str_replace('_', ' ', $key))); ?>:</strong> <?php echo e(is_array($value) ? json_encode($value) : $value); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>
        <a href="/pos" class="btn btn-primary mt-3">Back to POS</a>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\School-Projects\Software-dev\Kessly\resources\views/sales/payment-complete.blade.php ENDPATH**/ ?>