<div>
    @if (session()->has('message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Search and Filter Section -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row g-3 align-items-end">
                <div class="col-md-4">
                    <input type="text" wire:model.live="search" placeholder="Search employees..." class="form-control">
                </div>
                <div class="col-md-2">
                    <select wire:model.live="department" class="form-select">
                        <option value="">All Departments</option>
                        @foreach($departments as $dept)
                            <option value="{{ $dept }}">{{ $dept }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select wire:model.live="employment_status" class="form-select">
                        <option value="">All Status</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                        <option value="terminated">Terminated</option>
                    </select>
                </div>
                <div class="col-md-4 text-end">
                    <button wire:click.prevent="create" type="button" class="btn btn-primary">
                        <i class="ri-add-line me-1"></i>
                        Add Employee
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Employees Table -->
    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>
                            <button type="button" class="btn btn-sm btn-link text-decoration-none p-0 text-muted" wire:click="sortBy('employee_id')">
                                Employee ID
                                @if ($sortField === 'employee_id')
                                    <i class="ri-arrow-{{ $sortDirection === 'asc' ? 'up' : 'down' }}-s-line"></i>
                                @endif
                            </button>
                        </th>
                        <th>Employee</th>
                        <th>Department</th>
                        <th>Position</th>
                        <th>Branch</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($employees as $employee)
                        <tr>
                            <td class="fw-medium">{{ $employee->employee_id }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar avatar-sm me-3">
                                        <span class="avatar-initial rounded-circle bg-label-primary">
                                            {{ $employee->user ? strtoupper(substr($employee->user->name, 0, 2)) : 'NA' }}
                                        </span>
                                    </div>
                                    <div>
                                        <div class="fw-medium">{{ $employee->user ? $employee->user->name : 'N/A' }}</div>
                                        <small class="text-muted">{{ $employee->user ? $employee->user->email : 'N/A' }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $employee->department }}</td>
                            <td>{{ $employee->position }}</td>
                            <td>{{ $employee->branch ? $employee->branch->name : 'N/A' }}</td>
                            <td>
                                <span class="badge bg-label-{{ $employee->employment_status === 'active' ? 'success' : ($employee->employment_status === 'inactive' ? 'warning' : 'danger') }}">
                                    {{ ucfirst($employee->employment_status) }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                    <button wire:click.prevent="view({{ $employee->id }})" class="btn btn-sm btn-icon btn-label-info" title="View Details">
                                        <i class="ri-eye-line"></i>
                                    </button>
                                    <button wire:click.prevent="edit({{ $employee->id }})" class="btn btn-sm btn-icon btn-label-primary" title="Edit">
                                        <i class="ri-edit-line"></i>
                                    </button>
                                    <button wire:click.prevent="delete({{ $employee->id }})" 
                                            onclick="return confirm('Are you sure you want to delete this employee?')"
                                            class="btn btn-sm btn-icon btn-label-danger" title="Delete">
                                        <i class="ri-delete-bin-line"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                No employees found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($employees->hasPages())
            <div class="card-footer border-top">
                {{ $employees->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>

    <style>
        .pagination .page-link svg {
            display: none;
        }
        .pagination .page-link {
            padding: 0.375rem 0.75rem;
        }
    </style>

    <!-- Modal for Add/Edit Employee -->
    @if($showModal)
        <div class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0,0,0,0.5);" wire:click.self="closeModal">
            <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable" wire:click.stop>
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="ri-{{ $editing ? 'edit' : 'add' }}-line me-2"></i>
                            {{ $editing ? 'Edit Employee' : 'Add New Employee' }}
                        </h5>
                        <button type="button" class="btn-close" wire:click.prevent="closeModal"></button>
                    </div>
                    
                    <form wire:submit.prevent="save">
                        <div class="modal-body">
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label class="form-label fw-medium">Employee ID</label>
                                    <input type="text" wire:model="employee_id" class="form-control @error('employee_id') is-invalid @enderror">
                                    @error('employee_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-medium">User Account</label>
                                    <div class="mb-3">
                                        <div class="form-check">
                                            <input type="checkbox" wire:model.live="create_user" class="form-check-input" id="create_user">
                                            <label class="form-check-label" for="create_user">
                                                Create new user account
                                            </label>
                                        </div>
                                    </div>

                                    @if($create_user)
                                        <div class="border rounded p-3 bg-light">
                                            <h6 class="mb-3">New User Details</h6>
                                            <div class="row g-3">
                                                <div class="col-12">
                                                    <label class="form-label">Name <span class="text-danger">*</span></label>
                                                    <input type="text" wire:model="user_name" class="form-control @error('user_name') is-invalid @enderror" placeholder="Full Name">
                                                    @error('user_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Email <span class="text-danger">*</span></label>
                                                    <input type="email" wire:model="user_email" class="form-control @error('user_email') is-invalid @enderror" placeholder="user@example.com">
                                                    @error('user_email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Role <span class="text-danger">*</span></label>
                                                    <select wire:model="user_role_id" class="form-select @error('user_role_id') is-invalid @enderror">
                                                        <option value="">Select Role</option>
                                                        @foreach($roles as $role)
                                                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('user_role_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                                </div>
                                                <div class="col-12">
                                                    <label class="form-label">Password <span class="text-danger">*</span></label>
                                                    <input type="password" wire:model="user_password" class="form-control @error('user_password') is-invalid @enderror" placeholder="••••••••">
                                                    @error('user_password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                                    <small class="text-muted">Minimum 8 characters</small>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <select wire:model="user_id" class="form-select @error('user_id') is-invalid @enderror">
                                            <option value="">Select Existing User</option>
                                            @foreach($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                                            @endforeach
                                        </select>
                                        @error('user_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    @endif
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-medium">Branch</label>
                                    <select wire:model="branch_id" class="form-select @error('branch_id') is-invalid @enderror">
                                        <option value="">Select Branch</option>
                                        @foreach($branches as $branch)
                                            <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('branch_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-medium">Department</label>
                                    <input type="text" wire:model="department_name" class="form-control @error('department_name') is-invalid @enderror">
                                    @error('department_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-medium">Position</label>
                                    <input type="text" wire:model="position" class="form-control @error('position') is-invalid @enderror">
                                    @error('position') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-medium">Hire Date</label>
                                    <input type="date" wire:model="hire_date" class="form-control @error('hire_date') is-invalid @enderror">
                                    @error('hire_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-medium">Salary</label>
                                    <div class="input-group">
                                        <span class="input-group-text">$</span>
                                        <input type="number" step="0.01" wire:model="salary" class="form-control @error('salary') is-invalid @enderror">
                                        @error('salary') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-medium">Status</label>
                                    <select wire:model="status" class="form-select @error('status') is-invalid @enderror">
                                        <option value="active">Active</option>
                                        <option value="inactive">Inactive</option>
                                        <option value="terminated">Terminated</option>
                                    </select>
                                    @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-12">
                                    <label class="form-label fw-medium">Manager</label>
                                    <select wire:model="manager_id" class="form-select @error('manager_id') is-invalid @enderror">
                                        <option value="">Select Manager (Optional)</option>
                                        @foreach($managers as $manager)
                                            <option value="{{ $manager->id }}">{{ $manager->user ? $manager->user->name : 'N/A' }} - {{ $manager->position }}</option>
                                        @endforeach
                                    </select>
                                    @error('manager_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-medium">Phone</label>
                                    <input type="text" wire:model="phone" class="form-control @error('phone') is-invalid @enderror">
                                    @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-medium">Emergency Contact</label>
                                    <input type="text" wire:model="emergency_contact" class="form-control @error('emergency_contact') is-invalid @enderror">
                                    @error('emergency_contact') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-medium">Emergency Phone</label>
                                    <input type="text" wire:model="emergency_phone" class="form-control @error('emergency_phone') is-invalid @enderror">
                                    @error('emergency_phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-12">
                                    <label class="form-label fw-medium">Address</label>
                                    <textarea wire:model="address" rows="2" class="form-control @error('address') is-invalid @enderror"></textarea>
                                    @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-12">
                                    <label class="form-label fw-medium">Notes</label>
                                    <textarea wire:model="notes" rows="2" class="form-control @error('notes') is-invalid @enderror"></textarea>
                                    @error('notes') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" wire:click.prevent="closeModal" class="btn btn-label-secondary">
                                <i class="ri-close-line me-1"></i>
                                Cancel
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="ri-save-line me-1"></i>
                                {{ $editing ? 'Update' : 'Create' }} Employee
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <!-- View Employee Modal -->
    @if($showViewModal)
        <div class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0,0,0,0.5);" wire:click.self="closeViewModal">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" wire:click.stop>
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">
                            <i class="ri-user-line me-2"></i>
                            Employee Details
                        </h5>
                        <button type="button" class="btn-close btn-close-white" wire:click.prevent="closeViewModal"></button>
                    </div>
                    
                    <div class="modal-body">
                        @if($viewEmployee)
                            <div class="row g-4">
                                <!-- Employee Header -->
                                <div class="col-12">
                                    <div class="d-flex align-items-center p-3 bg-light rounded">
                                        <div class="avatar avatar-lg me-3">
                                            <span class="avatar-initial rounded-circle bg-primary text-white fs-4">
                                                {{ $viewEmployee->user ? strtoupper(substr($viewEmployee->user->name, 0, 2)) : 'NA' }}
                                            </span>
                                        </div>
                                        <div>
                                            <h5 class="mb-1">{{ $viewEmployee->user ? $viewEmployee->user->name : 'N/A' }}</h5>
                                            <p class="mb-0 text-muted">{{ $viewEmployee->position }}</p>
                                            <span class="badge bg-label-{{ $viewEmployee->employment_status === 'active' ? 'success' : ($viewEmployee->employment_status === 'inactive' ? 'warning' : 'danger') }} mt-1">
                                                {{ ucfirst($viewEmployee->employment_status) }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Basic Information -->
                                <div class="col-12">
                                    <h6 class="mb-3 fw-bold"><i class="ri-information-line me-2"></i>Basic Information</h6>
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <small class="text-muted d-block">Employee ID</small>
                                            <strong>{{ $viewEmployee->employee_id }}</strong>
                                        </div>
                                        <div class="col-md-6">
                                            <small class="text-muted d-block">Email</small>
                                            <strong>{{ $viewEmployee->user ? $viewEmployee->user->email : 'N/A' }}</strong>
                                        </div>
                                        <div class="col-md-6">
                                            <small class="text-muted d-block">Department</small>
                                            <strong>{{ $viewEmployee->department }}</strong>
                                        </div>
                                        <div class="col-md-6">
                                            <small class="text-muted d-block">Branch</small>
                                            <strong>{{ $viewEmployee->branch ? $viewEmployee->branch->name : 'N/A' }}</strong>
                                        </div>
                                        <div class="col-md-6">
                                            <small class="text-muted d-block">Phone</small>
                                            <strong>{{ $viewEmployee->phone ?: 'N/A' }}</strong>
                                        </div>
                                        <div class="col-md-6">
                                            <small class="text-muted d-block">Hire Date</small>
                                            <strong>{{ $viewEmployee->hire_date ? \Carbon\Carbon::parse($viewEmployee->hire_date)->format('M d, Y') : 'N/A' }}</strong>
                                        </div>
                                    </div>
                                </div>

                                <!-- Employment Details -->
                                <div class="col-12">
                                    <h6 class="mb-3 fw-bold"><i class="ri-briefcase-line me-2"></i>Employment Details</h6>
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <small class="text-muted d-block">Salary</small>
                                            <strong>{{ $viewEmployee->salary ? '$' . number_format($viewEmployee->salary, 2) : 'N/A' }}</strong>
                                        </div>
                                        <div class="col-md-6">
                                            <small class="text-muted d-block">Manager</small>
                                            <strong>{{ $viewEmployee->manager && $viewEmployee->manager->user ? $viewEmployee->manager->user->name : 'N/A' }}</strong>
                                        </div>
                                    </div>
                                </div>

                                <!-- Emergency Contact -->
                                <div class="col-12">
                                    <h6 class="mb-3 fw-bold"><i class="ri-phone-line me-2"></i>Emergency Contact</h6>
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <small class="text-muted d-block">Contact Name</small>
                                            <strong>{{ $viewEmployee->emergency_contact ?: 'N/A' }}</strong>
                                        </div>
                                        <div class="col-md-6">
                                            <small class="text-muted d-block">Contact Phone</small>
                                            <strong>{{ $viewEmployee->emergency_phone ?: 'N/A' }}</strong>
                                        </div>
                                    </div>
                                </div>

                                <!-- Address -->
                                @if($viewEmployee->address)
                                    <div class="col-12">
                                        <h6 class="mb-3 fw-bold"><i class="ri-map-pin-line me-2"></i>Address</h6>
                                        <p class="mb-0">{{ $viewEmployee->address }}</p>
                                    </div>
                                @endif

                                <!-- Notes -->
                                @if($viewEmployee->notes)
                                    <div class="col-12">
                                        <h6 class="mb-3 fw-bold"><i class="ri-file-text-line me-2"></i>Notes</h6>
                                        <p class="mb-0">{{ $viewEmployee->notes }}</p>
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>

                    <div class="modal-footer">
                        <button type="button" wire:click.prevent="closeViewModal" class="btn btn-label-secondary">
                            <i class="ri-close-line me-1"></i>
                            Close
                        </button>
                        <button type="button" wire:click.prevent="editFromView" class="btn btn-primary">
                            <i class="ri-edit-line me-1"></i>
                            Edit Employee
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>