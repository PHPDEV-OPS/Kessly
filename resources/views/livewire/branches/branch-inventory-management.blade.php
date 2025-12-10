<div>
    @if (session()->has('message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Statistics Cards -->
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar me-3">
                            <span class="avatar-initial rounded-circle bg-label-primary">
                                <i class="ri-box-3-line ri-22px"></i>
                            </span>
                        </div>
                        <div>
                            <div class="text-muted small">Total Items</div>
                            <h5 class="mb-0">{{ number_format($totalItems) }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar me-3">
                            <span class="avatar-initial rounded-circle bg-label-warning">
                                <i class="ri-error-warning-line ri-22px"></i>
                            </span>
                        </div>
                        <div>
                            <div class="text-muted small">Low Stock</div>
                            <h5 class="mb-0 text-warning">{{ $lowStockItems }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar me-3">
                            <span class="avatar-initial rounded-circle bg-label-danger">
                                <i class="ri-close-circle-line ri-22px"></i>
                            </span>
                        </div>
                        <div>
                            <div class="text-muted small">Out of Stock</div>
                            <h5 class="mb-0 text-danger">{{ $outOfStockItems }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Filter Section -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search products or branches..." class="form-control">
                </div>
                <div class="col-md-3">
                    <select wire:model.live="selectedBranch" class="form-select">
                        <option value="">All Branches</option>
                        @foreach($branches as $branch)
                            <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 text-end">
                    <button wire:click.prevent="create" type="button" class="btn btn-primary">
                        <i class="ri-add-line me-1"></i> Add Inventory
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Inventory Table -->
    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Branch</th>
                        <th>Quantity</th>
                        <th>Min Stock</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($inventory as $item)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar avatar-sm me-2">
                                        <span class="avatar-initial rounded bg-label-secondary">
                                            {{ strtoupper(substr($item->product->name ?? 'N/A', 0, 2)) }}
                                        </span>
                                    </div>
                                    <div>
                                        <div class="fw-medium">{{ $item->product->name ?? 'N/A' }}</div>
                                        <small class="text-muted">SKU: {{ $item->product->sku ?? 'N/A' }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $item->branch->name ?? 'N/A' }}</td>
                            <td>{{ number_format($item->quantity) }}</td>
                            <td>{{ number_format($item->min_stock_level) }}</td>
                            <td>
                                @if($item->quantity == 0)
                                    <span class="badge bg-label-danger">Out of Stock</span>
                                @elseif($item->quantity <= $item->min_stock_level)
                                    <span class="badge bg-label-warning">Low Stock</span>
                                @else
                                    <span class="badge bg-label-success">In Stock</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    <button wire:click.prevent="edit({{ $item->id }})" class="btn btn-sm btn-text-primary">
                                        <i class="ri-edit-line"></i>
                                    </button>
                                    <button wire:click.prevent="delete({{ $item->id }})" 
                                            onclick="return confirm('Are you sure you want to delete this inventory item?')"
                                            class="btn btn-sm btn-text-danger">
                                        <i class="ri-delete-bin-line"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">
                                No inventory items found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $inventory->links('pagination::bootstrap-5') }}
    </div>

    <style>
        .pagination .page-link svg {
            display: none;
        }
        .pagination .page-link {
            padding: 0.375rem 0.75rem;
        }
    </style>

    <!-- Modal for Add/Edit Inventory -->
    @if($showModal)
        <div class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0,0,0,0.5);" wire:click.self="closeModal">
            <div class="modal-dialog modal-dialog-centered" wire:click.stop>
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ $editing ? 'Edit Branch Inventory' : 'Add Branch Inventory' }}</h5>
                        <button type="button" class="btn-close" wire:click.prevent="closeModal"></button>
                    </div>
                    
                    <form wire:submit.prevent="save">
                        <div class="modal-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Branch <span class="text-danger">*</span></label>
                                    <select wire:model="branch_id" class="form-select @error('branch_id') is-invalid @enderror">
                                        <option value="">Select Branch</option>
                                        @foreach($branches as $branch)
                                            <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('branch_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Product <span class="text-danger">*</span></label>
                                    <select wire:model="product_id" class="form-select @error('product_id') is-invalid @enderror">
                                        <option value="">Select Product</option>
                                        @foreach($products as $product)
                                            <option value="{{ $product->id }}">{{ $product->name }} ({{ $product->sku }})</option>
                                        @endforeach
                                    </select>
                                    @error('product_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">Quantity <span class="text-danger">*</span></label>
                                    <input type="number" wire:model="quantity" class="form-control @error('quantity') is-invalid @enderror">
                                    @error('quantity') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">Min Stock Level</label>
                                    <input type="number" wire:model="min_stock_level" class="form-control @error('min_stock_level') is-invalid @enderror">
                                    @error('min_stock_level') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">Max Stock Level</label>
                                    <input type="number" wire:model="max_stock_level" class="form-control @error('max_stock_level') is-invalid @enderror">
                                    @error('max_stock_level') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-12">
                                    <label class="form-label">Notes</label>
                                    <textarea wire:model="notes" rows="2" class="form-control @error('notes') is-invalid @enderror"></textarea>
                                    @error('notes') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" wire:click.prevent="closeModal" class="btn btn-label-secondary">
                                Cancel
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <span wire:loading.remove wire:target="save">
                                    {{ $editing ? 'Update' : 'Add' }} Inventory
                                </span>
                                <span wire:loading wire:target="save">
                                    <span class="spinner-border spinner-border-sm me-1"></span> Saving...
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>