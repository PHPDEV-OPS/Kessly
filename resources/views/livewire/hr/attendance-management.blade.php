<div>
    <!-- Statistics Cards -->
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar me-3">
                            <span class="avatar-initial rounded-circle bg-label-primary">
                                <i class="ri-team-line ri-22px"></i>
                            </span>
                        </div>
                        <div>
                            <div class="text-muted small">Total Employees</div>
                            <h5 class="mb-0">{{ $totalEmployees }}</h5>
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
                            <div class="text-muted small">Present Today</div>
                            <h5 class="mb-0 text-success">{{ $presentToday }}</h5>
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
                                <i class="ri-close-circle-line ri-22px"></i>
                            </span>
                        </div>
                        <div>
                            <div class="text-muted small">Absent Today</div>
                            <h5 class="mb-0 text-danger">{{ $absentToday }}</h5>
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
                            <span class="avatar-initial rounded-circle bg-label-warning">
                                <i class="ri-time-line ri-22px"></i>
                            </span>
                        </div>
                        <div>
                            <div class="text-muted small">Late Today</div>
                            <h5 class="mb-0 text-warning">{{ $lateToday }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Date Selection and Controls -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="form-label fw-medium">Date</label>
                    <input type="date" wire:model.live="selectedDate" class="form-control">
                </div>
                <div class="col-md-5">
                    <label class="form-label fw-medium">Search Employee</label>
                    <input type="text" wire:model.live="search" placeholder="Search by name..." class="form-control">
                </div>
                <div class="col-md-4 text-end">
                    <button wire:click.prevent="create" type="button" class="btn btn-primary">
                        <i class="ri-add-line me-1"></i>
                        Record Attendance
                    </button>
                </div>
            </div>
        </div>
    </div>

    @if (session()->has('message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Attendance Table -->
    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Employee</th>
                        <th>Clock In</th>
                        <th>Clock Out</th>
                        <th>Hours Worked</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($attendances as $attendance)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar avatar-sm me-3">
                                        <span class="avatar-initial rounded-circle bg-label-primary">
                                            {{ $attendance->employee->user ? strtoupper(substr($attendance->employee->user->name, 0, 2)) : 'NA' }}
                                        </span>
                                    </div>
                                    <div class="fw-medium">
                                        {{ $attendance->employee->user ? $attendance->employee->user->name : 'N/A' }}
                                    </div>
                                </div>
                            </td>
                            <td>{{ $attendance->clock_in ? $attendance->clock_in->format('H:i A') : '-' }}</td>
                            <td>{{ $attendance->clock_out ? $attendance->clock_out->format('H:i A') : '-' }}</td>
                            <td>{{ $attendance->hours_worked ? number_format($attendance->hours_worked, 2) . ' hrs' : '-' }}</td>
                            <td>
                                <span class="badge bg-label-{{ $attendance->status === 'present' ? 'success' : ($attendance->status === 'late' ? 'warning' : 'danger') }}">
                                    {{ ucfirst($attendance->status) }}
                                </span>
                            </td>
                            <td>
                                <button wire:click.prevent="edit({{ $attendance->id }})" class="btn btn-sm btn-icon btn-label-primary">
                                    <i class="ri-edit-line"></i>
                                </button>
                                <button wire:click.prevent="delete({{ $attendance->id }})" 
                                        onclick="return confirm('Are you sure you want to delete this attendance record?')"
                                        class="btn btn-sm btn-icon btn-label-danger">
                                    <i class="ri-delete-bin-line"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                No attendance records found for {{ $selectedDate }}.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($attendances->hasPages())
            <div class="card-footer border-top">
                {{ $attendances->links() }}
            </div>
        @endif
    </div>

    <!-- Modal for Add/Edit Attendance -->
    @if($showModal)
        <div class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0,0,0,0.5);" wire:click.self="closeModal">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" wire:click.stop>
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="ri-{{ $editing ? 'edit' : 'add' }}-line me-2"></i>
                            {{ $editing ? 'Edit Attendance' : 'Record Attendance' }}
                        </h5>
                        <button type="button" class="btn-close" wire:click.prevent="closeModal"></button>
                    </div>
                    
                    <form wire:submit.prevent="save">
                        <div class="modal-body">
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label class="form-label fw-medium">Employee</label>
                                    <select wire:model="employee_id" class="form-select @error('employee_id') is-invalid @enderror">
                                        <option value="">Select Employee</option>
                                        @foreach($employees as $employee)
                                            <option value="{{ $employee->id }}">{{ $employee->user ? $employee->user->name : 'N/A' }} - {{ $employee->employee_id }}</option>
                                        @endforeach
                                    </select>
                                    @error('employee_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-medium">Date</label>
                                    <input type="date" wire:model="date" class="form-control @error('date') is-invalid @enderror">
                                    @error('date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-medium">Clock In</label>
                                    <input type="time" wire:model="clock_in" class="form-control @error('clock_in') is-invalid @enderror">
                                    @error('clock_in') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-medium">Clock Out</label>
                                    <input type="time" wire:model="clock_out" class="form-control @error('clock_out') is-invalid @enderror">
                                    @error('clock_out') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-medium">Break Start</label>
                                    <input type="time" wire:model="break_start" class="form-control @error('break_start') is-invalid @enderror">
                                    @error('break_start') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-medium">Break End</label>
                                    <input type="time" wire:model="break_end" class="form-control @error('break_end') is-invalid @enderror">
                                    @error('break_end') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-medium">Status</label>
                                    <select wire:model="status" class="form-select @error('status') is-invalid @enderror">
                                        <option value="present">Present</option>
                                        <option value="absent">Absent</option>
                                        <option value="late">Late</option>
                                        <option value="half_day">Half Day</option>
                                    </select>
                                    @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-12">
                                    <label class="form-label fw-medium">Notes</label>
                                    <textarea wire:model="notes" rows="3" class="form-control @error('notes') is-invalid @enderror"></textarea>
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
                                {{ $editing ? 'Update' : 'Save' }} Attendance
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>