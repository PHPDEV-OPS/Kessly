<?php

namespace App\Livewire\Sales;

use App\Models\Customer;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class Customers extends Component
{
    use WithPagination;

    public string $search = '';
    public string $sortField = 'name';
    public string $sortDirection = 'asc';
    public int $perPage = 10;

    public ?int $customerId = null;
    public string $name = '';
    public string $email = '';
    public ?string $phone = null;
    public ?string $address = null;
    public ?string $notes = null;

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
            'email' => [
                'required', 'email', 'max:255',
                Rule::unique('customers', 'email')->ignore($this->customerId),
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
        $c = Customer::findOrFail($id);
        $this->customerId = $c->id;
        $this->name = $c->name;
        $this->email = $c->email;
        $this->phone = $c->phone;
        $this->address = $c->address;
        $this->notes = $c->notes;
        $this->showForm = true;
    }

    public function save(): void
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
            'notes' => $this->notes,
        ];

        if ($this->customerId) {
            Customer::whereKey($this->customerId)->update($data);
            session()->flash('status', 'Customer updated');
        } else {
            Customer::create($data);
            session()->flash('status', 'Customer created');
        }

        $this->resetForm();
        $this->showForm = false;
    }

    public function delete(int $id): void
    {
        Customer::whereKey($id)->delete();
        session()->flash('status', 'Customer deleted');
        $this->resetPage();
    }

    public function cancel(): void
    {
        $this->resetForm();
        $this->showForm = false;
    }

    protected function resetForm(): void
    {
        $this->reset(['customerId', 'name', 'email', 'phone', 'address', 'notes']);
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function render()
    {
        $query = Customer::query()
            ->when($this->search !== '', function ($q) {
                $q->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%')
                      ->orWhere('phone', 'like', '%' . $this->search . '%')
                      ->orWhere('address', 'like', '%' . $this->search . '%');
                });
            });

        $allowed = ['name', 'email', 'created_at'];
        $field = in_array($this->sortField, $allowed, true) ? $this->sortField : 'name';
        $direction = $this->sortDirection === 'desc' ? 'desc' : 'asc';

        $customers = $query->orderBy($field, $direction)->paginate($this->perPage);

        return view('livewire.sales.customers', [
            'customers' => $customers,
        ]);
    }
}
