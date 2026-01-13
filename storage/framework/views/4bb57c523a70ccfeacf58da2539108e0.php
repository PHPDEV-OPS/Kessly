<div>
    <!-- Status Message -->
    <?php if(session()->has('status')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <div class="d-flex align-items-center">
                <i class="ri-checkbox-circle-line ri-20px me-2"></i>
                <span><?php echo e(session('status')); ?></span>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Search and Filters -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row g-3 align-items-end">
                <div class="col-md-6">
                    <label class="form-label small text-muted">Search</label>
                    <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search by order #, customer..." class="form-control">
                </div>
                <div class="col-md-2">
                    <label class="form-label small text-muted">Per Page</label>
                    <select wire:model.live="perPage" class="form-select">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div>
                <div class="col-md-4 text-end">
                    <button type="button" class="btn btn-label-secondary" wire:click="export">
                        <i class="ri-download-line me-1"></i>
                        Export
                    </button>
                    <button type="button" class="btn btn-primary" wire:click="create">
                        <i class="ri-add-line me-1"></i>
                        Add Order
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Orders Table -->
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>
                        <button type="button" class="btn btn-sm btn-link text-decoration-none p-0 d-flex align-items-center gap-1" wire:click="sortBy('order_number')">
                            Order #
                            <?php if($sortField === 'order_number'): ?>
                                <i class="ri-<?php echo e($sortDirection === 'asc' ? 'arrow-up' : 'arrow-down'); ?>-s-line text-primary"></i>
                            <?php endif; ?>
                        </button>
                    </th>
                    <th>Customer</th>
                    <th>
                        <button type="button" class="btn btn-sm btn-link text-decoration-none p-0 d-flex align-items-center gap-1" wire:click="sortBy('order_date')">
                            Date
                            <?php if($sortField === 'order_date'): ?>
                                <i class="ri-<?php echo e($sortDirection === 'asc' ? 'arrow-up' : 'arrow-down'); ?>-s-line text-primary"></i>
                            <?php endif; ?>
                        </button>
                    </th>
                    <th>
                        <button type="button" class="btn btn-sm btn-link text-decoration-none p-0 d-flex align-items-center gap-1" wire:click="sortBy('total_amount')">
                            Total
                            <?php if($sortField === 'total_amount'): ?>
                                <i class="ri-<?php echo e($sortDirection === 'asc' ? 'arrow-up' : 'arrow-down'); ?>-s-line text-primary"></i>
                            <?php endif; ?>
                        </button>
                    </th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="avatar avatar-sm">
                                    <span class="avatar-initial rounded bg-label-primary">
                                        <i class="ri-file-list-3-line"></i>
                                    </span>
                                </div>
                                <span class="fw-medium"><?php echo e($order->order_number); ?></span>
                            </div>
                        </td>
                        <td><?php echo e($order->customer?->name ?? '—'); ?></td>
                        <td><?php echo e(optional($order->order_date)->format('M d, Y')); ?></td>
                        <td><span class="fw-semibold">$<?php echo e(number_format($order->total_amount, 2)); ?></span></td>
                        <td>
                            <div class="d-flex align-items-center justify-content-end gap-1">
                                <button type="button" class="btn btn-sm btn-icon btn-text-secondary rounded-pill" wire:click="view(<?php echo e($order->id); ?>)" title="View">
                                    <i class="ri-eye-line ri-20px"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-icon btn-text-secondary rounded-pill" wire:click="edit(<?php echo e($order->id); ?>)" title="Edit">
                                    <i class="ri-edit-line ri-20px"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-icon btn-text-danger rounded-pill" wire:click="delete(<?php echo e($order->id); ?>)" onclick="return confirm('Are you sure you want to delete this order?')" title="Delete">
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
                                        <i class="ri-file-list-3-line ri-48px"></i>
                                    </span>
                                </div>
                                <h6 class="mb-1">No orders found</h6>
                                <p class="text-muted small mb-0">Get started by creating your first order.</p>
                            </div>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination and Stats -->
    <div class="card-footer border-top">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <?php if($orders->hasPages()): ?>
                <nav aria-label="Order pagination" class="w-100">
                    <?php echo e($orders->links('pagination::bootstrap-5')); ?>

                </nav>
            <?php else: ?>
                <small class="text-muted">
                    <i class="ri-information-line me-1"></i>
                    Showing <?php echo e($orders->firstItem() ?? 0); ?> to <?php echo e($orders->lastItem() ?? 0); ?> of <?php echo e($orders->total()); ?> orders
                </small>
            <?php endif; ?>
        </div>
    </div>
    
    <style>
        .pagination {
            margin: 0;
            gap: 0.25rem;
        }
        .pagination .page-link {
            border-radius: 0.375rem;
            border: 1px solid #ddd;
            color: #697a8d;
            padding: 0.375rem 0.75rem;
            margin: 0 2px;
            font-size: 0.9375rem;
            transition: all 0.2s;
        }
        .pagination .page-link svg {
            display: none;
        }
        .pagination .page-link:hover {
            background-color: #f5f5f9;
            border-color: #7367f0;
            color: #7367f0;
        }
        .pagination .page-item.active .page-link {
            background-color: #7367f0;
            border-color: #7367f0;
            color: #fff;
        }
        .pagination .page-item.disabled .page-link {
            background-color: #f5f5f9;
            border-color: #ddd;
            color: #c7cdd4;
            cursor: not-allowed;
        }
    </style>

    <!-- Create/Edit Form Modal -->
    <?php if($showForm): ?>
        <div class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0, 0, 0, 0.5);">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <form wire:submit.prevent="save">
                        <div class="modal-header">
                            <h5 class="modal-title">
                                <i class="ri-<?php echo e($orderId ? 'edit' : 'add'); ?>-line me-2"></i>
                                <?php echo e($orderId ? 'Edit Order' : 'Add New Order'); ?>

                            </h5>
                            <button type="button" class="btn-close" wire:click="cancel"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label" for="order_number">Order Number</label>
                                    <input type="text" id="order_number" class="form-control <?php $__errorArgs = ['order_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" wire:model.defer="order_number">
                                    <?php $__errorArgs = ['order_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="customer_id">Customer</label>
                                    <select id="customer_id" class="form-select <?php $__errorArgs = ['customer_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" wire:model.defer="customer_id">
                                        <option value="">Select customer</option>
                                        <?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($c->id); ?>"><?php echo e($c->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <?php $__errorArgs = ['customer_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="order_date">Order Date</label>
                                    <input type="date" id="order_date" class="form-control <?php $__errorArgs = ['order_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" wire:model.defer="order_date">
                                    <?php $__errorArgs = ['order_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="total_amount">Total Amount</label>
                                    <div class="input-group">
                                        <span class="input-group-text">$</span>
                                        <input type="number" step="0.01" min="0" id="total_amount" class="form-control <?php $__errorArgs = ['total_amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" wire:model.defer="total_amount">
                                    </div>
                                    <?php $__errorArgs = ['total_amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-label-secondary" wire:click="cancel">Cancel</button>
                            <button type="submit" class="btn btn-primary">
                                <i class="ri-save-line me-1"></i>
                                Save Order
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- View Order Modal -->
    <?php if($showView && $viewingOrder): ?>
        <div class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0, 0, 0, 0.5);">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="ri-eye-line me-2"></i>
                            Order Details
                        </h5>
                        <button type="button" class="btn-close" wire:click="closeView"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-4">
                            <div class="col-12">
                                <div class="card bg-label-primary mb-0">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-lg me-3">
                                                <span class="avatar-initial rounded bg-label-primary">
                                                    <i class="ri-file-list-3-line ri-36px"></i>
                                                </span>
                                            </div>
                                            <div>
                                                <h5 class="mb-0"><?php echo e($viewingOrder->order_number); ?></h5>
                                                <p class="text-muted small mb-0">Order Number</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-muted small">Customer</label>
                                <div class="d-flex align-items-center">
                                    <i class="ri-user-line me-2 text-primary"></i>
                                    <span class="fw-medium"><?php echo e($viewingOrder->customer?->name ?? 'N/A'); ?></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-muted small">Order Date</label>
                                <div class="d-flex align-items-center">
                                    <i class="ri-calendar-line me-2 text-primary"></i>
                                    <span class="fw-medium"><?php echo e(optional($viewingOrder->order_date)->format('M d, Y') ?? 'N/A'); ?></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-muted small">Total Amount</label>
                                <div class="d-flex align-items-center">
                                    <i class="ri-money-dollar-circle-line me-2 text-success"></i>
                                    <span class="fw-bold text-success fs-5">$<?php echo e(number_format($viewingOrder->total_amount, 2)); ?></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-muted small">Created</label>
                                <div class="d-flex align-items-center">
                                    <i class="ri-time-line me-2 text-primary"></i>
                                    <span class="fw-medium"><?php echo e($viewingOrder->created_at->format('M d, Y g:i A')); ?></span>
                                </div>
                            </div>
                            <?php if($viewingOrder->customer): ?>
                                <div class="col-12">
                                    <div class="card bg-label-secondary mb-0">
                                        <div class="card-body">
                                            <h6 class="mb-3">
                                                <i class="ri-information-line me-2"></i>
                                                Customer Information
                                            </h6>
                                            <div class="row g-3">
                                                <?php if($viewingOrder->customer->email): ?>
                                                    <div class="col-md-6">
                                                        <small class="text-muted d-block">Email</small>
                                                        <a href="mailto:<?php echo e($viewingOrder->customer->email); ?>" class="text-primary">
                                                            <?php echo e($viewingOrder->customer->email); ?>

                                                        </a>
                                                    </div>
                                                <?php endif; ?>
                                                <?php if($viewingOrder->customer->phone): ?>
                                                    <div class="col-md-6">
                                                        <small class="text-muted d-block">Phone</small>
                                                        <span><?php echo e($viewingOrder->customer->phone); ?></span>
                                                    </div>
                                                <?php endif; ?>
                                                <?php if($viewingOrder->customer->address): ?>
                                                    <div class="col-12">
                                                        <small class="text-muted d-block">Address</small>
                                                        <span><?php echo e($viewingOrder->customer->address); ?></span>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-label-secondary" wire:click="closeView">Close</button>
                        <button type="button" class="btn btn-info" onclick="printOrderReceipt(<?php echo e($viewingOrder->id); ?>)">
                            <i class="ri-printer-line me-1"></i>
                            Print
                        </button>
                        <button type="button" class="btn btn-primary" wire:click="edit(<?php echo e($viewingOrder->id); ?>)">
                            <i class="ri-edit-line me-1"></i>
                            Edit Order
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Printable Order Receipt -->
        <div id="printable-order-<?php echo e($viewingOrder->id); ?>" style="display: none;">
            <div style="max-width: 800px; margin: 0 auto; padding: 40px; font-family: Arial, sans-serif; color: #333;">
                <!-- Header -->
                <div style="text-align: center; margin-bottom: 30px; border-bottom: 3px solid #7367f0; padding-bottom: 20px;">
                    <h1 style="margin: 0; color: #7367f0; font-size: 32px;">ORDER RECEIPT</h1>
                    <p style="margin: 5px 0 0 0; color: #666; font-size: 14px;"><?php echo e(config('app.name', 'KESSLY')); ?></p>
                </div>

                <!-- Order Info -->
                <div style="background: #f8f9fa; padding: 20px; border-radius: 8px; margin-bottom: 30px;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <tr>
                            <td style="padding: 8px 0; width: 50%;">
                                <strong style="color: #666; font-size: 12px;">ORDER NUMBER</strong><br>
                                <span style="font-size: 18px; font-weight: bold; color: #7367f0;"><?php echo e($viewingOrder->order_number); ?></span>
                            </td>
                            <td style="padding: 8px 0; text-align: right;">
                                <strong style="color: #666; font-size: 12px;">ORDER DATE</strong><br>
                                <span style="font-size: 16px;"><?php echo e(optional($viewingOrder->order_date)->format('M d, Y')); ?></span>
                            </td>
                        </tr>
                    </table>
                </div>

                <!-- Customer Information -->
                <div style="margin-bottom: 30px;">
                    <h3 style="color: #7367f0; border-bottom: 2px solid #e0e0e0; padding-bottom: 10px; margin-bottom: 15px;">Customer Information</h3>
                    <table style="width: 100%; border-collapse: collapse;">
                        <tr>
                            <td style="padding: 5px 0;"><strong>Name:</strong></td>
                            <td style="padding: 5px 0;"><?php echo e($viewingOrder->customer?->name ?? 'N/A'); ?></td>
                        </tr>
                        <?php if($viewingOrder->customer?->email): ?>
                        <tr>
                            <td style="padding: 5px 0;"><strong>Email:</strong></td>
                            <td style="padding: 5px 0;"><?php echo e($viewingOrder->customer->email); ?></td>
                        </tr>
                        <?php endif; ?>
                        <?php if($viewingOrder->customer?->phone): ?>
                        <tr>
                            <td style="padding: 5px 0;"><strong>Phone:</strong></td>
                            <td style="padding: 5px 0;"><?php echo e($viewingOrder->customer->phone); ?></td>
                        </tr>
                        <?php endif; ?>
                        <?php if($viewingOrder->customer?->address): ?>
                        <tr>
                            <td style="padding: 5px 0;"><strong>Address:</strong></td>
                            <td style="padding: 5px 0;"><?php echo e($viewingOrder->customer->address); ?></td>
                        </tr>
                        <?php endif; ?>
                    </table>
                </div>

                <!-- Order Total -->
                <div style="background: linear-gradient(135deg, #7367f0 0%, #9055fd 100%); color: white; padding: 25px; border-radius: 8px; margin-bottom: 30px;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <tr>
                            <td style="font-size: 18px; padding: 0;">Total Amount</td>
                            <td style="text-align: right; font-size: 32px; font-weight: bold; padding: 0;">$<?php echo e(number_format($viewingOrder->total_amount, 2)); ?></td>
                        </tr>
                    </table>
                </div>

                <!-- Footer -->
                <div style="text-align: center; color: #999; font-size: 12px; border-top: 2px solid #e0e0e0; padding-top: 20px;">
                    <p style="margin: 5px 0;">Printed on <?php echo e(now()->format('F d, Y \a\t g:i A')); ?></p>
                    <p style="margin: 5px 0;">Thank you for your business!</p>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

    <?php
        $__scriptKey = '2806245395-1';
        ob_start();
    ?>
<script>
    window.printOrderReceipt = function(orderId) {
        console.log('Print order receipt called for ID:', orderId);
        
        const printContent = document.getElementById('printable-order-' + orderId);
        
        if (!printContent) {
            console.error('Printable content not found for order ID:', orderId);
            alert('Error: Order content not found. Please try again.');
            return;
        }
        
        console.log('Print content found, opening window...');
        
        const printWindow = window.open('', '_blank', 'width=800,height=600');
        
        if (!printWindow) {
            alert('Please allow pop-ups to print receipts');
            return;
        }
            
            printWindow.document.write(`
                <!DOCTYPE html>
                <html>
                <head>
                    <title>Order Receipt #${orderId}</title>
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
    ?><?php /**PATH D:\School-Projects\Software-dev\Kessly\resources\views\livewire\sales\orders.blade.php ENDPATH**/ ?>