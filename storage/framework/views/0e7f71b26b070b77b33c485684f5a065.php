<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;

?>

<div>
    <!-- Enhanced Header with Gradient -->
    <div class="card mb-4 border-0 shadow-sm">
        <div class="card-body p-0">
            <!-- Gradient Header -->
            <div class="p-3 p-md-4 bg-gradient-primary text-white rounded-top" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
                    <div>
                        <h4 class="mb-1 fw-bold text-white">
                            <i class='bx bx-cog me-2'></i>Settings
                        </h4>
                        <p class="mb-0 text-white opacity-90 small d-none d-sm-block">Configure your system preferences and company information</p>
                    </div>
                    <div>
                        <div class="badge bg-white text-primary px-2 px-md-3 py-2">
                            <i class='bx bx-time-five me-1'></i>
                            <span class="d-none d-sm-inline">Last Updated: </span><?php echo e(now()->format('M d, Y')); ?>

                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab Navigation -->
            <div class="border-bottom overflow-auto">
                <ul class="nav nav-pills px-3 px-md-4 pt-3 flex-nowrap" style="gap: 0.5rem;">
                    <li class="nav-item">
                        <button wire:click="setActiveTab('company')" 
                            class="nav-link <?php echo e($activeTab === 'company' ? 'active' : ''); ?> text-nowrap"
                            style="<?php echo e($activeTab === 'company' ? 'background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);' : ''); ?>">
                            <i class='bx bx-buildings me-1'></i>
                            <span class="d-none d-md-inline">Company </span>Profile
                        </button>
                    </li>
                    <li class="nav-item">
                        <button wire:click="setActiveTab('system')" 
                            class="nav-link <?php echo e($activeTab === 'system' ? 'active' : ''); ?> text-nowrap"
                            style="<?php echo e($activeTab === 'system' ? 'background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);' : ''); ?>">
                            <i class='bx bx-cog me-1'></i>
                            <span class="d-none d-md-inline">System </span>Config
                        </button>
                    </li>
                    <li class="nav-item">
                        <button wire:click="setActiveTab('users')" 
                            class="nav-link <?php echo e($activeTab === 'users' ? 'active' : ''); ?> text-nowrap"
                            style="<?php echo e($activeTab === 'users' ? 'background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);' : ''); ?>">
                            <i class='bx bx-user me-1'></i>
                            <span class="d-none d-md-inline">Users & </span>Roles
                        </button>
                    </li>
                    <li class="nav-item">
                        <button wire:click="setActiveTab('security')" 
                            class="nav-link <?php echo e($activeTab === 'security' ? 'active' : ''); ?> text-nowrap"
                            style="<?php echo e($activeTab === 'security' ? 'background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);' : ''); ?>">
                            <i class='bx bx-shield me-1'></i>
                            Security
                        </button>
                    </li>
                    <li class="nav-item">
                        <button wire:click="setActiveTab('email')" 
                            class="nav-link <?php echo e($activeTab === 'email' ? 'active' : ''); ?> text-nowrap"
                            style="<?php echo e($activeTab === 'email' ? 'background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);' : ''); ?>">
                            <i class='bx bx-envelope me-1'></i>
                            <span class="d-none d-lg-inline">Email & </span>Notifications
                        </button>
                    </li>
                    <li class="nav-item">
                        <button wire:click="setActiveTab('business')" 
                            class="nav-link <?php echo e($activeTab === 'business' ? 'active' : ''); ?> text-nowrap"
                            style="<?php echo e($activeTab === 'business' ? 'background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);' : ''); ?>">
                            <i class='bx bx-briefcase me-1'></i>
                            <span class="d-none d-lg-inline">Business </span>Rules
                        </button>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Tab Content -->
    <div class="tab-content">
        <!-- Company Profile Tab -->
        <div class="tab-pane fade <?php echo e($activeTab === 'company' ? 'show active' : ''); ?>">
            <?php if($activeTab === 'company'): ?>
                <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('settings.company-profile', []);

$__html = app('livewire')->mount($__name, $__params, 'lw-2432901930-6', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
            <?php endif; ?>
        </div>

        <!-- System Configuration Tab -->
        <div class="tab-pane fade <?php echo e($activeTab === 'system' ? 'show active' : ''); ?>">
            <?php if($activeTab === 'system'): ?>
                <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('settings.system-configuration', []);

$__html = app('livewire')->mount($__name, $__params, 'lw-2432901930-7', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
            <?php endif; ?>
        </div>

        <!-- Users & Roles Tab -->
        <div class="tab-pane fade <?php echo e($activeTab === 'users' ? 'show active' : ''); ?>">
            <?php if($activeTab === 'users'): ?>
                <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('settings.users', []);

$__html = app('livewire')->mount($__name, $__params, 'lw-2432901930-8', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
            <?php endif; ?>
        </div>

        <!-- Security Tab -->
        <div class="tab-pane fade <?php echo e($activeTab === 'security' ? 'show active' : ''); ?>">
            <?php if($activeTab === 'security'): ?>
                <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('settings.security-settings', []);

$__html = app('livewire')->mount($__name, $__params, 'lw-2432901930-9', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
            <?php endif; ?>
        </div>

        <!-- Email & Notifications Tab -->
        <div class="tab-pane fade <?php echo e($activeTab === 'email' ? 'show active' : ''); ?>">
            <?php if($activeTab === 'email'): ?>
                <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('settings.email-notifications', []);

$__html = app('livewire')->mount($__name, $__params, 'lw-2432901930-10', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
            <?php endif; ?>
        </div>

        <!-- Business Rules Tab -->
        <div class="tab-pane fade <?php echo e($activeTab === 'business' ? 'show active' : ''); ?>">
            <?php if($activeTab === 'business'): ?>
                <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('settings.business-rules', []);

$__html = app('livewire')->mount($__name, $__params, 'lw-2432901930-11', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
            <?php endif; ?>
        </div>
    </div>
</div><?php /**PATH D:\School-Projects\Software-dev\Kessly\resources\views\livewire\pages\settings.blade.php ENDPATH**/ ?>