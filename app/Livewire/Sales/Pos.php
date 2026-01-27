<?php

namespace App\Livewire\Sales;

use Livewire\Component;
use App\Models\Product;

class Pos extends Component
{
    public $cart = [];
    public $products;
    public $total = 0;

    public function mount()
    {
        $this->products = Product::all();
    }

    public function addToCart($productId)
    {
        $product = Product::find($productId);
        if ($product) {
            $this->cart[$productId] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'qty' => ($this->cart[$productId]['qty'] ?? 0) + 1,
            ];
            $this->updateTotal();
        }
    }

    public function removeFromCart($productId)
    {
        unset($this->cart[$productId]);
        $this->updateTotal();
    }

    public function updateTotal()
    {
        $this->total = collect($this->cart)->sum(function($item) {
            return $item['price'] * $item['qty'];
        });
    }


    public function render()
    {
        return view('livewire.sales.pos');
    }
}
