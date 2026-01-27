<?php

use App\Models\User;
use App\Models\Role;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use App\Notifications\UserRegistrationNotification;
use App\Notifications\AdminNewUserNotification;

new #[Layout('components.layouts.auth')] class extends Component {
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';
    public string $role_id = '';

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
            'role_id' => ['required', 'exists:roles,id'],
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['is_verified'] = false; // User needs admin verification

        $user = User::create($validated);

        // Send notification to admin
        $adminUsers = User::whereHas('role', function($query) {
            $query->where('name', 'Administrator');
        })->get();

        foreach ($adminUsers as $admin) {
            $admin->notify(new AdminNewUserNotification($user));
        }

        // Don't auto-login - user needs verification
        // Auth::login($user);

        session()->flash('status', 'Registration successful! Please wait for admin verification. You will receive an email once your account is approved.');

        // Redirect to login with message
        $this->redirect(route('login'), navigate: true);
    }

    public function getAvailableRolesProperty()
    {
        // Return roles that users can register for (exclude admin roles)
        return Role::whereNotIn('name', ['Administrator', 'Super Admin'])
                  ->whereIn('name', ['Sales Manager', 'Sales Representative', 'Branch Manager', 'HR Manager', 'Inventory Manager', 'Accountant', 'Customer Service'])
                  ->orderBy('name')
                  ->get();
    }
}; ?>

<div class="flex flex-col gap-6">
    <x-auth-header :title="__('Create an account')" :description="__('Enter your details below to create your account')" />

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <form method="POST" wire:submit="register" class="flex flex-col gap-6">
        <!-- Name -->
        <flux:input
            wire:model="name"
            :label="__('Name')"
            type="text"
            required
            autofocus
            autocomplete="name"
            :placeholder="__('Full name')"
        />

        <!-- Email Address -->
        <flux:input
            wire:model="email"
            :label="__('Email address')"
            type="email"
            required
            autocomplete="email"
            placeholder="email@example.com"
        />

        <!-- Role Selection -->
        <div>
            <label for="role_id" class="form-label">Role <span class="text-danger">*</span></label>
            <select wire:model="role_id" id="role_id" class="form-select @error('role_id') is-invalid @enderror" required>
                <option value="">Select your role</option>
                @foreach($this->availableRoles as $role)
                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                @endforeach
            </select>
            @error('role_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <!-- Password -->
        <flux:input
            wire:model="password"
            :label="__('Password')"
            type="password"
            required
            autocomplete="new-password"
            :placeholder="__('Password')"
            viewable
        />

        <!-- Confirm Password -->
        <flux:input
            wire:model="password_confirmation"
            :label="__('Confirm password')"
            type="password"
            required
            autocomplete="new-password"
            :placeholder="__('Confirm password')"
            viewable
        />

        <div class="flex items-center justify-end">
            <flux:button type="submit" variant="primary" class="w-full" data-test="register-user-button">
                {{ __('Create account') }}
            </flux:button>
        </div>
    </form>

    <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-600">
        <span>{{ __('Already have an account?') }}</span>
        <flux:link :href="route('login')" wire:navigate>{{ __('Log in') }}</flux:link>
    </div>
</div>
