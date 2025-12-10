<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" class="light-style layout-wide customizer-hide" dir="ltr" data-theme="theme-default" data-assets-path="<?php echo e(asset('assets')); ?>/" data-template="vertical-menu-template" data-style="light" data-bs-theme="light">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

        <title><?php echo e(config('app.name', 'Laravel')); ?></title>
        
        <meta name="description" content="<?php echo e(config('variables.templateDescription') ? config('variables.templateDescription') : ''); ?>" />
        <meta name="keywords" content="<?php echo e(config('variables.templateKeyword') ? config('variables.templateKeyword') : ''); ?>">
        
        <!-- Favicon -->
        <link rel="icon" type="image/x-icon" href="<?php echo e(asset('assets/img/favicon/favicon.ico')); ?>" />

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet" />

        <!-- Icons -->
        <link rel="stylesheet" href="<?php echo e(asset('assets/vendor/fonts/fontawesome.css')); ?>" />
        <link rel="stylesheet" href="<?php echo e(asset('assets/vendor/fonts/tabler-icons.css')); ?>" />
        <link rel="stylesheet" href="<?php echo e(asset('assets/vendor/fonts/flag-icons.css')); ?>" />
        <link href="https://cdn.jsdelivr.net/npm/remixicon@4.0.0/fonts/remixicon.css" rel="stylesheet" />

        <!-- Core CSS -->
        <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
        
        <!-- Page CSS -->
        <link rel="stylesheet" href="<?php echo e(asset('assets/vendor/css/pages/page-auth.css')); ?>" />

        <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::styles(); ?>

        
        <style>
            body {
                margin: 0;
                padding: 0;
                background-color: #fff;
            }
            .authentication-bg {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                z-index: -1;
                overflow: hidden;
            }
            .authentication-bg-mask {
                position: absolute;
                bottom: 0;
                left: 0;
                width: 100%;
                height: auto;
                object-fit: cover;
            }
            .authentication-image-tree {
                position: absolute;
                bottom: 4rem;
                left: 3rem;
                width: auto;
                height: 200px;
                object-fit: contain;
            }
            .authentication-image-object-left {
                position: absolute;
                bottom: 6%;
                left: 4%;
                width: auto;
                height: 150px;
                object-fit: contain;
            }
            .authentication-image-object-right {
                position: absolute;
                bottom: 7%;
                right: 4%;
                width: auto;
                height: 150px;
                object-fit: contain;
            }
            .authentication-wrapper {
                position: relative;
                z-index: 1;
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 1.5rem;
            }
            .authentication-wrapper.authentication-basic {
                align-items: center;
                justify-content: center;
            }
            .authentication-inner {
                width: 100%;
                max-width: 460px;
                margin: 0 auto;
            }
            .authentication-inner .card {
                box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.15);
                border: none;
                border-radius: 0.5rem;
            }
            .app-brand-link {
                text-decoration: none;
                color: inherit;
            }
            .form-floating-outline .form-control {
                border: 1px solid #d9dee3;
                border-radius: 0.375rem;
                background-color: #fff;
            }
            .form-floating-outline .form-control:focus {
                border-color: #696cff;
                box-shadow: 0 0 0 0.125rem rgba(105, 108, 255, 0.25);
            }
            .form-floating-outline .form-control ~ label {
                color: #a8aaae;
                transform: translateY(0.75rem) translateX(1rem) scale(1);
                transition: all 0.2s ease-in-out;
            }
            .form-floating-outline .form-control:focus ~ label,
            .form-floating-outline .form-control:not(:placeholder-shown) ~ label {
                transform: translateY(-0.5rem) translateX(0.75rem) scale(0.85);
                color: #696cff;
            }
            .input-group-text {
                border-left: none;
                background-color: #fff;
            }
            .input-group .form-control:focus + .input-group-text {
                border-color: #696cff;
            }
            .btn-primary {
                background-color: #696cff;
                border-color: #696cff;
            }
            .btn-primary:hover {
                background-color: #5a5fc7;
                border-color: #5a5fc7;
            }
            @media (min-width: 768px) {
                .authentication-wrapper {
                    padding: 3rem;
                }
                .authentication-inner {
                    max-width: 500px;
                }
            }
            @media (max-width: 991.98px) {
                .authentication-image-tree,
                .authentication-image-object-left,
                .authentication-image-object-right,
                .authentication-bg-mask {
                    display: none !important;
                }
            }
        </style>
    </head>
    <body>
        <?php echo e($slot); ?>

        
        <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::scripts(); ?>


        <script>
            // Password toggle functionality
            document.addEventListener('DOMContentLoaded', function() {
                const passwordToggle = document.querySelector('.form-password-toggle .input-group-text');
                const passwordInput = document.getElementById('password');
                const eyeIcon = passwordToggle ? passwordToggle.querySelector('i') : null;

                if (passwordToggle && passwordInput && eyeIcon) {
                    passwordToggle.addEventListener('click', function() {
                        if (passwordInput.type === 'password') {
                            passwordInput.type = 'text';
                            eyeIcon.classList.remove('ri-eye-off-line');
                            eyeIcon.classList.add('ri-eye-line');
                        } else {
                            passwordInput.type = 'password';
                            eyeIcon.classList.remove('ri-eye-line');
                            eyeIcon.classList.add('ri-eye-off-line');
                        }
                    });
                }
            });
        </script>
    </body>
</html>
<?php /**PATH D:\School-Projects\Software-dev\Kessly\resources\views/layouts/guest.blade.php ENDPATH**/ ?>