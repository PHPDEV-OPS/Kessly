<?php if (isset($component)) { $__componentOriginal5863877a5171c196453bfa0bd807e410 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5863877a5171c196453bfa0bd807e410 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.app','data' => ['title' => 'Access Denied']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.app'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Access Denied']); ?>
    <div class="row items-center justify-center min-h-[60vh] p-4">
        <div class="col-md-6 col-lg-5">
            <div class="card text-center shadow-lg border-0 rounded-4 overflow-hidden">
                <div class="card-body p-5">
                    
                    <!-- Icon Ring -->
                    <div class="mx-auto d-flex align-items-center justify-content-center mb-4 position-relative" style="width: 80px; height: 80px;">
                        <div class="position-absolute w-100 h-100 bg-danger opacity-10 rounded-circle animate-pulse"></div>
                        <div class="d-flex align-items-center justify-content-center bg-danger bg-opacity-10 rounded-circle position-relative z-1" style="width: 60px; height: 60px;">
                            <i class="ri-forbid-2-line text-danger fs-1"></i>
                        </div>
                    </div>
        
                    <!-- Content -->
                    <h3 class="fw-bold text-dark mb-2">Access Denied</h3>
                    
                    <p class="text-muted mb-4 fs-6">
                        <?php echo e($exception->getMessage() ?: "You don't have permission to access this area."); ?>

                    </p>
        
                    <!-- Buttons -->
                    <div class="d-flex gap-2 justify-content-center">
                        <a href="<?php echo e(route('dashboard')); ?>" class="btn btn-primary px-4">
                             <i class="ri-home-4-line me-1"></i> Go to Dashboard
                        </a>
                        
                        <a href="<?php echo e(url()->previous()); ?>" class="btn btn-outline-secondary px-4">
                            <i class="ri-arrow-left-line me-1"></i> Go Back
                        </a>
                    </div>
        
                    <!-- User Context -->
                    <div class="mt-4 pt-4 border-top">
                        <small class="text-uppercase text-muted fw-semibold" style="font-size: 0.75rem; letter-spacing: 1px;">
                            Current Role
                        </small>
                        <div class="mt-1">
                            <?php if(auth()->check() && auth()->user()->role): ?>
                                <span class="badge bg-label-danger rounded-pill">
                                    <?php echo e(auth()->user()->role->name); ?>

                                </span>
                            <?php else: ?>
                                <span class="badge bg-label-secondary rounded-pill">Guest</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5863877a5171c196453bfa0bd807e410)): ?>
<?php $attributes = $__attributesOriginal5863877a5171c196453bfa0bd807e410; ?>
<?php unset($__attributesOriginal5863877a5171c196453bfa0bd807e410); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5863877a5171c196453bfa0bd807e410)): ?>
<?php $component = $__componentOriginal5863877a5171c196453bfa0bd807e410; ?>
<?php unset($__componentOriginal5863877a5171c196453bfa0bd807e410); ?>
<?php endif; ?><?php /**PATH D:\School-Projects\Software-dev\Kessly\resources\views/errors/403.blade.php ENDPATH**/ ?>