<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;

new #[Layout('layouts.app')] class extends Component {
    public string $activeTab = 'company';

    public function setActiveTab(string $tab): void
    {
        $this->activeTab = $tab;
    }
}; ?>

<div>
    <!-- Enhanced Header with Gradient -->
    <div class="card mb-4 border-0 shadow-sm">
        <div class="card-body p-0">
            <!-- Gradient Header -->
            <div class="p-3 p-md-4 bg-gradient-primary text-white rounded-top" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
                    <div>
                        <h4 class="mb-1 fw-bold text-white">
                            <i class='bx bx-cog me-2'></i>Settings
                        </h4>
                        <p class="mb-0 text-white opacity-90 small d-none d-sm-block">Configure your system preferences and company information</p>
                    </div>
                    <div>
                        <div class="badge bg-white text-primary px-2 px-md-3 py-2">
                            <i class='bx bx-time-five me-1'></i>
                            <span class="d-none d-sm-inline">Last Updated: </span>{{ now()->format('M d, Y') }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab Navigation -->
            <div class="border-bottom overflow-auto">
                <ul class="nav nav-pills px-3 px-md-4 pt-3 flex-nowrap" style="gap: 0.5rem;">
                    <li class="nav-item">
                        <button wire:click="setActiveTab('company')" 
                            class="nav-link {{ $activeTab === 'company' ? 'active' : '' }} text-nowrap"
                            style="{{ $activeTab === 'company' ? 'background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);' : '' }}">
                            <i class='bx bx-buildings me-1'></i>
                            <span class="d-none d-md-inline">Company </span>Profile
                        </button>
                    </li>
                    <li class="nav-item">
                        <button wire:click="setActiveTab('system')" 
                            class="nav-link {{ $activeTab === 'system' ? 'active' : '' }} text-nowrap"
                            style="{{ $activeTab === 'system' ? 'background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);' : '' }}">
                            <i class='bx bx-cog me-1'></i>
                            <span class="d-none d-md-inline">System </span>Config
                        </button>
                    </li>
                    <li class="nav-item">
                        <button wire:click="setActiveTab('users')" 
                            class="nav-link {{ $activeTab === 'users' ? 'active' : '' }} text-nowrap"
                            style="{{ $activeTab === 'users' ? 'background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);' : '' }}">
                            <i class='bx bx-user me-1'></i>
                            <span class="d-none d-md-inline">Users & </span>Roles
                        </button>
                    </li>
                    <li class="nav-item">
                        <button wire:click="setActiveTab('security')" 
                            class="nav-link {{ $activeTab === 'security' ? 'active' : '' }} text-nowrap"
                            style="{{ $activeTab === 'security' ? 'background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);' : '' }}">
                            <i class='bx bx-shield me-1'></i>
                            Security
                        </button>
                    </li>
                    <li class="nav-item">
                        <button wire:click="setActiveTab('email')" 
                            class="nav-link {{ $activeTab === 'email' ? 'active' : '' }} text-nowrap"
                            style="{{ $activeTab === 'email' ? 'background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);' : '' }}">
                            <i class='bx bx-envelope me-1'></i>
                            <span class="d-none d-lg-inline">Email & </span>Notifications
                        </button>
                    </li>
                    <li class="nav-item">
                        <button wire:click="setActiveTab('business')" 
                            class="nav-link {{ $activeTab === 'business' ? 'active' : '' }} text-nowrap"
                            style="{{ $activeTab === 'business' ? 'background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);' : '' }}">
                            <i class='bx bx-briefcase me-1'></i>
                            <span class="d-none d-lg-inline">Business </span>Rules
                        </button>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Tab Content -->
    <div class="tab-content">
        <!-- Company Profile Tab -->
        <div class="tab-pane fade {{ $activeTab === 'company' ? 'show active' : '' }}">
            @if($activeTab === 'company')
                <livewire:settings.company-profile />
            @endif
        </div>

        <!-- System Configuration Tab -->
        <div class="tab-pane fade {{ $activeTab === 'system' ? 'show active' : '' }}">
            @if($activeTab === 'system')
                <livewire:settings.system-configuration />
            @endif
        </div>

        <!-- Users & Roles Tab -->
        <div class="tab-pane fade {{ $activeTab === 'users' ? 'show active' : '' }}">
            @if($activeTab === 'users')
                <livewire:settings.users />
            @endif
        </div>

        <!-- Security Tab -->
        <div class="tab-pane fade {{ $activeTab === 'security' ? 'show active' : '' }}">
            @if($activeTab === 'security')
                <livewire:settings.security-settings />
            @endif
        </div>

        <!-- Email & Notifications Tab -->
        <div class="tab-pane fade {{ $activeTab === 'email' ? 'show active' : '' }}">
            @if($activeTab === 'email')
                <livewire:settings.email-notifications />
            @endif
        </div>

        <!-- Business Rules Tab -->
        <div class="tab-pane fade {{ $activeTab === 'business' ? 'show active' : '' }}">
            @if($activeTab === 'business')
                <livewire:settings.business-rules />
            @endif
        </div>
    </div>
</div>
