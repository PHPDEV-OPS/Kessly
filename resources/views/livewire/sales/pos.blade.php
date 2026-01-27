
<div class="row" style="margin-top: 2rem;">
    <div class="col-md-8">
        <div class="card mb-3">
            <div class="card-header bg-primary text-white">Products</div>
            <div class="card-body">
                <div class="row g-3">
                    @foreach($products as $product)
                        <div class="col-6 col-md-4 col-lg-3 mb-3">
                            <div class="card h-100 border shadow-sm">
                                <div class="card-body p-2 d-flex flex-column align-items-center justify-content-between">
                                    <h6 class="mb-1 text-center">{{ $product->name }}</h6>
                                    <div class="mb-2 text-muted">${{ number_format($product->price, 2) }}</div>
                                    <button type="button" class="btn btn-sm btn-primary w-100 mt-auto" wire:click="addToCart({{ $product->id }})">Add</button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card mb-3">
            <div class="card-header bg-secondary text-white">Customer Details</div>
            <div class="card-body">
                <form method="POST" action="{{ route('pesapal.pay') }}" autocomplete="off">
                    @csrf
                    <div class="mb-3">
                        <label for="customer_name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="customer_name" name="customer_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="customer_email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="customer_email" name="customer_email" required>
                    </div>
                    <div class="mb-3">
                        <label for="customer_phone" class="form-label">Phone</label>
                        <input type="text" class="form-control" id="customer_phone" name="customer_phone" required>
                    </div>
                    <div class="card mb-3">
                        <div class="card-header">Cart</div>
                        <div class="card-body">
                            @if(count($cart))
                                <ul class="list-group mb-3">
                                    @foreach($cart as $item)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span>{{ $item['name'] }} x{{ $item['qty'] }}</span>
                                            <span>${{ number_format($item['price'] * $item['qty'], 2) }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                                <div class="mb-3">
                                    <strong>Total: ${{ number_format($total, 2) }}</strong>
                                </div>
                                <input type="hidden" name="amount" value="{{ $total }}">
                                <button type="submit" class="btn btn-success w-100">Checkout with Pesapal</button>
                            @else
                                <div class="text-muted">Cart is empty.</div>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>
        @if(session('error'))
            <div class="alert alert-danger mt-2">{{ session('error') }}</div>
        @endif
    </div>
</div>
