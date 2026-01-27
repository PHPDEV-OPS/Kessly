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

<?php $__env->startSection('layoutContent'); ?>
<div class="layout-wrapper layout-content-navbar <?php echo e($isMenu ? '' : 'layout-without-menu'); ?>">
    <div class="layout-container">

        <!--[if BLOCK]><![endif]--><?php if($isMenu): ?>
        <?php echo $__env->make('layouts/sections/menu/verticalMenu', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

        <!-- Layout page -->
        <div class="layout-page">

            <!-- BEGIN: Navbar-->
            <!--[if BLOCK]><![endif]--><?php if($isNavbar): ?>
            <?php echo $__env->make('layouts/sections/navbar/navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            <!-- END: Navbar-->

            <!-- Content wrapper -->
            <div class="content-wrapper">

                <!-- Content -->
                <!--[if BLOCK]><![endif]--><?php if($isFlex): ?>
                <div class="<?php echo e($container); ?> d-flex align-items-stretch flex-grow-1 p-0">
                <?php else: ?>
                <div class="<?php echo e($container); ?> flex-grow-1 container-p-y">
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                    <!-- Page Heading -->
                    <!--[if BLOCK]><![endif]--><?php if(isset($header)): ?>
                        <div class="mb-4">
                            <?php echo e($header); ?>

                        </div>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                    <!-- Page Content / Livewire Component -->
                    <!--[if BLOCK]><![endif]--><?php if(isset($slot)): ?>
                        <?php echo e($slot); ?>

                    <?php else: ?>
                        <?php echo $__env->yieldContent('layoutContent'); ?>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                </div>
                <!-- / Content -->

                <!-- Footer -->
                <!--[if BLOCK]><![endif]--><?php if($isFooter): ?>
                <?php echo $__env->make('layouts/sections/footer/footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                <!-- / Footer -->
                
                <div class="content-backdrop fade"></div>
            </div>
            <!--/ Content wrapper -->
        </div>
        <!-- / Layout page -->
    </div>

    <!--[if BLOCK]><![endif]--><?php if($isMenu): ?>
    <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle" onclick="toggleMenu(event)"></div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    
    <!-- Drag Target Area To SlideIn Menu On Small Screens -->
    <div class="drag-target"></div>
</div>
<!-- / Layout wrapper -->
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts/commonMaster', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\School-Projects\Software-dev\Kessly\resources\views/layouts/app.blade.php ENDPATH**/ ?>