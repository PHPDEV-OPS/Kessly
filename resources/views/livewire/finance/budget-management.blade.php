<div>
    @if (session()->has('message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Statistics Cards -->
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar me-3">
                            <span class="avatar-initial rounded-circle bg-label-primary">
                                <i class="ri-file-list-3-line ri-22px"></i>
                            </span>
                        </div>
                        <div>
                            <div class="text-muted small">Total Budgets</div>
                            <h5 class="mb-0">{{ $totalBudgets }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar me-3">
                            <span class="avatar-initial rounded-circle bg-label-success">
                                <i class="ri-check-double-line ri-22px"></i>
                            </span>
                        </div>
                        <div>
                            <div class="text-muted small">Approved</div>
                            <h5 class="mb-0 text-success">{{ $approvedBudgets }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar me-3">
                            <span class="avatar-initial rounded-circle bg-label-info">
                                <i class="ri-money-dollar-circle-line ri-22px"></i>
                            </span>
                        </div>
                        <div>
                            <div class="text-muted small">Total Allocated</div>
                            <h5 class="mb-0">${{ number_format($totalAllocated, 2) }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar me-3">
                            <span class="avatar-initial rounded-circle bg-label-danger">
                                <i class="ri-wallet-3-line ri-22px"></i>
                            </span>
                        </div>
                        <div>
                            <div class="text-muted small">Total Spent</div>
                            <h5 class="mb-0 text-danger">${{ number_format($totalSpent, 2) }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Filter Section -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row g-3 align-items-end">
                <div class="col-md-4">
                    <input type="text" wire:model.live="search" placeholder="Search budgets..." class="form-control">
                </div>
                <div class="col-md-2">
                    <select wire:model.live="category" class="form-select">
                        <option value="">All Categories</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}">{{ $cat }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select wire:model.live="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="draft">Draft</option>
                        <option value="approved">Approved</option>
                        <option value="rejected">Rejected</option>
                    </select>
                </div>
                <div class="col-md-4 text-end">
                    <button wire:click="create" type="button" class="btn btn-primary">
                        <i class="ri-add-line me-1"></i>
                        Create Budget
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Budget Cards -->
    <div class="row g-4">
        @forelse($budgets as $budget)
            <div class="col-lg-4 col-md-6">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <h5 class="card-title mb-0">{{ $budget->name }}</h5>
                            <span class="badge bg-label-{{ $budget->status === 'approved' ? 'success' : ($budget->status === 'draft' ? 'warning' : 'danger') }}">
                                {{ ucfirst($budget->status) }}
                            </span>
                        </div>
                        
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-2">
                                <small class="text-muted">Category:</small>
                                <small>{{ $budget->category }}</small>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <small class="text-muted">Branch:</small>
                                <small>{{ $budget->branch?->name ?? 'All Branches' }}</small>
                            </div>
                            <div class="d-flex justify-content-between">
                                <small class="text-muted">Period:</small>
                                <small>{{ $budget->period_start->format('M Y') }} - {{ $budget->period_end->format('M Y') }}</small>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-1">
                                <small class="text-muted">Budget Utilization</small>
                                <small>{{ $budget->utilization_percentage }}%</small>
                            </div>
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar" role="progressbar" style="width: {{ min($budget->utilization_percentage, 100) }}%" 
                                     aria-valuenow="{{ $budget->utilization_percentage }}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <div class="d-flex justify-content-between mt-1">
                                <small class="text-muted">${{ number_format($budget->spent_amount, 2) }} spent</small>
                                <small class="text-muted">${{ number_format($budget->allocated_amount, 2) }} allocated</small>
                            </div>
                        </div>
                        
                        <div class="d-flex gap-2">
                            @if($budget->status === 'draft')
                                <button wire:click="approve({{ $budget->id }})" class="btn btn-sm btn-success">
                                    <i class="ri-check-line me-1"></i>Approve
                                </button>
                                <button wire:click="reject({{ $budget->id }})" class="btn btn-sm btn-danger">
                                    <i class="ri-close-line me-1"></i>Reject
                                </button>
                            @endif
                            <button wire:click="edit({{ $budget->id }})" class="btn btn-sm btn-label-primary">
                                <i class="ri-edit-line"></i>
                            </button>
                            <button wire:click="delete({{ $budget->id }})" 
                                    onclick="return confirm('Are you sure you want to delete this budget?')"
                                    class="btn btn-sm btn-label-danger">
                                <i class="ri-delete-bin-line"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="text-center py-5">
                    <p class="text-muted mb-0">No budgets found. Get started by creating your first budget.</p>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($budgets->hasPages())
        <div class="mt-4">
            {{ $budgets->links() }}
        </div>
    @endif

    <!-- Modal for Add/Edit Budget -->
    @if($showModal)
        <div class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0,0,0,0.5);">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="ri-{{ $editing ? 'edit' : 'add' }}-line me-2"></i>
                            {{ $editing ? 'Edit Budget' : 'Create New Budget' }}
                        </h5>
                        <button type="button" class="btn-close" wire:click="closeModal"></button>
                    </div>
                    
                    <form wire:submit="save">
                        <div class="modal-body">
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label class="form-label fw-medium">Budget Name</label>
                                    <input type="text" wire:model="name" class="form-control @error('name') is-invalid @enderror">
                                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-medium">Category</label>
                                    <input type="text" wire:model="budget_category" class="form-control @error('budget_category') is-invalid @enderror">
                                    @error('budget_category') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-medium">Branch (Optional)</label>
                                    <select wire:model="branch_id" class="form-select @error('branch_id') is-invalid @enderror">
                                        <option value="">All Branches</option>
                                        @foreach($branches as $branch)
                                            <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('branch_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-medium">Allocated Amount</label>
                                    <div class="input-group">
                                        <span class="input-group-text">$</span>
                                        <input type="number" step="0.01" wire:model="allocated_amount" class="form-control @error('allocated_amount') is-invalid @enderror">
                                        @error('allocated_amount') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-medium">Period Start</label>
                                    <input type="date" wire:model="period_start" class="form-control @error('period_start') is-invalid @enderror">
                                    @error('period_start') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-medium">Period End</label>
                                    <input type="date" wire:model="period_end" class="form-control @error('period_end') is-invalid @enderror">
                                    @error('period_end') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-medium">Status</label>
                                    <select wire:model="budget_status" class="form-select @error('budget_status') is-invalid @enderror">
                                        <option value="draft">Draft</option>
                                        <option value="approved">Approved</option>
                                        <option value="rejected">Rejected</option>
                                        <option value="expired">Expired</option>
                                    </select>
                                    @error('budget_status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-12">
                                    <label class="form-label fw-medium">Description</label>
                                    <textarea wire:model="description" rows="3" class="form-control @error('description') is-invalid @enderror"></textarea>
                                    @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" wire:click="closeModal" class="btn btn-label-secondary">
                                <i class="ri-close-line me-1"></i>
                                Cancel
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="ri-save-line me-1"></i>
                                {{ $editing ? 'Update' : 'Create' }} Budget
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>