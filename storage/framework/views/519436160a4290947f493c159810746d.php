<?php
$containerFooter = !empty($containerNav) ? $containerNav : 'container-fluid';
$companyProfile = \App\Models\Setting::get('company.profile', []);
$companyName = $companyProfile['name'] ?? 'Kessly Wine Distribution';
$companyWebsite = $companyProfile['website'] ?? null;
$companyEmail = $companyProfile['email'] ?? null;
$companyPhone = $companyProfile['phone'] ?? null;
?>

<!-- Footer-->
<footer class="content-footer footer bg-footer-theme">
    <div class="<?php echo e($containerFooter); ?>">
        <div class="footer-container d-flex align-items-center justify-content-between py-3 py-md-4 flex-column flex-md-row gap-2">
            <div class="text-body text-center text-md-start mb-2 mb-md-0">
                &#169; <?php echo e(date('Y')); ?>

                <?php if($companyWebsite): ?>
                    <a href="<?php echo e($companyWebsite); ?>" target="_blank" class="footer-link fw-medium"><?php echo e($companyName); ?></a>
                <?php else: ?>
                    <span class="fw-medium"><?php echo e($companyName); ?></span>
                <?php endif; ?>
                <span class="d-none d-sm-inline-block">- All rights reserved</span>
            </div>
            <div class="d-flex flex-wrap justify-content-center gap-2 gap-md-3">
                <?php if($companyPhone): ?>
                    <a href="tel:<?php echo e($companyPhone); ?>" class="footer-link text-body small">
                        <i class='bx bx-phone me-1'></i>
                        <span class="d-none d-lg-inline"><?php echo e($companyPhone); ?></span>
                    </a>
                <?php endif; ?>
                <?php if($companyEmail): ?>
                    <a href="mailto:<?php echo e($companyEmail); ?>" class="footer-link text-body small">
                        <i class='bx bx-envelope me-1'></i>
                        <span class="d-none d-lg-inline"><?php echo e($companyEmail); ?></span>
                    </a>
                <?php endif; ?>
                <a href="<?php echo e(route('settings')); ?>" class="footer-link text-body small">
                    <i class='bx bx-cog me-1'></i>
                    <span class="d-none d-lg-inline">Settings</span>
                </a>
            </div>
        </div>
    </div>
</footer>
<!--/ Footer-->
<?php /**PATH D:\School-Projects\Software-dev\Kessly\resources\views/layouts/sections/footer/footer.blade.php ENDPATH**/ ?>