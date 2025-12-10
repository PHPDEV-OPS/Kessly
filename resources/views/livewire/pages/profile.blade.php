<?php

use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.app')] class extends Component {
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
        $this->dispatch('profile-updated', name: $this->name);
    }
};
?>

<div>
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">
                <i class="ri-user-settings-line me-2"></i>
                Profile Settings
            </h5>
        </div>
        <div class="card-body">
            @if ($status)
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="ri-checkbox-circle-line me-2"></i>
                        <span>{{ $status }}</span>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form wire:submit.prevent="updateProfile">
                <div class="row">
                    <!-- Name -->
                    <div class="col-md-6 mb-4">
                        <label for="name" class="form-label">Name</label>
                        <input 
                            type="text" 
                            id="name" 
                            wire:model.defer="name"
                            class="form-control @error('name') is-invalid @enderror"
                            placeholder="Enter your name"
                        >
                        @error('name') 
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="col-md-6 mb-4">
                        <label for="email" class="form-label">Email</label>
                        <input 
                            type="email" 
                            id="email" 
                            wire:model.defer="email"
                            class="form-control @error('email') is-invalid @enderror"
                            placeholder="Enter your email"
                        >
                        @error('email') 
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Save Button -->
                <div class="d-flex justify-content-end gap-2">
                    <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                        <span wire:loading.remove>
                            <i class="ri-save-line me-1"></i>
                            Save Changes
                        </span>
                        <span wire:loading>
                            <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
                            Saving...
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
