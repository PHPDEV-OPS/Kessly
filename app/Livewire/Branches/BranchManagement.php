<?php

namespace App\Livewire\Branches;

use App\Models\Branch;
use App\Models\Employee;
use App\Models\BranchInventory;
use App\Models\Order;
use Livewire\Component;
use Livewire\WithPagination;

class BranchManagement extends Component
{
    use WithPagination;

    public $search = '';
    public $status = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';

    // Modal state
    public $showModal = false;
    public $editing = false;
    public $branchId = null;

    // Form fields
    public $name = '';
    public $code = '';
    public $address = '';
    public $city = '';
    public $state = '';
    public $postal_code = '';
    public $phone = '';
    public $email = '';
    public $manager_id = '';
    public $branch_status = 'active';
    public $established_date = '';
    public $description = '';

    protected $rules = [
        'name' => 'required|string|max:255',
        'code' => 'required|string|max:10|unique:branches,code',
        'address' => 'required|string|max:500',
        'city' => 'required|string|max:255',
        'state' => 'required|string|max:255',
        'postal_code' => 'required|string|max:20',
        'phone' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'manager_id' => 'nullable|exists:employees,id',
        'branch_status' => 'required|in:active,inactive',
        'established_date' => 'required|date',
        'description' => 'nullable|string|max:1000',
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

    public function edit($branchId)
    {
        $this->branchId = $branchId;
        $branch = Branch::findOrFail($branchId);
        
        $this->name = $branch->name;
        $this->code = $branch->code;
        $this->address = $branch->address;
        $this->city = $branch->city;
        $this->state = $branch->state;
        $this->postal_code = $branch->postal_code;
        $this->phone = $branch->phone;
        $this->email = $branch->email;
        $this->manager_id = $branch->manager_id;
        $this->branch_status = $branch->status;
        $this->established_date = $branch->established_date?->format('Y-m-d');
        $this->description = $branch->description;
        
        $this->showModal = true;
        $this->editing = true;
    }

    public function save()
    {
        if ($this->editing) {
            $rules = $this->rules;
            $rules['code'] = 'required|string|max:10|unique:branches,code,' . $this->branchId;
        } else {
            $rules = $this->rules;
        }

        $this->validate($rules);

        $data = [
            'name' => $this->name,
            'code' => $this->code,
            'address' => $this->address,
            'city' => $this->city,
            'state' => $this->state,
            'postal_code' => $this->postal_code,
            'phone' => $this->phone,
            'email' => $this->email,
            'manager_id' => $this->manager_id ?: null,
            'status' => $this->branch_status,
            'established_date' => $this->established_date,
            'description' => $this->description,
        ];

        if ($this->editing) {
            Branch::findOrFail($this->branchId)->update($data);
            session()->flash('message', 'Branch updated successfully.');
        } else {
            Branch::create($data);
            session()->flash('message', 'Branch created successfully.');
        }

        $this->resetForm();
        $this->showModal = false;
    }

    public function delete($branchId)
    {
        try {
            $branch = Branch::findOrFail($branchId);
            
            // Check if branch can be safely deleted
            $deleteCheck = $this->canDeleteBranch($branchId);
            
            if (!$deleteCheck['canDelete']) {
                $constraintsList = implode(', ', $deleteCheck['constraints']);
                session()->flash('error', "Cannot delete branch '{$branch->name}'. It has associated: {$constraintsList}. Please remove or reassign these items first.");
                return;
            }
            
            $branch->delete();
            session()->flash('message', "Branch '{$branch->name}' deleted successfully.");
            
            // Reset pagination if we're on a page that might not have records after deletion
            $this->resetPage();
            
        } catch (\Illuminate\Database\QueryException $e) {
            // Handle foreign key constraint violations
            if ($e->getCode() === '23000') {
                session()->flash('error', 'Cannot delete this branch because it has associated records. Please remove all associated employees, orders, and inventory first.');
            } else {
                session()->flash('error', 'An error occurred while deleting the branch. Please try again.');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'An unexpected error occurred. Please try again.');
        }
    }

    public function resetForm()
    {
        $this->branchId = null;
        $this->name = '';
        $this->code = '';
        $this->address = '';
        $this->city = '';
        $this->state = '';
        $this->postal_code = '';
        $this->phone = '';
        $this->email = '';
        $this->manager_id = '';
        $this->branch_status = 'active';
        $this->established_date = '';
        $this->description = '';
        $this->editing = false;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
    }

    /**
     * Check if branch can be safely deleted
     */
    private function canDeleteBranch($branchId)
    {
        $constraints = [];
        
        // Check for employees
        $employeeCount = Employee::where('branch_id', $branchId)->count();
        if ($employeeCount > 0) {
            $constraints[] = "{$employeeCount} employee(s)";
        }
        
        // Check for orders
        $orderCount = Order::where('branch_id', $branchId)->count();
        if ($orderCount > 0) {
            $constraints[] = "{$orderCount} order(s)";
        }
        
        // Check for branch inventory
        $inventoryCount = BranchInventory::where('branch_id', $branchId)->count();
        if ($inventoryCount > 0) {
            $constraints[] = "{$inventoryCount} inventory item(s)";
        }
        
        return [
            'canDelete' => empty($constraints),
            'constraints' => $constraints
        ];
    }

    public function render()
    {
        $branches = Branch::forUser()
            ->with(['manager.user', 'employees'])
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('code', 'like', '%' . $this->search . '%')
                      ->orWhere('city', 'like', '%' . $this->search . '%');
            })
            ->when($this->status, function ($query) {
                $query->where('status', $this->status);
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);

        $managers = Employee::with('user')->managers()->active()->get();

        // Branch statistics - filtered by user role
        $totalBranches = Branch::forUser()->count();
        $activeBranches = Branch::forUser()->where('status', 'active')->count();
        $totalEmployees = Employee::count();

        return view('livewire.branches.branch-management', compact(
            'branches', 
            'managers', 
            'totalBranches', 
            'activeBranches', 
            'totalEmployees'
        ));
    }
}