<?php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
?>

<!--  Brand demo (display only for navbar-full and hide on below xl) -->
<?php if(isset($navbarFull)): ?>
<div class="navbar-brand app-brand demo d-none d-xl-flex py-0 me-6">
    <a href="<?php echo e(url('/')); ?>" class="app-brand-link gap-2">
        <span class="app-brand-logo demo"><?php echo $__env->make('_partials.macros', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?></span>
        <span class="app-brand-text demo menu-text fw-bold"><?php echo e(config('variables.templateName')); ?></span>
    </a>
</div>
<?php endif; ?>

<!-- ! Not required for layout-without-menu -->
<?php if(!isset($navbarHideToggle)): ?>
<div class="layout-menu-toggle navbar-nav align-items-xl-center me-4 me-xl-0 <?php echo e(isset($contentNavbar) ? ' d-xl-none ' : ''); ?>">
    <a class="nav-item nav-link px-0 me-xl-6" href="javascript:void(0)" onclick="toggleMenu(event)">
        <i class="icon-base ri ri-menu-line icon-md"></i>
    </a>
</div>
<?php endif; ?>

<div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
    <!-- Search -->
    <div class="navbar-nav align-items-center">
        <div class="nav-item d-flex align-items-center position-relative">
            <i class="icon-base ri ri-search-line icon-lg lh-0 me-2"></i>
            <input 
                type="text" 
                id="globalSearch" 
                class="form-control border-0 shadow-none ps-0" 
                placeholder="Search products, customers, orders..." 
                aria-label="Search..."
                autocomplete="off"
                style="min-width: 200px;"
            >
            <!-- Search Results Dropdown -->
            <div id="searchResults" class="dropdown-menu shadow-lg border-0" style="display: none; position: fixed; min-width: 450px; max-height: 600px; overflow-y: auto; z-index: 9999; margin-top: 0.5rem;">
                <div id="searchContent"></div>
            </div>
        </div>
    </div>
    <!-- /Search -->
    <ul class="navbar-nav flex-row align-items-center ms-auto">
        <!-- User -->
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle hide-arrow p-0" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <div class="avatar avatar-online">
                    <img src="<?php echo e(Auth::user()->profile_photo_path ? asset('storage/' . Auth::user()->profile_photo_path) : asset('assets/img/avatars/1.png')); ?>" alt="<?php echo e(Auth::user()->name); ?>" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;" />
                </div>
            </a>
            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown" style="min-width: 280px;">
                <a class="dropdown-item py-3" href="<?php echo e(route('profile')); ?>" wire:navigate>
                    <div class="d-flex">
                        <div class="flex-shrink-0 me-3">
                            <div class="avatar avatar-online">
                                <img src="<?php echo e(Auth::user()->profile_photo_path ? asset('storage/' . Auth::user()->profile_photo_path) : asset('assets/img/avatars/1.png')); ?>" alt="<?php echo e(Auth::user()->name); ?>" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;" />
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="mb-0"><?php echo e(Auth::user()->name); ?></h6>
                            <small class="text-muted"><?php echo e(Auth::user()->email); ?></small>
                        </div>
                    </div>
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item py-2" href="<?php echo e(route('profile')); ?>" wire:navigate>
                    <i class="ri-user-3-line me-2"></i>
                    <span>My Profile</span>
                </a>
                <a class="dropdown-item py-2" href="<?php echo e(route('settings')); ?>" wire:navigate>
                    <i class="ri-settings-4-line me-2"></i>
                    <span>Settings</span>
                </a>
                <div class="dropdown-divider"></div>
                <div class="px-3 py-2">
                    <form method="POST" action="<?php echo e(route('logout')); ?>">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="btn btn-sm btn-danger d-flex align-items-center justify-content-center w-100">
                            <i class="ri-logout-box-r-line me-2"></i>
                            <span>Logout</span>
                        </button>
                    </form>
                </div>
            </div>
        </li>
        <!--/ User -->
    </ul>
</div><?php /**PATH D:\School-Projects\Software-dev\Kessly\resources\views\layouts\sections\navbar\navbar-partial.blade.php ENDPATH**/ ?>