<?php

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Locked;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    #[Locked]
    public string $token = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Mount the component.
     */
    public function mount(string $token): void
    {
        $this->token = $token;

        $this->email = request()->string('email');
    }

    /**
     * Reset the password for the given user.
     */
    public function resetPassword(): void
    {
        $this->validate([
            'token' => ['required'],
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.
        $status = Password::reset(
            $this->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) {
                $user->forceFill([
                    'password' => Hash::make($this->password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        // If the password was successfully reset, we will redirect the user back to
        // the application's home authenticated view. If there is an error we can
        // redirect them back to where they came from with their error message.
        if ($status != Password::PASSWORD_RESET) {
            $this->addError('email', __($status));

            return;
        }

        Session::flash('status', __($status));

        $this->redirectRoute('login', navigate: true);
    }
}; ?>

<div class="authentication-wrapper authentication-basic">
    <div class="authentication-inner">
        <!-- Reset Password -->
        <div class="card">
            <div class="card-body p-5">
                <!-- Logo -->
                <div class="app-brand justify-content-center mb-5">
                    <a href="{{ route('login') }}" class="app-brand-link gap-2" wire:navigate>
                        <span class="app-brand-logo demo">{!! \App\Helpers\Helper::getAppBrandLogo() !!}</span>
                        <span class="app-brand-text demo text-heading fw-bold">{{ config('app.name') }}</span>
                    </a>
                </div>
                <!-- /Logo -->
                
                <h4 class="mb-1">Reset Password 🔐</h4>
                <p class="mb-5">Enter your new password below</p>

                <form wire:submit="resetPassword" class="mb-3">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" 
                               wire:model="email" 
                               class="form-control @error('email') is-invalid @enderror" 
                               id="email" 
                               placeholder="your.email@company.com" 
                               autofocus 
                               required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 form-password-toggle">
                        <label class="form-label" for="password">New Password</label>
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
                        <label class="form-label" for="password_confirmation">Confirm New Password</label>
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
                    
                    <button type="submit" class="btn btn-primary d-grid w-100">Reset Password</button>
                </form>

                <div class="text-center">
                    <a href="{{ route('login') }}" class="d-flex align-items-center justify-content-center" wire:navigate>
                        <i class="ri-arrow-left-s-line scaleX-n1-rtl me-1"></i>
                        Back to login
                    </a>
                </div>
            </div>
        </div>
        <!-- /Reset Password -->
    </div>
</div>
