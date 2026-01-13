<?php

namespace App\Livewire\Branches;

use App\Models\Branch;
use App\Models\BranchInventory;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class BranchInventoryManagement extends Component
{
    use WithPagination;

    public $search = '';
    public $selectedBranch = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';

    // Modal state
    public $showModal = false;
    public $editing = false;
    public $inventoryId = null;

    // Form fields
    public $branch_id = '';
    public $product_id = '';
    public $quantity = '';
    public $min_stock_level = '';
    public $max_stock_level = '';
    public $notes = '';

    protected $rules = [
        'branch_id' => 'required|exists:branches,id',
        'product_id' => 'required|exists:products,id',
        'quantity' => 'required|numeric|min:0',
        'min_stock_level' => 'nullable|numeric|min:0',
        'max_stock_level' => 'nullable|numeric|min:0',
        'notes' => 'nullable|string',
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

    public function edit($inventoryId)
    {
        $this->inventoryId = $inventoryId;
        $inventory = BranchInventory::findOrFail($inventoryId);
        
        $this->branch_id = $inventory->branch_id;
        $this->product_id = $inventory->product_id;
        $this->quantity = $inventory->quantity;
        $this->min_stock_level = $inventory->min_stock_level;
        $this->max_stock_level = $inventory->max_stock_level;
        $this->notes = $inventory->notes;
        
        $this->showModal = true;
        $this->editing = true;
    }

    public function save()
    {
        $rules = $this->rules;
        
        // Prevent duplicate product-branch combinations
        if ($this->editing) {
            $rules['product_id'] .= '|unique:branch_inventory,product_id,' . $this->inventoryId . ',id,branch_id,' . $this->branch_id;
        } else {
            $rules['product_id'] .= '|unique:branch_inventory,product_id,NULL,id,branch_id,' . $this->branch_id;
        }
        
        $this->validate($rules);

        $data = [
            'branch_id' => $this->branch_id,
            'product_id' => $this->product_id,
            'quantity' => $this->quantity,
            'min_stock_level' => $this->min_stock_level ?? 0,
            'max_stock_level' => $this->max_stock_level ?? 0,
            'notes' => $this->notes,
        ];

        if ($this->editing) {
            BranchInventory::findOrFail($this->inventoryId)->update($data);
            session()->flash('message', 'Branch inventory updated successfully.');
        } else {
            BranchInventory::create($data);
            session()->flash('message', 'Branch inventory created successfully.');
        }

        $this->resetForm();
        $this->showModal = false;
    }

    public function delete($inventoryId)
    {
        BranchInventory::findOrFail($inventoryId)->delete();
        session()->flash('message', 'Branch inventory deleted successfully.');
    }

    public function resetForm()
    {
        $this->inventoryId = null;
        $this->branch_id = '';
        $this->product_id = '';
        $this->quantity = '';
        $this->min_stock_level = '';
        $this->max_stock_level = '';
        $this->notes = '';
        $this->editing = false;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
    }

    public function render()
    {
        $inventory = BranchInventory::with(['branch', 'product'])
            ->when($this->search, function ($query) {
                $query->whereHas('product', function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('sku', 'like', '%' . $this->search . '%');
                })
                ->orWhereHas('branch', function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->selectedBranch, function ($query) {
                $query->where('branch_id', $this->selectedBranch);
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(15);

        $branches = Branch::active()->get();
        $products = Product::all();

        // Statistics
        $totalItems = BranchInventory::sum('quantity');
        $lowStockItems = BranchInventory::whereColumn('quantity', '<=', 'min_stock_level')->count();
        $outOfStockItems = BranchInventory::where('quantity', 0)->count();

        return view('livewire.branches.branch-inventory-management', [
            'inventory' => $inventory,
            'branches' => $branches,
            'products' => $products,
            'totalItems' => $totalItems,
            'lowStockItems' => $lowStockItems,
            'outOfStockItems' => $outOfStockItems,
        ]);
    }
}