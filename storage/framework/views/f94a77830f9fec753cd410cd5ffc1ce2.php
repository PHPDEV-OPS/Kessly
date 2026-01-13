<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use Livewire\WithFileUploads;
use App\Models\Customer;
use App\Models\CustomerNote;

?>

<div>
    <?php if(session()->has('message')): ?>
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
            <?php echo e(session('message')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
        <div class="col-xl col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar me-3">
                            <span class="avatar-initial rounded-circle bg-label-primary">
                                <i class="ri-team-line ri-22px"></i>
                            </span>
                        </div>
                        <div>
                            <div class="text-muted small">Total Customers</div>
                            <h5 class="mb-0"><?php echo e(number_format($this->customerStats['total'])); ?></h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar me-3">
                            <span class="avatar-initial rounded-circle bg-label-success">
                                <i class="ri-check-double-line ri-22px"></i>
                            </span>
                        </div>
                        <div>
                            <div class="text-muted small">Active</div>
                            <h5 class="mb-0 text-success"><?php echo e(number_format($this->customerStats['active'])); ?></h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar me-3">
                            <span class="avatar-initial rounded-circle bg-label-warning">
                                <i class="ri-time-line ri-22px"></i>
                            </span>
                        </div>
                        <div>
                            <div class="text-muted small">Prospects</div>
                            <h5 class="mb-0 text-warning"><?php echo e(number_format($this->customerStats['prospects'])); ?></h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar me-3">
                            <span class="avatar-initial rounded-circle bg-label-danger">
                                <i class="ri-close-circle-line ri-22px"></i>
                            </span>
                        </div>
                        <div>
                            <div class="text-muted small">Inactive</div>
                            <h5 class="mb-0 text-danger"><?php echo e(number_format($this->customerStats['inactive'])); ?></h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar me-3">
                            <span class="avatar-initial rounded-circle bg-label-info">
                                <i class="ri-money-dollar-circle-line ri-22px"></i>
                            </span>
                        </div>
                        <div>
                            <div class="text-muted small">Total Revenue</div>
                            <h5 class="mb-0">KES <?php echo e(number_format($this->customerStats['total_spent'], 2)); ?></h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Card -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Customer Management</h5>
            <div class="d-flex gap-2">
                <button wire:click="create" type="button" class="btn btn-primary">
                    <i class="ri-add-line me-1"></i>
                    Add Customer
                </button>
            </div>
        </div>

        <div class="card-body">
            <!-- Filters -->
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search customers..." class="form-control">
                </div>
                <div class="col-md-2">
                    <select wire:model.live="filterType" class="form-select">
                        <option value="">All Types</option>
                        <option value="individual">Individual</option>
                        <option value="business">Business</option>
                        <option value="enterprise">Enterprise</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select wire:model.live="filterStatus" class="form-select">
                        <option value="">All Status</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                        <option value="prospect">Prospect</option>
                        <option value="blocked">Blocked</option>
                    </select>
                </div>
                <div class="col-md-2 ms-auto">
                    <select wire:model.live="perPage" class="form-select">
                        <option value="10">10 per page</option>
                        <option value="25">25 per page</option>
                        <option value="50">50 per page</option>
                        <option value="100">100 per page</option>
                    </select>
                </div>
            </div>

            <!-- Table -->
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>
                                <button wire:click="sortBy('name')" type="button" class="btn btn-sm btn-link text-decoration-none p-0">
                                    Customer
                                    <?php if($sortField === 'name'): ?>
                                        <i class="ri-arrow-<?php echo e($sortDirection === 'asc' ? 'up' : 'down'); ?>-s-line"></i>
                                    <?php endif; ?>
                                </button>
                            </th>
                            <th>Contact</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>
                                <button wire:click="sortBy('total_spent')" type="button" class="btn btn-sm btn-link text-decoration-none p-0">
                                    Total Spent
                                    <?php if($sortField === 'total_spent'): ?>
                                        <i class="ri-arrow-<?php echo e($sortDirection === 'asc' ? 'up' : 'down'); ?>-s-line"></i>
                                    <?php endif; ?>
                                </button>
                            </th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $this->customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <?php if($customer->avatar): ?>
                                            <img class="avatar avatar-sm me-3 rounded-circle" src="<?php echo e(asset('storage/' . $customer->avatar)); ?>" alt="">
                                        <?php else: ?>
                                            <div class="avatar avatar-sm me-3">
                                                <span class="avatar-initial rounded-circle bg-label-primary"><?php echo e($customer->initials); ?></span>
                                            </div>
                                        <?php endif; ?>
                                        <div>
                                            <div class="fw-medium"><?php echo e($customer->name); ?></div>
                                            <?php if($customer->company): ?>
                                                <small class="text-muted"><?php echo e($customer->company); ?></small>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div><?php echo e($customer->email); ?></div>
                                    <?php if($customer->phone): ?>
                                        <small class="text-muted"><?php echo e($customer->phone); ?></small>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="badge bg-label-<?php echo e($customer->customer_type === 'enterprise' ? 'info' : ($customer->customer_type === 'business' ? 'primary' : 'secondary')); ?>">
                                        <?php echo e(ucfirst($customer->customer_type)); ?>

                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-label-<?php echo e($customer->status === 'active' ? 'success' : ($customer->status === 'inactive' ? 'danger' : ($customer->status === 'prospect' ? 'warning' : 'secondary'))); ?>">
                                        <?php echo e(ucfirst($customer->status)); ?>

                                    </span>
                                </td>
                                <td>KES <?php echo e(number_format($customer->total_spent, 2)); ?></td>
                                <td class="text-end">
                                    <button wire:click="viewCustomer(<?php echo e($customer->id); ?>)" type="button" class="btn btn-sm btn-icon btn-label-info" title="View Details">
                                        <i class="ri-eye-line"></i>
                                    </button>
                                    <button wire:click="edit(<?php echo e($customer->id); ?>)" type="button" class="btn btn-sm btn-icon btn-label-primary" title="Edit">
                                        <i class="ri-edit-line"></i>
                                    </button>
                                    <button wire:click="delete(<?php echo e($customer->id); ?>)" type="button"
                                            onclick="return confirm('Are you sure you want to delete this customer?')"
                                            class="btn btn-sm btn-icon btn-label-danger" title="Delete">
                                        <i class="ri-delete-bin-line"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <p class="text-muted mb-0">No customers found.</p>
                                    <button wire:click="create" type="button" class="btn btn-primary mt-3">
                                        <i class="ri-add-line me-1"></i>
                                        Add Customer
                                    </button>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        <?php if($this->customers->hasPages()): ?>
            <div class="card-footer border-top">
                <?php echo e($this->customers->links()); ?>

            </div>
        <?php endif; ?>
    </div>

    <!-- Customer Form Modal -->
    <?php if($showForm): ?>
        <div class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0,0,0,0.5);" wire:click.self="cancel">
            <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable" wire:click.stop>
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="ri-<?php echo e($customerId ? 'edit' : 'add'); ?>-line me-2"></i>
                            <?php echo e($customerId ? 'Edit Customer' : 'Add New Customer'); ?>

                        </h5>
                        <button type="button" class="btn-close" wire:click.prevent="cancel"></button>
                    </div>
                    
                    <form wire:submit.prevent="save">
                        <div class="modal-body">
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label class="form-label fw-medium">Full Name *</label>
                                    <input type="text" wire:model="name" class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                    <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-medium">Email *</label>
                                    <input type="email" wire:model="email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                    <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-medium">Phone</label>
                                    <input type="text" wire:model="phone" class="form-control <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                    <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-medium">Mobile</label>
                                    <input type="text" wire:model="mobile" class="form-control <?php $__errorArgs = ['mobile'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                    <?php $__errorArgs = ['mobile'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-medium">Company</label>
                                    <input type="text" wire:model="company" class="form-control <?php $__errorArgs = ['company'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                    <?php $__errorArgs = ['company'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-medium">Customer Type *</label>
                                    <select wire:model="customer_type" class="form-select <?php $__errorArgs = ['customer_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                        <option value="individual">Individual</option>
                                        <option value="business">Business</option>
                                        <option value="enterprise">Enterprise</option>
                                    </select>
                                    <?php $__errorArgs = ['customer_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-medium">Status *</label>
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
                                        <option value="prospect">Prospect</option>
                                        <option value="blocked">Blocked</option>
                                    </select>
                                    <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-medium">Address</label>
                                    <input type="text" wire:model="address" class="form-control <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                    <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div class="col-12">
                                    <label class="form-label fw-medium">Notes</label>
                                    <textarea wire:model="notes" rows="3" class="form-control <?php $__errorArgs = ['notes'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"></textarea>
                                    <?php $__errorArgs = ['notes'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" wire:click.prevent="cancel" class="btn btn-label-secondary">
                                <i class="ri-close-line me-1"></i>
                                Cancel
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="ri-save-line me-1"></i>
                                <?php echo e($customerId ? 'Update' : 'Create'); ?> Customer
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Customer Details Modal -->
    <?php if($selectedCustomer): ?>
        <div class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0,0,0,0.5);" wire:click.self="$set('selectedCustomerId', null)">
            <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable" wire:click.stop>
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="ri-user-line me-2"></i>
                            Customer Details
                        </h5>
                        <button type="button" class="btn-close" wire:click.prevent="$set('selectedCustomerId', null)"></button>
                    </div>
                    
                    <div class="modal-body">
                        <div class="row g-4">
                            <!-- Customer Header -->
                            <div class="col-12">
                                <div class="d-flex align-items-center justify-content-between mb-4">
                                    <div class="d-flex align-items-center">
                                        <?php if($selectedCustomer->avatar): ?>
                                            <img class="avatar avatar-lg me-3 rounded-circle" src="<?php echo e(asset('storage/' . $selectedCustomer->avatar)); ?>" alt="">
                                        <?php else: ?>
                                            <div class="avatar avatar-lg me-3">
                                                <span class="avatar-initial rounded-circle bg-label-primary fs-4"><?php echo e($selectedCustomer->initials); ?></span>
                                            </div>
                                        <?php endif; ?>
                                        <div>
                                            <h4 class="mb-1"><?php echo e($selectedCustomer->name); ?></h4>
                                            <?php if($selectedCustomer->company): ?>
                                                <p class="text-muted mb-0"><?php echo e($selectedCustomer->company); ?></p>
                                            <?php endif; ?>
                                            <div class="mt-2">
                                                <span class="badge bg-label-<?php echo e($selectedCustomer->customer_type === 'enterprise' ? 'info' : ($selectedCustomer->customer_type === 'business' ? 'primary' : 'secondary')); ?> me-2">
                                                    <?php echo e(ucfirst($selectedCustomer->customer_type)); ?>

                                                </span>
                                                <span class="badge bg-label-<?php echo e($selectedCustomer->status === 'active' ? 'success' : ($selectedCustomer->status === 'inactive' ? 'danger' : ($selectedCustomer->status === 'prospect' ? 'warning' : 'secondary'))); ?>">
                                                    <?php echo e(ucfirst($selectedCustomer->status)); ?>

                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <button wire:click.prevent="edit(<?php echo e($selectedCustomer->id); ?>)" type="button" class="btn btn-primary">
                                        <i class="ri-edit-line me-1"></i>
                                        Edit Customer
                                    </button>
                                </div>
                            </div>

                            <!-- Stats Cards -->
                            <div class="col-md-3 col-sm-6">
                                <div class="card bg-label-primary">
                                    <div class="card-body text-center">
                                        <i class="ri-shopping-cart-line ri-24px mb-2"></i>
                                        <h5 class="mb-0"><?php echo e($selectedCustomer->total_orders ?? 0); ?></h5>
                                        <small>Total Orders</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="card bg-label-success">
                                    <div class="card-body text-center">
                                        <i class="ri-money-dollar-circle-line ri-24px mb-2"></i>
                                        <h5 class="mb-0">KES <?php echo e(number_format($selectedCustomer->total_spent, 2)); ?></h5>
                                        <small>Total Spent</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="card bg-label-warning">
                                    <div class="card-body text-center">
                                        <i class="ri-wallet-line ri-24px mb-2"></i>
                                        <h5 class="mb-0">KES <?php echo e(number_format($selectedCustomer->credit_limit, 2)); ?></h5>
                                        <small>Credit Limit</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="card bg-label-info">
                                    <div class="card-body text-center">
                                        <i class="ri-calendar-line ri-24px mb-2"></i>
                                        <h5 class="mb-0"><?php echo e($selectedCustomer->created_at->format('M Y')); ?></h5>
                                        <small>Customer Since</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Contact Information -->
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h6 class="mb-0"><i class="ri-contacts-line me-2"></i>Contact Information</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <small class="text-muted d-block">Email</small>
                                            <span><?php echo e($selectedCustomer->email); ?></span>
                                        </div>
                                        <?php if($selectedCustomer->phone): ?>
                                            <div class="mb-3">
                                                <small class="text-muted d-block">Phone</small>
                                                <span><?php echo e($selectedCustomer->phone); ?></span>
                                            </div>
                                        <?php endif; ?>
                                        <?php if($selectedCustomer->mobile): ?>
                                            <div class="mb-3">
                                                <small class="text-muted d-block">Mobile</small>
                                                <span><?php echo e($selectedCustomer->mobile); ?></span>
                                            </div>
                                        <?php endif; ?>
                                        <?php if($selectedCustomer->website): ?>
                                            <div class="mb-3">
                                                <small class="text-muted d-block">Website</small>
                                                <a href="<?php echo e($selectedCustomer->website); ?>" target="_blank" class="text-primary"><?php echo e($selectedCustomer->website); ?></a>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>

                            <!-- Address Information -->
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h6 class="mb-0"><i class="ri-map-pin-line me-2"></i>Address</h6>
                                    </div>
                                    <div class="card-body">
                                        <?php if($selectedCustomer->address): ?>
                                            <div class="mb-2"><?php echo e($selectedCustomer->address); ?></div>
                                        <?php endif; ?>
                                        <div>
                                            <?php if($selectedCustomer->city): ?><?php echo e($selectedCustomer->city); ?><?php endif; ?>
                                            <?php if($selectedCustomer->state): ?>, <?php echo e($selectedCustomer->state); ?><?php endif; ?>
                                            <?php if($selectedCustomer->postal_code): ?> <?php echo e($selectedCustomer->postal_code); ?><?php endif; ?>
                                        </div>
                                        <?php if($selectedCustomer->country): ?>
                                            <div class="mt-2"><?php echo e($selectedCustomer->country); ?></div>
                                        <?php endif; ?>
                                        <?php if(!$selectedCustomer->address && !$selectedCustomer->city && !$selectedCustomer->state): ?>
                                            <span class="text-muted">No address information</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>

                            <!-- Business Information -->
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h6 class="mb-0"><i class="ri-briefcase-line me-2"></i>Business Information</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <?php if($selectedCustomer->tax_id): ?>
                                                <div class="col-md-4 mb-3">
                                                    <small class="text-muted d-block">Tax ID</small>
                                                    <span><?php echo e($selectedCustomer->tax_id); ?></span>
                                                </div>
                                            <?php endif; ?>
                                            <?php if($selectedCustomer->payment_terms): ?>
                                                <div class="col-md-4 mb-3">
                                                    <small class="text-muted d-block">Payment Terms</small>
                                                    <span><?php echo e($selectedCustomer->payment_terms); ?></span>
                                                </div>
                                            <?php endif; ?>
                                            <div class="col-md-4 mb-3">
                                                <small class="text-muted d-block">Customer Type</small>
                                                <span><?php echo e(ucfirst($selectedCustomer->customer_type)); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Notes -->
                            <?php if($selectedCustomer->notes): ?>
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h6 class="mb-0"><i class="ri-file-text-line me-2"></i>Notes</h6>
                                        </div>
                                        <div class="card-body">
                                            <p class="mb-0"><?php echo e($selectedCustomer->notes); ?></p>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <!-- Tags -->
                            <?php if($selectedCustomer->tags && count($selectedCustomer->tags) > 0): ?>
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h6 class="mb-0"><i class="ri-price-tag-3-line me-2"></i>Tags</h6>
                                        </div>
                                        <div class="card-body">
                                            <?php $__currentLoopData = $selectedCustomer->tags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <span class="badge bg-label-primary me-1 mb-1"><?php echo e($tag); ?></span>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" wire:click.prevent="$set('selectedCustomerId', null)" class="btn btn-label-secondary">
                            <i class="ri-close-line me-1"></i>
                            Close
                        </button>
                        <button wire:click.prevent="edit(<?php echo e($selectedCustomer->id); ?>)" type="button" class="btn btn-primary">
                            <i class="ri-edit-line me-1"></i>
                            Edit Customer
                        </button>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div><?php /**PATH D:\School-Projects\Software-dev\Kessly\resources\views\livewire\pages\customers.blade.php ENDPATH**/ ?>