<?php

namespace App\Livewire\Finance;

use App\Models\Budget;
use App\Models\Branch;
use Livewire\Component;
use Livewire\WithPagination;

class BudgetManagement extends Component
{
    use WithPagination;

    public $search = '';
    public $category = '';
    public $status = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';

    // Modal state
    public $showModal = false;
    public $editing = false;
    public $budgetId = null;

    // Form fields
    public $name = '';
    public $description = '';
    public $budget_category = '';
    public $branch_id = '';
    public $allocated_amount = '';
    public $period_start = '';
    public $period_end = '';
    public $budget_status = 'draft';

    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'nullable|string|max:1000',
        'budget_category' => 'required|string|max:255',
        'branch_id' => 'nullable|exists:branches,id',
        'allocated_amount' => 'required|numeric|min:0',
        'period_start' => 'required|date',
        'period_end' => 'required|date|after_or_equal:period_start',
        'budget_status' => 'required|in:draft,approved,rejected,expired',
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

    public function edit($budgetId)
    {
        $this->budgetId = $budgetId;
        $budget = Budget::findOrFail($budgetId);
        
        $this->name = $budget->name;
        $this->description = $budget->description;
        $this->budget_category = $budget->category;
        $this->branch_id = $budget->branch_id;
        $this->allocated_amount = $budget->allocated_amount;
        $this->period_start = $budget->period_start->format('Y-m-d');
        $this->period_end = $budget->period_end->format('Y-m-d');
        $this->budget_status = $budget->status;
        
        $this->showModal = true;
        $this->editing = true;
    }

    public function save()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'description' => $this->description,
            'category' => $this->budget_category,
            'branch_id' => $this->branch_id ?: null,
            'allocated_amount' => $this->allocated_amount,
            'period_start' => $this->period_start,
            'period_end' => $this->period_end,
            'status' => $this->budget_status,
            'created_by' => auth()->id(),
        ];

        if ($this->budget_status === 'approved') {
            $data['approved_by'] = auth()->id();
            $data['approved_at'] = now();
        }

        if ($this->editing) {
            Budget::findOrFail($this->budgetId)->update($data);
            session()->flash('message', 'Budget updated successfully.');
        } else {
            Budget::create($data);
            session()->flash('message', 'Budget created successfully.');
        }

        $this->resetForm();
        $this->showModal = false;
    }

    public function approve($budgetId)
    {
        Budget::findOrFail($budgetId)->update([
            'status' => 'approved',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        session()->flash('message', 'Budget approved successfully.');
    }

    public function reject($budgetId)
    {
        Budget::findOrFail($budgetId)->update([
            'status' => 'rejected',
        ]);

        session()->flash('message', 'Budget rejected.');
    }

    public function delete($budgetId)
    {
        Budget::findOrFail($budgetId)->delete();
        session()->flash('message', 'Budget deleted successfully.');
    }

    private function resetForm()
    {
        $this->budgetId = null;
        $this->name = '';
        $this->description = '';
        $this->budget_category = '';
        $this->branch_id = '';
        $this->allocated_amount = '';
        $this->period_start = '';
        $this->period_end = '';
        $this->budget_status = 'draft';
        $this->editing = false;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
    }

    public function render()
    {
        $budgets = Budget::with(['branch', 'creator', 'approver'])
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('category', 'like', '%' . $this->search . '%');
            })
            ->when($this->category, function ($query) {
                $query->where('category', $this->category);
            })
            ->when($this->status, function ($query) {
                $query->where('status', $this->status);
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);

        $branches = Branch::active()->get();
        $categories = Budget::distinct('category')->pluck('category')->filter();

        // Statistics
        $totalBudgets = Budget::count();
        $approvedBudgets = Budget::where('status', 'approved')->count();
        $totalAllocated = Budget::where('status', 'approved')->sum('allocated_amount');
        $totalSpent = Budget::where('status', 'approved')->sum('spent_amount');

        return view('livewire.finance.budget-management', compact(
            'budgets', 
            'branches', 
            'categories', 
            'totalBudgets', 
            'approvedBudgets', 
            'totalAllocated', 
            'totalSpent'
        ));
    }
}