<?php

namespace App\Livewire\Settings;

use App\Models\Role;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class Roles extends Component
{
    use WithPagination;

    // Listing controls
    public string $search = '';
    public string $sortField = 'name';
    public string $sortDirection = 'asc';
    public int $perPage = 10;

    // Form fields
    public ?int $roleId = null;
    public string $name = '';
    public ?string $description = null;
    public ?string $permissions = null; // comma-separated or JSON-like string

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
                Rule::unique('roles', 'name')->ignore($this->roleId),
            ],
            'description' => ['nullable', 'string'],
            'permissions' => ['nullable', 'string'],
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
        $r = Role::findOrFail($id);
        $this->roleId = $r->id;
        $this->name = $r->name;
        $this->description = $r->description;
        $this->permissions = $r->permissions;
        $this->showForm = true;
    }

    public function save(): void
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'description' => $this->description,
            'permissions' => $this->permissions,
        ];

        if ($this->roleId) {
            Role::whereKey($this->roleId)->update($data);
            session()->flash('status', 'Role updated');
        } else {
            Role::create($data);
            session()->flash('status', 'Role created');
        }

        $this->resetForm();
        $this->showForm = false;
    }

    public function delete(int $id): void
    {
        Role::whereKey($id)->delete();
        session()->flash('status', 'Role deleted');
        $this->resetPage();
    }

    public function cancel(): void
    {
        $this->resetForm();
        $this->showForm = false;
    }

    public function togglePermission(string $permission): void
    {
        $current = $this->permissions ? array_map('trim', explode(',', $this->permissions)) : [];
        
        if (in_array($permission, $current)) {
            // Remove permission
            $current = array_filter($current, fn($p) => $p !== $permission);
        } else {
            // Add permission
            $current[] = $permission;
        }
        
        $this->permissions = implode(', ', array_filter($current));
    }

    protected function resetForm(): void
    {
        $this->reset(['roleId', 'name', 'description', 'permissions']);
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function render()
    {
        $query = Role::query()
            ->when($this->search !== '', function ($q) {
                $q->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('description', 'like', '%' . $this->search . '%')
                      ->orWhere('permissions', 'like', '%' . $this->search . '%');
                });
            });

        $allowed = ['name', 'created_at'];
        $field = in_array($this->sortField, $allowed, true) ? $this->sortField : 'name';
        $direction = $this->sortDirection === 'desc' ? 'desc' : 'asc';

        $roles = $query->orderBy($field, $direction)->paginate($this->perPage);

        return view('livewire.settings.roles', [
            'roles' => $roles,
        ]);
    }
}
