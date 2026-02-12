<div>
    <!-- Status Message -->
    <!--[if BLOCK]><![endif]--><?php if(session()->has('status')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <div class="d-flex align-items-center">
                <i class="ri-checkbox-circle-line ri-20px me-2"></i>
                <span><?php echo e(session('status')); ?></span>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

    <!-- Search and Filters -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row g-3 align-items-end">
                <div class="col-12 col-md-4">
                    <label class="form-label small text-muted">Search</label>
                    <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search by name, email, phone..." class="form-control">
                </div>
                <div class="col-6 col-md-2">
                    <label class="form-label small text-muted">Sort By</label>
                    <select wire:model.live="sortField" class="form-select">
                        <option value="name">Name</option>
                        <option value="email">Email</option>
                        <option value="created_at">Date Added</option>
                    </select>
                </div>
                <div class="col-6 col-md-2">
                    <label class="form-label small text-muted">Per Page</label>
                    <select wire:model.live="perPage" class="form-select">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div>
                <div class="col-12 col-md-4 text-md-end pt-2 pt-md-0">
                    <div class="d-flex gap-2 justify-content-md-end">
                        <button type="button" class="btn btn-label-secondary flex-fill flex-md-grow-0" wire:click="export">
                            <i class="ri-download-line me-1"></i>
                            Export
                        </button>
                        <button type="button" class="btn btn-primary flex-fill flex-md-grow-0" wire:click="create">
                            <i class="ri-add-line me-1"></i>
                            Add Customer
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Customers Table -->
    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover mb-0 table-stacked">
            <thead>
                <tr>
                    <th>
                        <button type="button" class="btn btn-sm btn-link text-decoration-none p-0 d-flex align-items-center gap-1" wire:click="sortBy('name')">
                            Name
                            <!--[if BLOCK]><![endif]--><?php if($sortField === 'name'): ?>
                                <i class="ri-<?php echo e($sortDirection === 'asc' ? 'arrow-up' : 'arrow-down'); ?>-s-line text-primary"></i>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </button>
                    </th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                <!--[if BLOCK]><![endif]--><?php $__empty_1 = true; $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td data-label="Name">
                            <div class="d-flex align-items-center gap-2">
                                <div class="avatar avatar-sm">
                                    <span class="avatar-initial rounded bg-label-success">
                                        <i class="ri-user-line"></i>
                                    </span>
                                </div>
                                <span class="fw-medium"><?php echo e($customer->name); ?></span>
                            </div>
                        </td>
                        <td data-label="Email">
                            <a href="mailto:<?php echo e($customer->email); ?>" class="text-primary">
                                <i class="ri-mail-line me-1"></i><?php echo e($customer->email); ?>

                            </a>
                        </td>
                        <td data-label="Phone">
                            <!--[if BLOCK]><![endif]--><?php if($customer->phone): ?>
                                <i class="ri-phone-line me-1"></i><?php echo e($customer->phone); ?>

                            <?php else: ?>
                                <span class="text-muted">—</span>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </td>
                        <td data-label="Address"><?php echo e($customer->address ?? '—'); ?></td>
                        <td class="text-end" data-label="Actions">
                            <div class="d-flex align-items-center justify-content-end gap-1">
                                <button type="button" class="btn btn-sm btn-icon btn-text-secondary rounded-pill" wire:click="view(<?php echo e($customer->id); ?>)" title="View">
                                    <i class="ri-eye-line ri-20px"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-icon btn-text-secondary rounded-pill" wire:click="edit(<?php echo e($customer->id); ?>)" title="Edit">
                                    <i class="ri-edit-line ri-20px"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-icon btn-text-danger rounded-pill" wire:click="delete(<?php echo e($customer->id); ?>)" onclick="return confirm('Are you sure you want to delete this customer?')" title="Delete">
                                    <i class="ri-delete-bin-line ri-20px"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            <div class="d-flex flex-column align-items-center">
                                <div class="avatar avatar-xl mb-3">
                                    <span class="avatar-initial rounded bg-label-secondary">
                                        <i class="ri-team-line ri-48px"></i>
                                    </span>
                                </div>
                                <h6 class="mb-1">No customers found</h6>
                                <p class="text-muted small mb-0">Get started by adding your first customer.</p>
                            </div>
                        </td>
                    </tr>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            </tbody>
        </table>
    </div>

    <!-- Pagination and Stats -->
    <div class="card-footer border-top">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div class="d-flex align-items-center gap-3">
                <small class="text-muted">
                    <i class="ri-information-line me-1"></i>
                    Showing <?php echo e($customers->firstItem() ?? 0); ?> to <?php echo e($customers->lastItem() ?? 0); ?> of <?php echo e($customers->total()); ?> customers
                </small>
            </div>
            <!--[if BLOCK]><![endif]--><?php if($customers->hasPages()): ?>
                <nav aria-label="Customer pagination">
                    <?php echo e($customers->links('pagination::bootstrap-5')); ?>

                </nav>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        </div>
    </div>
</div>

    <style>
        .pagination .page-link svg {
            display: none;
        }
        .pagination .page-link {
            padding: 0.375rem 0.75rem;
        }
    </style>

    <!-- Create/Edit Form Modal -->
    <!--[if BLOCK]><![endif]--><?php if($showForm): ?>
        <div class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0, 0, 0, 0.5);">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <form wire:submit.prevent="save">
                        <div class="modal-header">
                            <h5 class="modal-title">
                                <i class="ri-<?php echo e($customerId ? 'edit' : 'add'); ?>-line me-2"></i>
                                <?php echo e($customerId ? 'Edit Customer' : 'Add New Customer'); ?>

                            </h5>
                            <button type="button" class="btn-close" wire:click="cancel"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row g-3">
                                <div class="col-12 col-md-6">
                                    <label class="form-label" for="customer_name">Name</label>
                                    <input type="text" id="customer_name" class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" wire:model.defer="name">
                                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="form-label" for="customer_email">Email</label>
                                    <input type="email" id="customer_email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" wire:model.defer="email">
                                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="form-label" for="customer_phone">Phone</label>
                                    <input type="text" id="customer_phone" class="form-control <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" wire:model.defer="phone">
                                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="form-label" for="customer_address">Address</label>
                                    <input type="text" id="customer_address" class="form-control <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" wire:model.defer="address">
                                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                                </div>
                                <div class="col-12">
                                    <label class="form-label" for="customer_notes">Notes</label>
                                    <textarea id="customer_notes" rows="3" class="form-control <?php $__errorArgs = ['notes'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" wire:model.defer="notes"></textarea>
                                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['notes'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer d-flex flex-column flex-md-row gap-2">
                            <button type="button" class="btn btn-label-secondary w-100 w-md-auto m-0" wire:click="cancel">Cancel</button>
                            <button type="submit" class="btn btn-primary w-100 w-md-auto m-0">
                                <i class="ri-save-line me-1"></i>
                                Save Customer
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

    <!-- View Customer Modal -->
    <!--[if BLOCK]><![endif]--><?php if($showView && $viewingCustomer): ?>
        <div class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0, 0, 0, 0.5);">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="ri-eye-line me-2"></i>
                            Customer Details
                        </h5>
                        <button type="button" class="btn-close" wire:click="closeView"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-4">
                            <div class="col-12">
                                <div class="card bg-label-success mb-0">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-lg me-3">
                                                <span class="avatar-initial rounded bg-label-success">
                                                    <i class="ri-user-line ri-36px"></i>
                                                </span>
                                            </div>
                                            <div>
                                                <h5 class="mb-0"><?php echo e($viewingCustomer->name); ?></h5>
                                                <p class="text-muted small mb-0">Customer Name</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-muted small">Email Address</label>
                                <div class="d-flex align-items-center">
                                    <i class="ri-mail-line me-2 text-primary"></i>
                                    <a href="mailto:<?php echo e($viewingCustomer->email); ?>" class="text-primary"><?php echo e($viewingCustomer->email); ?></a>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-muted small">Phone Number</label>
                                <div class="d-flex align-items-center">
                                    <i class="ri-phone-line me-2 text-primary"></i>
                                    <span class="fw-medium"><?php echo e($viewingCustomer->phone ?? 'N/A'); ?></span>
                                </div>
                            </div>
                            <!--[if BLOCK]><![endif]--><?php if($viewingCustomer->address): ?>
                                <div class="col-12">
                                    <label class="form-label fw-semibold text-muted small">Address</label>
                                    <div class="d-flex align-items-start">
                                        <i class="ri-map-pin-line me-2 text-primary mt-1"></i>
                                        <span class="fw-medium"><?php echo e($viewingCustomer->address); ?></span>
                                    </div>
                                </div>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            <!--[if BLOCK]><![endif]--><?php if($viewingCustomer->notes): ?>
                                <div class="col-12">
                                    <label class="form-label fw-semibold text-muted small">Notes</label>
                                    <div class="card bg-label-secondary mb-0">
                                        <div class="card-body">
                                            <p class="mb-0"><?php echo e($viewingCustomer->notes); ?></p>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-muted small">Member Since</label>
                                <div class="d-flex align-items-center">
                                    <i class="ri-calendar-line me-2 text-primary"></i>
                                    <span class="fw-medium"><?php echo e($viewingCustomer->created_at->format('M d, Y')); ?></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-muted small">Last Updated</label>
                                <div class="d-flex align-items-center">
                                    <i class="ri-time-line me-2 text-primary"></i>
                                    <span class="fw-medium"><?php echo e($viewingCustomer->updated_at->format('M d, Y g:i A')); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-label-secondary" wire:click="closeView">Close</button>
                        <button type="button" class="btn btn-info" onclick="printCustomerProfile(<?php echo e($viewingCustomer->id); ?>)">
                            <i class="ri-printer-line me-1"></i>
                            Print
                        </button>
                        <button type="button" class="btn btn-primary" wire:click="edit(<?php echo e($viewingCustomer->id); ?>)">
                            <i class="ri-edit-line me-1"></i>
                            Edit Customer
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Printable Customer Details -->
        <div id="printable-customer-<?php echo e($viewingCustomer->id); ?>" style="display: none;">
            <div style="max-width: 800px; margin: 0 auto; padding: 40px; font-family: Arial, sans-serif; color: #333;">
                <!-- Header -->
                <div style="text-align: center; margin-bottom: 30px; border-bottom: 3px solid #28a745; padding-bottom: 20px;">
                    <h1 style="margin: 0; color: #28a745; font-size: 32px;">CUSTOMER PROFILE</h1>
                    <p style="margin: 5px 0 0 0; color: #666; font-size: 14px;"><?php echo e(config('app.name', 'KESSLY')); ?></p>
                </div>

                <!-- Customer Name -->
                <div style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); color: white; padding: 25px; border-radius: 8px; margin-bottom: 30px; text-align: center;">
                    <h2 style="margin: 0; font-size: 28px;"><?php echo e($viewingCustomer->name); ?></h2>
                    <p style="margin: 10px 0 0 0; font-size: 14px; opacity: 0.9;">Member since <?php echo e($viewingCustomer->created_at->format('F Y')); ?></p>
                </div>

                <!-- Contact Information -->
                <div style="margin-bottom: 30px;">
                    <h3 style="color: #28a745; border-bottom: 2px solid #e0e0e0; padding-bottom: 10px; margin-bottom: 15px;">Contact Information</h3>
                    <table style="width: 100%; border-collapse: collapse;">
                        <tr>
                            <td style="padding: 10px 0; border-bottom: 1px solid #f0f0f0;"><strong>Email:</strong></td>
                            <td style="padding: 10px 0; border-bottom: 1px solid #f0f0f0;"><?php echo e($viewingCustomer->email); ?></td>
                        </tr>
                        <tr>
                            <td style="padding: 10px 0; border-bottom: 1px solid #f0f0f0;"><strong>Phone:</strong></td>
                            <td style="padding: 10px 0; border-bottom: 1px solid #f0f0f0;"><?php echo e($viewingCustomer->phone ?? 'N/A'); ?></td>
                        </tr>
                        <!--[if BLOCK]><![endif]--><?php if($viewingCustomer->address): ?>
                        <tr>
                            <td style="padding: 10px 0; border-bottom: 1px solid #f0f0f0;"><strong>Address:</strong></td>
                            <td style="padding: 10px 0; border-bottom: 1px solid #f0f0f0;"><?php echo e($viewingCustomer->address); ?></td>
                        </tr>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </table>
                </div>

                <!-- Additional Notes -->
                <!--[if BLOCK]><![endif]--><?php if($viewingCustomer->notes): ?>
                <div style="margin-bottom: 30px;">
                    <h3 style="color: #28a745; border-bottom: 2px solid #e0e0e0; padding-bottom: 10px; margin-bottom: 15px;">Notes</h3>
                    <div style="background: #f8f9fa; padding: 20px; border-radius: 8px; border-left: 4px solid #28a745;">
                        <p style="margin: 0; line-height: 1.6;"><?php echo e($viewingCustomer->notes); ?></p>
                    </div>
                </div>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                <!-- Account Information -->
                <div style="background: #f8f9fa; padding: 20px; border-radius: 8px; margin-bottom: 30px;">
                    <h3 style="color: #28a745; margin-top: 0; margin-bottom: 15px;">Account Information</h3>
                    <table style="width: 100%; border-collapse: collapse;">
                        <tr>
                            <td style="padding: 5px 0;"><strong>Customer ID:</strong></td>
                            <td style="padding: 5px 0;">#<?php echo e(str_pad($viewingCustomer->id, 6, '0', STR_PAD_LEFT)); ?></td>
                        </tr>
                        <tr>
                            <td style="padding: 5px 0;"><strong>Registration Date:</strong></td>
                            <td style="padding: 5px 0;"><?php echo e($viewingCustomer->created_at->format('F d, Y')); ?></td>
                        </tr>
                        <tr>
                            <td style="padding: 5px 0;"><strong>Last Updated:</strong></td>
                            <td style="padding: 5px 0;"><?php echo e($viewingCustomer->updated_at->format('F d, Y g:i A')); ?></td>
                        </tr>
                    </table>
                </div>

                <!-- Footer -->
                <div style="text-align: center; color: #999; font-size: 12px; border-top: 2px solid #e0e0e0; padding-top: 20px;">
                    <p style="margin: 5px 0;">Generated on <?php echo e(now()->format('F d, Y \a\t g:i A')); ?></p>
                    <p style="margin: 5px 0;">Confidential Customer Information</p>
                </div>
            </div>
        </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
</div>

    <?php
        $__scriptKey = '125380357-0';
        ob_start();
    ?>
<script>
    window.printCustomerProfile = function(customerId) {
        console.log('Print customer profile called for ID:', customerId);
        
        const printContent = document.getElementById('printable-customer-' + customerId);
        
        if (!printContent) {
            console.error('Printable content not found for customer ID:', customerId);
            alert('Error: Customer profile content not found. Please try again.');
            return;
        }
        
        console.log('Print content found, opening window...');
        
        const printWindow = window.open('', '_blank', 'width=800,height=600');
        
        if (!printWindow) {
            alert('Please allow pop-ups to print customer profiles');
            return;
        }
        
        printWindow.document.write(`
            <!DOCTYPE html>
            <html>
            <head>
                <title>Customer Profile #${customerId}</title>
                <style>
                    * {
                        margin: 0;
                        padding: 0;
                        box-sizing: border-box;
                    }
                    body {
                        margin: 0;
                        padding: 20px;
                        font-family: Arial, sans-serif;
                    }
                    @media print {
                        body {
                            margin: 0;
                            padding: 0;
                        }
                    }
                    @page {
                        margin: 1cm;
                    }
                </style>
            </head>
            <body>
                ${printContent.innerHTML}
            </body>
            </html>
        `);
        
        printWindow.document.close();
        
        setTimeout(() => {
            printWindow.focus();
            printWindow.print();
            setTimeout(() => {
                printWindow.close();
            }, 100);
        }, 500);
    }
</script>
    <?php
        $__output = ob_get_clean();

        \Livewire\store($this)->push('scripts', $__output, $__scriptKey)
    ?>
</div>
<?php /**PATH D:\School-Projects\Software-dev\Kessly\resources\views/livewire/sales/customers.blade.php ENDPATH**/ ?>