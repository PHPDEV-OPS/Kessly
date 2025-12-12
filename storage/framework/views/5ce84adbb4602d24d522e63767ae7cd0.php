<?php
use Illuminate\Support\Facades\Route;
?>
<aside id="layout-menu" class="layout-menu menu-vertical menu">

    <!-- ! Hide app brand if navbar-full -->
    <div class="app-brand demo">
        <a href="<?php echo e(url('/')); ?>" class="app-brand-link" wire:navigate>
            <span class="app-brand-logo demo me-1"><?php echo $__env->make('_partials.macros', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?></span>
            <span class="app-brand-text demo menu-text fw-semibold ms-2"><?php echo e(config('variables.templateName')); ?></span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="menu-toggle-icon d-xl-inline-block align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <?php $__currentLoopData = $menuData[0]->menu; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

        

        
        <?php if(isset($menu->menuHeader)): ?>
        <li class="menu-header mt-7">
            <span class="menu-header-text"><?php echo e(__($menu->menuHeader)); ?></span>
        </li>
        <?php else: ?>

        
        <?php
        $activeClass = null;
        $currentRouteName = Route::currentRouteName();

        if ($currentRouteName === $menu->slug) {
        $activeClass = 'active';
        }
        elseif (isset($menu->submenu)) {
        if (gettype($menu->slug) === 'array') {
        foreach($menu->slug as $slug){
        if (str_contains($currentRouteName,$slug) and strpos($currentRouteName,$slug) === 0) {
        $activeClass = 'active open';
        }
        }
        }
        else{
        if (str_contains($currentRouteName,$menu->slug) and strpos($currentRouteName,$menu->slug) === 0) {
        $activeClass = 'active open';
        }
        }
        }
        ?>

        
        <li class="menu-item <?php echo e($activeClass); ?>">
            <a href="<?php echo e(isset($menu->url) ? url($menu->url) : 'javascript:void(0);'); ?>" 
               class="<?php echo e(isset($menu->submenu) ? 'menu-link menu-toggle' : 'menu-link'); ?>" 
               <?php if(isset($menu->target) and !empty($menu->target)): ?> target="_blank" <?php endif; ?>
               <?php if(isset($menu->submenu)): ?> onclick="toggleSubmenu(event, this)" <?php endif; ?>
               <?php if(isset($menu->url) && !isset($menu->submenu)): ?> wire:navigate <?php endif; ?>>
                <?php if(isset($menu->icon)): ?>
                <i class="<?php echo e($menu->icon); ?>"></i>
                <?php endif; ?>
                <div><?php echo e(isset($menu->name) ? __($menu->name) : ''); ?></div>
                <?php if(isset($menu->badge)): ?>
                <div class="badge rounded-pill bg-<?php echo e($menu->badge[0]); ?> rounded-pill ms-auto"><?php echo e($menu->badge[1]); ?></div>
                <?php endif; ?>
            </a>

            
            <?php if(isset($menu->submenu)): ?>
            <?php echo $__env->make('layouts.sections.menu.submenu',['menu' => $menu->submenu], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <?php endif; ?>
        </li>
        <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        
        
        <li class="menu-item">
            <form method="POST" action="<?php echo e(route('logout')); ?>" class="m-0">
                <?php echo csrf_field(); ?>
                <button type="submit" class="menu-link w-100 text-start border-0 bg-transparent">
                    <i class="menu-icon icon-base ri ri-logout-box-r-line text-danger"></i>
                    <div class="text-danger">Logout</div>
                </button>
            </form>
        </li>
    </ul>

</aside>
<?php /**PATH D:\School-Projects\Software-dev\Kessly\resources\views/layouts/sections/menu/verticalMenu.blade.php ENDPATH**/ ?>