<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;

new #[Layout('components.layouts.app')] class extends Component {
    public string $activeTab = 'profile';

    public function setActiveTab(string $tab): void
    {
        $this->activeTab = $tab;
    }
}; ?>

<div>
    <!-- Page Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Settings</h1>
            <p class="text-sm text-gray-600 dark:text-gray-400">Manage your account settings and preferences</p>
        </div>
    </div>

    <!-- Tab Navigation -->
    <div class="mt-3 bg-white dark:bg-gray-800 shadow-sm rounded-lg border border-gray-200 dark:border-gray-700">
        <div class="border-b border-gray-200 dark:border-gray-700">
            <nav class="flex space-x-8 px-6 overflow-x-auto" aria-label="Tabs">
                <button
                    wire:click="setActiveTab('profile')"
                    class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm {{ $activeTab === 'profile' ? 'border-blue-500 text-blue-600 dark:text-blue-400' : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300' }}"
                >
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Profile
                    </div>
                </button>

                <button
                    wire:click="setActiveTab('password')"
                    class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm {{ $activeTab === 'password' ? 'border-blue-500 text-blue-600 dark:text-blue-400' : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300' }}"
                >
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                        Password
                    </div>
                </button>

                <button
                    wire:click="setActiveTab('appearance')"
                    class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm {{ $activeTab === 'appearance' ? 'border-blue-500 text-blue-600 dark:text-blue-400' : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300' }}"
                >
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zM21 5a2 2 0 00-2-2h-4a2 2 0 00-2 2v12a4 4 0 004 4h4a2 2 0 002-2V5z"></path>
                        </svg>
                        Appearance
                    </div>
                </button>
            </nav>
        </div>

        <!-- Tab Content -->
        <div class="p-6">
            @if($activeTab === 'profile')
                <livewire:settings.profile />
            @elseif($activeTab === 'password')
                <livewire:settings.password />
            @elseif($activeTab === 'appearance')
                <livewire:settings.appearance />
            @endif
        </div>
    </div>
</div>