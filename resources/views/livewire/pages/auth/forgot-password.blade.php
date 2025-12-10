<?php

use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $email = '';

    /**
     * Send a password reset link to the provided email address.
     */
    public function sendPasswordResetLink(): void
    {
        $this->validate([
            'email' => ['required', 'string', 'email'],
        ]);

        // Will send the password reset link to the user. Once we have attempted
        // to send the link, will examine the response then see the message we
        // need to show to the user. Finally send out a proper response.
        $status = Password::sendResetLink(
            $this->only('email')
        );

        if ($status != Password::RESET_LINK_SENT) {
            $this->addError('email', __($status));

            return;
        }

        $this->reset('email');

        session()->flash('status', __($status));
    }
}; ?>

<div class="authentication-wrapper authentication-basic">
    <div class="authentication-inner">
        <!-- Forgot Password -->
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
                
                <h4 class="mb-1">Forgot Password? 🔒</h4>
                <p class="mb-5">Enter your email and we'll send you instructions to reset your password</p>

                <!-- Session Status -->
                @if (session('status'))
                    <div class="alert alert-success mb-3" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <form wire:submit="sendPasswordResetLink" class="mb-3">
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
                    
                    <button type="submit" class="btn btn-primary d-grid w-100">Send Reset Link</button>
                </form>

                <div class="text-center">
                    <a href="{{ route('login') }}" class="d-flex align-items-center justify-content-center" wire:navigate>
                        <i class="ri-arrow-left-s-line scaleX-n1-rtl me-1"></i>
                        Back to login
                    </a>
                </div>
            </div>
        </div>
        <!-- /Forgot Password -->
    </div>
</div>
