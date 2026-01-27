<div>
    <h5 class="mb-3">Products</h5>
    <div class="row">
        @forelse($products as $product)
            <div class="col-md-3 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h6 class="card-title">{{ $product->name }}</h6>
                        <p class="card-text">Ksh {{ number_format($product->price, 2) }}</p>
                        <button class="btn btn-primary btn-sm" wire:click="addToCart({{ $product->id }})">
                            Add to Cart
                            @if(isset($cart[$product->id]))
                                <span class="badge bg-success ms-2">{{ $cart[$product->id]['quantity'] }}</span>
                            @endif
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info">No products found.</div>
            </div>
        @endforelse
    </div>
</div>
