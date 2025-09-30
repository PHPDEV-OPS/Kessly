<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Livewire\Volt\Component;

new class extends Component {
    public string $current_password = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Update the password for the currently authenticated user.
     */
    public function updatePassword(): void
    {
        try {
            $validated = $this->validate([
                'current_password' => ['required', 'string', 'current_password'],
                'password' => ['required', 'string', Password::defaults(), 'confirmed'],
            ]);
        } catch (ValidationException $e) {
            $this->reset('current_password', 'password', 'password_confirmation');

            throw $e;
        }

        Auth::user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        $this->reset('current_password', 'password', 'password_confirmation');

        $this->dispatch('password-updated');
    }
}; ?>

<div class="space-y-6">
    <div>
        <h3 class="text-lg font-medium text-gray-900">Update password</h3>
        <p class="mt-1 text-sm text-gray-600">Ensure your account is using a long, random password to stay secure</p>
    </div>

    <form method="POST" wire:submit="updatePassword" class="space-y-6">
        <flux:input
            wire:model="current_password"
            :label="__('Current password')"
            type="password"
            required
            autocomplete="current-password"
        />
        <flux:input
            wire:model="password"
            :label="__('New password')"
            type="password"
            required
            autocomplete="new-password"
        />
        <flux:input
            wire:model="password_confirmation"
            :label="__('Confirm Password')"
            type="password"
            required
            autocomplete="new-password"
        />

        <div class="flex items-center gap-4">
            <flux:button variant="primary" type="submit" data-test="update-password-button">
                {{ __('Save') }}
            </flux:button>

            <x-action-message on="password-updated">
                {{ __('Saved.') }}
            </x-action-message>
        </div>
    </form>
</div>
