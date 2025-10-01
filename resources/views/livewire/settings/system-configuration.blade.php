<div class="space-y-6">
    <h2 class="text-xl font-semibold text-gray-900 dark:text-white">System Configuration</h2>
    
    @if (session()->has('message'))
        <div class="p-3 rounded bg-green-100 text-green-800">{{ session('message') }}</div>
    @endif

    @if (session()->has('error'))
        <div class="p-3 rounded bg-red-100 text-red-800">{{ session('error') }}</div>
    @endif

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold mb-4">Application Settings</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Application Name</label>
                <input type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white" wire:model.defer="app_name">
                @error('app_name') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Application URL</label>
                <input type="url" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white" wire:model.defer="app_url">
                @error('app_url') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Environment</label>
                <select class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white" wire:model.defer="app_env">
                    <option value="production">Production</option>
                    <option value="staging">Staging</option>
                    <option value="development">Development</option>
                    <option value="local">Local</option>
                </select>
                @error('app_env') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="flex items-center">
                    <input type="checkbox" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" wire:model.defer="app_debug">
                    <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">Enable Debug Mode</span>
                </label>
            </div>
        </div>

        <div class="mt-6">
            <button type="button" class="px-4 py-2 rounded bg-blue-600 text-white hover:bg-blue-700" wire:click="save">Save Configuration</button>
            <button type="button" class="ml-3 px-4 py-2 rounded border border-gray-300 text-gray-700 hover:bg-gray-50" wire:click="resetToDefaults">Reset to Defaults</button>
        </div>
    </div>
</div>