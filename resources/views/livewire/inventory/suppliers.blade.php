<div>
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
                    <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search by name, email, phone..." class="form-control">
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
                        Add Supplier
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Suppliers Table -->
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>
                            <button type="button" class="btn btn-sm btn-link text-decoration-none p-0 d-flex align-items-center gap-1" wire:click="sortBy('name')">
                                Name
                                @if ($sortField === 'name')
                                    <i class="ri-{{ $sortDirection === 'asc' ? 'arrow-up' : 'arrow-down' }}-s-line text-primary"></i>
                                @endif
                            </button>
                        </th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($suppliers as $sup)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar avatar-sm me-3">
                                        <span class="avatar-initial rounded bg-label-info">
                                            <i class="ri-truck-line ri-20px"></i>
                                        </span>
                                    </div>
                                    <h6 class="mb-0">{{ $sup->name }}</h6>
                                </div>
                            </td>
                            <td>
                                @if($sup->contact_email)
                                    <a href="mailto:{{ $sup->contact_email }}" class="text-decoration-none">
                                        <i class="ri-mail-line ri-16px me-1"></i>{{ $sup->contact_email }}
                                    </a>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>
                            <td>
                                @if($sup->phone)
                                    <i class="ri-phone-line ri-16px me-1"></i>{{ $sup->phone }}
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>
                            <td>{{ $sup->address ?? '—' }}</td>
                            <td class="text-end">
                                <div class="d-flex justify-content-end gap-1">
                                    <button type="button" class="btn btn-sm btn-icon btn-text-secondary rounded-pill" wire:click="edit({{ $sup->id }})" title="Edit">
                                        <i class="ri-edit-line ri-20px"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-icon btn-text-danger rounded-pill" wire:click="delete({{ $sup->id }})" onclick="return confirm('Delete this supplier?')" title="Delete">
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
                                            <i class="ri-truck-line ri-48px"></i>
                                        </span>
                                    </div>
                                    <h6 class="mb-1">No suppliers found</h6>
                                    <p class="text-muted small mb-0">Add suppliers to manage your inventory sources.</p>
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
                        Showing {{ $suppliers->firstItem() ?? 0 }} to {{ $suppliers->lastItem() ?? 0 }} of {{ $suppliers->total() }} suppliers
                    </small>
                </div>
                @if($suppliers->hasPages())
                    <nav aria-label="Supplier pagination">
                        {{ $suppliers->links('pagination::bootstrap-5') }}
                    </nav>
                @endif
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

    <!-- Create/Edit Modal -->
    @if ($showForm)
        <div class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0, 0, 0, 0.5);">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="ri-{{ $supplierId ? 'edit' : 'add' }}-line me-2"></i>
                            {{ $supplierId ? 'Edit Supplier' : 'New Supplier' }}
                        </h5>
                        <button type="button" class="btn-close" wire:click="cancel" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" wire:model.defer="name" placeholder="Supplier name">
                                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control @error('contact_email') is-invalid @enderror" wire:model.defer="contact_email" placeholder="email@example.com">
                                @error('contact_email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Phone</label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror" wire:model.defer="phone" placeholder="+1 234 567 8900">
                                @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Address</label>
                                <input type="text" class="form-control @error('address') is-invalid @enderror" wire:model.defer="address" placeholder="123 Main St, City">
                                @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-12">
                                <label class="form-label">Notes</label>
                                <textarea rows="3" class="form-control @error('notes') is-invalid @enderror" wire:model.defer="notes" placeholder="Additional notes about this supplier"></textarea>
                                @error('notes') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-label-secondary" wire:click="cancel">Cancel</button>
                        <button type="button" class="btn btn-primary" wire:click="save">
                            <i class="ri-save-line me-1"></i>
                            {{ $supplierId ? 'Update' : 'Create' }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
