<div class="pos-cart">
    <div class="d-flex align-items-center justify-content-between gap-2 mb-3">
        <div>
            <h6 class="mb-1">Cart</h6>
            <small class="text-muted">Review items before checkout</small>
        </div>
        @if($cart)
            <span class="badge bg-label-primary">{{ count($cart) }} items</span>
        @endif
    </div>

    @if($order)
        <div class="alert alert-success">
            <h6 class="mb-1">Order Complete</h6>
            <div class="small">Order #: <strong>{{ $order->id }}</strong></div>
            <div class="small">Total: <strong>Ksh {{ number_format($order->total_amount, 2) }}</strong></div>
        </div>
    @elseif(empty($cart))
        <div class="alert alert-info mb-0">Your cart is empty.</div>
    @else
        <div class="mb-3">
            <h6 class="mb-2">Customer</h6>
            @php
                $customer = $customerId ? \App\Models\Customer::find($customerId) : null;
            @endphp
            @if($customer)
                <div class="border rounded p-2 bg-light">
                    <div class="fw-semibold">{{ $customer->name }}</div>
                    <div class="small text-muted">{{ $customer->email }}</div>
                    <div class="small text-muted">{{ $customer->phone }}</div>
                </div>
            @else
                <div class="text-danger">No customer selected.</div>
            @endif
        </div>

        <div class="table-responsive mb-3">
            <table class="table table-sm table-borderless align-middle mb-0 table-stacked">
                <thead class="border-bottom">
                    <tr>
                        <th>Item</th>
                        <th class="text-end">Price</th>
                        <th class="text-center">Qty</th>
                        <th class="text-end">Subtotal</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cart as $item)
                        <tr>
                            <td data-label="Item" class="fw-semibold">{{ $item['name'] }}</td>
                            <td data-label="Price" class="text-end">Ksh {{ number_format($item['price'], 2) }}</td>
                            <td data-label="Qty" class="text-center">
                                <div class="btn-group btn-group-sm" role="group">
                                    <button class="btn btn-outline-secondary" wire:click="decrement({{ $item['id'] }})">-</button>
                                    <span class="btn btn-outline-secondary disabled" style="min-width: 30px;">{{ $item['quantity'] }}</span>
                                    <button class="btn btn-outline-secondary" wire:click="increment({{ $item['id'] }})">+</button>
                                </div>
                            </td>
                            <td data-label="Subtotal" class="text-end">Ksh {{ number_format($item['price'] * $item['quantity'], 2) }}</td>
                            <td data-label="Actions" class="text-end">
                                <button class="btn btn-link text-danger p-0" wire:click="removeFromCart({{ $item['id'] }})"><i class="ri-delete-bin-line"></i></button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-between align-items-center border-top pt-3 mb-3">
            <span class="fw-semibold">Total</span>
            <span class="h5 mb-0 text-success">Ksh {{ number_format($total, 2) }}</span>
        </div>

        @if($customerId)
            <form method="POST" action="{{ route('pesapal.pay') }}" autocomplete="off" class="d-grid gap-2">
                @csrf
                <input type="hidden" name="amount" value="{{ $total }}">
                <input type="hidden" name="customer_id" value="{{ $customerId }}">
                @if($customer)
                    <input type="hidden" name="customer_name" value="{{ $customer->name }}">
                    <input type="hidden" name="customer_email" value="{{ $customer->email }}">
                    <input type="hidden" name="customer_phone" value="{{ $customer->phone }}">
                @endif
                <button type="submit" class="btn btn-success">Checkout with Pesapal</button>
            </form>
        @else
            <div class="text-danger">Select a customer to checkout</div>
        @endif
    @endif
</div>
