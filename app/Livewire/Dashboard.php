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
        $analyticsService = app(DashboardAnalyticsService::class);
        
        // Check if user is a branch manager and apply branch filter for cache clearing
        $user = auth()->user();
        if ($user && $user->hasRole(['Branch Manager', 'Sales Manager', 'HR Manager'])) {
            $branch = $user->getBranch();
            if ($branch) {
                $analyticsService->setBranch($branch->id);
            }
        }
        
        // Clear the cache and refresh
        $analyticsService->clearCache();
        $this->dispatch('analytics-refreshed');
    }

    public function render()
    {
        $analyticsService = app(DashboardAnalyticsService::class);
        
        // Check if user is a branch manager and apply branch filter
        $user = auth()->user();
        if ($user && $user->hasRole(['Branch Manager', 'Sales Manager', 'HR Manager'])) {
            $branch = $user->getBranch();
            if ($branch) {
                $analyticsService->setBranch($branch->id);
            }
        }
        
        $analytics = $analyticsService->getAnalytics();
        
        return view('livewire.dashboard', compact('analytics'));
    }
}
