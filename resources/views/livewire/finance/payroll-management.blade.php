<div>
    <!-- Status Message -->
    @if (session()->has('message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <div class="d-flex align-items-center">
                <i class="ri-checkbox-circle-line ri-20px me-2"></i>
                <span>{{ session('message') }}</span>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Statistics Cards -->
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="content-left">
                            <small class="text-muted">Total Payrolls</small>
                            <h4 class="mb-0 mt-2">{{ $totalPayrolls }}</h4>
                        </div>
                        <div class="avatar">
                            <span class="avatar-initial rounded bg-label-primary">
                                <i class="ri-file-list-3-line ri-24px"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="content-left">
                            <small class="text-muted">Processed</small>
                            <h4 class="mb-0 mt-2 text-success">{{ $processedPayrolls }}</h4>
                        </div>
                        <div class="avatar">
                            <span class="avatar-initial rounded bg-label-success">
                                <i class="ri-check-double-line ri-24px"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="content-left">
                            <small class="text-muted">Pending</small>
                            <h4 class="mb-0 mt-2 text-warning">{{ $pendingPayrolls }}</h4>
                        </div>
                        <div class="avatar">
                            <span class="avatar-initial rounded bg-label-warning">
                                <i class="ri-time-line ri-24px"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="content-left">
                            <small class="text-muted">Total Amount</small>
                            <h4 class="mb-0 mt-2">${{ number_format($totalPayroll, 2) }}</h4>
                        </div>
                        <div class="avatar">
                            <span class="avatar-initial rounded bg-label-info">
                                <i class="ri-money-dollar-circle-line ri-24px"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Filter Card -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Search Employee</label>
                    <input type="text" wire:model.live="search" class="form-control" placeholder="Search by name or ID...">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Filter by Status</label>
                    <select wire:model.live="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="pending">Pending</option>
                        <option value="processed">Processed</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                </div>
                <div class="col-md-5 d-flex align-items-end justify-content-end">
                    <button wire:click="create" type="button" class="btn btn-primary">
                        <i class="ri-add-line me-1"></i>
                        Create Payroll
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Payroll Table -->
    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Employee</th>
                        <th>Period</th>
                        <th>Gross Pay</th>
                        <th>Net Pay</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($payrolls as $payroll)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar avatar-sm me-3">
                                    <span class="avatar-initial rounded-circle bg-label-primary">
                                        {{ $payroll->employee->user ? strtoupper(substr($payroll->employee->user->name, 0, 2)) : 'NA' }}
                                    </span>
                                </div>
                                <div>
                                    <h6 class="mb-0">{{ $payroll->employee->user ? $payroll->employee->user->name : 'N/A' }}</h6>
                                    <small class="text-muted">{{ $payroll->employee->employee_id }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="fw-medium">{{ $payroll->pay_period_start->format('M d') }} - {{ $payroll->pay_period_end->format('M d, Y') }}</span>
                        </td>
                        <td>
                            <span class="fw-medium">${{ number_format($payroll->gross_pay, 2) }}</span>
                        </td>
                        <td>
                            <span class="fw-medium text-success">${{ number_format($payroll->net_pay, 2) }}</span>
                        </td>
                        <td>
                            <span class="badge bg-label-{{ $payroll->status === 'processed' ? 'success' : ($payroll->status === 'pending' ? 'warning' : 'danger') }}">
                                {{ ucfirst($payroll->status) }}
                            </span>
                        </td>
                        <td class="text-end">
                            <div class="d-flex justify-content-end gap-2">
                                @if($payroll->status === 'pending')
                                    <button wire:click="processPayroll({{ $payroll->id }})" class="btn btn-sm btn-success" title="Process">
                                        <i class="ri-check-line"></i>
                                    </button>
                                @endif
                                <button wire:click="edit({{ $payroll->id }})" class="btn btn-sm btn-icon btn-label-primary" title="Edit">
                                    <i class="ri-edit-line"></i>
                                </button>
                                <button wire:click="delete({{ $payroll->id }})" 
                                        onclick="return confirm('Are you sure you want to delete this payroll?')"
                                        class="btn btn-sm btn-icon btn-label-danger" title="Delete">
                                    <i class="ri-delete-bin-line"></i>
                                </button>
                            </div>
                        </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">
                                <p class="text-muted mb-0">No payroll records found.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($payrolls->hasPages())
            <div class="card-footer border-top">
                {{ $payrolls->links() }}
            </div>
        @endif
    </div>

    <!-- Modal for Add/Edit Payroll -->
    @if($showModal)
        <div class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0, 0, 0, 0.5);">
            <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="ri-{{ $editing ? 'edit' : 'add' }}-line me-2"></i>
                            {{ $editing ? 'Edit Payroll' : 'Create New Payroll' }}
                        </h5>
                        <button type="button" class="btn-close" wire:click="closeModal"></button>
                    </div>
                    <form wire:submit="save">
                        <div class="modal-body">
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label class="form-label fw-medium">Employee <span class="text-danger">*</span></label>
                                    <select wire:model="employee_id" class="form-select @error('employee_id') is-invalid @enderror">
                                        <option value="">Select Employee</option>
                                        @foreach($employees as $employee)
                                            <option value="{{ $employee->id }}">{{ $employee->user ? $employee->user->name : 'N/A' }} - {{ $employee->employee_id }}</option>
                                        @endforeach
                                    </select>
                                    @error('employee_id') 
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-medium">Basic Salary <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text">$</span>
                                        <input type="number" step="0.01" wire:model="basic_salary" class="form-control @error('basic_salary') is-invalid @enderror" placeholder="0.00">
                                    </div>
                                    @error('basic_salary') 
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-medium">Period Start <span class="text-danger">*</span></label>
                                    <input type="date" wire:model="period_start" class="form-control @error('period_start') is-invalid @enderror">
                                    @error('period_start') 
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-medium">Period End <span class="text-danger">*</span></label>
                                    <input type="date" wire:model="period_end" class="form-control @error('period_end') is-invalid @enderror">
                                    @error('period_end') 
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-medium">Overtime Hours</label>
                                    <input type="number" step="0.01" wire:model="overtime_hours" class="form-control @error('overtime_hours') is-invalid @enderror" placeholder="0.00">
                                    @error('overtime_hours') 
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-medium">Overtime Rate</label>
                                    <div class="input-group">
                                        <span class="input-group-text">$</span>
                                        <input type="number" step="0.01" wire:model="overtime_rate" class="form-control @error('overtime_rate') is-invalid @enderror" placeholder="0.00">
                                    </div>
                                    @error('overtime_rate') 
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-medium">Bonus</label>
                                    <div class="input-group">
                                        <span class="input-group-text">$</span>
                                        <input type="number" step="0.01" wire:model="bonus" class="form-control @error('bonus') is-invalid @enderror" placeholder="0.00">
                                    </div>
                                    @error('bonus') 
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-medium">Deductions</label>
                                    <div class="input-group">
                                        <span class="input-group-text">$</span>
                                        <input type="number" step="0.01" wire:model="deductions" class="form-control @error('deductions') is-invalid @enderror" placeholder="0.00">
                                    </div>
                                    @error('deductions') 
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-medium">Tax Deduction</label>
                                    <div class="input-group">
                                        <span class="input-group-text">$</span>
                                        <input type="number" step="0.01" wire:model="tax_deduction" class="form-control @error('tax_deduction') is-invalid @enderror" placeholder="0.00">
                                    </div>
                                    @error('tax_deduction') 
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-medium">Status <span class="text-danger">*</span></label>
                                    <select wire:model="payroll_status" class="form-select @error('payroll_status') is-invalid @enderror">
                                        <option value="pending">Pending</option>
                                        <option value="processed">Processed</option>
                                        <option value="cancelled">Cancelled</option>
                                    </select>
                                    @error('payroll_status') 
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <label class="form-label fw-medium">Notes</label>
                                    <textarea wire:model="notes" rows="3" class="form-control @error('notes') is-invalid @enderror" placeholder="Add any additional notes..."></textarea>
                                    @error('notes') 
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
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
                                {{ $editing ? 'Update' : 'Create' }} Payroll
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>