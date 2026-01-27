<div>
    <h5 class="mb-3">Cart</h5>
    @if($order)
        <div class="alert alert-success">
            <h6>Order Complete!</h6>
            <div>Order #: <strong>{{ $order->id }}</strong></div>
            <div>Total: <strong>Ksh {{ number_format($order->total_amount, 2) }}</strong></div>
        </div>
    @elseif(empty($cart))
        <div class="alert alert-info">Your cart is empty.</div>
    @else
        <div class="mb-3">
            <h6>Customer Details</h6>
            @php
                $customer = $customerId ? \App\Models\Customer::find($customerId) : null;
            @endphp
            @if($customer)
                <div class="border rounded p-2 mb-2">
                    <div><strong>Name:</strong> {{ $customer->name }}</div>
                    <div><strong>Email:</strong> {{ $customer->email }}</div>
                    <div><strong>Phone:</strong> {{ $customer->phone }}</div>
                </div>
            @else
                <div class="text-danger">No customer selected.</div>
            @endif
        </div>
        <table class="table table-bordered align-middle">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Qty</th>
                    <th>Subtotal</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($cart as $item)
                    <tr>
                        <td>{{ $item['name'] }}</td>
                        <td>Ksh {{ number_format($item['price'], 2) }}</td>
                        <td>
                            <button class="btn btn-sm btn-light" wire:click="decrement({{ $item['id'] }})">-</button>
                            <span class="mx-2">{{ $item['quantity'] }}</span>
                            <button class="btn btn-sm btn-light" wire:click="increment({{ $item['id'] }})">+</button>
                        </td>
                        <td>Ksh {{ number_format($item['price'] * $item['quantity'], 2) }}</td>
                        <td>
                            <button class="btn btn-danger btn-sm" wire:click="removeFromCart({{ $item['id'] }})">Remove</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h6>Total: <span class="text-success">Ksh {{ number_format($total, 2) }}</span></h6>
        </div>
        @if($customerId)
            <form method="POST" action="{{ route('pesapal.pay') }}" autocomplete="off">
                @csrf
                <input type="hidden" name="amount" value="{{ $total }}">
                <input type="hidden" name="customer_id" value="{{ $customerId }}">
                <button type="submit" class="btn btn-success w-100">Checkout with Pesapal</button>
            </form>
        @else
            <span class="text-danger">Select a customer to checkout</span>
        @endif
    @endif
</div>
