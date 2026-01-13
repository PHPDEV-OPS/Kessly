<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;

new #[Layout('layouts.app')] class extends Component {
    public string $activeTab = 'branches';

    public function setActiveTab(string $tab): void
    {
        $this->activeTab = $tab;
    }
}; ?>

<div>
    <!-- Statistics Cards -->
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar me-3">
                            <span class="avatar-initial rounded-circle bg-label-primary">
                                <i class="ri-store-line ri-22px"></i>
                            </span>
                        </div>
                        <div>
                            <div class="text-muted small">Total Branches</div>
                            <h5 class="mb-0">{{ \App\Models\Branch::count() }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar me-3">
                            <span class="avatar-initial rounded-circle bg-label-success">
                                <i class="ri-checkbox-circle-line ri-22px"></i>
                            </span>
                        </div>
                        <div>
                            <div class="text-muted small">Active Branches</div>
                            <h5 class="mb-0 text-success">{{ \App\Models\Branch::where('status', 'active')->count() }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar me-3">
                            <span class="avatar-initial rounded-circle bg-label-info">
                                <i class="ri-team-line ri-22px"></i>
                            </span>
                        </div>
                        <div>
                            <div class="text-muted small">Total Employees</div>
                            <h5 class="mb-0">{{ \App\Models\Employee::count() }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar me-3">
                            <span class="avatar-initial rounded-circle bg-label-warning">
                                <i class="ri-box-3-line ri-22px"></i>
                            </span>
                        </div>
                        <div>
                            <div class="text-muted small">Total Inventory</div>
                            <h5 class="mb-0">{{ \App\Models\BranchInventory::sum('quantity') }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="card">
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
                <button wire:click.prevent="setActiveTab('branches')" 
                        class="nav-link {{ $activeTab === 'branches' ? 'active' : '' }}" 
                        type="button">
                    <i class="ri-store-line me-2"></i>
                    Branches
                </button>
            </li>
            <li class="nav-item">
                <button wire:click.prevent="setActiveTab('inventory')" 
                        class="nav-link {{ $activeTab === 'inventory' ? 'active' : '' }}" 
                        type="button">
                    <i class="ri-box-3-line me-2"></i>
                    Branch Inventory
                </button>
            </li>
        </ul>

        <div class="card-body">
            @if($activeTab === 'branches')
                <livewire:branches.branch-management />
            @elseif($activeTab === 'inventory')
                <livewire:branches.branch-inventory-management />
            @endif
        </div>
    </div>
</div>
