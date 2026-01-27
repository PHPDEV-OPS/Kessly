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
use App\Mail\WelcomeEmail;
use Illuminate\Support\Facades\Mail;

new #[Layout('layouts.guest')] class extends Component
{
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
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
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

        // Send welcome email to user
        Mail::to($user->email)->send(new WelcomeEmail($user));

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

<div class="authentication-wrapper authentication-basic">
    <div class="authentication-inner">
        <!-- Register -->
        <div class="card">
            <div class="card-body p-5">
                <!-- Logo -->
                <div class="app-brand justify-content-center mb-5">
                    <a href="{{ route('dashboard') }}" class="app-brand-link gap-2" wire:navigate>
                        <span class="app-brand-logo demo">{!! \App\Helpers\Helper::getAppBrandLogo() !!}</span>
                        <span class="app-brand-text demo text-heading fw-bold">{{ config('app.name') }}</span>
                    </a>
                </div>
                <!-- /Logo -->
                
                <h4 class="mb-1">Join Kessly Today! 🚀</h4>
                <p class="mb-5">Create your account to streamline your supply chain operations</p>

                @if (session()->has('status'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('status') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form wire:submit="register" class="mb-3">
                    <div class="mb-3">
                        <label for="name" class="form-label">Full Name</label>
                        <input type="text" 
                               wire:model="name" 
                               class="form-control @error('name') is-invalid @enderror" 
                               id="name" 
                               placeholder="John Doe" 
                               autofocus 
                               required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" 
                               wire:model="email" 
                               class="form-control @error('email') is-invalid @enderror" 
                               id="email" 
                               placeholder="your.email@company.com" 
                               required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="role_id" class="form-label">Role</label>
                        <select
                            class="form-select @error('role_id') is-invalid @enderror"
                            id="role_id"
                            wire:model="role_id"
                            required
                        >
                            <option value="">Select your role</option>
                            @foreach($this->availableRoles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                        @error('role_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    
                    <div class="mb-3 form-password-toggle">
                        <label class="form-label" for="password">Password</label>
                        <div class="input-group input-group-merge">
                            <input type="password" 
                                   wire:model="password" 
                                   id="password" 
                                   class="form-control @error('password') is-invalid @enderror" 
                                   placeholder="Create a strong password" 
                                   required 
                                   aria-describedby="password" />
                            <span class="input-group-text cursor-pointer"><i class="ri-eye-off-line"></i></span>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mb-3 form-password-toggle">
                        <label class="form-label" for="password_confirmation">Confirm Password</label>
                        <div class="input-group input-group-merge">
                            <input type="password" 
                                   wire:model="password_confirmation" 
                                   id="password_confirmation" 
                                   class="form-control" 
                                   placeholder="Confirm your password" 
                                   required />
                            <span class="input-group-text cursor-pointer"><i class="ri-eye-off-line"></i></span>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="terms-conditions" required />
                            <label class="form-check-label" for="terms-conditions">
                                I agree to Kessly's
                                <a href="javascript:void(0);">Terms of Service</a> and <a href="javascript:void(0);">Privacy Policy</a>
                            </label>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary d-grid w-100" wire:loading.attr="disabled">
                        <span wire:loading.remove>Sign up</span>
                        <span wire:loading>
                            <span class="spinner-border spinner-border-sm me-2" role="status"></span>
                            Creating account...
                        </span>
                    </button>
                </form>

                <p class="text-center">
                    <span>Already have an account?</span>
                    <a href="{{ route('login') }}" wire:navigate>
                        <span>Sign in here</span>
                    </a>
                </p>
            </div>
        </div>
        <!-- /Register -->
    </div>
</div>
