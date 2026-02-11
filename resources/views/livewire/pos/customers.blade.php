<div class="pos-customers">
    <div class="d-flex align-items-center justify-content-between gap-2 mb-3">
        <div>
            <h6 class="mb-1">Customer</h6>
            <small class="text-muted">Search and pick a customer for the order</small>
        </div>
    </div>

    <div class="input-group input-group-sm mb-3">
        <span class="input-group-text bg-transparent border-end-0"><i class="ri-search-line"></i></span>
        <input type="text" class="form-control border-start-0" placeholder="Search by name" wire:model.debounce.300ms="search">
    </div>

    <div class="list-group mb-3" style="max-height: 320px; overflow-y: auto;">
        @forelse($customers as $customer)
            <button class="list-group-item list-group-item-action d-flex justify-content-between align-items-start {{ $selectedCustomer && $selectedCustomer->id === $customer->id ? 'active' : '' }}" wire:click="selectCustomer({{ $customer->id }})">
                <div class="me-2">
                    <div class="fw-semibold">{{ $customer->name }}</div>
                    <div class="text-muted small">{{ $customer->email }}</div>
                </div>
                <span class="badge bg-label-primary">Select</span>
            </button>
        @empty
            <div class="list-group-item">No customers found.</div>
        @endforelse
    </div>

    @if($selectedCustomer)
        <div class="alert alert-success mb-0">
            <div class="fw-semibold">{{ $selectedCustomer->name }}</div>
            <div class="small mb-1">{{ $selectedCustomer->email }}</div>
            <div class="small">{{ $selectedCustomer->phone }}</div>
        </div>
    @endif
</div>
