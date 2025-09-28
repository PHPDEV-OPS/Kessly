<?php

namespace App\Livewire\Inventory;

use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class Products extends Component
{
    use WithPagination;

    // Listing controls
    public string $search = '';
    public string $sortField = 'name';
    public string $sortDirection = 'asc';
    public int $perPage = 10;

    // Form fields
    public ?int $productId = null;
    public string $name = '';
    public ?string $description = '';
    public ?int $category_id = null;
    public ?int $supplier_id = null;
    public int $stock = 0;
    public float $price = 0.0;

    // UI state
    public bool $showForm = false; // toggles create/edit form

    protected $queryString = [
        'search' => ['except' => ''],
        'sortField' => ['except' => 'name'],
        'sortDirection' => ['except' => 'asc'],
    ];

    protected function rules(): array
    {
        return [
            'name' => [
                'required', 'string', 'max:255',
                Rule::unique('products', 'name')->ignore($this->productId),
            ],
            'description' => ['nullable', 'string'],
            'category_id' => ['required', 'exists:categories,id'],
            'supplier_id' => ['nullable', 'exists:suppliers,id'],
            'stock' => ['required', 'integer', 'min:0'],
            'price' => ['required', 'numeric', 'min:0'],
        ];
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function sortBy(string $field): void
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
        $this->resetPage();
    }

    public function create(): void
    {
        $this->resetForm();
        $this->showForm = true;
    }

    public function edit(int $id): void
    {
        $product = Product::findOrFail($id);

        $this->productId = $product->id;
        $this->name = $product->name;
        $this->description = (string)($product->description ?? '');
        $this->category_id = $product->category_id;
        $this->supplier_id = $product->supplier_id;
        $this->stock = (int)$product->stock;
        $this->price = (float)$product->price;

        $this->showForm = true;
    }

    public function save(): void
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'description' => $this->description,
            'category_id' => $this->category_id,
            'supplier_id' => $this->supplier_id,
            'stock' => $this->stock,
            'price' => $this->price,
        ];

        if ($this->productId) {
            Product::whereKey($this->productId)->update($data);
            session()->flash('status', 'Product updated');
        } else {
            Product::create($data);
            session()->flash('status', 'Product created');
        }

        $this->resetForm();
        $this->showForm = false;
    }

    public function delete(int $id): void
    {
        Product::whereKey($id)->delete();
        session()->flash('status', 'Product deleted');
        $this->resetPage();
    }

    public function cancel(): void
    {
        $this->resetForm();
        $this->showForm = false;
    }

    protected function resetForm(): void
    {
        $this->reset([
            'productId', 'name', 'description', 'category_id', 'supplier_id', 'stock', 'price'
        ]);
        $this->stock = 0;
        $this->price = 0.0;
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function render()
    {
        $query = Product::query()
            ->with(['category', 'supplier'])
            ->when($this->search !== '', function ($q) {
                $q->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('description', 'like', '%' . $this->search . '%');
                });
            });

        // Validate allowed sort fields to avoid SQL injection via query string
        $allowedSorts = ['name', 'stock', 'price', 'created_at'];
        $sortField = in_array($this->sortField, $allowedSorts, true) ? $this->sortField : 'name';
        $sortDirection = $this->sortDirection === 'desc' ? 'desc' : 'asc';

        $products = $query->orderBy($sortField, $sortDirection)
            ->paginate($this->perPage);

        return view('livewire.inventory.products', [
            'products' => $products,
            'categories' => Category::orderBy('name')->get(),
            'suppliers' => Supplier::orderBy('name')->get(),
        ]);
    }
}
