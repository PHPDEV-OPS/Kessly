<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="fluxAppearance" :class="$store.flux.appearance">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
        <flux:sidebar sticky stashable class="w-64 border-e border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white shadow-xl sidebar-modern flex flex-col">
            <flux:sidebar.toggle class="lg:hidden text-gray-700 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg" icon="x-mark" />

            <!-- Logo/Brand Section -->
            <div class="px-4 py-4 sidebar-brand bg-blue-600 dark:bg-blue-700 border-b border-blue-500 dark:border-blue-600">
                <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 rtl:space-x-reverse" wire:navigate>
                    <div class="w-8 h-8 bg-white rounded-lg flex items-center justify-center shadow-lg">
                        <span class="text-blue-600 font-bold text-sm">K</span>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-lg font-bold text-white">Kessly</span>
                        <span class="text-xs text-blue-100">SCM System</span>
                    </div>
                </a>
            </div>

            <!-- Main Navigation - Scrollable Content -->
            <div class="flex-1 overflow-y-auto px-4 py-3">
                <flux:navlist variant="outline" class="space-y-2">
                    <!-- Business Management Section -->
                    <div class="mb-6">
                        <h6 class="section-header px-3 mb-3 text-gray-500 dark:text-gray-400">Business Management</h6>
                        <div class="space-y-1">
                            <flux:navlist.item
                                icon="home"
                                :href="route('dashboard')"
                                :current="request()->routeIs('dashboard')"
                                wire:navigate
                                class="nav-item-modern text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-800/50 rounded-lg transition-all duration-300 px-3 py-2"
                            >
                                Dashboard
                            </flux:navlist.item>

                            <flux:navlist.item
                                icon="archive-box"
                                :href="route('inventory')"
                                :current="request()->routeIs('inventory')"
                                wire:navigate
                                class="nav-item-modern text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-800/50 rounded-lg transition-all duration-300 px-3 py-2"
                            >
                                Inventory
                            </flux:navlist.item>

                            <flux:navlist.item
                                icon="shopping-cart"
                                :href="route('sales')"
                                :current="request()->routeIs('sales')"
                                wire:navigate
                                class="nav-item-modern text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-800/50 rounded-lg transition-all duration-300 px-3 py-2"
                            >
                                Sales
                            </flux:navlist.item>

                            <flux:navlist.item
                                icon="user-group"
                                :href="route('customers')"
                                :current="request()->routeIs('customers')"
                                wire:navigate
                                class="nav-item-modern text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-800/50 rounded-lg transition-all duration-300 px-3 py-2"
                            >
                                Customers
                            </flux:navlist.item>

                            <flux:navlist.item
                                icon="chart-bar"
                                :href="route('reports')"
                                :current="request()->routeIs('reports')"
                                wire:navigate
                                class="nav-item-modern text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-800/50 rounded-lg transition-all duration-300 px-3 py-2"
                            >
                                Reports
                            </flux:navlist.item>
                        </div>
                    </div>

                    <!-- HR & Operations Section -->
                    <div class="mb-6">
                        <h6 class="section-header px-3 mb-3 text-gray-500 dark:text-gray-400">HR & Operations</h6>
                        <div class="space-y-1">
                            <flux:navlist.item
                                icon="user-group"
                                :href="route('hr')"
                                :current="request()->routeIs('hr*')"
                                wire:navigate
                                class="nav-item-modern text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-800/50 rounded-lg transition-all duration-300 px-3 py-2"
                            >
                                Human Resources
                            </flux:navlist.item>

                            <flux:navlist.item
                                icon="building-office-2"
                                :href="route('branches')"
                                :current="request()->routeIs('branches*')"
                                wire:navigate
                                class="nav-item-modern text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-800/50 rounded-lg transition-all duration-300 px-3 py-2"
                            >
                                Branches
                            </flux:navlist.item>
                        </div>
                    </div>

                    <!-- Finance & Analytics Section -->
                    <div class="mb-6">
                        <h6 class="section-header px-3 mb-3 text-gray-500 dark:text-gray-400">Finance & Analytics</h6>
                        <div class="space-y-1">
                            <flux:navlist.item
                                icon="currency-dollar"
                                :href="route('finance')"
                                :current="request()->routeIs('finance*')"
                                wire:navigate
                                class="nav-item-modern text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-800/50 rounded-lg transition-all duration-300 px-3 py-2"
                            >
                                Finance
                            </flux:navlist.item>

                            <flux:navlist.item
                                icon="presentation-chart-line"
                                :href="route('analytics')"
                                :current="request()->routeIs('analytics*')"
                                wire:navigate
                                class="nav-item-modern text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-800/50 rounded-lg transition-all duration-300 px-3 py-2"
                            >
                                Analytics
                            </flux:navlist.item>
                        </div>
                    </div>

                    <!-- Settings Section -->
                    <div class="mb-6">
                        <h6 class="section-header px-3 mb-3 text-gray-500 dark:text-gray-400">Account</h6>
                        <div class="space-y-1">
                            <flux:navlist.item
                                icon="cog-6-tooth"
                                :href="route('settings')"
                                :current="request()->routeIs('settings')"
                                wire:navigate
                                class="nav-item-modern text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-800/50 rounded-lg transition-all duration-300 px-3 py-2"
                            >
                                Settings
                            </flux:navlist.item>
                        </div>
                    </div>
                </flux:navlist>
            </div>

            </div>

            <!-- User Profile Section -->
            <div class="bg-white dark:bg-gray-900 px-4 py-3 border-t border-gray-200 dark:border-gray-700 mt-auto">
                <div class="relative" x-data="{ open: false }">
                    <!-- Profile Button -->
                    <button 
                        @click="open = !open"
                        @click.away="open = false"
                        class="user-profile-card flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 cursor-pointer transition-all duration-300 bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 w-full text-left focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900"
                    >
                        <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center shadow-lg">
                            <span class="text-white font-semibold text-sm">{{ auth()->user()->initials() }}</span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 dark:text-white truncate">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ auth()->user()->email }}</p>
                        </div>
                        <svg 
                            class="w-4 h-4 text-gray-400 dark:text-gray-500 transition-transform duration-200"
                            :class="{ 'rotate-180': open }"
                            fill="none" 
                            stroke="currentColor" 
                            viewBox="0 0 24 24"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>

                    <!-- Dropdown Menu -->
                    <div 
                        x-show="open"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
                        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                        x-transition:leave-end="opacity-0 scale-95 -translate-y-2"
                        class="absolute bottom-full left-0 w-[220px] mb-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-xl z-50"
                        @click.away="open = false"
                    >
                        <!-- Profile Header -->
                        <div class="p-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 rounded-t-lg">
                            <div class="flex items-center space-x-3">
                                <div class="w-12 h-12 bg-blue-600 rounded-full flex items-center justify-center shadow-lg">
                                    <span class="text-white font-semibold">{{ auth()->user()->initials() }}</span>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">{{ auth()->user()->name }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ auth()->user()->email }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Menu Items -->
                        <div class="py-2">
                            <!-- Settings Link -->
                            <a 
                                href="{{ route('settings') }}" 
                                wire:navigate
                                class="flex items-center px-4 py-3 text-sm text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200"
                                @click="open = false"
                            >
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                Settings
                            </a>

                            <!-- Separator -->
                            <div class="border-t border-gray-200 dark:border-gray-700 my-1"></div>

                            <!-- Logout Form -->
                            <form method="POST" action="{{ route('logout') }}" class="w-full">
                                @csrf
                                <button
                                    type="submit"
                                    class="flex items-center w-full px-4 py-3 text-sm text-left text-red-600 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200 rounded-b-lg"
                                    data-test="logout-button"
                                    @click="open = false"
                                >
                                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                    </svg>
                                    Log Out
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </flux:sidebar>

        <!-- Mobile Header -->
                <!-- Mobile Header -->
                <!-- Mobile Header -->
                <!-- Mobile Header -->
        <flux:header class="lg:hidden mobile-header-modern h-14 z-50 bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-700">
            <flux:sidebar.toggle class="lg:hidden text-gray-700 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg" icon="bars-2" inset="left" />

            <div class="flex items-center space-x-3">
                <div class="w-6 h-6 bg-blue-600 rounded flex items-center justify-center shadow-lg">
                    <span class="text-white font-bold text-xs">K</span>
                </div>
                <span class="text-gray-900 dark:text-white font-semibold">Kessly</span>
            </div>

            <flux:spacer />

            <flux:dropdown position="top" align="end">
                <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center cursor-pointer shadow-lg">
                    <span class="text-white font-semibold text-xs">{{ auth()->user()->initials() }}</span>
                </div>

                <flux:menu class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-xl">
                    <flux:menu.radio.group>
                        <div class="p-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center shadow-lg">
                                    <span class="text-white font-semibold">{{ auth()->user()->initials() }}</span>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">{{ auth()->user()->name }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ auth()->user()->email }}</p>
                                </div>
                            </div>
                        </flux:menu.radio.group>

                    <flux:menu.separator class="bg-gray-200 dark:bg-gray-700" />

                    <flux:menu.radio.group>
                        <flux:menu.item
                            :href="route('settings')"
                            icon="cog-6-tooth"
                            wire:navigate
                            class="text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200"
                        >
                            Settings
                        </flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator class="bg-gray-200 dark:bg-gray-700" />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item
                            as="button"
                            type="submit"
                            icon="arrow-right-start-on-rectangle"
                            class="w-full text-red-600 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200"
                            data-test="logout-button"
                        >
                            Log Out
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:header>

        <!-- Main Content Area -->
        <main class="lg:ml-64 transition-all duration-300 ease-in-out">
            <div class="min-h-screen bg-gray-50 dark:bg-gray-900">
                <div class="p-2 sm:p-4 main-content-wrapper">
                    {{ $slot }}
                </div>
            </div>
        </main>

        @fluxScripts
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.store('flux', {
                    appearance: Alpine.$persist(
                        window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light'
                    ).as('flux-appearance'),

                    setAppearance(appearance) {
                        this.appearance = appearance;
                    }
                });
            });
        </script>
    </body>
</html>
