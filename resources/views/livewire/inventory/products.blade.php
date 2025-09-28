<div class="space-y-6">
    <!-- Status Message -->
    @if (session()->has('status'))
        <div class="p-3 rounded bg-green-100 text-green-800">
            {{ session('status') }}
        </div>
    @endif

    <!-- Header and Controls -->
    <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
        <h2 class="text-xl font-semibold">Products</h2>

        <div class="flex gap-2 items-center w-full md:w-auto">
            <input
                type="text"
                placeholder="Search products..."
                class="w-full md:w-64 rounded-md border-gray-300 shadow-sm"
                wire:model.debounce.300ms="search"
            />

            <select class="rounded-md border-gray-300 shadow-sm" wire:model="perPage">
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>

            <button
                type="button"
                class="px-3 py-2 rounded bg-blue-600 text-white hover:bg-blue-700"
                wire:click="create"
            >
                New Product
            </button>
        </div>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto bg-white rounded-lg shadow">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <button type="button" class="flex items-center gap-1" wire:click="sortBy('name')">
                            Name
                            @if ($sortField === 'name')
                                <span>@if ($sortDirection === 'asc') ↑ @else ↓ @endif</span>
                            @endif
                        </button>
                    </th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Supplier</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <button type="button" class="flex items-center gap-1" wire:click="sortBy('stock')">
                            Stock
                            @if ($sortField === 'stock')
                                <span>@if ($sortDirection === 'asc') ↑ @else ↓ @endif</span>
                            @endif
                        </button>
                    </th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <button type="button" class="flex items-center gap-1" wire:click="sortBy('price')">
                            Price
                            @if ($sortField === 'price')
                                <span>@if ($sortDirection === 'asc') ↑ @else ↓ @endif</span>
                            @endif
                        </button>
                    </th>
                    <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($products as $product)
                    <tr>
                        <td class="px-4 py-3">
                            <div class="font-medium text-gray-900">{{ $product->name }}</div>
                            @if ($product->description)
                                <div class="text-gray-500 text-sm">{{ \Illuminate\Support\Str::limit($product->description, 80) }}</div>
                            @endif
                        </td>
                        <td class="px-4 py-3">{{ $product->category?->name ?? '—' }}</td>
                        <td class="px-4 py-3">{{ $product->supplier?->name ?? '—' }}</td>
                        <td class="px-4 py-3">{{ $product->stock }}</td>
                        <td class="px-4 py-3">$ {{ number_format($product->price, 2) }}</td>
                        <td class="px-4 py-3 text-right space-x-2">
                            <button type="button" class="text-blue-600 hover:text-blue-800" wire:click="edit({{ $product->id }})">Edit</button>
                            <button type="button" class="text-red-600 hover:text-red-800" wire:click="delete({{ $product->id }})" onclick="return confirm('Delete this product?')">Delete</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-6 text-center text-gray-500">No products found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="px-4 py-3">{{ $products->links() }}</div>
    </div>

    <!-- Create/Edit Form -->
    @if ($showForm)
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold mb-4">{{ $productId ? 'Edit Product' : 'New Product' }}</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Name -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Name</label>
                    <input type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" wire:model.defer="name">
                    @error('name') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                </div>

                <!-- Category -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Category</label>
                    <select class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" wire:model.defer="category_id">
                        <option value="">Select category</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                </div>

                <!-- Supplier -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Supplier</label>
                    <select class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" wire:model.defer="supplier_id">
                        <option value="">None</option>
                        @foreach ($suppliers as $sup)
                            <option value="{{ $sup->id }}">{{ $sup->name }}</option>
                        @endforeach
                    </select>
                    @error('supplier_id') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                </div>

                <!-- Stock -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Stock</label>
                    <input type="number" min="0" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" wire:model.defer="stock">
                    @error('stock') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                </div>

                <!-- Price -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Price</label>
                    <input type="number" step="0.01" min="0" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" wire:model.defer="price">
                    @error('price') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                </div>

                <!-- Description -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" wire:model.defer="description"></textarea>
                    @error('description') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="mt-6 flex items-center gap-3">
                <button type="button" class="px-4 py-2 rounded bg-blue-600 text-white hover:bg-blue-700" wire:click="save">Save</button>
                <button type="button" class="px-4 py-2 rounded bg-gray-200 hover:bg-gray-300" wire:click="cancel">Cancel</button>
            </div>
        </div>
    @endif
</div>
