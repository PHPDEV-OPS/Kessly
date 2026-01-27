<?php

namespace App\Livewire\Pos;

use Livewire\Component;
use App\Models\Product;

class Products extends Component
{
    public $cart = [];

    protected $listeners = [
        'cartUpdated' => 'updateCart',
    ];

    public function addToCart($productId)
    {
        $product = Product::find($productId);
        if ($product) {
            $cart = session()->get('pos_cart', []);
            if (isset($cart[$productId])) {
                $cart[$productId]['quantity'] += 1;
            } else {
                $cart[$productId] = [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'quantity' => 1,
                ];
            }
            session(['pos_cart' => $cart]);
            $this->dispatch('cartUpdated');
        }
    }

    public function updateCart()
    {
        $this->cart = session()->get('pos_cart', []);
    }

    public function mount()
    {
        $this->cart = session()->get('pos_cart', []);
    }

    public function render()
    {
        $products = Product::all();
        return view('livewire.pos.products', compact('products'));
    }
}
