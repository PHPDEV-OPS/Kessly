<?php

namespace App\Livewire\Pos;

use Livewire\Component;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class Cart extends Component
{
    public $cart = [];
    public $customerId = null;
    public $order = null;

    protected $listeners = [
        'cartUpdated' => 'updateCart',
        'customerSelected' => 'setCustomer',
    ];

    public function mount()
    {
        $this->cart = session()->get('pos_cart', []);
        $this->customerId = session('pos_customer');
    }

    public function updateCart()
    {
        $this->cart = session()->get('pos_cart', []);
        $this->dispatch('refresh');
    }

    public function setCustomer()
    {
        $this->customerId = session('pos_customer');
    }

    public function removeFromCart($productId)
    {
        $cart = session()->get('pos_cart', []);
        unset($cart[$productId]);
        session(['pos_cart' => $cart]);
        $this->cart = $cart;
        $this->dispatch('cartUpdated');
    }

    public function increment($productId)
    {
        $cart = session()->get('pos_cart', []);
        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += 1;
            session(['pos_cart' => $cart]);
            $this->cart = $cart;
            $this->dispatch('cartUpdated');
        }
    }

    public function decrement($productId)
    {
        $cart = session()->get('pos_cart', []);
        if (isset($cart[$productId]) && $cart[$productId]['quantity'] > 1) {
            $cart[$productId]['quantity'] -= 1;
            session(['pos_cart' => $cart]);
            $this->cart = $cart;
            $this->dispatch('cartUpdated');
        }
    }

    public function checkout()
    {
        $cart = $this->cart;
        $customerId = $this->customerId;
        if (empty($cart) || !$customerId) {
            $this->dispatchBrowserEvent('notify', ['type' => 'error', 'message' => 'Select a customer and add products to cart.']);
            return;
        }
        DB::beginTransaction();
        try {
            $order = Order::create([
                'customer_id' => $customerId,
                'order_date' => now(),
                'total_amount' => collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']),
            ]);
            foreach ($cart as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['price'],
                    'total_price' => $item['price'] * $item['quantity'],
                ]);
            }
            DB::commit();
            session()->forget('pos_cart');
            $this->cart = [];
            $this->order = $order;
            $this->dispatch('orderCompleted', $order->id);
        } catch (\Exception $e) {
            DB::rollBack();
            $this->dispatchBrowserEvent('notify', ['type' => 'error', 'message' => 'Order failed: ' . $e->getMessage()]);
        }
    }

    public function render()
    {
        $cart = $this->cart;
        $total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);
        $customerId = $this->customerId;
        $order = $this->order;
        return view('livewire.pos.cart', compact('cart', 'total', 'customerId', 'order'));
    }
}
