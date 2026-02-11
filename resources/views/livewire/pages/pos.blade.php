<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;

new #[Layout('layouts.app')] class extends Component {};
?>

<div class="pos-page">
    <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
        <div>
            <h4 class="mb-1">Point of Sale</h4>
            <small class="text-muted">Process orders, add items, and checkout customers</small>
        </div>
        <div class="d-flex flex-wrap gap-2">
            <span class="badge bg-label-primary">Customers: {{ \App\Models\Customer::count() }}</span>
            <span class="badge bg-label-primary">Products: {{ \App\Models\Product::count() }}</span>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card h-100">
                <div class="card-body">
                    <livewire:pos.products />
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="position-sticky" style="top: 88px;">
                <div class="card mb-3">
                    <div class="card-body">
                        <livewire:pos.customers />
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <livewire:pos.cart />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
