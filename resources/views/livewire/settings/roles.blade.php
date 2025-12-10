<div>
    <!-- Success/Error Messages -->
    @if (session()->has('status'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class='bx bx-check-circle me-2'></i>
            {{ session('status') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class='bx bx-error-circle me-2'></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Header Section -->
    <div class="card border-0 shadow-sm mb-4" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
        <div class="card-body p-4">
            <div class="row align-items-center">
                <div class="col">
                    <h4 class="text-white mb-1 fw-bold">
                        <i class='bx bx-shield-alt me-2'></i>
                        Roles & Permissions Management
                    </h4>
                    <p class="text-white-50 mb-0 small">Define roles and control access to system features</p>
                </div>
                <div class="col-auto">
                    <button wire:click="create" class="btn btn-light shadow-sm">
                        <i class='bx bx-plus-circle me-2'></i>Create New Role
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Controls Bar -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-3">
            <div class="row g-3 align-items-center">
                <div class="col-md-5">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0">
                            <i class='bx bx-search text-muted'></i>
                        </span>
                        <input type="text" 
                            wire:model.live.debounce.300ms="search" 
                            class="form-control border-start-0 ps-0" 
                            placeholder="Search by role name, description, or permissions...">
                        @if($search)
                            <button class="btn btn-outline-secondary" wire:click="$set('search', '')">
                                <i class='bx bx-x'></i>
                            </button>
                        @endif
                    </div>
                </div>
                <div class="col-md-3">
                    <select wire:model.live="sortField" class="form-select">
                        <option value="name">Sort by Name</option>
                        <option value="created_at">Sort by Date Created</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select wire:model.live="sortDirection" class="form-select">
                        <option value="asc">Ascending</option>
                        <option value="desc">Descending</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select wire:model.live="perPage" class="form-select">
                        <option value="10">10 / page</option>
                        <option value="25">25 / page</option>
                        <option value="50">50 / page</option>
                        <option value="100">100 / page</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Roles Grid -->
    <div class="row g-4 mb-4">
        @forelse($roles as $role)
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card border-0 shadow-sm h-100 hover-lift" style="transition: transform 0.2s;">
                    <div class="card-body">
                        <div class="d-flex align-items-start mb-3">
                            <div class="flex-shrink-0">
                                <div class="rounded-circle d-flex align-items-center justify-content-center" 
                                    style="width: 56px; height: 56px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                    <i class='bx bx-shield-alt text-white fs-3'></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h5 class="mb-1 fw-bold">{{ $role->name }}</h5>
                                <p class="text-muted small mb-0">
                                    @if($role->users_count ?? 0)
                                        <i class='bx bx-user me-1'></i>{{ $role->users_count }} {{ Str::plural('user', $role->users_count) }}
                                    @else
                                        <i class='bx bx-user me-1'></i>No users assigned
                                    @endif
                                </p>
                            </div>
                        </div>

                        <p class="text-muted small mb-3" style="min-height: 40px;">
                            {{ $role->description ?: 'No description provided for this role.' }}
                        </p>

                        <!-- Permissions Preview -->
                        <div class="mb-3">
                            <div class="d-flex align-items-center mb-2">
                                <small class="text-muted fw-semibold">
                                    <i class='bx bx-key me-1'></i>Permissions
                                </small>
                            </div>
                            @if($role->permissions)
                                @php
                                    $perms = is_string($role->permissions) ? explode(',', $role->permissions) : [];
                                    $perms = array_map('trim', array_filter($perms));
                                    $displayPerms = array_slice($perms, 0, 4);
                                    $remaining = count($perms) - count($displayPerms);
                                @endphp
                                <div class="d-flex flex-wrap gap-1">
                                    @foreach($displayPerms as $perm)
                                        <span class="badge rounded-pill bg-primary-subtle text-primary" style="font-size: 0.7rem;">
                                            {{ str_replace('_', ' ', $perm) }}
                                        </span>
                                    @endforeach
                                    @if($remaining > 0)
                                        <span class="badge rounded-pill bg-secondary-subtle text-secondary" style="font-size: 0.7rem;">
                                            +{{ $remaining }} more
                                        </span>
                                    @endif
                                </div>
                            @else
                                <span class="badge bg-warning-subtle text-warning">
                                    <i class='bx bx-error-circle me-1'></i>No permissions set
                                </span>
                            @endif
                        </div>

                        <div class="border-top pt-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">
                                    <i class='bx bx-calendar me-1'></i>
                                    {{ $role->created_at->format('M d, Y') }}
                                </small>
                                <div class="btn-group btn-group-sm">
                                    <button wire:click="edit({{ $role->id }})" 
                                        class="btn btn-outline-primary"
                                        title="Edit Role">
                                        <i class='bx bx-edit-alt'></i>
                                    </button>
                                    <button wire:click="delete({{ $role->id }})" 
                                        wire:confirm="Are you sure you want to delete the '{{ $role->name }}' role? This action cannot be undone."
                                        class="btn btn-outline-danger"
                                        title="Delete Role">
                                        <i class='bx bx-trash'></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center py-5">
                        <div class="mb-3">
                            <i class='bx bx-shield-x display-1 text-muted'></i>
                        </div>
                        <h5 class="text-muted mb-2">No Roles Found</h5>
                        <p class="text-muted mb-3">
                            @if($search)
                                No roles match your search criteria. Try adjusting your filters.
                            @else
                                Get started by creating your first role to manage user permissions.
                            @endif
                        </p>
                        @if($search)
                            <button wire:click="$set('search', '')" class="btn btn-outline-primary">
                                <i class='bx bx-reset me-2'></i>Clear Search
                            </button>
                        @else
                            <button wire:click="create" class="btn btn-primary">
                                <i class='bx bx-plus-circle me-2'></i>Create Your First Role
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($roles->hasPages())
        <div class="d-flex justify-content-center">
            {{ $roles->links() }}
        </div>
    @endif

    <!-- Role Form Modal -->
    @if($showForm)
        <div class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0,0,0,0.6);" wire:click.self="cancel">
            <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
                <div class="modal-content border-0 shadow-lg">
                    <div class="modal-header border-0" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                        <h5 class="modal-title text-white fw-bold">
                            <i class='bx bx-{{ $roleId ? "edit" : "plus-circle" }} me-2'></i>
                            {{ $roleId ? 'Edit Role' : 'Create New Role' }}
                        </h5>
                        <button type="button" wire:click="cancel" class="btn-close btn-close-white"></button>
                    </div>
                    <form wire:submit="save">
                        <div class="modal-body p-4">
                            <!-- Basic Information -->
                            <div class="mb-4">
                                <h6 class="fw-semibold mb-3">
                                    <i class='bx bx-info-circle text-primary me-2'></i>
                                    Basic Information
                                </h6>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">
                                            Role Name <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" 
                                            wire:model="name" 
                                            class="form-control @error('name') is-invalid @enderror" 
                                            placeholder="e.g., Store Manager, Sales Associate">
                                        @error('name') 
                                            <div class="invalid-feedback">{{ $message }}</div> 
                                        @enderror
                                        <small class="text-muted">Choose a clear, descriptive name</small>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Description</label>
                                        <input type="text" 
                                            wire:model="description" 
                                            class="form-control @error('description') is-invalid @enderror" 
                                            placeholder="Brief role description">
                                        @error('description') 
                                            <div class="invalid-feedback">{{ $message }}</div> 
                                        @enderror
                                        <small class="text-muted">Optional but recommended</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Permissions Section -->
                            <div class="mb-4">
                                <h6 class="fw-semibold mb-3">
                                    <i class='bx bx-key text-primary me-2'></i>
                                    Permissions
                                </h6>
                                
                                <!-- Permission Categories -->
                                <div class="row g-3 mb-3">
                                    @php
                                        $permissionGroups = [
                                            'Dashboard & Analytics' => [
                                                'view_dashboard' => 'View Dashboard',
                                                'view_analytics' => 'View Analytics',
                                                'export_reports' => 'Export Reports',
                                            ],
                                            'Inventory Management' => [
                                                'view_inventory' => 'View Inventory',
                                                'manage_inventory' => 'Manage Inventory',
                                                'manage_products' => 'Manage Products',
                                                'manage_categories' => 'Manage Categories',
                                                'manage_suppliers' => 'Manage Suppliers',
                                            ],
                                            'Sales & Orders' => [
                                                'view_sales' => 'View Sales',
                                                'create_sales' => 'Create Sales',
                                                'manage_orders' => 'Manage Orders',
                                                'view_invoices' => 'View Invoices',
                                                'manage_customers' => 'Manage Customers',
                                            ],
                                            'Finance & Expenses' => [
                                                'view_finance' => 'View Finance',
                                                'manage_expenses' => 'Manage Expenses',
                                                'manage_budgets' => 'Manage Budgets',
                                                'view_payroll' => 'View Payroll',
                                            ],
                                            'HR & Employees' => [
                                                'view_employees' => 'View Employees',
                                                'manage_employees' => 'Manage Employees',
                                                'manage_attendance' => 'Manage Attendance',
                                                'manage_payroll' => 'Manage Payroll',
                                            ],
                                            'System Administration' => [
                                                'manage_settings' => 'Manage Settings',
                                                'manage_users' => 'Manage Users',
                                                'manage_roles' => 'Manage Roles',
                                                'view_logs' => 'View System Logs',
                                            ],
                                        ];
                                        $currentPerms = $permissions ? array_map('trim', explode(',', $permissions)) : [];
                                    @endphp

                                    @foreach($permissionGroups as $groupName => $perms)
                                        <div class="col-lg-6">
                                            <div class="card bg-light border-0">
                                                <div class="card-body p-3">
                                                    <h6 class="fw-semibold mb-2 small">{{ $groupName }}</h6>
                                                    <div class="d-flex flex-wrap gap-2">
                                                        @foreach($perms as $permKey => $permLabel)
                                                            <button type="button"
                                                                wire:click="togglePermission('{{ $permKey }}')"
                                                                class="btn btn-sm {{ in_array($permKey, $currentPerms) ? 'btn-primary' : 'btn-outline-secondary' }}">
                                                                <i class='bx bx-{{ in_array($permKey, $currentPerms) ? "check" : "plus" }} me-1'></i>
                                                                {{ $permLabel }}
                                                            </button>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <!-- Custom Permissions -->
                                <div class="card border-primary bg-primary-subtle">
                                    <div class="card-body p-3">
                                        <label class="form-label fw-semibold mb-2">
                                            <i class='bx bx-code-alt me-1'></i>
                                            Custom Permissions (Advanced)
                                        </label>
                                        <textarea wire:model="permissions" 
                                            class="form-control font-monospace @error('permissions') is-invalid @enderror" 
                                            rows="3" 
                                            placeholder="Enter comma-separated custom permissions (e.g., custom_feature, special_access)"></textarea>
                                        @error('permissions') 
                                            <div class="invalid-feedback">{{ $message }}</div> 
                                        @enderror
                                        <small class="text-muted">
                                            <i class='bx bx-info-circle me-1'></i>
                                            Click permission buttons above or manually enter comma-separated values
                                        </small>
                                    </div>
                                </div>
                            </div>

                            <!-- Selected Permissions Preview -->
                            @if($permissions)
                                <div class="alert alert-info d-flex align-items-start">
                                    <i class='bx bx-info-circle fs-5 me-2'></i>
                                    <div>
                                        <strong>Selected Permissions:</strong>
                                        <div class="d-flex flex-wrap gap-1 mt-2">
                                            @foreach(array_filter(array_map('trim', explode(',', $permissions))) as $perm)
                                                <span class="badge bg-white text-primary">{{ $perm }}</span>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="modal-footer border-0 bg-light">
                            <button type="button" wire:click="cancel" class="btn btn-secondary">
                                <i class='bx bx-x me-2'></i>Cancel
                            </button>
                            <button type="submit" class="btn btn-primary" wire:loading.attr="disabled" wire:target="save">
                                <span wire:loading.remove wire:target="save">
                                    <i class='bx bx-{{ $roleId ? "save" : "plus-circle" }} me-2'></i>
                                    {{ $roleId ? 'Update Role' : 'Create Role' }}
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

    <style>
        .hover-lift:hover {
            transform: translateY(-5px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
        }
    </style>
</div>
