<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;

new #[Layout('layouts.app')] class extends Component {
    public string $activeTab = 'customers';

    public function setActiveTab(string $tab): void
    {
        $this->activeTab = $tab;
    }
}; ?>

<div>
    <!-- Tab Navigation Card for POS -->
    <div class="card mb-4">
        <div class="card-header border-bottom">
            <ul class="nav nav-tabs card-header-tabs" role="tablist">
                <li class="nav-item">
                    <button 
                        wire:click="setActiveTab('customers')"
                        class="nav-link {{ $activeTab === 'customers' ? 'active' : '' }}"
                        type="button"
                        role="tab">
                        <i class="ri-user-line me-2"></i>
                        Customer
                        <span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-label-primary ms-1">
                            {{ \App\Models\Customer::count() }}
                        </span>
                    </button>
                </li>
                <li class="nav-item">
                    <button 
                        wire:click="setActiveTab('pos-products')"
                        class="nav-link {{ $activeTab === 'pos-products' ? 'active' : '' }}"
                        type="button"
                        role="tab">
                        <i class="ri-stack-line me-2"></i>
                        Products
                        <span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-label-primary ms-1">
                            {{ \App\Models\Product::count() }}
                        </span>
                    </button>
                </li>
                <li class="nav-item">
                    <button 
                        wire:click="setActiveTab('cart')"
                        class="nav-link {{ $activeTab === 'cart' ? 'active' : '' }}"
                        type="button"
                        role="tab">
                        <i class="ri-shopping-cart-line me-2"></i>
                        Cart
                        <span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-label-primary ms-1">
                            {{ is_array($cart ?? null) ? count($cart) : 0 }}
                        </span>
                    </button>
                </li>
            </ul>
        </div>

        <!-- Tab Content -->
        <div class="card-body p-0">
            <div class="tab-content">
                @if($activeTab === 'customers')
                    <!-- POS Customer Selection -->
                    <livewire:pos.customers />
                @elseif($activeTab === 'pos-products')
                    <!-- POS Product Grid or List -->
                    <livewire:pos.products />
                @elseif($activeTab === 'cart')
                    <!-- POS Cart View -->
                    <livewire:pos.cart />
                @endif
            </div>
        </div>
    </div>
</div>
