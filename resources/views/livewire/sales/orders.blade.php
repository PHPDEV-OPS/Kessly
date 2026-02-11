<div>
    <!-- Status Message -->
    @if (session()->has('status'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <div class="d-flex align-items-center">
                <i class="ri-checkbox-circle-line ri-20px me-2"></i>
                <span>{{ session('status') }}</span>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Search and Filters -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row g-3 align-items-end">
                <div class="col-12 col-md-6">
                    <label class="form-label small text-muted">Search</label>
                    <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search by order #, customer..." class="form-control">
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
                            Add Order
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Orders Table -->
    <div class="table-responsive">
        <table class="table table-hover mb-0 table-stacked">
            <thead>
                <tr>
                    <th>
                        <button type="button" class="btn btn-sm btn-link text-decoration-none p-0 d-flex align-items-center gap-1" wire:click="sortBy('order_number')">
                            Order #
                            @if ($sortField === 'order_number')
                                <i class="ri-{{ $sortDirection === 'asc' ? 'arrow-up' : 'arrow-down' }}-s-line text-primary"></i>
                            @endif
                        </button>
                    </th>
                    <th>Customer</th>
                    <th>
                        <button type="button" class="btn btn-sm btn-link text-decoration-none p-0 d-flex align-items-center gap-1" wire:click="sortBy('order_date')">
                            Date
                            @if ($sortField === 'order_date')
                                <i class="ri-{{ $sortDirection === 'asc' ? 'arrow-up' : 'arrow-down' }}-s-line text-primary"></i>
                            @endif
                        </button>
                    </th>
                    <th>
                        <button type="button" class="btn btn-sm btn-link text-decoration-none p-0 d-flex align-items-center gap-1" wire:click="sortBy('total_amount')">
                            Total
                            @if ($sortField === 'total_amount')
                                <i class="ri-{{ $sortDirection === 'asc' ? 'arrow-up' : 'arrow-down' }}-s-line text-primary"></i>
                            @endif
                        </button>
                    </th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($orders as $order)
                    <tr>
                        <td data-label="Order #">
                            <div class="d-flex align-items-center gap-2">
                                <div class="avatar avatar-sm">
                                    <span class="avatar-initial rounded bg-label-primary">
                                        <i class="ri-file-list-3-line"></i>
                                    </span>
                                </div>
                                <span class="fw-medium">{{ $order->order_number }}</span>
                            </div>
                        </td>
                        <td data-label="Customer">{{ $order->customer?->name ?? '—' }}</td>
                        <td data-label="Date">{{ optional($order->order_date)->format('M d, Y') }}</td>
                        <td data-label="Total"><span class="fw-semibold">Ksh {{ number_format($order->total_amount, 2) }}</span></td>
                        <td class="text-end" data-label="Actions">
                            <div class="d-flex align-items-center justify-content-end gap-1">
                                <button type="button" class="btn btn-sm btn-icon btn-text-secondary rounded-pill" wire:click="view({{ $order->id }})" title="View">
                                    <i class="ri-eye-line ri-20px"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-icon btn-text-secondary rounded-pill" wire:click="edit({{ $order->id }})" title="Edit">
                                    <i class="ri-edit-line ri-20px"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-icon btn-text-danger rounded-pill" wire:click="delete({{ $order->id }})" onclick="return confirm('Are you sure you want to delete this order?')" title="Delete">
                                    <i class="ri-delete-bin-line ri-20px"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
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
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination and Stats -->
    <div class="card-footer border-top">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            @if($orders->hasPages())
                <nav aria-label="Order pagination" class="w-100">
                    {{ $orders->links('pagination::bootstrap-5') }}
                </nav>
            @else
                <small class="text-muted">
                    <i class="ri-information-line me-1"></i>
                    Showing {{ $orders->firstItem() ?? 0 }} to {{ $orders->lastItem() ?? 0 }} of {{ $orders->total() }} orders
                </small>
            @endif
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
    @if ($showForm)
        <div class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0, 0, 0, 0.5);">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <form wire:submit.prevent="save">
                        <div class="modal-header">
                            <h5 class="modal-title">
                                <i class="ri-{{ $orderId ? 'edit' : 'add' }}-line me-2"></i>
                                {{ $orderId ? 'Edit Order' : 'Add New Order' }}
                            </h5>
                            <button type="button" class="btn-close" wire:click="cancel"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label" for="order_number">Order Number</label>
                                    <input type="text" id="order_number" class="form-control @error('order_number') is-invalid @enderror" wire:model.defer="order_number">
                                    @error('order_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="customer_id">Customer</label>
                                    <select id="customer_id" class="form-select @error('customer_id') is-invalid @enderror" wire:model.defer="customer_id">
                                        <option value="">Select customer</option>
                                        @foreach ($customers as $c)
                                            <option value="{{ $c->id }}">{{ $c->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('customer_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="order_date">Order Date</label>
                                    <input type="date" id="order_date" class="form-control @error('order_date') is-invalid @enderror" wire:model.defer="order_date">
                                    @error('order_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="total_amount">Total Amount</label>
                                    <div class="input-group">
                                        <span class="input-group-text">$</span>
                                        <input type="number" step="0.01" min="0" id="total_amount" class="form-control @error('total_amount') is-invalid @enderror" wire:model.defer="total_amount">
                                    </div>
                                    @error('total_amount')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
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
    @endif

    <!-- View Order Modal -->
    @if ($showView && $viewingOrder)
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
                                                <h5 class="mb-0">{{ $viewingOrder->order_number }}</h5>
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
                                    <span class="fw-medium">{{ $viewingOrder->customer?->name ?? 'N/A' }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-muted small">Order Date</label>
                                <div class="d-flex align-items-center">
                                    <i class="ri-calendar-line me-2 text-primary"></i>
                                    <span class="fw-medium">{{ optional($viewingOrder->order_date)->format('M d, Y') ?? 'N/A' }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-muted small">Total Amount</label>
                                <div class="d-flex align-items-center">
                                    <i class="ri-money-dollar-circle-line me-2 text-success"></i>
                                    <span class="fw-bold text-success fs-5">${{ number_format($viewingOrder->total_amount, 2) }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-muted small">Created</label>
                                <div class="d-flex align-items-center">
                                    <i class="ri-time-line me-2 text-primary"></i>
                                    <span class="fw-medium">{{ $viewingOrder->created_at->format('M d, Y g:i A') }}</span>
                                </div>
                            </div>
                            @if($viewingOrder->customer)
                                <div class="col-12">
                                    <div class="card bg-label-secondary mb-0">
                                        <div class="card-body">
                                            <h6 class="mb-3">
                                                <i class="ri-information-line me-2"></i>
                                                Customer Information
                                            </h6>
                                            <div class="row g-3">
                                                @if($viewingOrder->customer->email)
                                                    <div class="col-md-6">
                                                        <small class="text-muted d-block">Email</small>
                                                        <a href="mailto:{{ $viewingOrder->customer->email }}" class="text-primary">
                                                            {{ $viewingOrder->customer->email }}
                                                        </a>
                                                    </div>
                                                @endif
                                                @if($viewingOrder->customer->phone)
                                                    <div class="col-md-6">
                                                        <small class="text-muted d-block">Phone</small>
                                                        <span>{{ $viewingOrder->customer->phone }}</span>
                                                    </div>
                                                @endif
                                                @if($viewingOrder->customer->address)
                                                    <div class="col-12">
                                                        <small class="text-muted d-block">Address</small>
                                                        <span>{{ $viewingOrder->customer->address }}</span>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-label-secondary" wire:click="closeView">Close</button>
                        <button type="button" class="btn btn-info" onclick="printOrderReceipt({{ $viewingOrder->id }})">
                            <i class="ri-printer-line me-1"></i>
                            Print
                        </button>
                        <button type="button" class="btn btn-primary" wire:click="edit({{ $viewingOrder->id }})">
                            <i class="ri-edit-line me-1"></i>
                            Edit Order
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Printable Order Receipt -->
        <div id="printable-order-{{ $viewingOrder->id }}" style="display: none;">
            <div style="max-width: 800px; margin: 0 auto; padding: 40px; font-family: Arial, sans-serif; color: #333;">
                <!-- Header -->
                <div style="text-align: center; margin-bottom: 30px; border-bottom: 3px solid #7367f0; padding-bottom: 20px;">
                    <h1 style="margin: 0; color: #7367f0; font-size: 32px;">ORDER RECEIPT</h1>
                    <p style="margin: 5px 0 0 0; color: #666; font-size: 14px;">{{ config('app.name', 'KESSLY') }}</p>
                </div>

                <!-- Order Info -->
                <div style="background: #f8f9fa; padding: 20px; border-radius: 8px; margin-bottom: 30px;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <tr>
                            <td style="padding: 8px 0; width: 50%;">
                                <strong style="color: #666; font-size: 12px;">ORDER NUMBER</strong><br>
                                <span style="font-size: 18px; font-weight: bold; color: #7367f0;">{{ $viewingOrder->order_number }}</span>
                            </td>
                            <td style="padding: 8px 0; text-align: right;">
                                <strong style="color: #666; font-size: 12px;">ORDER DATE</strong><br>
                                <span style="font-size: 16px;">{{ optional($viewingOrder->order_date)->format('M d, Y') }}</span>
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
                            <td style="padding: 5px 0;">{{ $viewingOrder->customer?->name ?? 'N/A' }}</td>
                        </tr>
                        @if($viewingOrder->customer?->email)
                        <tr>
                            <td style="padding: 5px 0;"><strong>Email:</strong></td>
                            <td style="padding: 5px 0;">{{ $viewingOrder->customer->email }}</td>
                        </tr>
                        @endif
                        @if($viewingOrder->customer?->phone)
                        <tr>
                            <td style="padding: 5px 0;"><strong>Phone:</strong></td>
                            <td style="padding: 5px 0;">{{ $viewingOrder->customer->phone }}</td>
                        </tr>
                        @endif
                        @if($viewingOrder->customer?->address)
                        <tr>
                            <td style="padding: 5px 0;"><strong>Address:</strong></td>
                            <td style="padding: 5px 0;">{{ $viewingOrder->customer->address }}</td>
                        </tr>
                        @endif
                    </table>
                </div>

                <!-- Order Total -->
                <div style="background: linear-gradient(135deg, #7367f0 0%, #9055fd 100%); color: white; padding: 25px; border-radius: 8px; margin-bottom: 30px;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <tr>
                            <td style="font-size: 18px; padding: 0;">Total Amount</td>
                            <td style="text-align: right; font-size: 32px; font-weight: bold; padding: 0;">${{ number_format($viewingOrder->total_amount, 2) }}</td>
                        </tr>
                    </table>
                </div>

                <!-- Footer -->
                <div style="text-align: center; color: #999; font-size: 12px; border-top: 2px solid #e0e0e0; padding-top: 20px;">
                    <p style="margin: 5px 0;">Printed on {{ now()->format('F d, Y \a\t g:i A') }}</p>
                    <p style="margin: 5px 0;">Thank you for your business!</p>
                </div>
            </div>
        </div>
    @endif
</div>

@script
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
@endscript
