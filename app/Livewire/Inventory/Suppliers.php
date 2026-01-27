<?php

namespace App\Livewire\Inventory;

use App\Models\Supplier;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class Suppliers extends Component
{
    use WithPagination;

    // Listing controls
    public string $search = '';
    public string $sortField = 'name';
    public string $sortDirection = 'asc';
    public int $perPage = 10;

    // Form fields
    public ?int $supplierId = null;
    public string $name = '';
    public string $contact_email = '';
    public ?string $phone = null;
    public ?string $address = null;
    public ?string $notes = null;

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
            'name' => ['required', 'string', 'max:255'],
            'contact_email' => [
                'required', 'email', 'max:255',
                Rule::unique('suppliers', 'contact_email')->ignore($this->supplierId),
            ],
            'phone' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string'],
            'notes' => ['nullable', 'string'],
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
        $sup = Supplier::findOrFail($id);
        $this->supplierId = $sup->id;
        $this->name = $sup->name;
        $this->contact_email = $sup->contact_email;
        $this->phone = $sup->phone;
        $this->address = $sup->address;
        $this->notes = $sup->notes;
        $this->showForm = true;
    }

    public function save(): void
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'contact_email' => $this->contact_email,
            'phone' => $this->phone,
            'address' => $this->address,
            'notes' => $this->notes,
        ];

        if ($this->supplierId) {
            Supplier::whereKey($this->supplierId)->update($data);
            session()->flash('status', 'Supplier updated');
        } else {
            Supplier::create($data);
            session()->flash('status', 'Supplier created');
        }

        $this->resetForm();
        $this->showForm = false;
    }

    public function delete(int $id): void
    {
        Supplier::whereKey($id)->delete();
        session()->flash('status', 'Supplier deleted');
        $this->resetPage();
    }

    public function cancel(): void
    {
        $this->resetForm();
        $this->showForm = false;
    }

    public function export()
    {
        $query = Supplier::forUser()
            ->when($this->search !== '', function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('contact_email', 'like', '%' . $this->search . '%')
                  ->orWhere('phone', 'like', '%' . $this->search . '%');
            });

        $allowed = ['name', 'contact_email', 'created_at'];
        $field = in_array($this->sortField, $allowed, true) ? $this->sortField : 'name';
        $direction = $this->sortDirection === 'desc' ? 'desc' : 'asc';

        $suppliers = $query->orderBy($field, $direction)->get();

        $csv = "Name,Email,Phone,Address,Notes\n";
        foreach ($suppliers as $supplier) {
            $csv .= sprintf(
                "\"%s\",\"%s\",\"%s\",\"%s\",\"%s\"\n",
                str_replace('"', '""', $supplier->name),
                str_replace('"', '""', $supplier->contact_email),
                str_replace('"', '""', $supplier->phone ?? ''),
                str_replace('"', '""', $supplier->address ?? ''),
                str_replace('"', '""', $supplier->notes ?? '')
            );
        }

        return response()->streamDownload(function () use ($csv) {
            echo $csv;
        }, 'suppliers-' . now()->format('Y-m-d') . '.csv', [
            'Content-Type' => 'text/csv',
        ]);
    }

    protected function resetForm(): void
    {
        $this->reset(['supplierId', 'name', 'contact_email', 'phone', 'address', 'notes']);
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function render()
    {
        $query = Supplier::forUser()
            ->when($this->search !== '', function ($q) {
                $q->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('contact_email', 'like', '%' . $this->search . '%')
                      ->orWhere('phone', 'like', '%' . $this->search . '%')
                      ->orWhere('address', 'like', '%' . $this->search . '%');
                });
            });

        $allowed = ['name', 'contact_email', 'created_at'];
        $field = in_array($this->sortField, $allowed, true) ? $this->sortField : 'name';
        $direction = $this->sortDirection === 'desc' ? 'desc' : 'asc';

        $suppliers = $query->orderBy($field, $direction)->paginate($this->perPage);

        return view('livewire.inventory.suppliers', [
            'suppliers' => $suppliers,
        ]);
    }
}
