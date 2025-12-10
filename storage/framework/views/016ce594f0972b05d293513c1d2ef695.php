<div <?php echo e($attributes->merge(['class' => 'flex flex-col items-center justify-center py-12 px-4 text-center'])); ?>>
    <div class="w-16 h-16 <?php echo e($iconColor ?? 'text-gray-400'); ?> mb-4">
        <?php echo $icon ?? '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>'; ?>

    </div>
    <h3 class="text-lg font-medium text-gray-900 mb-1"><?php echo e($title ?? 'No items found'); ?></h3>
    <p class="text-sm text-gray-500 mb-4"><?php echo e($description ?? 'Get started by adding your first item.'); ?></p>
    <?php if(isset($action)): ?>
        <button <?php echo e($action->attributes->merge(['class' => 'btn-primary'])); ?>>
            <?php echo e($action->text ?? 'Add Item'); ?>

        </button>
    <?php endif; ?>
</div><?php /**PATH D:\School-Projects\Software-dev\Kessly\resources\views\components\empty-state.blade.php ENDPATH**/ ?>