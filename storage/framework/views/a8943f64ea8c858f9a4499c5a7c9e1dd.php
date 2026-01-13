<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" class="dark">
    <head>
        <?php echo $__env->make('partials.head', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </head>
    <body class="min-h-screen bg-neutral-100 antialiased">
        <div class="bg-muted flex min-h-svh flex-col items-center justify-center gap-6 p-6 md:p-10">
            <div class="flex w-full max-w-md flex-col gap-6">
                <a href="<?php echo e(route('home')); ?>" class="flex flex-col items-center gap-2 font-medium" wire:navigate>
                    <?php
                        $companyLogo = \App\Models\Setting::getCompanyLogo();
                        $companyName = \App\Models\Setting::getCompanyName();
                    ?>
                    
                    <span class="flex h-9 w-9 items-center justify-center rounded-md <?php echo e($companyLogo ? 'bg-white border border-gray-200' : ''); ?>">
                        <?php if($companyLogo): ?>
                            <img src="<?php echo e($companyLogo); ?>" alt="<?php echo e($companyName); ?> Logo" class="size-8 object-contain rounded">
                        <?php else: ?>
                            <?php if (isset($component)) { $__componentOriginal159d6670770cb479b1921cea6416c26c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal159d6670770cb479b1921cea6416c26c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.app-logo-icon','data' => ['class' => 'size-9 fill-current text-black']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-logo-icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'size-9 fill-current text-black']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal159d6670770cb479b1921cea6416c26c)): ?>
<?php $attributes = $__attributesOriginal159d6670770cb479b1921cea6416c26c; ?>
<?php unset($__attributesOriginal159d6670770cb479b1921cea6416c26c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal159d6670770cb479b1921cea6416c26c)): ?>
<?php $component = $__componentOriginal159d6670770cb479b1921cea6416c26c; ?>
<?php unset($__componentOriginal159d6670770cb479b1921cea6416c26c); ?>
<?php endif; ?>
                        <?php endif; ?>
                    </span>

                    <span class="sr-only"><?php echo e($companyName); ?></span>
                </a>

                <div class="flex flex-col gap-6">
                    <div class="rounded-xl border bg-white text-stone-800 shadow-xs">
                        <div class="px-10 py-8"><?php echo e($slot); ?></div>
                    </div>
                </div>
            </div>
        </div>
        <?php app('livewire')->forceAssetInjection(); ?>
<?php echo app('flux')->scripts(); ?>

    </body>
</html>
<?php /**PATH D:\School-Projects\Software-dev\Kessly\resources\views\components\layouts\auth\card.blade.php ENDPATH**/ ?>