<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'title' => 'Page Title',
    'description' => '',
    'showBack' => true,
    'breadcrumbs' => []
]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter(([
    'title' => 'Page Title',
    'description' => '',
    'showBack' => true,
    'breadcrumbs' => []
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<div class="sticky top-0 z-50 bg-white/95 dark:bg-gray-800/95 backdrop-blur-sm border-b border-gray-200 dark:border-gray-700 shadow-sm">
    <div class="px-4 sm:px-6 lg:px-8 py-4">
        <div class="flex items-center justify-between">
            <!-- Left Section: Navigation & Title -->
            <div class="flex items-center space-x-4">
                <?php if($showBack): ?>
                    <!-- Back Button -->
                    <button 
                        onclick="window.history.back()" 
                        class="inline-flex items-center justify-center w-10 h-10 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-full transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                        title="Go back"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </button>
                <?php endif; ?>

                <!-- Title Section -->
                <div class="flex flex-col">
                    <?php if(count($breadcrumbs) > 0): ?>
                        <!-- Breadcrumbs -->
                        <nav class="flex items-center space-x-2 text-sm text-gray-500 dark:text-gray-400 mb-1">
                            <a href="<?php echo e(route('dashboard')); ?>" wire:navigate class="hover:text-gray-700 dark:hover:text-gray-200 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5v4l2-2 2 2V5"/>
                                </svg>
                            </a>
                            <?php $__currentLoopData = $breadcrumbs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $breadcrumb): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <svg class="w-4 h-4 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                                <?php if(isset($breadcrumb['url'])): ?>
                                    <a href="<?php echo e($breadcrumb['url']); ?>" wire:navigate class="hover:text-gray-700 dark:hover:text-gray-200 transition-colors">
                                        <?php echo e($breadcrumb['title']); ?>

                                    </a>
                                <?php else: ?>
                                    <span class="text-gray-700 dark:text-gray-300 font-medium"><?php echo e($breadcrumb['title']); ?></span>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </nav>
                    <?php endif; ?>

                    <!-- Page Title -->
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-gray-100">
                        <?php echo e($title); ?>

                    </h1>
                    
                    <?php if($description): ?>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400"><?php echo e($description); ?></p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Right Section: Actions -->
            <div class="flex items-center space-x-4">
                <!-- Sidebar Toggle for Mobile -->
                <?php if (isset($component)) { $__componentOriginal1b6467b07b302021134396bbd98e74a9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1b6467b07b302021134396bbd98e74a9 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::sidebar.toggle','data' => ['class' => 'lg:hidden text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg p-2 transition-colors','icon' => 'bars-3']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::sidebar.toggle'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'lg:hidden text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg p-2 transition-colors','icon' => 'bars-3']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1b6467b07b302021134396bbd98e74a9)): ?>
<?php $attributes = $__attributesOriginal1b6467b07b302021134396bbd98e74a9; ?>
<?php unset($__attributesOriginal1b6467b07b302021134396bbd98e74a9); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1b6467b07b302021134396bbd98e74a9)): ?>
<?php $component = $__componentOriginal1b6467b07b302021134396bbd98e74a9; ?>
<?php unset($__componentOriginal1b6467b07b302021134396bbd98e74a9); ?>
<?php endif; ?>
                
                <!-- Desktop App Navigation Buttons -->
                <div class="hidden sm:flex items-center space-x-2">
                    <!-- Forward/Back Browser-style buttons -->
                    <button 
                        onclick="window.history.back()" 
                        class="inline-flex items-center justify-center w-8 h-8 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md transition-colors duration-200"
                        title="Go back"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </button>
                    <button 
                        onclick="window.history.forward()" 
                        class="inline-flex items-center justify-center w-8 h-8 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md transition-colors duration-200"
                        title="Go forward"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </button>
                    <button 
                        onclick="window.location.reload()" 
                        class="inline-flex items-center justify-center w-8 h-8 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md transition-colors duration-200"
                        title="Refresh page"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                    </button>
                </div>

                <!-- Quick Actions Slot -->
                <?php echo e($slot ?? ''); ?>

            </div>
        </div>
    </div>
</div><?php /**PATH D:\School-Projects\Software-dev\Kessly\resources\views\components\page-navigation.blade.php ENDPATH**/ ?>