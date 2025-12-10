<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div class="container-xxl">
    <div class="authentication-wrapper authentication-basic">
        <div class="authentication-inner">
            <!-- Login -->
            <div class="card">
                <div class="card-body p-sm-7 p-2">
                <!-- Logo -->
                <div class="app-brand justify-content-center mt-5">
                    <a href="{{ route('dashboard') }}" class="app-brand-link gap-3" wire:navigate>
                        <span class="app-brand-logo demo">{!! \App\Helpers\Helper::getAppBrandLogo() !!}</span>
                        <span class="app-brand-text demo text-heading fw-semibold">{{ config('app.name') }}</span>
                    </a>
                </div>
                <!-- /Logo -->

                <div class="card-body mt-1">
                    <h4 class="mb-1">Welcome to Kessly! 👋🏻</h4>
                    <p class="mb-5">Please sign-in to your account and start the adventure</p>

                    <!-- Session Status -->
                    @if (session('status'))
                        <div class="alert alert-success mb-3" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form id="formAuthentication" class="mb-5" wire:submit="login">
                        <div class="form-floating form-floating-outline mb-5 form-control-validation">
                            <input type="email" 
                                   wire:model="form.email" 
                                   class="form-control @error('form.email') is-invalid @enderror" 
                                   id="email" 
                                   name="email" 
                                   placeholder="Enter your email or username" 
                                   autofocus />
                            <label for="email">Email or Username</label>
                            @error('form.email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-5">
                            <div class="form-password-toggle form-control-validation">
                                <div class="input-group input-group-merge">
                                    <div class="form-floating form-floating-outline">
                                        <input type="password" 
                                               wire:model="form.password" 
                                               id="password" 
                                               class="form-control @error('form.password') is-invalid @enderror" 
                                               name="password" 
                                               placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" 
                                               aria-describedby="password" />
                                        <label for="password">Password</label>
                                    </div>
                                    <span class="input-group-text cursor-pointer">
                                        <i class="icon-base ri ri-eye-off-line icon-20px"></i>
                                    </span>
                                </div>
                                @error('form.password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-5 pb-2 d-flex justify-content-between pt-2 align-items-center">
                            <div class="form-check mb-0">
                                <input wire:model="form.remember" class="form-check-input" type="checkbox" id="remember-me" />
                                <label class="form-check-label" for="remember-me"> Remember Me </label>
                            </div>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="float-end mb-1" wire:navigate>
                                    <span>Forgot Password?</span>
                                </a>
                            @endif
                        </div>
                        <div class="mb-5">
                            <button class="btn btn-primary d-grid w-100" type="submit">login</button>
                        </div>
                    </form>

                    @if (Route::has('register'))
                        <p class="text-center mb-5">
                            <span>New on our platform?</span>
                            <a href="{{ route('register') }}" wire:navigate>
                                <span>Create an account</span>
                            </a>
                        </p>
                    @endif
                </div>
                </div>
            </div>
            <!-- /Login -->
        </div>
    </div>

    <!-- Background images -->
    <div class="authentication-bg">
        <img class="authentication-bg-mask d-none d-lg-block scaleX-n1-rtl" src="{{ asset('assets/img/illustrations/auth-basic-mask-light.png') }}" alt="auth mask">
        <img class="authentication-image-tree d-none d-lg-block" src="{{ asset('assets/img/illustrations/tree-3.png') }}" alt="auth tree">
        <img class="authentication-image-object-left d-none d-lg-block" src="{{ asset('assets/img/illustrations/tree.png') }}" alt="auth tree left">
    </div>
</div>
