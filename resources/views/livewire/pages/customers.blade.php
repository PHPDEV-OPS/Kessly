<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use Livewire\WithFileUploads;
use App\Models\Customer;
use App\Models\CustomerNote;

new #[Layout('layouts.app')] class extends Component {
    use WithFileUploads;

    public string $search = '';
    public string $sortField = 'name';
    public string $sortDirection = 'asc';
    public int $perPage = 10;
    public string $filterType = '';
    public string $filterStatus = '';

    // Form fields
    public ?int $customerId = null;
    public string $name = '';
    public string $email = '';
    public ?string $phone = null;
    public ?string $mobile = null;
    public ?string $company = null;
    public ?string $website = null;
    public ?string $address = null;
    public ?string $city = null;
    public ?string $state = null;
    public ?string $postal_code = null;
    public ?string $country = null;
    public ?string $tax_id = null;
    public string $customer_type = 'individual';
    public string $status = 'active';
    public float $credit_limit = 0;
    public ?string $payment_terms = null;
    public ?string $notes = null;
    public array $tags = [];
    public $avatar;

    // UI state
    public bool $showForm = false;
    public bool $showImport = false;
    public bool $showAnalytics = false;
    public ?int $selectedCustomerId = null;

    // Notes
    public bool $showNotesModal = false;
    public string $noteSubject = '';
    public string $noteContent = '';
    public string $noteType = 'note';
    public bool $noteIsPrivate = false;

    protected $queryString = [
        'search' => ['except' => ''],
        'sortField' => ['except' => 'name'],
        'sortDirection' => ['except' => 'asc'],
        'filterType' => ['except' => ''],
        'filterStatus' => ['except' => ''],
    ];

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:customers,email,' . $this->customerId,
            'phone' => 'nullable|string|max:255',
            'mobile' => 'nullable|string|max:255',
            'company' => 'nullable|string|max:255',
            'website' => 'nullable|url|max:255',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:255',
            'tax_id' => 'nullable|string|max:255',
            'customer_type' => 'required|in:individual,business,enterprise',
            'status' => 'required|in:active,inactive,prospect,blocked',
            'credit_limit' => 'nullable|numeric|min:0',
            'payment_terms' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'tags' => 'nullable|array',
            'avatar' => 'nullable|image|max:2048',
        ];
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
        $this->resetPage();
    }

    public function create()
    {
        $this->resetForm();
        $this->showForm = true;
    }

    public function edit($id)
    {
        $customer = Customer::findOrFail($id);
        $this->customerId = $customer->id;
        $this->name = $customer->name;
        $this->email = $customer->email;
        $this->phone = $customer->phone;
        $this->mobile = $customer->mobile;
        $this->company = $customer->company;
        $this->website = $customer->website;
        $this->address = $customer->address;
        $this->city = $customer->city;
        $this->state = $customer->state;
        $this->postal_code = $customer->postal_code;
        $this->country = $customer->country;
        $this->tax_id = $customer->tax_id;
        $this->customer_type = $customer->customer_type;
        $this->status = $customer->status;
        $this->credit_limit = (float) ($customer->credit_limit ?? 0.0);
        $this->payment_terms = $customer->payment_terms;
        $this->notes = $customer->notes;
        $this->tags = $customer->tags ?? [];
        $this->showForm = true;
    }

    public function save()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'mobile' => $this->mobile,
            'company' => $this->company,
            'website' => $this->website,
            'address' => $this->address,
            'city' => $this->city,
            'state' => $this->state,
            'postal_code' => $this->postal_code,
            'country' => $this->country,
            'tax_id' => $this->tax_id,
            'customer_type' => $this->customer_type,
            'status' => $this->status,
            'credit_limit' => $this->credit_limit,
            'payment_terms' => $this->payment_terms,
            'notes' => $this->notes,
            'tags' => $this->tags,
        ];

        if ($this->avatar) {
            $data['avatar'] = $this->avatar->store('customers', 'public');
        }

        if ($this->customerId) {
            Customer::whereKey($this->customerId)->update($data);
            session()->flash('message', 'Customer updated successfully.');
        } else {
            Customer::create($data);
            session()->flash('message', 'Customer created successfully.');
        }

        $this->resetForm();
        $this->showForm = false;
        $this->activeTab = 'list';
    }

    public function delete($id)
    {
        Customer::whereKey($id)->delete();
        session()->flash('message', 'Customer deleted successfully.');
        $this->resetPage();
    }

    public function cancel()
    {
        $this->resetForm();
        $this->showForm = false;
    }

    public function addTag($tag)
    {
        if (!in_array($tag, $this->tags)) {
            $this->tags[] = $tag;
        }
    }

    public function removeTag($tag)
    {
        $this->tags = array_filter($this->tags, fn($t) => $t !== $tag);
    }

    public function viewCustomer($id)
    {
        $this->selectedCustomerId = $id;
    }

    public function addNote()
    {
        $this->validate([
            'noteSubject' => 'required|string|max:255',
            'noteContent' => 'required|string',
            'noteType' => 'required|in:note,call,email,meeting,complaint,feedback',
        ]);

        CustomerNote::create([
            'customer_id' => $this->selectedCustomerId,
            'user_id' => auth()->id(),
            'note_type' => $this->noteType,
            'subject' => $this->noteSubject,
            'content' => $this->noteContent,
            'is_private' => $this->noteIsPrivate,
        ]);

        $this->reset(['noteSubject', 'noteContent', 'noteType', 'noteIsPrivate']);
        $this->showNotesModal = false;
        session()->flash('message', 'Note added successfully.');
    }

    protected function resetForm()
    {
        $this->reset([
            'customerId', 'name', 'email', 'phone', 'mobile', 'company', 'website',
            'address', 'city', 'state', 'postal_code', 'country', 'tax_id',
            'customer_type', 'status', 'credit_limit', 'payment_terms', 'notes', 'tags', 'avatar'
        ]);
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function getCustomersProperty()
    {
        $query = Customer::query()
            ->when($this->search, function ($q) {
                $q->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%')
                      ->orWhere('company', 'like', '%' . $this->search . '%')
                      ->orWhere('phone', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->filterType, fn($q) => $q->where('customer_type', $this->filterType))
            ->when($this->filterStatus, fn($q) => $q->where('status', $this->filterStatus));

        $allowedSorts = ['name', 'email', 'company', 'customer_type', 'status', 'created_at', 'total_spent'];
        $sortField = in_array($this->sortField, $allowedSorts) ? $this->sortField : 'name';

        return $query->orderBy($sortField, $this->sortDirection)->paginate($this->perPage);
    }

    public function getCustomerStatsProperty()
    {
        return [
            'total' => Customer::count(),
            'active' => Customer::where('status', 'active')->count(),
            'inactive' => Customer::where('status', 'inactive')->count(),
            'prospects' => Customer::where('status', 'prospect')->count(),
            'total_spent' => Customer::sum('total_spent'),
        ];
    }

    public function getSelectedCustomerProperty()
    {
        return $this->selectedCustomerId ? Customer::with('customerNotes.user')->find($this->selectedCustomerId) : null;
    }

    public function with(): array
    {
        return [
            'customers' => $this->customers,
            'customerStats' => $this->customerStats,
            'selectedCustomer' => $this->selectedCustomer,
        ];
    }
}; ?>

<div>
    @if (session()->has('message'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
            {{ session('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
        <div class="col-xl col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar me-3">
                            <span class="avatar-initial rounded-circle bg-label-primary">
                                <i class="ri-team-line ri-22px"></i>
                            </span>
                        </div>
                        <div>
                            <div class="text-muted small">Total Customers</div>
                            <h5 class="mb-0">{{ number_format($this->customerStats['total']) }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar me-3">
                            <span class="avatar-initial rounded-circle bg-label-success">
                                <i class="ri-check-double-line ri-22px"></i>
                            </span>
                        </div>
                        <div>
                            <div class="text-muted small">Active</div>
                            <h5 class="mb-0 text-success">{{ number_format($this->customerStats['active']) }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar me-3">
                            <span class="avatar-initial rounded-circle bg-label-warning">
                                <i class="ri-time-line ri-22px"></i>
                            </span>
                        </div>
                        <div>
                            <div class="text-muted small">Prospects</div>
                            <h5 class="mb-0 text-warning">{{ number_format($this->customerStats['prospects']) }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar me-3">
                            <span class="avatar-initial rounded-circle bg-label-danger">
                                <i class="ri-close-circle-line ri-22px"></i>
                            </span>
                        </div>
                        <div>
                            <div class="text-muted small">Inactive</div>
                            <h5 class="mb-0 text-danger">{{ number_format($this->customerStats['inactive']) }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar me-3">
                            <span class="avatar-initial rounded-circle bg-label-info">
                                <i class="ri-money-dollar-circle-line ri-22px"></i>
                            </span>
                        </div>
                        <div>
                            <div class="text-muted small">Total Revenue</div>
                            <h5 class="mb-0">KES {{ number_format($this->customerStats['total_spent'], 2) }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Card -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Customer Management</h5>
            <div class="d-flex gap-2">
                <button wire:click="create" type="button" class="btn btn-primary">
                    <i class="ri-add-line me-1"></i>
                    Add Customer
                </button>
            </div>
        </div>

        <div class="card-body">
            <!-- Filters -->
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search customers..." class="form-control">
                </div>
                <div class="col-md-2">
                    <select wire:model.live="filterType" class="form-select">
                        <option value="">All Types</option>
                        <option value="individual">Individual</option>
                        <option value="business">Business</option>
                        <option value="enterprise">Enterprise</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select wire:model.live="filterStatus" class="form-select">
                        <option value="">All Status</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                        <option value="prospect">Prospect</option>
                        <option value="blocked">Blocked</option>
                    </select>
                </div>
                <div class="col-md-2 ms-auto">
                    <select wire:model.live="perPage" class="form-select">
                        <option value="10">10 per page</option>
                        <option value="25">25 per page</option>
                        <option value="50">50 per page</option>
                        <option value="100">100 per page</option>
                    </select>
                </div>
            </div>

            <!-- Table -->
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>
                                <button wire:click="sortBy('name')" type="button" class="btn btn-sm btn-link text-decoration-none p-0">
                                    Customer
                                    @if($sortField === 'name')
                                        <i class="ri-arrow-{{ $sortDirection === 'asc' ? 'up' : 'down' }}-s-line"></i>
                                    @endif
                                </button>
                            </th>
                            <th>Contact</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>
                                <button wire:click="sortBy('total_spent')" type="button" class="btn btn-sm btn-link text-decoration-none p-0">
                                    Total Spent
                                    @if($sortField === 'total_spent')
                                        <i class="ri-arrow-{{ $sortDirection === 'asc' ? 'up' : 'down' }}-s-line"></i>
                                    @endif
                                </button>
                            </th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($this->customers as $customer)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($customer->avatar)
                                            <img class="avatar avatar-sm me-3 rounded-circle" src="{{ asset('storage/' . $customer->avatar) }}" alt="">
                                        @else
                                            <div class="avatar avatar-sm me-3">
                                                <span class="avatar-initial rounded-circle bg-label-primary">{{ $customer->initials }}</span>
                                            </div>
                                        @endif
                                        <div>
                                            <div class="fw-medium">{{ $customer->name }}</div>
                                            @if($customer->company)
                                                <small class="text-muted">{{ $customer->company }}</small>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div>{{ $customer->email }}</div>
                                    @if($customer->phone)
                                        <small class="text-muted">{{ $customer->phone }}</small>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-label-{{ $customer->customer_type === 'enterprise' ? 'info' : ($customer->customer_type === 'business' ? 'primary' : 'secondary') }}">
                                        {{ ucfirst($customer->customer_type) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-label-{{ $customer->status === 'active' ? 'success' : ($customer->status === 'inactive' ? 'danger' : ($customer->status === 'prospect' ? 'warning' : 'secondary')) }}">
                                        {{ ucfirst($customer->status) }}
                                    </span>
                                </td>
                                <td>KES {{ number_format($customer->total_spent, 2) }}</td>
                                <td class="text-end">
                                    <button wire:click="viewCustomer({{ $customer->id }})" type="button" class="btn btn-sm btn-icon btn-label-info" title="View Details">
                                        <i class="ri-eye-line"></i>
                                    </button>
                                    <button wire:click="edit({{ $customer->id }})" type="button" class="btn btn-sm btn-icon btn-label-primary" title="Edit">
                                        <i class="ri-edit-line"></i>
                                    </button>
                                    <button wire:click="delete({{ $customer->id }})" type="button"
                                            onclick="return confirm('Are you sure you want to delete this customer?')"
                                            class="btn btn-sm btn-icon btn-label-danger" title="Delete">
                                        <i class="ri-delete-bin-line"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <p class="text-muted mb-0">No customers found.</p>
                                    <button wire:click="create" type="button" class="btn btn-primary mt-3">
                                        <i class="ri-add-line me-1"></i>
                                        Add Customer
                                    </button>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        @if($this->customers->hasPages())
            <div class="card-footer border-top">
                {{ $this->customers->links() }}
            </div>
        @endif
    </div>

    <!-- Customer Form Modal -->
    @if($showForm)
        <div class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0,0,0,0.5);" wire:click.self="cancel">
            <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable" wire:click.stop>
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="ri-{{ $customerId ? 'edit' : 'add' }}-line me-2"></i>
                            {{ $customerId ? 'Edit Customer' : 'Add New Customer' }}
                        </h5>
                        <button type="button" class="btn-close" wire:click.prevent="cancel"></button>
                    </div>
                    
                    <form wire:submit.prevent="save">
                        <div class="modal-body">
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label class="form-label fw-medium">Full Name *</label>
                                    <input type="text" wire:model="name" class="form-control @error('name') is-invalid @enderror">
                                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-medium">Email *</label>
                                    <input type="email" wire:model="email" class="form-control @error('email') is-invalid @enderror">
                                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-medium">Phone</label>
                                    <input type="text" wire:model="phone" class="form-control @error('phone') is-invalid @enderror">
                                    @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-medium">Mobile</label>
                                    <input type="text" wire:model="mobile" class="form-control @error('mobile') is-invalid @enderror">
                                    @error('mobile') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-medium">Company</label>
                                    <input type="text" wire:model="company" class="form-control @error('company') is-invalid @enderror">
                                    @error('company') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-medium">Customer Type *</label>
                                    <select wire:model="customer_type" class="form-select @error('customer_type') is-invalid @enderror">
                                        <option value="individual">Individual</option>
                                        <option value="business">Business</option>
                                        <option value="enterprise">Enterprise</option>
                                    </select>
                                    @error('customer_type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-medium">Status *</label>
                                    <select wire:model="status" class="form-select @error('status') is-invalid @enderror">
                                        <option value="active">Active</option>
                                        <option value="inactive">Inactive</option>
                                        <option value="prospect">Prospect</option>
                                        <option value="blocked">Blocked</option>
                                    </select>
                                    @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-medium">Address</label>
                                    <input type="text" wire:model="address" class="form-control @error('address') is-invalid @enderror">
                                    @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-12">
                                    <label class="form-label fw-medium">Notes</label>
                                    <textarea wire:model="notes" rows="3" class="form-control @error('notes') is-invalid @enderror"></textarea>
                                    @error('notes') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" wire:click.prevent="cancel" class="btn btn-label-secondary">
                                <i class="ri-close-line me-1"></i>
                                Cancel
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="ri-save-line me-1"></i>
                                {{ $customerId ? 'Update' : 'Create' }} Customer
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <!-- Customer Details Modal -->
    @if($selectedCustomer)
        <div class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0,0,0,0.5);" wire:click.self="$set('selectedCustomerId', null)">
            <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable" wire:click.stop>
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="ri-user-line me-2"></i>
                            Customer Details
                        </h5>
                        <button type="button" class="btn-close" wire:click.prevent="$set('selectedCustomerId', null)"></button>
                    </div>
                    
                    <div class="modal-body">
                        <div class="row g-4">
                            <!-- Customer Header -->
                            <div class="col-12">
                                <div class="d-flex align-items-center justify-content-between mb-4">
                                    <div class="d-flex align-items-center">
                                        @if($selectedCustomer->avatar)
                                            <img class="avatar avatar-lg me-3 rounded-circle" src="{{ asset('storage/' . $selectedCustomer->avatar) }}" alt="">
                                        @else
                                            <div class="avatar avatar-lg me-3">
                                                <span class="avatar-initial rounded-circle bg-label-primary fs-4">{{ $selectedCustomer->initials }}</span>
                                            </div>
                                        @endif
                                        <div>
                                            <h4 class="mb-1">{{ $selectedCustomer->name }}</h4>
                                            @if($selectedCustomer->company)
                                                <p class="text-muted mb-0">{{ $selectedCustomer->company }}</p>
                                            @endif
                                            <div class="mt-2">
                                                <span class="badge bg-label-{{ $selectedCustomer->customer_type === 'enterprise' ? 'info' : ($selectedCustomer->customer_type === 'business' ? 'primary' : 'secondary') }} me-2">
                                                    {{ ucfirst($selectedCustomer->customer_type) }}
                                                </span>
                                                <span class="badge bg-label-{{ $selectedCustomer->status === 'active' ? 'success' : ($selectedCustomer->status === 'inactive' ? 'danger' : ($selectedCustomer->status === 'prospect' ? 'warning' : 'secondary')) }}">
                                                    {{ ucfirst($selectedCustomer->status) }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <button wire:click.prevent="edit({{ $selectedCustomer->id }})" type="button" class="btn btn-primary">
                                        <i class="ri-edit-line me-1"></i>
                                        Edit Customer
                                    </button>
                                </div>
                            </div>

                            <!-- Stats Cards -->
                            <div class="col-md-3 col-sm-6">
                                <div class="card bg-label-primary">
                                    <div class="card-body text-center">
                                        <i class="ri-shopping-cart-line ri-24px mb-2"></i>
                                        <h5 class="mb-0">{{ $selectedCustomer->total_orders ?? 0 }}</h5>
                                        <small>Total Orders</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="card bg-label-success">
                                    <div class="card-body text-center">
                                        <i class="ri-money-dollar-circle-line ri-24px mb-2"></i>
                                        <h5 class="mb-0">KES {{ number_format($selectedCustomer->total_spent, 2) }}</h5>
                                        <small>Total Spent</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="card bg-label-warning">
                                    <div class="card-body text-center">
                                        <i class="ri-wallet-line ri-24px mb-2"></i>
                                        <h5 class="mb-0">KES {{ number_format($selectedCustomer->credit_limit, 2) }}</h5>
                                        <small>Credit Limit</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="card bg-label-info">
                                    <div class="card-body text-center">
                                        <i class="ri-calendar-line ri-24px mb-2"></i>
                                        <h5 class="mb-0">{{ $selectedCustomer->created_at->format('M Y') }}</h5>
                                        <small>Customer Since</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Contact Information -->
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h6 class="mb-0"><i class="ri-contacts-line me-2"></i>Contact Information</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <small class="text-muted d-block">Email</small>
                                            <span>{{ $selectedCustomer->email }}</span>
                                        </div>
                                        @if($selectedCustomer->phone)
                                            <div class="mb-3">
                                                <small class="text-muted d-block">Phone</small>
                                                <span>{{ $selectedCustomer->phone }}</span>
                                            </div>
                                        @endif
                                        @if($selectedCustomer->mobile)
                                            <div class="mb-3">
                                                <small class="text-muted d-block">Mobile</small>
                                                <span>{{ $selectedCustomer->mobile }}</span>
                                            </div>
                                        @endif
                                        @if($selectedCustomer->website)
                                            <div class="mb-3">
                                                <small class="text-muted d-block">Website</small>
                                                <a href="{{ $selectedCustomer->website }}" target="_blank" class="text-primary">{{ $selectedCustomer->website }}</a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Address Information -->
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h6 class="mb-0"><i class="ri-map-pin-line me-2"></i>Address</h6>
                                    </div>
                                    <div class="card-body">
                                        @if($selectedCustomer->address)
                                            <div class="mb-2">{{ $selectedCustomer->address }}</div>
                                        @endif
                                        <div>
                                            @if($selectedCustomer->city){{ $selectedCustomer->city }}@endif
                                            @if($selectedCustomer->state), {{ $selectedCustomer->state }}@endif
                                            @if($selectedCustomer->postal_code) {{ $selectedCustomer->postal_code }}@endif
                                        </div>
                                        @if($selectedCustomer->country)
                                            <div class="mt-2">{{ $selectedCustomer->country }}</div>
                                        @endif
                                        @if(!$selectedCustomer->address && !$selectedCustomer->city && !$selectedCustomer->state)
                                            <span class="text-muted">No address information</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Business Information -->
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h6 class="mb-0"><i class="ri-briefcase-line me-2"></i>Business Information</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            @if($selectedCustomer->tax_id)
                                                <div class="col-md-4 mb-3">
                                                    <small class="text-muted d-block">Tax ID</small>
                                                    <span>{{ $selectedCustomer->tax_id }}</span>
                                                </div>
                                            @endif
                                            @if($selectedCustomer->payment_terms)
                                                <div class="col-md-4 mb-3">
                                                    <small class="text-muted d-block">Payment Terms</small>
                                                    <span>{{ $selectedCustomer->payment_terms }}</span>
                                                </div>
                                            @endif
                                            <div class="col-md-4 mb-3">
                                                <small class="text-muted d-block">Customer Type</small>
                                                <span>{{ ucfirst($selectedCustomer->customer_type) }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Notes -->
                            @if($selectedCustomer->notes)
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h6 class="mb-0"><i class="ri-file-text-line me-2"></i>Notes</h6>
                                        </div>
                                        <div class="card-body">
                                            <p class="mb-0">{{ $selectedCustomer->notes }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <!-- Tags -->
                            @if($selectedCustomer->tags && count($selectedCustomer->tags) > 0)
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h6 class="mb-0"><i class="ri-price-tag-3-line me-2"></i>Tags</h6>
                                        </div>
                                        <div class="card-body">
                                            @foreach($selectedCustomer->tags as $tag)
                                                <span class="badge bg-label-primary me-1 mb-1">{{ $tag }}</span>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" wire:click.prevent="$set('selectedCustomerId', null)" class="btn btn-label-secondary">
                            <i class="ri-close-line me-1"></i>
                            Close
                        </button>
                        <button wire:click.prevent="edit({{ $selectedCustomer->id }})" type="button" class="btn btn-primary">
                            <i class="ri-edit-line me-1"></i>
                            Edit Customer
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
