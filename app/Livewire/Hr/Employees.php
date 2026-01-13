<?php

namespace App\Livewire\Hr;

use App\Models\Employee;
use App\Models\User;
use App\Models\Branch;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;

class Employees extends Component
{
    use WithPagination;

    public $search = '';
    public $department = '';
    public $employment_status = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';

    // Modal state
    public $showModal = false;
    public $editing = false;
    public $employeeId = null;

    // View modal state
    public $showViewModal = false;
    public $viewEmployee = null;
    public $viewEmployeeId = null;

    // Form fields
    public $employee_id = '';
    public $user_id = '';
    public $branch_id = '';
    public $department_name = '';
    public $position = '';
    public $hire_date = '';
    public $salary = '';
    public $status = 'active';
    public $manager_id = '';
    public $phone = '';
    public $address = '';
    public $emergency_contact = '';
    public $emergency_phone = '';
    public $notes = '';

    protected $rules = [
        'employee_id' => 'required|string|max:255',
        'user_id' => 'required|exists:users,id',
        'branch_id' => 'required|exists:branches,id',
        'department_name' => 'required|string|max:255',
        'position' => 'required|string|max:255',
        'hire_date' => 'required|date',
        'salary' => 'required|numeric|min:0',
        'status' => 'required|in:active,inactive,terminated',
        'manager_id' => 'nullable|exists:employees,id',
        'phone' => 'nullable|string|max:255',
        'address' => 'nullable|string',
        'emergency_contact' => 'nullable|string|max:255',
        'emergency_phone' => 'nullable|string|max:255',
        'notes' => 'nullable|string',
    ];

    protected $messages = [
        'employee_id.unique' => 'This employee ID is already taken.',
        'user_id.unique' => 'This user is already assigned to another employee.',
        'user_id.exists' => 'Selected user does not exist.',
        'branch_id.exists' => 'Selected branch does not exist.',
        'manager_id.exists' => 'Selected manager does not exist.',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }

        $this->sortField = $field;
    }

    public function create()
    {
        $this->resetForm();
        $this->showModal = true;
        $this->editing = false;
    }

    public function edit($employeeId)
    {
        $this->employeeId = $employeeId;
        $employee = Employee::findOrFail($employeeId);
        
        $this->employee_id = $employee->employee_id;
        $this->user_id = $employee->user_id;
        $this->branch_id = $employee->branch_id;
        $this->department_name = $employee->department;
        $this->position = $employee->position;
        $this->hire_date = $employee->hire_date?->format('Y-m-d');
        $this->salary = $employee->salary;
        $this->status = $employee->employment_status;
        $this->manager_id = $employee->manager_id;
        $this->phone = $employee->phone;
        $this->address = $employee->address;
        $this->emergency_contact = $employee->emergency_contact;
        $this->emergency_phone = $employee->emergency_phone;
        $this->notes = $employee->notes;
        
        $this->showModal = true;
        $this->editing = true;
    }

    public function save()
    {
        $rules = $this->rules;
        
        if ($this->editing) {
            // Get current employee to check what's actually changing
            $currentEmployee = Employee::findOrFail($this->employeeId);
            
            // Always validate employee_id uniqueness excluding current record
            $rules['employee_id'] = 'required|string|max:255|unique:employees,employee_id,' . $this->employeeId . ',id';
            
            // Only validate user_id uniqueness if it's actually changing
            if ($currentEmployee->user_id != $this->user_id) {
                $rules['user_id'] = 'required|exists:users,id|unique:employees,user_id';
            } else {
                // If user_id is not changing, just validate existence
                $rules['user_id'] = 'required|exists:users,id';
            }
        } else {
            // For new records, ensure both employee_id and user_id are unique
            $rules['employee_id'] = 'required|string|max:255|unique:employees,employee_id';
            $rules['user_id'] = 'required|exists:users,id|unique:employees,user_id';
        }

        $this->validate($rules);

        $data = [
            'employee_id' => $this->employee_id,
            'user_id' => $this->user_id,
            'branch_id' => $this->branch_id,
            'department' => $this->department_name,
            'position' => $this->position,
            'hire_date' => $this->hire_date,
            'salary' => $this->salary,
            'employment_status' => $this->status,
            'manager_id' => $this->manager_id ?: null,
            'phone' => $this->phone,
            'address' => $this->address,
            'emergency_contact' => $this->emergency_contact,
            'emergency_phone' => $this->emergency_phone,
            'notes' => $this->notes,
        ];

        if ($this->editing) {
            Employee::findOrFail($this->employeeId)->update($data);
            session()->flash('message', 'Employee updated successfully.');
        } else {
            Employee::create($data);
            session()->flash('message', 'Employee created successfully.');
        }

        $this->resetForm();
        $this->showModal = false;
        $this->resetPage();
    }

    public function delete($employeeId)
    {
        Employee::findOrFail($employeeId)->delete();
        session()->flash('message', 'Employee deleted successfully.');
    }

    public function view($employeeId)
    {
        $this->viewEmployeeId = $employeeId;
        $this->viewEmployee = Employee::with(['user', 'branch', 'manager.user'])
            ->findOrFail($employeeId);
        $this->showViewModal = true;
    }

    public function closeViewModal()
    {
        $this->showViewModal = false;
        $this->viewEmployee = null;
        $this->viewEmployeeId = null;
    }

    public function editFromView()
    {
        if ($this->viewEmployeeId) {
            $this->closeViewModal();
            $this->edit($this->viewEmployeeId);
        }
    }

    private function resetForm()
    {
        $this->employeeId = null;
        $this->employee_id = '';
        $this->user_id = '';
        $this->branch_id = '';
        $this->department_name = '';
        $this->position = '';
        $this->hire_date = '';
        $this->salary = '';
        $this->status = 'active';
        $this->manager_id = '';
        $this->phone = '';
        $this->address = '';
        $this->emergency_contact = '';
        $this->emergency_phone = '';
        $this->notes = '';
        $this->editing = false;
    }

    #[On('close-modal')]
    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
    }

    public function render()
    {
        $employees = Employee::with(['user', 'branch', 'manager.user'])
            ->when($this->search, function ($query) {
                $query->whereHas('user', function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%');
                })
                ->orWhere('employee_id', 'like', '%' . $this->search . '%')
                ->orWhere('position', 'like', '%' . $this->search . '%');
            })
            ->when($this->department, function ($query) {
                $query->where('department', $this->department);
            })
            ->when($this->employment_status, function ($query) {
                $query->where('employment_status', $this->employment_status);
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);

        // Get available users - if editing, include current employee's user
        $users = User::whereDoesntHave('employee', function($query) {
            if ($this->editing && $this->employeeId) {
                $query->where('id', '!=', $this->employeeId);
            }
        })->get();
        
        // If editing, also include the current employee's user to maintain assignment
        if ($this->editing && $this->employeeId) {
            $currentEmployee = Employee::findOrFail($this->employeeId);
            $currentUser = $currentEmployee->user;
            if ($currentUser && !$users->contains('id', $currentUser->id)) {
                $users->prepend($currentUser);
            }
        }
        
        $branches = Branch::active()->get();
        $managers = Employee::with('user')->managers()->active()->get();
        $departments = Employee::distinct('department')->pluck('department')->filter();

        return view('livewire.hr.employees', compact('employees', 'users', 'branches', 'managers', 'departments'));
    }
}