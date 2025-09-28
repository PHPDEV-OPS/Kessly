<div class="space-y-6">
    @if (session()->has('status'))
        <div class="p-3 rounded bg-green-100 text-green-800">{{ session('status') }}</div>
    @endif

    <h2 class="text-xl font-semibold">Company Profile</h2>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Company Name</label>
                <input type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" wire:model.defer="company_name">
                @error('company_name') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" wire:model.defer="company_email">
                @error('company_email') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Phone</label>
                <input type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" wire:model.defer="company_phone">
                @error('company_phone') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700">Address</label>
                <textarea rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" wire:model.defer="company_address"></textarea>
                @error('company_address') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="mt-6">
            <button type="button" class="px-4 py-2 rounded bg-blue-600 text-white hover:bg-blue-700" wire:click="save">Save</button>
        </div>
    </div>
</div>
