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

    <!-- Header -->
    <div class="d-flex align-items-center gap-2 mb-3">
        <div class="avatar avatar-sm">
            <span class="avatar-initial rounded bg-label-primary"><i class="ri-folder-2-line"></i></span>
        </div>
        <div>
            <h5 class="mb-0">Categories</h5>
            <small class="text-muted">Organize products into groups</small>
        </div>
    </div>

    <!-- Search and Filters -->
    <div class="card mb-3">
        <div class="card-body">
            <div class="row g-3 align-items-end">
                <div class="col-12 col-md-6">
                    <label class="form-label small text-muted">Search</label>
                    <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search by name, slug, description..." class="form-control">
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
                            Add Category
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Categories Table -->
    <div class="card mb-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-stacked mb-0">
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
                        <th>
                            <button type="button" class="btn btn-sm btn-link text-decoration-none p-0 d-flex align-items-center gap-1" wire:click="sortBy('slug')">
                                Slug
                                @if ($sortField === 'slug')
                                    <i class="ri-{{ $sortDirection === 'asc' ? 'arrow-up' : 'arrow-down' }}-s-line text-primary"></i>
                                @endif
                            </button>
                        </th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($categories as $cat)
                        <tr>
                            <td data-label="Name">
                                <div class="d-flex align-items-center">
                                    <div class="avatar avatar-sm me-3">
                                        <span class="avatar-initial rounded bg-label-primary">
                                            <i class="ri-folder-line ri-20px"></i>
                                        </span>
                                    </div>
                                    <h6 class="mb-0">{{ $cat->name }}</h6>
                                </div>
                            </td>
                            <td data-label="Slug"><span class="badge bg-label-secondary">{{ $cat->slug }}</span></td>
                            <td data-label="Actions" class="text-end">
                                <div class="d-flex justify-content-end justify-content-md-end gap-1 flex-wrap">
                                    <button type="button" class="btn btn-sm btn-icon btn-text-secondary rounded-pill" wire:click="edit({{ $cat->id }})" title="Edit">
                                        <i class="ri-edit-line ri-20px"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-icon btn-text-danger rounded-pill" wire:click="delete({{ $cat->id }})" onclick="return confirm('Delete this category?')" title="Delete">
                                        <i class="ri-delete-bin-line ri-20px"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center py-5">
                                <div class="d-flex flex-column align-items-center">
                                    <div class="avatar avatar-xl mb-3">
                                        <span class="avatar-initial rounded bg-label-secondary">
                                            <i class="ri-folder-open-line ri-48px"></i>
                                        </span>
                                    </div>
                                    <h6 class="mb-1">No categories found</h6>
                                    <p class="text-muted small mb-0">Create your first category to organize products.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            </div>
        </div>

        <!-- Pagination and Stats -->
        <div class="card-footer border-top">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <small class="text-muted">
                        <i class="ri-information-line me-1"></i>
                        Showing {{ $categories->firstItem() ?? 0 }} to {{ $categories->lastItem() ?? 0 }} of {{ $categories->total() }} categories
                    </small>
                </div>
                @if($categories->hasPages())
                    <nav aria-label="Category pagination">
                        {{ $categories->links('pagination::bootstrap-5') }}
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

    <!-- Create/Edit Modal -->
    @if ($showForm)
        <div class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0, 0, 0, 0.5);">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="ri-{{ $categoryId ? 'edit' : 'add' }}-line me-2"></i>
                            {{ $categoryId ? 'Edit Category' : 'New Category' }}
                        </h5>
                        <button type="button" class="btn-close" wire:click="cancel" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" wire:model.defer="name" placeholder="Category name">
                                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Slug</label>
                                <input type="text" class="form-control @error('slug') is-invalid @enderror" wire:model.defer="slug" placeholder="auto-generated">
                                <small class="text-muted">Leave blank to auto-generate</small>
                                @error('slug') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-label-secondary" wire:click="cancel">Cancel</button>
                        <button type="button" class="btn btn-primary" wire:click="save">
                            <i class="ri-save-line me-1"></i>
                            {{ $categoryId ? 'Update' : 'Create' }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
