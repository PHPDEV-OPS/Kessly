<div>
    @if (session()->has('message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Search and Filter Section -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search branches..." class="form-control">
                </div>
                <div class="col-md-3">
                    <select wire:model.live="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
                <div class="col-md-3 text-end">
                    <button wire:click.prevent="create" type="button" class="btn btn-primary">
                        <i class="ri-add-line me-1"></i> Add Branch
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Branches Grid -->
    <div class="row g-4 mb-4">
        @forelse($branches as $branch)
            <div class="col-md-6 col-lg-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="d-flex align-items-center">
                                <div class="avatar me-3">
                                    <span class="avatar-initial rounded-circle bg-label-primary">
                                        {{ strtoupper(substr($branch->name, 0, 2)) }}
                                    </span>
                                </div>
                                <div>
                                    <h5 class="mb-0">{{ $branch->name }}</h5>
                                    <small class="text-muted">{{ $branch->code }}</small>
                                </div>
                            </div>
                            <span class="badge bg-label-{{ $branch->status === 'active' ? 'success' : 'secondary' }}">
                                {{ ucfirst($branch->status) }}
                            </span>
                        </div>
                        
                        <div class="mb-3">
                            <div class="d-flex align-items-center mb-2">
                                <i class="ri-map-pin-line me-2 text-muted"></i>
                                <small>{{ $branch->city }}, {{ $branch->state }}</small>
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <i class="ri-phone-line me-2 text-muted"></i>
                                <small>{{ $branch->phone }}</small>
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <i class="ri-user-line me-2 text-muted"></i>
                                <small>Manager: {{ $branch->manager?->user?->name ?? 'Not Assigned' }}</small>
                            </div>
                            <div class="d-flex align-items-center">
                                <i class="ri-team-line me-2 text-muted"></i>
                                <small>Employees: {{ $branch->employees->count() }}</small>
                            </div>
                        </div>
                        
                        <div class="d-flex gap-2">
                            <button wire:click.prevent="edit({{ $branch->id }})" class="btn btn-sm btn-outline-primary flex-fill">
                                <i class="ri-edit-line me-1"></i> Edit
                            </button>
                            <button wire:click.prevent="delete({{ $branch->id }})" 
                                    wire:loading.attr="disabled"
                                    onclick="return confirm('Are you sure you want to delete this branch?')"
                                    class="btn btn-sm btn-outline-danger">
                                <span wire:loading.remove wire:target="delete({{ $branch->id }})">
                                    <i class="ri-delete-bin-line"></i>
                                </span>
                                <span wire:loading wire:target="delete({{ $branch->id }})">
                                    <span class="spinner-border spinner-border-sm"></span>
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="text-center py-5">
                    <div class="avatar avatar-xl mx-auto mb-3">
                        <span class="avatar-initial rounded-circle bg-label-secondary">
                            <i class="ri-store-line ri-48px"></i>
                        </span>
                    </div>
                    <h5 class="mb-2">No branches found</h5>
                    <p class="text-muted">Get started by creating your first branch.</p>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $branches->links() }}
    </div>

    <!-- Modal for Add/Edit Branch -->
    @if($showModal)
        <div class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0,0,0,0.5);" wire:click.self="closeModal">
            <div class="modal-dialog modal-lg modal-dialog-centered" wire:click.stop>
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ $editing ? 'Edit Branch' : 'Add New Branch' }}</h5>
                        <button type="button" class="btn-close" wire:click.prevent="closeModal"></button>
                    </div>
                    
                    <form wire:submit.prevent="save">
                        <div class="modal-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Branch Name <span class="text-danger">*</span></label>
                                    <input type="text" wire:model="name" class="form-control @error('name') is-invalid @enderror">
                                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Branch Code <span class="text-danger">*</span></label>
                                    <input type="text" wire:model="code" class="form-control @error('code') is-invalid @enderror">
                                    @error('code') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-12">
                                    <label class="form-label">Address <span class="text-danger">*</span></label>
                                    <input type="text" wire:model="address" class="form-control @error('address') is-invalid @enderror">
                                    @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">City <span class="text-danger">*</span></label>
                                    <input type="text" wire:model="city" class="form-control @error('city') is-invalid @enderror">
                                    @error('city') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">State <span class="text-danger">*</span></label>
                                    <input type="text" wire:model="state" class="form-control @error('state') is-invalid @enderror">
                                    @error('state') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">Postal Code <span class="text-danger">*</span></label>
                                    <input type="text" wire:model="postal_code" class="form-control @error('postal_code') is-invalid @enderror">
                                    @error('postal_code') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Phone <span class="text-danger">*</span></label>
                                    <input type="text" wire:model="phone" class="form-control @error('phone') is-invalid @enderror">
                                    @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" wire:model="email" class="form-control @error('email') is-invalid @enderror">
                                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">Manager</label>
                                    <select wire:model="manager_id" class="form-select @error('manager_id') is-invalid @enderror">
                                        <option value="">Select Manager (Optional)</option>
                                        @foreach($managers as $manager)
                                            <option value="{{ $manager->id }}">{{ $manager->user ? $manager->user->name : 'N/A' }} - {{ $manager->position }}</option>
                                        @endforeach
                                    </select>
                                    @error('manager_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">Established Date <span class="text-danger">*</span></label>
                                    <input type="date" wire:model="established_date" class="form-control @error('established_date') is-invalid @enderror">
                                    @error('established_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">Status <span class="text-danger">*</span></label>
                                    <select wire:model="branch_status" class="form-select @error('branch_status') is-invalid @enderror">
                                        <option value="active">Active</option>
                                        <option value="inactive">Inactive</option>
                                    </select>
                                    @error('branch_status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-12">
                                    <label class="form-label">Description</label>
                                    <textarea wire:model="description" rows="3" class="form-control @error('description') is-invalid @enderror"></textarea>
                                    @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" wire:click.prevent="closeModal" class="btn btn-label-secondary">
                                Cancel
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <span wire:loading.remove wire:target="save">
                                    {{ $editing ? 'Update' : 'Create' }} Branch
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