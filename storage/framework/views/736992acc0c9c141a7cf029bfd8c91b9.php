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

?>

<div class="authentication-wrapper authentication-basic">
    <div class="authentication-inner">
        <!-- Reset Password -->
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
                
                <h4 class="mb-1">Reset Password 🔐</h4>
                <p class="mb-5">Enter your new password below</p>

                <form wire:submit="resetPassword" class="mb-3">
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
                        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="mb-3 form-password-toggle">
                        <label class="form-label" for="password">New Password</label>
                        <div class="input-group input-group-merge">
                            <input type="password" 
                                   wire:model="password" 
                                   id="password" 
                                   class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   placeholder="Create a strong password" 
                                   required 
                                   aria-describedby="password" />
                            <span class="input-group-text cursor-pointer"><i class="ri-eye-off-line"></i></span>
                            <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
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
                    <a href="<?php echo e(route('login')); ?>" class="d-flex align-items-center justify-content-center" wire:navigate>
                        <i class="ri-arrow-left-s-line scaleX-n1-rtl me-1"></i>
                        Back to login
                    </a>
                </div>
            </div>
        </div>
        <!-- /Reset Password -->
    </div>
</div><?php /**PATH D:\School-Projects\Software-dev\Kessly\resources\views\livewire\pages\auth\reset-password.blade.php ENDPATH**/ ?>