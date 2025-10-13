<?php

namespace App\Livewire;

use App\Services\DashboardAnalyticsService;
use Livewire\Component;

class Dashboard extends Component
{
    private DashboardAnalyticsService $analyticsService;

    public function boot()
    {
        $this->analyticsService = app(DashboardAnalyticsService::class);
    }
    
    public function refreshAnalytics()
    {
        // Clear the cache and refresh
        $this->analyticsService->clearCache();
        $this->dispatch('analytics-refreshed');
    }

    public function mount()
    {
        // Clear cache on mount to ensure fresh data
        $this->analyticsService->clearCache();
    }

    public function render()
    {
        $analytics = $this->analyticsService->getAnalytics();
        
        return view('livewire.dashboard', compact('analytics'));
    }
}
