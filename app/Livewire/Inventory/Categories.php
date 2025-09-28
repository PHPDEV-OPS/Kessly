<?php

namespace App\Livewire\Inventory;

use App\Models\Category;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;

class Categories extends Component
{
    use WithPagination;

    // Listing controls
    public string $search = '';
    public string $sortField = 'name';
    public string $sortDirection = 'asc';
    public int $perPage = 10;

    // Form fields
    public ?int $categoryId = null;
    public string $name = '';
    public ?string $slug = null;

    // UI state
    public bool $showForm = false;

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
                Rule::unique('categories', 'name')->ignore($this->categoryId),
            ],
            'slug' => [
                'nullable', 'string', 'max:255',
                Rule::unique('categories', 'slug')->ignore($this->categoryId),
            ],
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
        $cat = Category::findOrFail($id);
        $this->categoryId = $cat->id;
        $this->name = $cat->name;
        $this->slug = $cat->slug;
        $this->showForm = true;
    }

    public function save(): void
    {
        $this->validate();

        $slug = $this->slug ?: Str::slug($this->name);

        $data = [
            'name' => $this->name,
            'slug' => $slug,
        ];

        if ($this->categoryId) {
            Category::whereKey($this->categoryId)->update($data);
            session()->flash('status', 'Category updated');
        } else {
            Category::create($data);
            session()->flash('status', 'Category created');
        }

        $this->resetForm();
        $this->showForm = false;
    }

    public function delete(int $id): void
    {
        Category::whereKey($id)->delete();
        session()->flash('status', 'Category deleted');
        $this->resetPage();
    }

    public function cancel(): void
    {
        $this->resetForm();
        $this->showForm = false;
    }

    protected function resetForm(): void
    {
        $this->reset(['categoryId', 'name', 'slug']);
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function render()
    {
        $query = Category::query()
            ->when($this->search !== '', function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('slug', 'like', '%' . $this->search . '%');
            });

        $allowed = ['name', 'slug', 'created_at'];
        $field = in_array($this->sortField, $allowed, true) ? $this->sortField : 'name';
        $direction = $this->sortDirection === 'desc' ? 'desc' : 'asc';

        $categories = $query->orderBy($field, $direction)->paginate($this->perPage);

        return view('livewire.inventory.categories', [
            'categories' => $categories,
        ]);
    }
}
