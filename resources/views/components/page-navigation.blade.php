@props([
    'title' => 'Page Title',
    'description' => '',
    'showBack' => true,
    'breadcrumbs' => []
])

<div class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 sticky top-0 z-40">
    <div class="px-4 sm:px-6 lg:px-8 py-4">
        <div class="flex items-center justify-between">
            <!-- Left Section: Navigation & Title -->
            <div class="flex items-center space-x-4">
                @if($showBack)
                    <!-- Back Button -->
                    <button 
                        onclick="window.history.back()" 
                        class="inline-flex items-center justify-center w-10 h-10 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-full transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                        title="Go back"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </button>
                @endif

                <!-- Title Section -->
                <div class="flex flex-col">
                    @if(count($breadcrumbs) > 0)
                        <!-- Breadcrumbs -->
                        <nav class="flex items-center space-x-2 text-sm text-gray-500 dark:text-gray-400 mb-1">
                            <a href="{{ route('dashboard') }}" wire:navigate class="hover:text-gray-700 dark:hover:text-gray-200 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5v4l2-2 2 2V5"/>
                                </svg>
                            </a>
                            @foreach($breadcrumbs as $breadcrumb)
                                <svg class="w-4 h-4 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                                @if(isset($breadcrumb['url']))
                                    <a href="{{ $breadcrumb['url'] }}" wire:navigate class="hover:text-gray-700 dark:hover:text-gray-200 transition-colors">
                                        {{ $breadcrumb['title'] }}
                                    </a>
                                @else
                                    <span class="text-gray-700 dark:text-gray-300 font-medium">{{ $breadcrumb['title'] }}</span>
                                @endif
                            @endforeach
                        </nav>
                    @endif

                    <!-- Page Title -->
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-gray-100">
                        {{ $title }}
                    </h1>
                    
                    @if($description)
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ $description }}</p>
                    @endif
                </div>
            </div>

            <!-- Right Section: Actions -->
            <div class="flex items-center space-x-4">
                <!-- Sidebar Toggle for Mobile -->
                <flux:sidebar.toggle class="lg:hidden text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg p-2 transition-colors" icon="bars-3" />
                
                <!-- Desktop App Navigation Buttons -->
                <div class="hidden sm:flex items-center space-x-2">
                    <!-- Forward/Back Browser-style buttons -->
                    <button 
                        onclick="window.history.back()" 
                        class="inline-flex items-center justify-center w-8 h-8 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md transition-colors duration-200"
                        title="Go back"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </button>
                    <button 
                        onclick="window.history.forward()" 
                        class="inline-flex items-center justify-center w-8 h-8 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md transition-colors duration-200"
                        title="Go forward"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </button>
                    <button 
                        onclick="window.location.reload()" 
                        class="inline-flex items-center justify-center w-8 h-8 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md transition-colors duration-200"
                        title="Refresh page"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                    </button>
                </div>

                <!-- Quick Actions Slot -->
                {{ $slot ?? '' }}
            </div>
        </div>
    </div>
</div>