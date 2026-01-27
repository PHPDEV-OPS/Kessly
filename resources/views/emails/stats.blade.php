{{-- Email Statistics Dashboard --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Email Analytics & Statistics') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
                    <div class="flex items-center mb-6">
                        <svg class="w-8 h-8 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <h1 class="ml-2 text-2xl font-medium text-gray-900">
                            Email Performance Dashboard
                        </h1>
                    </div>

                    <!-- Email Type Filter -->
                    <div class="mb-6">
                        <label for="email_type" class="block text-sm font-medium text-gray-700 mb-2">Filter by Email Type</label>
                        <select id="email_type" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            <option value="">All Email Types</option>
                            <option value="welcome">Welcome Emails</option>
                            <option value="admin-new-user">Admin Notifications</option>
                            <option value="user-verified">Verification Emails</option>
                        </select>
                    </div>

                    <!-- Statistics Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                        <!-- Total Sent -->
                        <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg p-6 text-white">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-blue-400 bg-opacity-30">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <p class="text-blue-100 text-sm font-medium">Total Sent</p>
                                    <p class="text-2xl font-bold">{{ number_format($stats['total_sent']) }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Total Opened -->
                        <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-lg p-6 text-white">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-green-400 bg-opacity-30">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <p class="text-green-100 text-sm font-medium">Total Opened</p>
                                    <p class="text-2xl font-bold">{{ number_format($stats['total_opened']) }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Open Rate -->
                        <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-lg p-6 text-white">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-purple-400 bg-opacity-30">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"/>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <p class="text-purple-100 text-sm font-medium">Open Rate</p>
                                    <p class="text-2xl font-bold">{{ $stats['open_rate'] }}%</p>
                                </div>
                            </div>
                        </div>

                        <!-- Last 24 Hours -->
                        <div class="bg-gradient-to-r from-orange-500 to-orange-600 rounded-lg p-6 text-white">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-orange-400 bg-opacity-30">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <p class="text-orange-100 text-sm font-medium">Last 24h</p>
                                    <p class="text-lg font-bold">{{ $stats['last_24h'] }} sent</p>
                                    <p class="text-sm">{{ $stats['opened_last_24h'] }} opened</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Email Activity -->
                    <div class="bg-gray-50 rounded-lg p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Recent Email Activity</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email Type</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Recipient</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sent</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse(\App\Models\EmailTracking::latest()->take(10)->get() as $tracking)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ ucwords(str_replace('-', ' ', $tracking->email_type)) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $tracking->recipient_email }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($tracking->opened)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    Opened
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                    Sent
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $tracking->created_at->diffForHumans() }}
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                            No email activity yet
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Email type filter functionality
        document.getElementById('email_type').addEventListener('change', function() {
            const emailType = this.value;
            const url = emailType ? `{{ route('email.stats') }}?type=${emailType}` : '{{ route('email.stats') }}';
            window.location.href = url;
        });
    </script>
</x-app-layout>