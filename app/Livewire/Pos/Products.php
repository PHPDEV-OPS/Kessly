<?php

namespace App\Livewire\Pos;

use Livewire\Component;
use App\Models\Product;
use App\Models\Category;

class Products extends Component
{
    public $cart = [];
    public $search = '';
    public $categoryId = null;

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
        $products = Product::query()
            ->with('category')
            ->when($this->search, fn($q) => $q->where('name', 'like', "%{$this->search}%"))
            ->when($this->categoryId, fn($q) => $q->where('category_id', $this->categoryId))
            ->orderBy('name')
            ->get();

        $categories = Category::orderBy('name')->get();

        return view('livewire.pos.products', compact('products', 'categories'));
    }
}
