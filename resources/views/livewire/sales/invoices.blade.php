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
                <div class="col-md-6">
                    <label class="form-label small text-muted">Search</label>
                    <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search by invoice name, customer..." class="form-control">
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
                        Add Invoice
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Invoices Table -->
    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>Invoice Name</th>
                    <th>Customer</th>
                    <th>
                        <button type="button" class="btn btn-sm btn-link text-decoration-none p-0 d-flex align-items-center gap-1" wire:click="sortBy('created_at')">
                            Date
                            @if ($sortField === 'created_at')
                                <i class="ri-{{ $sortDirection === 'asc' ? 'arrow-up' : 'arrow-down' }}-s-line text-primary"></i>
                            @endif
                        </button>
                    </th>
                    <th>
                        <button type="button" class="btn btn-sm btn-link text-decoration-none p-0 d-flex align-items-center gap-1" wire:click="sortBy('amount')">
                            Amount
                            @if ($sortField === 'amount')
                                <i class="ri-{{ $sortDirection === 'asc' ? 'arrow-up' : 'arrow-down' }}-s-line text-primary"></i>
                            @endif
                        </button>
                    </th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($invoices as $invoice)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="avatar avatar-sm">
                                    <span class="avatar-initial rounded bg-label-info">
                                        <i class="ri-bill-line"></i>
                                    </span>
                                </div>
                                <span class="fw-medium">{{ $invoice->name }}</span>
                            </div>
                        </td>
                        <td>{{ $invoice->customer?->name ?? '—' }}</td>
                        <td>{{ optional($invoice->created_at)->format('M d, Y') }}</td>
                        <td><span class="fw-semibold">Ksh {{ number_format($invoice->amount, 2) }}</span></td>
                        <td>
                            <div class="d-flex align-items-center justify-content-end gap-1">
                                <button type="button" class="btn btn-sm btn-icon btn-text-secondary rounded-pill" wire:click="view({{ $invoice->id }})" title="View">
                                    <i class="ri-eye-line ri-20px"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-icon btn-text-secondary rounded-pill" wire:click="edit({{ $invoice->id }})" title="Edit">
                                    <i class="ri-edit-line ri-20px"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-icon btn-text-danger rounded-pill" wire:click="delete({{ $invoice->id }})" onclick="return confirm('Are you sure you want to delete this invoice?')" title="Delete">
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
                                        <i class="ri-bill-line ri-48px"></i>
                                    </span>
                                </div>
                                <h6 class="mb-1">No invoices found</h6>
                                <p class="text-muted small mb-0">Get started by creating your first invoice.</p>
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
            <div class="d-flex align-items-center gap-3">
                <small class="text-muted">
                    <i class="ri-information-line me-1"></i>
                    Showing {{ $invoices->firstItem() ?? 0 }} to {{ $invoices->lastItem() ?? 0 }} of {{ $invoices->total() }} invoices
                </small>
            </div>
            @if($invoices->hasPages())
                <nav aria-label="Invoice pagination">
                    {{ $invoices->links('pagination::bootstrap-5') }}
                </nav>
            @endif
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
    @if ($showForm)
        <div class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0, 0, 0, 0.5);">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <form wire:submit.prevent="save">
                        <div class="modal-header">
                            <h5 class="modal-title">
                                <i class="ri-{{ $invoiceId ? 'edit' : 'add' }}-line me-2"></i>
                                {{ $invoiceId ? 'Edit Invoice' : 'Add New Invoice' }}
                            </h5>
                            <button type="button" class="btn-close" wire:click="cancel"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label" for="invoice_name">Invoice Name</label>
                                    <input type="text" id="invoice_name" class="form-control @error('name') is-invalid @enderror" wire:model.defer="name">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="invoice_customer_id">Customer</label>
                                    <select id="invoice_customer_id" class="form-select @error('customer_id') is-invalid @enderror" wire:model.defer="customer_id">
                                        <option value="">Select customer</option>
                                        @foreach ($customers as $c)
                                            <option value="{{ $c->id }}">{{ $c->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('customer_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-12">
                                    <label class="form-label" for="invoice_amount">Amount</label>
                                    <div class="input-group">
                                        <span class="input-group-text">$</span>
                                        <input type="number" step="0.01" min="0" id="invoice_amount" class="form-control @error('amount') is-invalid @enderror" wire:model.defer="amount">
                                    </div>
                                    @error('amount')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-label-secondary" wire:click="cancel">Cancel</button>
                            <button type="submit" class="btn btn-primary">
                                <i class="ri-save-line me-1"></i>
                                Save Invoice
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <!-- View Invoice Modal -->
    @if ($showView && $viewingInvoice)
        <div class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0, 0, 0, 0.5);">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="ri-eye-line me-2"></i>
                            Invoice Details
                        </h5>
                        <button type="button" class="btn-close" wire:click="closeView"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-4">
                            <div class="col-12">
                                <div class="card bg-label-info mb-0">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-lg me-3">
                                                <span class="avatar-initial rounded bg-label-info">
                                                    <i class="ri-bill-line ri-36px"></i>
                                                </span>
                                            </div>
                                            <div>
                                                <h5 class="mb-0">{{ $viewingInvoice->name }}</h5>
                                                <p class="text-muted small mb-0">Invoice Name</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-muted small">Customer</label>
                                <div class="d-flex align-items-center">
                                    <i class="ri-user-line me-2 text-primary"></i>
                                    <span class="fw-medium">{{ $viewingInvoice->customer?->name ?? 'N/A' }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-muted small">Amount</label>
                                <div class="d-flex align-items-center">
                                    <i class="ri-money-dollar-circle-line me-2 text-success"></i>
                                    <span class="fw-bold text-success fs-5">${{ number_format($viewingInvoice->amount, 2) }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-muted small">Created Date</label>
                                <div class="d-flex align-items-center">
                                    <i class="ri-calendar-line me-2 text-primary"></i>
                                    <span class="fw-medium">{{ $viewingInvoice->created_at->format('M d, Y') }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-muted small">Last Updated</label>
                                <div class="d-flex align-items-center">
                                    <i class="ri-time-line me-2 text-primary"></i>
                                    <span class="fw-medium">{{ $viewingInvoice->updated_at->format('M d, Y g:i A') }}</span>
                                </div>
                            </div>
                            @if($viewingInvoice->customer)
                                <div class="col-12">
                                    <div class="card bg-label-secondary mb-0">
                                        <div class="card-body">
                                            <h6 class="mb-3">
                                                <i class="ri-information-line me-2"></i>
                                                Customer Information
                                            </h6>
                                            <div class="row g-3">
                                                @if($viewingInvoice->customer->email)
                                                    <div class="col-md-6">
                                                        <small class="text-muted d-block">Email</small>
                                                        <a href="mailto:{{ $viewingInvoice->customer->email }}" class="text-primary">
                                                            {{ $viewingInvoice->customer->email }}
                                                        </a>
                                                    </div>
                                                @endif
                                                @if($viewingInvoice->customer->phone)
                                                    <div class="col-md-6">
                                                        <small class="text-muted d-block">Phone</small>
                                                        <span>{{ $viewingInvoice->customer->phone }}</span>
                                                    </div>
                                                @endif
                                                @if($viewingInvoice->customer->address)
                                                    <div class="col-12">
                                                        <small class="text-muted d-block">Address</small>
                                                        <span>{{ $viewingInvoice->customer->address }}</span>
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
                        <button type="button" class="btn btn-info" onclick="printInvoiceDocument({{ $viewingInvoice->id }})">
                            <i class="ri-printer-line me-1"></i>
                            Print
                        </button>
                        <button type="button" class="btn btn-primary" wire:click="edit({{ $viewingInvoice->id }})">
                            <i class="ri-edit-line me-1"></i>
                            Edit Invoice
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Printable Invoice -->
        <div id="printable-invoice-{{ $viewingInvoice->id }}" style="display: none;">
            <div style="max-width: 800px; margin: 0 auto; padding: 40px; font-family: Arial, sans-serif; color: #333;">
                <!-- Header -->
                <div style="text-align: center; margin-bottom: 30px; border-bottom: 3px solid #17a2b8; padding-bottom: 20px;">
                    <h1 style="margin: 0; color: #17a2b8; font-size: 32px;">INVOICE</h1>
                    <p style="margin: 5px 0 0 0; color: #666; font-size: 14px;">{{ config('app.name', 'KESSLY') }}</p>
                </div>

                <!-- Invoice Info -->
                <div style="background: #f8f9fa; padding: 20px; border-radius: 8px; margin-bottom: 30px;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <tr>
                            <td style="padding: 8px 0; width: 50%;">
                                <strong style="color: #666; font-size: 12px;">INVOICE NAME</strong><br>
                                <span style="font-size: 18px; font-weight: bold; color: #17a2b8;">{{ $viewingInvoice->name }}</span>
                            </td>
                            <td style="padding: 8px 0; text-align: right;">
                                <strong style="color: #666; font-size: 12px;">DATE</strong><br>
                                <span style="font-size: 16px;">{{ $viewingInvoice->created_at->format('M d, Y') }}</span>
                            </td>
                        </tr>
                    </table>
                </div>

                <!-- Bill To -->
                <div style="margin-bottom: 30px;">
                    <h3 style="color: #17a2b8; border-bottom: 2px solid #e0e0e0; padding-bottom: 10px; margin-bottom: 15px;">Bill To</h3>
                    <table style="width: 100%; border-collapse: collapse;">
                        <tr>
                            <td style="padding: 5px 0;"><strong>Customer:</strong></td>
                            <td style="padding: 5px 0;">{{ $viewingInvoice->customer?->name ?? 'N/A' }}</td>
                        </tr>
                        @if($viewingInvoice->customer?->email)
                        <tr>
                            <td style="padding: 5px 0;"><strong>Email:</strong></td>
                            <td style="padding: 5px 0;">{{ $viewingInvoice->customer->email }}</td>
                        </tr>
                        @endif
                        @if($viewingInvoice->customer?->phone)
                        <tr>
                            <td style="padding: 5px 0;"><strong>Phone:</strong></td>
                            <td style="padding: 5px 0;">{{ $viewingInvoice->customer->phone }}</td>
                        </tr>
                        @endif
                        @if($viewingInvoice->customer?->address)
                        <tr>
                            <td style="padding: 5px 0;"><strong>Address:</strong></td>
                            <td style="padding: 5px 0;">{{ $viewingInvoice->customer->address }}</td>
                        </tr>
                        @endif
                    </table>
                </div>

                <!-- Amount Due -->
                <div style="background: linear-gradient(135deg, #17a2b8 0%, #138496 100%); color: white; padding: 25px; border-radius: 8px; margin-bottom: 30px;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <tr>
                            <td style="font-size: 18px; padding: 0;">Amount Due</td>
                            <td style="text-align: right; font-size: 32px; font-weight: bold; padding: 0;">${{ number_format($viewingInvoice->amount, 2) }}</td>
                        </tr>
                    </table>
                </div>

                <!-- Footer -->
                <div style="text-align: center; color: #999; font-size: 12px; border-top: 2px solid #e0e0e0; padding-top: 20px;">
                    <p style="margin: 5px 0;">Invoice generated on {{ now()->format('F d, Y \a\t g:i A') }}</p>
                    <p style="margin: 5px 0;">Thank you for your business!</p>
                </div>
            </div>
        </div>
    @endif
</div>

@script
<script>
    window.printInvoiceDocument = function(invoiceId) {
        console.log('Print invoice called for ID:', invoiceId);
        
        const printContent = document.getElementById('printable-invoice-' + invoiceId);
        
        if (!printContent) {
            console.error('Printable content not found for invoice ID:', invoiceId);
            alert('Error: Invoice content not found. Please try again.');
            return;
        }
        
        console.log('Print content found, opening window...');
        
        const printWindow = window.open('', '_blank', 'width=800,height=600');
        
        if (!printWindow) {
            alert('Please allow pop-ups to print invoices');
            return;
        }
        
        printWindow.document.write(`
            <!DOCTYPE html>
            <html>
            <head>
                <title>Invoice #${invoiceId}</title>
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
</div>
