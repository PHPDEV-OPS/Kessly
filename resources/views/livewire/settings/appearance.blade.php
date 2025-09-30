<?php

use Livewire\Volt\Component;

new class extends Component {
    public string $appearance = 'system';

    public function mount(): void
    {
        // Get current appearance from Flux store (will be set by Alpine)
        $this->appearance = 'system'; // Default to system
    }

    public function updatedAppearance(): void
    {
        // This will be handled by Alpine.js and the Flux store
        $this->dispatch('appearance-updated');
    }
}; ?>

<div class="space-y-6">
    <div>
        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Appearance</h3>
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Update the appearance settings for your account</p>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6">
        <flux:radio.group x-data variant="segmented" x-model="$store.flux.appearance">
            <flux:radio value="light" icon="sun">{{ __('Light') }}</flux:radio>
            <flux:radio value="dark" icon="moon">{{ __('Dark') }}</flux:radio>
            <flux:radio value="system" icon="computer-desktop">{{ __('System') }}</flux:radio>
        </flux:radio.group>

        <div class="mt-4 text-sm text-gray-600 dark:text-gray-400">
            <p><strong>Light:</strong> Always use light theme</p>
            <p><strong>Dark:</strong> Always use dark theme</p>
            <p><strong>System:</strong> Follow your system's theme preference</p>
        </div>
    </div>

    <x-action-message on="appearance-updated">
        {{ __('Appearance updated successfully.') }}
    </x-action-message>
</div>
