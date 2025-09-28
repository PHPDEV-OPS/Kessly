<?php

use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.app')] class extends Component {
    public string $name;
    public string $email;
    public ?string $status = null;

    public function mount()
    {
        $this->name = auth()->user()->name;
        $this->email = auth()->user()->email;
    }

    public function updateProfile()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . auth()->id(),
        ]);

        auth()->user()->update([
            'name' => $this->name,
            'email' => $this->email,
        ]);

        $this->status = 'Profile updated successfully!';
        $this->dispatchBrowserEvent('profile-updated', ['name' => $this->name]);
    }
};
?>

<div>
    <h1 class="text-xl font-bold mb-4">Profile Settings</h1>

    @if ($status)
        <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
            {{ $status }}
        </div>
    @endif

    <form wire:submit.prevent="updateProfile">
        @csrf

        <!-- Name -->
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
            <input type="text" id="name" wire:model.defer="name"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            @error('name') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Email -->
        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input type="email" id="email" wire:model.defer="email"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            @error('email') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Save Button -->
        <button type="submit"
                class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
            Save
        </button>
    </form>
</div>
