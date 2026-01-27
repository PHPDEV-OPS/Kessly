<div>
    <h5 class="mb-3">Select Customer</h5>
    <input type="text" class="form-control mb-3" placeholder="Search customer by name..." wire:model.debounce.300ms="search">
    <div class="list-group mb-3">
        @forelse($customers as $customer)
            <button class="list-group-item list-group-item-action @if($selectedCustomer && $selectedCustomer->id === $customer->id) active @endif" wire:click="selectCustomer({{ $customer->id }})">
                {{ $customer->name }}
                <span class="text-muted small">{{ $customer->email }}</span>
            </button>
        @empty
            <div class="list-group-item">No customers found.</div>
        @endforelse
    </div>
    @if($selectedCustomer)
        <div class="alert alert-success">
            Selected: <strong>{{ $selectedCustomer->name }}</strong>
        </div>
    @endif
</div>
