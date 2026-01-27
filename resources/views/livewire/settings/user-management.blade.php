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

    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">User Management</h5>
        </div>
        <div class="card-body">
            <!-- Search and Filter Section -->
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search users..." class="form-control">
                </div>
                <div class="col-md-4">
                    <select wire:model.live="status" class="form-select">
                        <option value="">All Users</option>
                        <option value="verified">Verified</option>
                        <option value="unverified">Pending Verification</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <div class="d-flex gap-2">
                        <button wire:click="$refresh" class="btn btn-outline-primary">
                            <i class="ri-refresh-line"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Users Table -->
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th wire:click="sortBy('name')" style="cursor: pointer;">
                                Name
                                @if($sortField === 'name')
                                    <i class="ri-arrow-{{ $sortDirection === 'asc' ? 'up' : 'down' }}-s-line"></i>
                                @endif
                            </th>
                            <th wire:click="sortBy('email')" style="cursor: pointer;">
                                Email
                                @if($sortField === 'email')
                                    <i class="ri-arrow-{{ $sortDirection === 'asc' ? 'up' : 'down' }}-s-line"></i>
                                @endif
                            </th>
                            <th>Role</th>
                            <th wire:click="sortBy('is_verified')" style="cursor: pointer;">
                                Status
                                @if($sortField === 'is_verified')
                                    <i class="ri-arrow-{{ $sortDirection === 'asc' ? 'up' : 'down' }}-s-line"></i>
                                @endif
                            </th>
                            <th wire:click="sortBy('created_at')" style="cursor: pointer;">
                                Registered
                                @if($sortField === 'created_at')
                                    <i class="ri-arrow-{{ $sortDirection === 'asc' ? 'up' : 'down' }}-s-line"></i>
                                @endif
                            </th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-sm me-3">
                                            <span class="avatar-initial rounded-circle bg-label-primary">
                                                {{ substr($user->name, 0, 1) }}
                                            </span>
                                        </div>
                                        <div>
                                            <h6 class="mb-0">{{ $user->name }}</h6>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <span class="badge bg-label-info">{{ $user->role?->name ?? 'No Role' }}</span>
                                </td>
                                <td>
                                    @if($user->is_verified)
                                        <span class="badge bg-label-success">Verified</span>
                                    @else
                                        <span class="badge bg-label-warning">Pending</span>
                                    @endif
                                </td>
                                <td>{{ $user->created_at->format('M d, Y') }}</td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                            Actions
                                        </button>
                                        <ul class="dropdown-menu">
                                            @if(!$user->is_verified)
                                                <li>
                                                    <button wire:click.prevent="verifyUser({{ $user->id }})"
                                                            wire:confirm="Are you sure you want to verify this user?"
                                                            class="dropdown-item text-success">
                                                        <i class="ri-check-line me-2"></i>Verify User
                                                    </button>
                                                </li>
                                            @else
                                                <li>
                                                    <button wire:click.prevent="unverifyUser({{ $user->id }})"
                                                            wire:confirm="Are you sure you want to unverify this user?"
                                                            class="dropdown-item text-warning">
                                                        <i class="ri-close-line me-2"></i>Unverify User
                                                    </button>
                                                </li>
                                            @endif
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <button wire:click.prevent="deleteUser({{ $user->id }})"
                                                        wire:confirm="Are you sure you want to delete this user? This action cannot be undone."
                                                        class="dropdown-item text-danger">
                                                    <i class="ri-delete-bin-line me-2"></i>Delete User
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <div class="d-flex flex-column align-items-center">
                                        <i class="ri-user-line ri-3x text-muted mb-3"></i>
                                        <h6 class="text-muted">No users found</h6>
                                        <p class="text-muted small">Try adjusting your search criteria</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $users->links() }}
            </div>
        </div>
    </div>
</div>