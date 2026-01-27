<?php

use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

?>

<div class="authentication-wrapper authentication-basic">
    <div class="authentication-inner">
        <!-- Forgot Password -->
        <div class="card">
            <div class="card-body p-5">
                <!-- Logo -->
                <div class="app-brand justify-content-center mb-5">
                    <a href="<?php echo e(route('login')); ?>" class="app-brand-link gap-2" wire:navigate>
                        <span class="app-brand-logo demo"><?php echo \App\Helpers\Helper::getAppBrandLogo(); ?></span>
                        <span class="app-brand-text demo text-heading fw-bold"><?php echo e(config('app.name')); ?></span>
                    </a>
                </div>
                <!-- /Logo -->
                
                <h4 class="mb-1">Forgot Password? 🔒</h4>
                <p class="mb-5">Enter your email and we'll send you instructions to reset your password</p>

                <!-- Session Status -->
                <!--[if BLOCK]><![endif]--><?php if(session('status')): ?>
                    <div class="alert alert-success mb-3" role="alert">
                        <?php echo e(session('status')); ?>

                    </div>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                <form wire:submit="sendPasswordResetLink" class="mb-3">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" 
                               wire:model="email" 
                               class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                               id="email" 
                               placeholder="your.email@company.com" 
                               autofocus 
                               required>
                        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['email'];
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
                    
                    <button type="submit" class="btn btn-primary d-grid w-100">Send Reset Link</button>
                </form>

                <div class="text-center">
                    <a href="<?php echo e(route('login')); ?>" class="d-flex align-items-center justify-content-center" wire:navigate>
                        <i class="ri-arrow-left-s-line scaleX-n1-rtl me-1"></i>
                        Back to login
                    </a>
                </div>
            </div>
        </div>
        <!-- /Forgot Password -->
    </div>
</div><?php /**PATH D:\School-Projects\Software-dev\Kessly\resources\views\livewire/pages/auth/forgot-password.blade.php ENDPATH**/ ?>