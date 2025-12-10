<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;

new #[Layout('layouts.app')] class extends Component {
    public string $activeTab = 'products';

    public function setActiveTab(string $tab): void
    {
        $this->activeTab = $tab;
    }
}; ?>

<div>
    <!-- Tab Navigation Card -->
    <div class="card mb-4">
        <div class="card-header border-bottom">
            <ul class="nav nav-tabs card-header-tabs" role="tablist">
                <li class="nav-item">
                    <button 
                        wire:click="setActiveTab('products')"
                        class="nav-link {{ $activeTab === 'products' ? 'active' : '' }}"
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
                        wire:click="setActiveTab('categories')"
                        class="nav-link {{ $activeTab === 'categories' ? 'active' : '' }}"
                        type="button"
                        role="tab">
                        <i class="ri-folder-line me-2"></i>
                        Categories
                        <span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-label-primary ms-1">
                            {{ \App\Models\Category::count() }}
                        </span>
                    </button>
                </li>
                <li class="nav-item">
                    <button 
                        wire:click="setActiveTab('suppliers')"
                        class="nav-link {{ $activeTab === 'suppliers' ? 'active' : '' }}"
                        type="button"
                        role="tab">
                        <i class="ri-truck-line me-2"></i>
                        Suppliers
                        <span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-label-primary ms-1">
                            {{ \App\Models\Supplier::count() }}
                        </span>
                    </button>
                </li>
            </ul>
        </div>

        <!-- Tab Content -->
        <div class="card-body p-0">
            <div class="tab-content">
                @if($activeTab === 'products')
                    <livewire:inventory.products :key="'products-'.now()->timestamp" />
                @elseif($activeTab === 'categories')
                    <livewire:inventory.categories :key="'categories-'.now()->timestamp" />
                @elseif($activeTab === 'suppliers')
                    <livewire:inventory.suppliers :key="'suppliers-'.now()->timestamp" />
                @endif
            </div>
        </div>
    </div>
</div>
