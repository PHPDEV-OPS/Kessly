<div class="pos-products">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-3">
        <div>
            <h5 class="mb-1">Products</h5>
            <small class="text-muted">Browse and add items to the cart</small>
        </div>
        <div class="d-flex flex-wrap gap-2">
            <div class="input-group input-group-sm" style="min-width: 220px;">
                <span class="input-group-text bg-transparent border-end-0"><i class="ri-search-line"></i></span>
                <input type="search" class="form-control border-start-0" placeholder="Search products" wire:model.debounce.300ms="search">
            </div>
        </div>
    </div>

    @if($categories->count())
        <div class="d-flex flex-wrap gap-2 mb-3">
            <button class="btn btn-sm {{ $categoryId ? 'btn-outline-secondary' : 'btn-primary' }}" wire:click="$set('categoryId', null)">All</button>
            @foreach($categories as $category)
                <button class="btn btn-sm {{ $categoryId === $category->id ? 'btn-primary' : 'btn-outline-secondary' }}" wire:click="$set('categoryId', {{ $category->id }})">{{ $category->name }}</button>
            @endforeach
        </div>
    @endif

    <div class="row g-3">
        @forelse($products as $product)
            <div class="col-12 col-sm-6 col-lg-4 col-xxl-3">
                <div class="card h-100 shadow-sm product-tile">
                    <div class="card-body d-flex flex-column gap-2">
                        <div class="d-flex justify-content-between align-items-start gap-2">
                            <h6 class="mb-0">{{ $product->name }}</h6>
                            @if(isset($cart[$product->id]))
                                <span class="badge bg-success">{{ $cart[$product->id]['quantity'] }} in cart</span>
                            @endif
                        </div>
                        <div class="text-muted small">{{ $product->category?->name ?? 'Uncategorized' }}</div>
                        <div class="fw-semibold h5 mb-0">Ksh {{ number_format($product->price, 2) }}</div>
                        <div class="d-flex justify-content-between align-items-center mt-auto">
                            <small class="text-muted">Stock: {{ $product->stock ?? 0 }}</small>
                            <button class="btn btn-sm btn-primary" wire:click="addToCart({{ $product->id }})">
                                <i class="ri-add-line me-1"></i>Add
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info mb-0">No products found.</div>
            </div>
        @endforelse
    </div>
</div>
