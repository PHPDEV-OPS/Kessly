<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="fluxAppearance" :class="$store.flux.appearance">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
        <flux:sidebar sticky stashable class="w-64 border-e border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white shadow-xl sidebar-modern">
            <flux:sidebar.toggle class="lg:hidden text-gray-700 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg" icon="x-mark" />

            <!-- Logo/Brand Section -->
            <div class="px-4 py-6 sidebar-brand bg-blue-600 dark:bg-blue-700">
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

            <!-- Main Navigation -->
            <div class="px-4 py-4">
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

            <flux:spacer />

            <!-- Resources Section -->
            <div class="px-4 py-4 border-t border-gray-200 dark:border-gray-700">
                <flux:navlist variant="outline" class="space-y-1">
                    <flux:navlist.item
                        icon="folder-git-2"
                        href="https://github.com/themesberg/volt-laravel-dashboard"
                        target="_blank"
                        class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 rounded-lg transition-colors duration-200"
                    >
                        Inspired by Volt
                    </flux:navlist.item>

                    <flux:navlist.item
                        icon="book-open-text"
                        href="https://laravel.com/docs"
                        target="_blank"
                        class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 rounded-lg transition-colors duration-200"
                    >
                        Laravel Docs
                    </flux:navlist.item>
                </flux:navlist>
            </div>

            <!-- User Profile Section -->
            <div class="px-4 py-4 border-t border-gray-200 dark:border-gray-700">
                <flux:dropdown class="w-full" position="top" align="start">
                    <div class="user-profile-card flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 cursor-pointer transition-all duration-300 bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
                        <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center shadow-lg">
                            <span class="text-white font-semibold text-sm">{{ auth()->user()->initials() }}</span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 dark:text-white truncate">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ auth()->user()->email }}</p>
                        </div>
                        <flux:icon.chevron-up-down class="w-4 h-4 text-gray-400 dark:text-gray-500" />
                    </div>

                    <flux:menu class="w-[220px] bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-xl">
                        <flux:menu.radio.group>
                            <div class="p-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900">
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
            </div>
        </flux:sidebar>

        <!-- Mobile Header -->
                <!-- Mobile Header -->
                <!-- Mobile Header -->
                <!-- Mobile Header -->
        <flux:header class="lg:hidden mobile-header-modern z-50 bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-700">
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
                <div class="p-4 sm:p-6 lg:p-8">
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
