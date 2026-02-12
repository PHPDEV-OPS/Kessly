<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" 
      class="layout-menu-fixed layout-compact" 
      data-assets-path="<?php echo e(asset('/assets') . '/'); ?>" 
      dir="ltr" 
      data-skin="default" 
      data-base-url="<?php echo e(url('/')); ?>" 
      data-framework="laravel" 
      data-bs-theme="light" 
      data-template="vertical-menu-template">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>
        <?php echo e($title ?? config('app.name')); ?> | <?php echo e(config('variables.templateName', config('app.name'))); ?>

    </title>
    
    <meta name="description" content="<?php echo e(config('variables.templateDescription', config('app.name'))); ?>" />
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>" />
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?php echo e(asset('assets/img/favicon/favicon.ico')); ?>" />

    <!-- Include Styles -->
    <?php echo $__env->make('layouts/sections/styles', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <!-- Include Scripts for customizer, helper, analytics, config -->
    <?php echo $__env->make('layouts/sections/scriptsIncludes', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    
    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::styles(); ?>

</head>

<body>
    <?php
    /* Display elements */
    $contentNavbar = $contentNavbar ?? true;
    $containerNav = $containerNav ?? 'container-xxl';
    $isNavbar = $isNavbar ?? true;
    $isMenu = $isMenu ?? true;
    $isFlex = $isFlex ?? false;
    $isFooter = $isFooter ?? true;

    /* HTML Classes */
    $navbarDetached = 'navbar-detached';
    $menuFixed = true;
    $navbarType = $navbarType ?? 'navbar-detached';
    $footerFixed = false;
    $menuCollapsed = false;

    /* Content classes */
    $container = ($container ?? 'container-xxl');
    ?>

    <!-- Layout Wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">

            <!-- Menu -->
            <?php echo $__env->make('layouts/sections/menu/verticalMenu', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <!-- / Menu -->

            <!-- Layout Page -->
            <div class="layout-page">

                <!-- Navbar -->
                <?php echo $__env->make('layouts/sections/navbar/navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                <!-- / Navbar -->

                <!-- Content Wrapper -->
                <div class="content-wrapper">

                    <!-- Content -->
                    <div class="container-xxl flex-grow-1 container-p-y">
                        <?php echo e($slot); ?>

                    </div>
                    <!-- / Content -->

                    <!-- Footer -->
                    <?php echo $__env->make('layouts/sections/footer/footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    <!-- / Footer -->

                    <div class="content-backdrop fade"></div>
                </div>
                <!-- / Content Wrapper -->
            </div>
            <!-- / Layout Page -->
        </div>

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>

        <!-- Drag Target Area To SlideIn Menu On Small Screens -->
        <div class="drag-target"></div>
    </div>
    <!-- / Layout Wrapper -->

    <!-- Include Scripts -->
    <?php echo $__env->make('layouts/sections/scripts', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    
    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::scripts(); ?>

</body>
</html>
<?php /**PATH D:\School-Projects\Software-dev\Kessly\resources\views/components/layouts/app/sidebar.blade.php ENDPATH**/ ?>