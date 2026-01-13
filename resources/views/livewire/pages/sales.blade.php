<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;

new #[Layout('layouts.app')] class extends Component {
    public string $activeTab = 'orders';

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
                        wire:click="setActiveTab('orders')"
                        class="nav-link {{ $activeTab === 'orders' ? 'active' : '' }}"
                        type="button"
                        role="tab">
                        <i class="ri-file-list-3-line me-2"></i>
                        Orders
                        <span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-label-primary ms-1">
                            {{ \App\Models\Order::count() }}
                        </span>
                    </button>
                </li>
                <li class="nav-item">
                    <button 
                        wire:click="setActiveTab('invoices')"
                        class="nav-link {{ $activeTab === 'invoices' ? 'active' : '' }}"
                        type="button"
                        role="tab">
                        <i class="ri-bill-line me-2"></i>
                        Invoices
                        <span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-label-primary ms-1">
                            {{ \App\Models\Invoice::count() }}
                        </span>
                    </button>
                </li>
                <li class="nav-item">
                    <button 
                        wire:click="setActiveTab('customers')"
                        class="nav-link {{ $activeTab === 'customers' ? 'active' : '' }}"
                        type="button"
                        role="tab">
                        <i class="ri-team-line me-2"></i>
                        Customers
                        <span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-label-primary ms-1">
                            {{ \App\Models\Customer::count() }}
                        </span>
                    </button>
                </li>
            </ul>
        </div>

        <!-- Tab Content -->
        <div class="card-body p-0">
            <div class="tab-content">
                @if($activeTab === 'orders')
                    <livewire:sales.orders />
                @elseif($activeTab === 'invoices')
                    <livewire:sales.invoices />
                @elseif($activeTab === 'customers')
                    <livewire:sales.customers />
                @endif
            </div>
        </div>
    </div>
</div>
