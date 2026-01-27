<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;

?>

<div>
    <!-- Statistics Cards -->
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar me-3">
                            <span class="avatar-initial rounded-circle bg-label-primary">
                                <i class="ri-team-line ri-22px"></i>
                            </span>
                        </div>
                        <div>
                            <div class="text-muted small">Total Employees</div>
                            <h5 class="mb-0"><?php echo e(\App\Models\Employee::count()); ?></h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar me-3">
                            <span class="avatar-initial rounded-circle bg-label-success">
                                <i class="ri-user-follow-line ri-22px"></i>
                            </span>
                        </div>
                        <div>
                            <div class="text-muted small">Active</div>
                            <h5 class="mb-0 text-success"><?php echo e(\App\Models\Employee::active()->count()); ?></h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar me-3">
                            <span class="avatar-initial rounded-circle bg-label-info">
                                <i class="ri-calendar-check-line ri-22px"></i>
                            </span>
                        </div>
                        <div>
                            <div class="text-muted small">Present Today</div>
                            <h5 class="mb-0"><?php echo e(\App\Models\Attendance::whereDate('date', today())->where('status', 'present')->count()); ?></h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar me-3">
                            <span class="avatar-initial rounded-circle bg-label-warning">
                                <i class="ri-money-dollar-circle-line ri-22px"></i>
                            </span>
                        </div>
                        <div>
                            <div class="text-muted small">Payroll This Month</div>
                            <h5 class="mb-0"><?php echo e(\App\Models\Payroll::whereMonth('period', now()->month)->count()); ?></h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tab Navigation Card -->
    <div class="card">
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
                <button wire:click.prevent="setActiveTab('employees')" 
                        class="nav-link <?php echo e($activeTab === 'employees' ? 'active' : ''); ?>" 
                        type="button">
                    <i class="ri-team-line me-2"></i>
                    Employees
                </button>
            </li>
            <li class="nav-item">
                <button wire:click.prevent="setActiveTab('attendance')" 
                        class="nav-link <?php echo e($activeTab === 'attendance' ? 'active' : ''); ?>" 
                        type="button">
                    <i class="ri-calendar-check-line me-2"></i>
                    Attendance
                </button>
            </li>
            <li class="nav-item">
                <button wire:click.prevent="setActiveTab('leave')" 
                        class="nav-link <?php echo e($activeTab === 'leave' ? 'active' : ''); ?>" 
                        type="button">
                    <i class="ri-time-line me-2"></i>
                    Leave Management
                </button>
            </li>
        </ul>

        <!-- Tab Content -->
        <div class="card-body">
            <!--[if BLOCK]><![endif]--><?php if($activeTab === 'employees'): ?>
                <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('hr.employees', []);

$__html = app('livewire')->mount($__name, $__params, 'lw-2469759441-0', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
            <?php elseif($activeTab === 'attendance'): ?>
                <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('hr.attendance-management', []);

$__html = app('livewire')->mount($__name, $__params, 'lw-2469759441-1', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
            <?php elseif($activeTab === 'leave'): ?>
                <div class="text-center py-5">
                    <div class="avatar avatar-xl mx-auto mb-3">
                        <span class="avatar-initial rounded-circle bg-label-warning">
                            <i class="ri-time-line ri-48px"></i>
                        </span>
                    </div>
                    <h5 class="mb-2">Leave Management</h5>
                    <p class="text-muted mb-0">Manage employee leave requests and approvals.</p>
                </div>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        </div>
    </div>
</div><?php /**PATH D:\School-Projects\Software-dev\Kessly\resources\views\livewire/pages/hr.blade.php ENDPATH**/ ?>