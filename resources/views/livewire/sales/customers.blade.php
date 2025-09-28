<div class="space-y-6">
    @if (session()->has('status'))
        <div class="p-3 rounded bg-green-100 text-green-800">{{ session('status') }}</div>
    @endif

    <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
        <h2 class="text-xl font-semibold">Customers</h2>

        <div class="flex gap-2 items-center w-full md:w-auto">
            <input type="text" placeholder="Search customers..." class="w-full md:w-64 rounded-md border-gray-300 shadow-sm" wire:model.debounce.300ms="search">
            <select class="rounded-md border-gray-300 shadow-sm" wire:model="perPage">
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>
            <button type="button" class="px-3 py-2 rounded bg-blue-600 text-white hover:bg-blue-700" wire:click="create">New Customer</button>
        </div>
    </div>

    <div class="overflow-x-auto bg-white rounded-lg shadow">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                        <button type="button" class="flex items-center gap-1" wire:click="sortBy('name')">
                            Name
                            @if ($sortField === 'name')
                                <span>@if ($sortDirection === 'asc') ↑ @else ↓ @endif</span>
                            @endif
                        </button>
                    </th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Phone</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Address</th>
                    <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($customers as $c)
                    <tr>
                        <td class="px-4 py-3">{{ $c->name }}</td>
                        <td class="px-4 py-3">{{ $c->email }}</td>
                        <td class="px-4 py-3">{{ $c->phone ?? '—' }}</td>
                        <td class="px-4 py-3">{{ $c->address ?? '—' }}</td>
                        <td class="px-4 py-3 text-right space-x-2">
                            <button type="button" class="text-blue-600 hover:text-blue-800" wire:click="edit({{ $c->id }})">Edit</button>
                            <button type="button" class="text-red-600 hover:text-red-800" wire:click="delete({{ $c->id }})" onclick="return confirm('Delete this customer?')">Delete</button>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-4 py-6 text-center text-gray-500">No customers found.</td></tr>
                @endforelse
            </tbody>
        </table>

        <div class="px-4 py-3">{{ $customers->links() }}</div>
    </div>

    @if ($showForm)
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold mb-4">{{ $customerId ? 'Edit Customer' : 'New Customer' }}</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Name</label>
                    <input type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" wire:model.defer="name">
                    @error('name') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" wire:model.defer="email">
                    @error('email') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Phone</label>
                    <input type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" wire:model.defer="phone">
                    @error('phone') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Address</label>
                    <input type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" wire:model.defer="address">
                    @error('address') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700">Notes</label>
                    <textarea rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" wire:model.defer="notes"></textarea>
                    @error('notes') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="mt-6 flex items-center gap-3">
                <button type="button" class="px-4 py-2 rounded bg-blue-600 text-white hover:bg-blue-700" wire:click="save">Save</button>
                <button type="button" class="px-4 py-2 rounded bg-gray-200 hover:bg-gray-300" wire:click="cancel">Cancel</button>
            </div>
        </div>
    @endif
</div>
