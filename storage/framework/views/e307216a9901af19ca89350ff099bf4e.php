<div>
    <!--[if BLOCK]><![endif]--><?php if(session()->has('message')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo e(session('message')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

    <!-- Search and Filter Section -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row g-3 align-items-end">
                <div class="col-md-4">
                    <input type="text" wire:model.live="search" placeholder="Search employees..." class="form-control">
                </div>
                <div class="col-md-2">
                    <select wire:model.live="department" class="form-select">
                        <option value="">All Departments</option>
                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dept): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($dept); ?>"><?php echo e($dept); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                    </select>
                </div>
                <div class="col-md-2">
                    <select wire:model.live="employment_status" class="form-select">
                        <option value="">All Status</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                        <option value="terminated">Terminated</option>
                    </select>
                </div>
                <div class="col-md-4 text-end">
                    <button wire:click.prevent="create" type="button" class="btn btn-primary">
                        <i class="ri-add-line me-1"></i>
                        Add Employee
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Employees Table -->
    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>
                            <button type="button" class="btn btn-sm btn-link text-decoration-none p-0 text-muted" wire:click="sortBy('employee_id')">
                                Employee ID
                                <!--[if BLOCK]><![endif]--><?php if($sortField === 'employee_id'): ?>
                                    <i class="ri-arrow-<?php echo e($sortDirection === 'asc' ? 'up' : 'down'); ?>-s-line"></i>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </button>
                        </th>
                        <th>Employee</th>
                        <th>Department</th>
                        <th>Position</th>
                        <th>Branch</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!--[if BLOCK]><![endif]--><?php $__empty_1 = true; $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td class="fw-medium"><?php echo e($employee->employee_id); ?></td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar avatar-sm me-3">
                                        <span class="avatar-initial rounded-circle bg-label-primary">
                                            <?php echo e($employee->user ? strtoupper(substr($employee->user->name, 0, 2)) : 'NA'); ?>

                                        </span>
                                    </div>
                                    <div>
                                        <div class="fw-medium"><?php echo e($employee->user ? $employee->user->name : 'N/A'); ?></div>
                                        <small class="text-muted"><?php echo e($employee->user ? $employee->user->email : 'N/A'); ?></small>
                                    </div>
                                </div>
                            </td>
                            <td><?php echo e($employee->department); ?></td>
                            <td><?php echo e($employee->position); ?></td>
                            <td><?php echo e($employee->branch ? $employee->branch->name : 'N/A'); ?></td>
                            <td>
                                <span class="badge bg-label-<?php echo e($employee->employment_status === 'active' ? 'success' : ($employee->employment_status === 'inactive' ? 'warning' : 'danger')); ?>">
                                    <?php echo e(ucfirst($employee->employment_status)); ?>

                                </span>
                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                    <button wire:click.prevent="view(<?php echo e($employee->id); ?>)" class="btn btn-sm btn-icon btn-label-info" title="View Details">
                                        <i class="ri-eye-line"></i>
                                    </button>
                                    <button wire:click.prevent="edit(<?php echo e($employee->id); ?>)" class="btn btn-sm btn-icon btn-label-primary" title="Edit">
                                        <i class="ri-edit-line"></i>
                                    </button>
                                    <button wire:click.prevent="delete(<?php echo e($employee->id); ?>)" 
                                            onclick="return confirm('Are you sure you want to delete this employee?')"
                                            class="btn btn-sm btn-icon btn-label-danger" title="Delete">
                                        <i class="ri-delete-bin-line"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                No employees found.
                            </td>
                        </tr>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <!--[if BLOCK]><![endif]--><?php if($employees->hasPages()): ?>
            <div class="card-footer border-top">
                <?php echo e($employees->links('pagination::bootstrap-5')); ?>

            </div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    </div>

    <style>
        .pagination .page-link svg {
            display: none;
        }
        .pagination .page-link {
            padding: 0.375rem 0.75rem;
        }
    </style>

    <!-- Modal for Add/Edit Employee -->
    <!--[if BLOCK]><![endif]--><?php if($showModal): ?>
        <div class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0,0,0,0.5);" wire:click.self="closeModal">
            <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable" wire:click.stop>
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="ri-<?php echo e($editing ? 'edit' : 'add'); ?>-line me-2"></i>
                            <?php echo e($editing ? 'Edit Employee' : 'Add New Employee'); ?>

                        </h5>
                        <button type="button" class="btn-close" wire:click.prevent="closeModal"></button>
                    </div>
                    
                    <form wire:submit.prevent="save">
                        <div class="modal-body">
                            <div class="row g-4">
                                <div class="col-12 col-md-6">
                                    <label class="form-label fw-medium">Employee ID</label>
                                    <input type="text" wire:model="employee_id" class="form-control <?php $__errorArgs = ['employee_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['employee_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                                </div>

                                <div class="col-12 col-md-6">
                                    <label class="form-label fw-medium">User Account</label>
                                    <div class="mb-3">
                                        <div class="form-check">
                                            <input type="checkbox" wire:model.live="create_user" class="form-check-input" id="create_user">
                                            <label class="form-check-label" for="create_user">
                                                Create new user account
                                            </label>
                                        </div>
                                    </div>

                                    <!--[if BLOCK]><![endif]--><?php if($create_user): ?>
                                        <div class="border rounded p-3 bg-light">
                                            <h6 class="mb-3">New User Details</h6>
                                            <div class="row g-3">
                                                <div class="col-12">
                                                    <label class="form-label">Name <span class="text-danger">*</span></label>
                                                    <input type="text" wire:model="user_name" class="form-control <?php $__errorArgs = ['user_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="Full Name">
                                                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['user_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <label class="form-label">Email <span class="text-danger">*</span></label>
                                                    <input type="email" wire:model="user_email" class="form-control <?php $__errorArgs = ['user_email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="user@example.com">
                                                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['user_email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <label class="form-label">Role <span class="text-danger">*</span></label>
                                                    <select wire:model="user_role_id" class="form-select <?php $__errorArgs = ['user_role_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                                        <option value="">Select Role</option>
                                                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($role->id); ?>"><?php echo e($role->name); ?></option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                                    </select>
                                                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['user_role_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                                                </div>
                                                <div class="col-12">
                                                    <label class="form-label">Password <span class="text-danger">*</span></label>
                                                    <input type="password" wire:model="user_password" class="form-control <?php $__errorArgs = ['user_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="••••••••">
                                                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['user_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                                                    <small class="text-muted">Minimum 8 characters</small>
                                                </div>
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <select wire:model="user_id" class="form-select <?php $__errorArgs = ['user_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                            <option value="">Select Existing User</option>
                                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($user->id); ?>"><?php echo e($user->name); ?> (<?php echo e($user->email); ?>)</option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                        </select>
                                        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['user_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                </div>

                                <div class="col-12 col-md-6">
                                    <label class="form-label fw-medium">Branch</label>
                                    <select wire:model="branch_id" class="form-select <?php $__errorArgs = ['branch_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                        <option value="">Select Branch</option>
                                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($branch->id); ?>"><?php echo e($branch->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                    </select>
                                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['branch_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                                </div>

                                <div class="col-12 col-md-6">
                                    <label class="form-label fw-medium">Department</label>
                                    <input type="text" wire:model="department_name" class="form-control <?php $__errorArgs = ['department_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['department_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                                </div>

                                <div class="col-12 col-md-6">
                                    <label class="form-label fw-medium">Position</label>
                                    <input type="text" wire:model="position" class="form-control <?php $__errorArgs = ['position'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['position'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                                </div>

                                <div class="col-12 col-md-6">
                                    <label class="form-label fw-medium">Hire Date</label>
                                    <input type="date" wire:model="hire_date" class="form-control <?php $__errorArgs = ['hire_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['hire_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                                </div>

                                <div class="col-12 col-md-6">
                                    <label class="form-label fw-medium">Salary</label>
                                    <div class="input-group">
                                        <span class="input-group-text">$</span>
                                        <input type="number" step="0.01" wire:model="salary" class="form-control <?php $__errorArgs = ['salary'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['salary'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                                    </div>
                                </div>

                                <div class="col-12 col-md-6">
                                    <label class="form-label fw-medium">Status</label>
                                    <select wire:model="status" class="form-select <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                        <option value="active">Active</option>
                                        <option value="inactive">Inactive</option>
                                        <option value="terminated">Terminated</option>
                                    </select>
                                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                                </div>

                                <div class="col-12">
                                    <label class="form-label fw-medium">Manager</label>
                                    <select wire:model="manager_id" class="form-select <?php $__errorArgs = ['manager_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                        <option value="">Select Manager (Optional)</option>
                                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $managers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $manager): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($manager->id); ?>"><?php echo e($manager->user ? $manager->user->name : 'N/A'); ?> - <?php echo e($manager->position); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                    </select>
                                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['manager_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                                </div>

                                <div class="col-12 col-md-6">
                                    <label class="form-label fw-medium">Phone</label>
                                    <input type="text" wire:model="phone" class="form-control <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                                </div>

                                <div class="col-12 col-md-6">
                                    <label class="form-label fw-medium">Emergency Contact</label>
                                    <input type="text" wire:model="emergency_contact" class="form-control <?php $__errorArgs = ['emergency_contact'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['emergency_contact'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                                </div>

                                <div class="col-12 col-md-6">
                                    <label class="form-label fw-medium">Emergency Phone</label>
                                    <input type="text" wire:model="emergency_phone" class="form-control <?php $__errorArgs = ['emergency_phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['emergency_phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                                </div>

                                <div class="col-12">
                                    <label class="form-label fw-medium">Address</label>
                                    <textarea wire:model="address" rows="2" class="form-control <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"></textarea>
                                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                                </div>

                                <div class="col-12">
                                    <label class="form-label fw-medium">Notes</label>
                                    <textarea wire:model="notes" rows="2" class="form-control <?php $__errorArgs = ['notes'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"></textarea>
                                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['notes'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer d-flex flex-column flex-md-row gap-2">
                            <button type="button" wire:click.prevent="closeModal" class="btn btn-label-secondary w-100 w-md-auto m-0">
                                <i class="ri-close-line me-1"></i>
                                Cancel
                            </button>
                            <button type="submit" class="btn btn-primary w-100 w-md-auto m-0">
                                <i class="ri-save-line me-1"></i>
                                <?php echo e($editing ? 'Update' : 'Create'); ?> Employee
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

    <!-- View Employee Modal -->
    <!--[if BLOCK]><![endif]--><?php if($showViewModal): ?>
        <div class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0,0,0,0.5);" wire:click.self="closeViewModal">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" wire:click.stop>
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">
                            <i class="ri-user-line me-2"></i>
                            Employee Details
                        </h5>
                        <button type="button" class="btn-close btn-close-white" wire:click.prevent="closeViewModal"></button>
                    </div>
                    
                    <div class="modal-body">
                        <!--[if BLOCK]><![endif]--><?php if($viewEmployee): ?>
                            <div class="row g-4">
                                <!-- Employee Header -->
                                <div class="col-12">
                                    <div class="d-flex align-items-center p-3 bg-light rounded">
                                        <div class="avatar avatar-lg me-3">
                                            <span class="avatar-initial rounded-circle bg-primary text-white fs-4">
                                                <?php echo e($viewEmployee->user ? strtoupper(substr($viewEmployee->user->name, 0, 2)) : 'NA'); ?>

                                            </span>
                                        </div>
                                        <div>
                                            <h5 class="mb-1"><?php echo e($viewEmployee->user ? $viewEmployee->user->name : 'N/A'); ?></h5>
                                            <p class="mb-0 text-muted"><?php echo e($viewEmployee->position); ?></p>
                                            <span class="badge bg-label-<?php echo e($viewEmployee->employment_status === 'active' ? 'success' : ($viewEmployee->employment_status === 'inactive' ? 'warning' : 'danger')); ?> mt-1">
                                                <?php echo e(ucfirst($viewEmployee->employment_status)); ?>

                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Basic Information -->
                                <div class="col-12">
                                    <h6 class="mb-3 fw-bold"><i class="ri-information-line me-2"></i>Basic Information</h6>
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <small class="text-muted d-block">Employee ID</small>
                                            <strong><?php echo e($viewEmployee->employee_id); ?></strong>
                                        </div>
                                        <div class="col-md-6">
                                            <small class="text-muted d-block">Email</small>
                                            <strong><?php echo e($viewEmployee->user ? $viewEmployee->user->email : 'N/A'); ?></strong>
                                        </div>
                                        <div class="col-md-6">
                                            <small class="text-muted d-block">Department</small>
                                            <strong><?php echo e($viewEmployee->department); ?></strong>
                                        </div>
                                        <div class="col-md-6">
                                            <small class="text-muted d-block">Branch</small>
                                            <strong><?php echo e($viewEmployee->branch ? $viewEmployee->branch->name : 'N/A'); ?></strong>
                                        </div>
                                        <div class="col-md-6">
                                            <small class="text-muted d-block">Phone</small>
                                            <strong><?php echo e($viewEmployee->phone ?: 'N/A'); ?></strong>
                                        </div>
                                        <div class="col-md-6">
                                            <small class="text-muted d-block">Hire Date</small>
                                            <strong><?php echo e($viewEmployee->hire_date ? \Carbon\Carbon::parse($viewEmployee->hire_date)->format('M d, Y') : 'N/A'); ?></strong>
                                        </div>
                                    </div>
                                </div>

                                <!-- Employment Details -->
                                <div class="col-12">
                                    <h6 class="mb-3 fw-bold"><i class="ri-briefcase-line me-2"></i>Employment Details</h6>
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <small class="text-muted d-block">Salary</small>
                                            <strong><?php echo e($viewEmployee->salary ? '$' . number_format($viewEmployee->salary, 2) : 'N/A'); ?></strong>
                                        </div>
                                        <div class="col-md-6">
                                            <small class="text-muted d-block">Manager</small>
                                            <strong><?php echo e($viewEmployee->manager && $viewEmployee->manager->user ? $viewEmployee->manager->user->name : 'N/A'); ?></strong>
                                        </div>
                                    </div>
                                </div>

                                <!-- Emergency Contact -->
                                <div class="col-12">
                                    <h6 class="mb-3 fw-bold"><i class="ri-phone-line me-2"></i>Emergency Contact</h6>
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <small class="text-muted d-block">Contact Name</small>
                                            <strong><?php echo e($viewEmployee->emergency_contact ?: 'N/A'); ?></strong>
                                        </div>
                                        <div class="col-md-6">
                                            <small class="text-muted d-block">Contact Phone</small>
                                            <strong><?php echo e($viewEmployee->emergency_phone ?: 'N/A'); ?></strong>
                                        </div>
                                    </div>
                                </div>

                                <!-- Address -->
                                <!--[if BLOCK]><![endif]--><?php if($viewEmployee->address): ?>
                                    <div class="col-12">
                                        <h6 class="mb-3 fw-bold"><i class="ri-map-pin-line me-2"></i>Address</h6>
                                        <p class="mb-0"><?php echo e($viewEmployee->address); ?></p>
                                    </div>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                                <!-- Notes -->
                                <!--[if BLOCK]><![endif]--><?php if($viewEmployee->notes): ?>
                                    <div class="col-12">
                                        <h6 class="mb-3 fw-bold"><i class="ri-file-text-line me-2"></i>Notes</h6>
                                        <p class="mb-0"><?php echo e($viewEmployee->notes); ?></p>
                                    </div>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </div>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </div>

                    <div class="modal-footer">
                        <button type="button" wire:click.prevent="closeViewModal" class="btn btn-label-secondary">
                            <i class="ri-close-line me-1"></i>
                            Close
                        </button>
                        <button type="button" wire:click.prevent="editFromView" class="btn btn-primary">
                            <i class="ri-edit-line me-1"></i>
                            Edit Employee
                        </button>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
</div><?php /**PATH D:\School-Projects\Software-dev\Kessly\resources\views/livewire/hr/employees.blade.php ENDPATH**/ ?>