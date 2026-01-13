<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;

new #[Layout('layouts.app')] class extends Component {
    public string $activeTab = 'business';

    public function setActiveTab(string $tab): void
    {
        $this->activeTab = $tab;
        $this->dispatch('tab-changed', tab: $tab);
    }
}; ?>

<div>
    <!-- Enhanced Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-gradient-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="text-white fw-bold mb-2">
                                <i class='bx bx-line-chart me-2'></i>Analytics Dashboard
                            </h4>
                            <p class="text-white-50 mb-0">
                                Comprehensive business insights and performance metrics
                            </p>
                        </div>
                        <div class="text-end">
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    <small class="text-white-50 d-block">Last Updated</small>
                                    <span class="text-white fw-semibold" id="lastUpdatedTime"></span>
                                </div>
                                <button class="btn btn-light btn-sm" wire:click="$refresh" onclick="updateTime()">
                                    <i class='bx bx-refresh'></i> Refresh
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tab Navigation with Modern Design -->
    <div class="card mb-4">
        <div class="card-body p-0">
            <nav class="nav nav-pills nav-justified" role="tablist">
                <button wire:click="setActiveTab('business')" type="button"
                    class="nav-link {{ $activeTab === 'business' ? 'active' : '' }} rounded-0 border-0 d-flex align-items-center justify-content-center py-3">
                    <div class="text-center">
                        <i class='bx bx-bar-chart-alt-2 fs-4 d-block mb-1'></i>
                        <span class="d-none d-sm-inline">Business Analytics</span>
                        <span class="d-inline d-sm-none">Business</span>
                    </div>
                </button>

                <button wire:click="setActiveTab('performance')" type="button"
                    class="nav-link {{ $activeTab === 'performance' ? 'active' : '' }} rounded-0 border-0 d-flex align-items-center justify-content-center py-3">
                    <div class="text-center">
                        <i class='bx bx-trending-up fs-4 d-block mb-1'></i>
                        <span class="d-none d-sm-inline">Performance Metrics</span>
                        <span class="d-inline d-sm-none">Performance</span>
                    </div>
                </button>

                <button wire:click="setActiveTab('reports')" type="button"
                    class="nav-link {{ $activeTab === 'reports' ? 'active' : '' }} rounded-0 border-0 d-flex align-items-center justify-content-center py-3">
                    <div class="text-center">
                        <i class='bx bx-file-blank fs-4 d-block mb-1'></i>
                        <span class="d-none d-sm-inline">Custom Reports</span>
                        <span class="d-inline d-sm-none">Reports</span>
                    </div>
                </button>
            </nav>
        </div>
    </div>

    <!-- Tab Content with Transitions -->
    <div class="tab-content">
        <div class="tab-pane fade {{ $activeTab === 'business' ? 'show active' : '' }}">
            @if($activeTab === 'business')
                <livewire:analytics.business-analytics :key="'business-'.now()" />
            @endif
        </div>

        <div class="tab-pane fade {{ $activeTab === 'performance' ? 'show active' : '' }}">
            @if($activeTab === 'performance')
                <div class="card">
                    <div class="card-body text-center py-5">
                        <div class="mb-3">
                            <i class='bx bx-trending-up display-1 text-primary'></i>
                        </div>
                        <h4 class="mb-2">Performance Metrics</h4>
                        <p class="text-muted mb-4">
                            Track detailed performance KPIs, conversion rates, and efficiency metrics across your business operations.
                        </p>
                        <div class="row g-3 text-start">
                            <div class="col-md-4">
                                <div class="card bg-label-primary">
                                    <div class="card-body">
                                        <h5 class="card-title">
                                            <i class='bx bx-time-five me-2'></i>Coming Soon
                                        </h5>
                                        <p class="card-text small mb-0">Response Time Analytics</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card bg-label-success">
                                    <div class="card-body">
                                        <h5 class="card-title">
                                            <i class='bx bx-target-lock me-2'></i>Coming Soon
                                        </h5>
                                        <p class="card-text small mb-0">Conversion Rate Tracking</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card bg-label-info">
                                    <div class="card-body">
                                        <h5 class="card-title">
                                            <i class='bx bx-stopwatch me-2'></i>Coming Soon
                                        </h5>
                                        <p class="card-text small mb-0">Efficiency Metrics</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <div class="tab-pane fade {{ $activeTab === 'reports' ? 'show active' : '' }}">
            @if($activeTab === 'reports')
                <div class="card">
                    <div class="card-body text-center py-5">
                        <div class="mb-3">
                            <i class='bx bx-file-blank display-1 text-info'></i>
                        </div>
                        <h4 class="mb-2">Custom Reports</h4>
                        <p class="text-muted mb-4">
                            Generate custom reports tailored to your specific business needs. Export data in multiple formats.
                        </p>
                        <div class="row g-3 text-start">
                            <div class="col-md-3">
                                <div class="card bg-label-primary">
                                    <div class="card-body text-center">
                                        <i class='bx bx-download fs-1 mb-2'></i>
                                        <h6>Excel Export</h6>
                                        <small>Download as .xlsx</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-label-danger">
                                    <div class="card-body text-center">
                                        <i class='bx bxs-file-pdf fs-1 mb-2'></i>
                                        <h6>PDF Reports</h6>
                                        <small>Generate PDFs</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-label-success">
                                    <div class="card-body text-center">
                                        <i class='bx bx-calendar fs-1 mb-2'></i>
                                        <h6>Scheduled Reports</h6>
                                        <small>Auto-generate</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-label-warning">
                                    <div class="card-body text-center">
                                        <i class='bx bx-customize fs-1 mb-2'></i>
                                        <h6>Custom Fields</h6>
                                        <small>Build your own</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Inline Styles -->
    <style>
        .bg-gradient-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .nav-pills .nav-link {
            transition: all 0.3s ease;
        }
        
        .nav-pills .nav-link:hover:not(.active) {
            background-color: rgba(0,0,0,0.05);
        }
        
        .nav-pills .nav-link.active {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white !important;
        }
        
        .tab-pane {
            animation: fadeIn 0.5s ease-in;
        }
        
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .card-border-shadow-primary {
            border-top: 3px solid #696cff;
            box-shadow: 0 0.125rem 0.25rem rgba(105, 108, 255, 0.4) !important;
        }
        
        .card-border-shadow-success {
            border-top: 3px solid #71dd37;
            box-shadow: 0 0.125rem 0.25rem rgba(113, 221, 55, 0.4) !important;
        }
        
        .card-border-shadow-warning {
            border-top: 3px solid #ffab00;
            box-shadow: 0 0.125rem 0.25rem rgba(255, 171, 0, 0.4) !important;
        }
        
        .card-border-shadow-info {
            border-top: 3px solid #03c3ec;
            box-shadow: 0 0.125rem 0.25rem rgba(3, 195, 236, 0.4) !important;
        }
    </style>

    <script>
        // Update time display
        function updateTime() {
            const timeElement = document.getElementById('lastUpdatedTime');
            if (timeElement) {
                timeElement.textContent = new Date().toLocaleTimeString();
            }
        }
        
        // Initialize time on page load
        document.addEventListener('DOMContentLoaded', updateTime);
        
        // Update time when Livewire updates
        document.addEventListener('livewire:init', () => {
            Livewire.hook('commit', () => {
                updateTime();
            });
        });
    </script>
</div>
