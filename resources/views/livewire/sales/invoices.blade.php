<div class="space-y-6">
    @if (session()->has('status'))
        <div class="p-3 rounded bg-green-100 text-green-800">{{ session('status') }}</div>
    @endif

    <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
        <h2 class="text-xl font-semibold">Invoices</h2>

        <div class="flex gap-2 items-center w-full md:w-auto">
            <input type="text" placeholder="Search by name or customer..." class="w-full md:w-64 rounded-md border-gray-300 shadow-sm" wire:model.debounce.300ms="search">
            <select class="rounded-md border-gray-300 shadow-sm" wire:model="perPage">
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>
            <button type="button" class="px-3 py-2 rounded bg-blue-600 text-white hover:bg-blue-700" wire:click="create">New Invoice</button>
        </div>
    </div>

    <div class="overflow-x-auto bg-white rounded-lg shadow">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Customer</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                        <button type="button" class="flex items-center gap-1" wire:click="sortBy('created_at')">
                            Date
                            @if ($sortField === 'created_at')
                                <span>@if ($sortDirection === 'asc') ↑ @else ↓ @endif</span>
                            @endif
                        </button>
                    </th>
                    <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">
                        <button type="button" class="flex items-center gap-1" wire:click="sortBy('amount')">
                            Amount
                            @if ($sortField === 'amount')
                                <span>@if ($sortDirection === 'asc') ↑ @else ↓ @endif</span>
                            @endif
                        </button>
                    </th>
                    <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($invoices as $inv)
                    <tr>
                        <td class="px-4 py-3">{{ $inv->name }}</td>
                        <td class="px-4 py-3">{{ $inv->customer?->name ?? '—' }}</td>
                        <td class="px-4 py-3">{{ optional($inv->created_at)->format('M d, Y') }}</td>
                        <td class="px-4 py-3 text-right">$ {{ number_format($inv->amount, 2) }}</td>
                        <td class="px-4 py-3 text-right space-x-2">
                            <button type="button" class="text-blue-600 hover:text-blue-800" wire:click="edit({{ $inv->id }})">Edit</button>
                            <button type="button" class="text-red-600 hover:text-red-800" wire:click="delete({{ $inv->id }})" onclick="return confirm('Delete this invoice?')">Delete</button>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-4 py-6 text-center text-gray-500">No invoices found.</td></tr>
                @endforelse
            </tbody>
        </table>

        <div class="px-4 py-3">{{ $invoices->links() }}</div>
    </div>

    @if ($showForm)
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold mb-4">{{ $invoiceId ? 'Edit Invoice' : 'New Invoice' }}</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Name</label>
                    <input type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" wire:model.defer="name">
                    @error('name') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Customer</label>
                    <select class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" wire:model.defer="customer_id">
                        <option value="">Select customer</option>
                        @foreach ($customers as $c)
                            <option value="{{ $c->id }}">{{ $c->name }}</option>
                        @endforeach
                    </select>
                    @error('customer_id') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Amount</label>
                    <input type="number" step="0.01" min="0" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" wire:model.defer="amount">
                    @error('amount') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="mt-6 flex items-center gap-3">
                <button type="button" class="px-4 py-2 rounded bg-blue-600 text-white hover:bg-blue-700" wire:click="save">Save</button>
                <button type="button" class="px-4 py-2 rounded bg-gray-200 hover:bg-gray-300" wire:click="cancel">Cancel</button>
            </div>
        </div>
    @endif
</div>
