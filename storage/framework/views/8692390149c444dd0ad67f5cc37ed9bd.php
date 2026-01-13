<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

?>

<div class="container-xxl">
    <div class="authentication-wrapper authentication-basic">
        <div class="authentication-inner">
            <!-- Login -->
            <div class="card">
                <div class="card-body p-sm-7 p-2">
                <!-- Logo -->
                <div class="app-brand justify-content-center mt-5">
                    <a href="<?php echo e(route('dashboard')); ?>" class="app-brand-link gap-3" wire:navigate>
                        <span class="app-brand-logo demo"><?php echo \App\Helpers\Helper::getAppBrandLogo(); ?></span>
                        <span class="app-brand-text demo text-heading fw-semibold"><?php echo e(config('app.name')); ?></span>
                    </a>
                </div>
                <!-- /Logo -->

                <div class="card-body mt-1">
                    <h4 class="mb-1">Welcome to Kessly! 👋🏻</h4>
                    <p class="mb-5">Please sign-in to your account and start the adventure</p>

                    <!-- Session Status -->
                    <!--[if BLOCK]><![endif]--><?php if(session('status')): ?>
                        <div class="alert alert-success mb-3" role="alert">
                            <?php echo e(session('status')); ?>

                        </div>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                    <form id="formAuthentication" class="mb-5" wire:submit="login">
                        <div class="form-floating form-floating-outline mb-5 form-control-validation">
                            <input type="email" 
                                   wire:model="form.email" 
                                   class="form-control <?php $__errorArgs = ['form.email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   id="email" 
                                   name="email" 
                                   placeholder="Enter your email or username" 
                                   autofocus />
                            <label for="email">Email or Username</label>
                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['form.email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                        <div class="mb-5">
                            <div class="form-password-toggle form-control-validation">
                                <div class="input-group input-group-merge">
                                    <div class="form-floating form-floating-outline">
                                        <input type="password" 
                                               wire:model="form.password" 
                                               id="password" 
                                               class="form-control <?php $__errorArgs = ['form.password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                               name="password" 
                                               placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" 
                                               aria-describedby="password" />
                                        <label for="password">Password</label>
                                    </div>
                                    <span class="input-group-text cursor-pointer">
                                        <i class="icon-base ri ri-eye-off-line icon-20px"></i>
                                    </span>
                                </div>
                                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['form.password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                            </div>
                        </div>
                        <div class="mb-5 pb-2 d-flex justify-content-between pt-2 align-items-center">
                            <div class="form-check mb-0">
                                <input wire:model="form.remember" class="form-check-input" type="checkbox" id="remember-me" />
                                <label class="form-check-label" for="remember-me"> Remember Me </label>
                            </div>
                            <!--[if BLOCK]><![endif]--><?php if(Route::has('password.request')): ?>
                                <a href="<?php echo e(route('password.request')); ?>" class="float-end mb-1" wire:navigate>
                                    <span>Forgot Password?</span>
                                </a>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                        <div class="mb-5">
                            <button class="btn btn-primary d-grid w-100" type="submit">login</button>
                        </div>
                    </form>

                    <!--[if BLOCK]><![endif]--><?php if(Route::has('register')): ?>
                        <p class="text-center mb-5">
                            <span>New on our platform?</span>
                            <a href="<?php echo e(route('register')); ?>" wire:navigate>
                                <span>Create an account</span>
                            </a>
                        </p>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </div>
                </div>
            </div>
            <!-- /Login -->
        </div>
    </div>

    <!-- Background images -->
    <div class="authentication-bg">
        <img class="authentication-bg-mask d-none d-lg-block scaleX-n1-rtl" src="<?php echo e(asset('assets/img/illustrations/auth-basic-mask-light.png')); ?>" alt="auth mask">
        <img class="authentication-image-tree d-none d-lg-block" src="<?php echo e(asset('assets/img/illustrations/tree-3.png')); ?>" alt="auth tree">
        <img class="authentication-image-object-left d-none d-lg-block" src="<?php echo e(asset('assets/img/illustrations/tree.png')); ?>" alt="auth tree left">
    </div>
</div><?php /**PATH D:\School-Projects\Software-dev\Kessly\resources\views\livewire/pages/auth/login.blade.php ENDPATH**/ ?>