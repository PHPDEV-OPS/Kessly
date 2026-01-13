<div>
    <!-- Success/Error Messages -->
    @if (session()->has('status'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class='bx bx-check-circle me-2'></i>
            {{ session('status') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row g-4">
        <!-- User List Card -->
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <div class="row align-items-center">
                        <div class="col">
                            <h5 class="mb-0 fw-semibold">
                                <i class='bx bx-user text-primary me-2'></i>
                                User Management
                            </h5>
                        </div>
                        <div class="col-auto">
                            <button wire:click="create" class="btn btn-primary">
                                <i class='bx bx-plus me-1'></i>
                                Add User
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Search and Filters -->
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <div class="input-group">
                                <span class="input-group-text"><i class='bx bx-search'></i></span>
                                <input type="text" wire:model.live="search" class="form-control" placeholder="Search users by name or email...">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <select wire:model.live="perPage" class="form-select">
                                <option value="10">10 per page</option>
                                <option value="25">25 per page</option>
                                <option value="50">50 per page</option>
                                <option value="100">100 per page</option>
                            </select>
                        </div>
                    </div>

                    <!-- Users Table -->
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th wire:click="sortBy('name')" style="cursor: pointer;">
                                        Name 
                                        @if($sortField === 'name')
                                            <i class='bx bx-{{ $sortDirection === 'asc' ? 'up' : 'down' }}-arrow-alt'></i>
                                        @endif
                                    </th>
                                    <th wire:click="sortBy('email')" style="cursor: pointer;">
                                        Email
                                        @if($sortField === 'email')
                                            <i class='bx bx-{{ $sortDirection === 'asc' ? 'up' : 'down' }}-arrow-alt'></i>
                                        @endif
                                    </th>
                                    <th>Role</th>
                                    <th wire:click="sortBy('created_at')" style="cursor: pointer;">
                                        Joined
                                        @if($sortField === 'created_at')
                                            <i class='bx bx-{{ $sortDirection === 'asc' ? 'up' : 'down' }}-arrow-alt'></i>
                                        @endif
                                    </th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($users as $user)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-circle bg-primary text-white me-2" style="width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold;">
                                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                                </div>
                                                <div>
                                                    <div class="fw-semibold">{{ $user->name }}</div>
                                                    @if($user->id === auth()->id())
                                                        <span class="badge bg-success-subtle text-success small">You</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            @if($user->role)
                                                <span class="badge bg-info-subtle text-info">{{ $user->role->name }}</span>
                                            @else
                                                <span class="badge bg-secondary-subtle text-secondary">No Role</span>
                                            @endif
                                        </td>
                                        <td>{{ $user->created_at->format('M d, Y') }}</td>
                                        <td class="text-end">
                                            <button wire:click="edit({{ $user->id }})" class="btn btn-sm btn-outline-primary me-1" title="Edit User">
                                                <i class='bx bx-edit me-1'></i>
                                                <span class="d-none d-md-inline">Edit</span>
                                            </button>
                                            @if($user->id !== auth()->id())
                                                <button wire:click="delete({{ $user->id }})" wire:confirm="Are you sure you want to delete this user?" class="btn btn-sm btn-outline-danger" title="Delete User">
                                                    <i class='bx bx-trash me-1'></i>
                                                    <span class="d-none d-md-inline">Delete</span>
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-4">
                                            <i class='bx bx-user-x display-4'></i>
                                            <p class="mb-0 mt-2">No users found</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-3">
                        {{ $users->links('pagination::bootstrap-5') }}
                    </div>
                    
                    <style>
                        .pagination .page-link svg {
                            display: none;
                        }
                        .pagination .page-link {
                            padding: 0.375rem 0.75rem;
                        }
                    </style>
                </div>
            </div>
        </div>
    </div>

    <!-- User Form Modal -->
    @if($showForm)
        <div class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0,0,0,0.5);">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class='bx bx-user me-2'></i>
                            {{ $userId ? 'Edit User' : 'Add New User' }}
                        </h5>
                        <button type="button" wire:click="cancel" class="btn-close"></button>
                    </div>
                    <form wire:submit="save">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Name <span class="text-danger">*</span></label>
                                <input type="text" wire:model="name" class="form-control @error('name') is-invalid @enderror" placeholder="Full Name">
                                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                                <input type="email" wire:model="email" class="form-control @error('email') is-invalid @enderror" placeholder="user@example.com">
                                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Role</label>
                                <select wire:model="role_id" class="form-select @error('role_id') is-invalid @enderror">
                                    <option value="">No Role</option>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                                @error('role_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">
                                    Password 
                                    @if($userId)
                                        <span class="text-muted small">(leave blank to keep current)</span>
                                    @else
                                        <span class="text-danger">*</span>
                                    @endif
                                </label>
                                <input type="password" wire:model="password" class="form-control @error('password') is-invalid @enderror" placeholder="••••••••">
                                @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                <small class="text-muted">Minimum 8 characters</small>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" wire:click="cancel" class="btn btn-secondary">
                                <i class='bx bx-x me-1'></i>Cancel
                            </button>
                            <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                                <span wire:loading.remove wire:target="save">
                                    <i class='bx bx-save me-1'></i>{{ $userId ? 'Update' : 'Create' }} User
                                </span>
                                <span wire:loading wire:target="save">
                                    <span class="spinner-border spinner-border-sm me-2"></span>
                                    Saving...
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
