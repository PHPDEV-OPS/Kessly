<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" 
      class="layout-menu-fixed layout-compact" 
      data-assets-path="<?php echo e(asset('/assets') . '/'); ?>" 
      dir="ltr" 
      data-skin="default" 
      data-base-url="<?php echo e(url('/')); ?>" 
      data-framework="laravel" 
      data-bs-theme="light" 
      data-template="vertical-menu-template">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>
        <?php echo $__env->yieldContent('title', config('app.name')); ?> | <?php echo e(config('variables.templateName', config('app.name'))); ?>

    </title>
    
    <meta name="description" content="<?php echo e(config('variables.templateDescription', config('app.name'))); ?>" />
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>" />
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?php echo e(asset('assets/img/favicon/favicon.ico')); ?>" />

    <!-- Include Styles -->
    <?php echo $__env->make('layouts/sections/styles', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <!-- Include Scripts for customizer, helper, analytics, config -->
    <?php echo $__env->make('layouts/sections/scriptsIncludes', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    
    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::styles(); ?>

    
    <style>
        /* Global Loading State */
        .page-loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(2px);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 10000;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.2s ease, visibility 0.2s ease;
            pointer-events: none;
        }
        
        .page-loader.active {
            opacity: 1;
            visibility: visible;
            pointer-events: auto;
        }
        
        .page-loader.active {
            opacity: 1;
            visibility: visible;
        }
        
        .loader-content {
            text-align: center;
        }
        
        .loader-spinner {
            width: 50px;
            height: 50px;
            border: 4px solid #f3f3f3;
            border-top: 4px solid #667eea;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0 auto 1rem;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        .loader-text {
            color: #667eea;
            font-weight: 500;
            font-size: 0.875rem;
        }
        
        /* Layout Overlay Enhancement */
        .layout-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            display: none;
            cursor: pointer;
        }
        
        .layout-overlay.active {
            display: block;
        }
        
        .layout-menu-expanded .layout-menu {
            transform: translateX(0) !important;
        }
    </style>
</head>

<body>
    <!-- Page Loader -->
    <div class="page-loader" id="pageLoader">
        <div class="loader-content">
            <div class="loader-spinner"></div>
            <div class="loader-text">Loading...</div>
        </div>
    </div>
    
    <!-- Layout Content -->
    <?php echo $__env->yieldContent('layoutContent'); ?>
    <!--/ Layout Content -->

    <!-- Include Scripts -->
    <?php echo $__env->make('layouts/sections/scripts', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    

    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::scripts(); ?>

    
    <script>
        // Menu Submenu Toggle
        window.toggleSubmenu = function(event, element) {
            event.preventDefault();
            const menuItem = element.closest('.menu-item');
            
            if (menuItem) {
                // Toggle open class
                if (menuItem.classList.contains('open')) {
                    menuItem.classList.remove('open');
                } else {
                    // Close other open submenus
                    document.querySelectorAll('.menu-item.open').forEach(item => {
                        if (item !== menuItem) {
                            item.classList.remove('open');
                        }
                    });
                    menuItem.classList.add('open');
                }
            }
        };
        
        // Menu Toggle Functionality
        if (!window.searchInitialized) {
            window.searchInitialized = true;
            window.searchTimeout = window.searchTimeout || null;
        const searchInput = document.getElementById('globalSearch');
        const searchResults = document.getElementById('searchResults');
        const searchContent = document.getElementById('searchContent');
        
        if (searchInput) {
            // Position search results dynamically
            function positionSearchResults() {
                if (searchInput && searchResults) {
                    const rect = searchInput.getBoundingClientRect();
                    searchResults.style.top = (rect.bottom + 8) + 'px';
                    searchResults.style.left = (rect.right - 450) + 'px'; // Align right edge
                }
            }
            
            searchInput.addEventListener('input', function(e) {
                const query = e.target.value.trim();
                
                clearTimeout(searchTimeout);
                
                if (query.length < 2) {
                    searchResults.style.display = 'none';
                    return;
                }
                
                searchTimeout = setTimeout(() => {
                    positionSearchResults();
                    performSearch(query);
                }, 300);
            });
            
            searchInput.addEventListener('focus', function() {
                if (searchInput.value.trim().length >= 2) {
                    positionSearchResults();
                    searchResults.style.display = 'block';
                }
            });
            
            // Reposition on window resize
            window.addEventListener('resize', function() {
                if (searchResults.style.display === 'block') {
                    positionSearchResults();
                }
            });
            
            // Close search results when clicking outside
            document.addEventListener('click', function(e) {
                if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
                    searchResults.style.display = 'none';
                }
            });
        }
        
        function performSearch(query) {
            searchContent.innerHTML = `
                <div class="p-4 text-center">
                    <span class="spinner-border spinner-border-sm text-primary" role="status"></span>
                    <span class="ms-2 text-muted">Searching...</span>
                </div>
            `;
            searchResults.style.display = 'block';
            
            fetch(`/search?query=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(data => {
                    displaySearchResults(data);
                })
                .catch(error => {
                    searchContent.innerHTML = `
                        <div class="p-4 text-center">
                            <i class="ri-error-warning-line ri-2x text-danger mb-2"></i>
                            <p class="text-danger mb-0">Error searching. Please try again.</p>
                        </div>
                    `;
                });
        }
        
        function displaySearchResults(data) {
            if (data.total === 0) {
                searchContent.innerHTML = `
                    <div class="p-4 text-center">
                        <i class="ri-search-line ri-3x text-muted mb-3 d-block"></i>
                        <p class="text-muted mb-0">No results found for "${data.query}"</p>
                    </div>
                `;
                return;
            }
            
            let html = '<div class="p-3">';
            
            // Products
            if (data.results.products.length > 0) {
                html += `
                    <div class="mb-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="avatar avatar-sm me-2">
                                <span class="avatar-initial rounded bg-label-primary">
                                    <i class="ri-stack-line"></i>
                                </span>
                            </div>
                            <h6 class="mb-0">Products</h6>
                        </div>
                `;
                data.results.products.forEach(item => {
                    html += `
                        <a href="${item.url}" class="dropdown-item rounded mb-2 p-3" wire:navigate style="transition: all 0.2s;">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="flex-grow-1">
                                    <div class="fw-semibold text-dark">${item.name}</div>
                                    <div class="small text-muted mt-1">
                                        <span class="badge bg-label-success me-1">Stock: ${item.stock}</span>
                                        <span class="badge bg-label-primary">$${parseFloat(item.price).toFixed(2)}</span>
                                    </div>
                                </div>
                                <i class="ri-arrow-right-line text-muted"></i>
                            </div>
                        </a>
                    `;
                });
                html += '</div>';
            }
            
            // Customers
            if (data.results.customers.length > 0) {
                html += `
                    <div class="mb-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="avatar avatar-sm me-2">
                                <span class="avatar-initial rounded bg-label-success">
                                    <i class="ri-user-line"></i>
                                </span>
                            </div>
                            <h6 class="mb-0">Customers</h6>
                        </div>
                `;
                data.results.customers.forEach(item => {
                    html += `
                        <a href="${item.url}" class="dropdown-item rounded mb-2 p-3" wire:navigate style="transition: all 0.2s;">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="flex-grow-1">
                                    <div class="fw-semibold text-dark">${item.name}</div>
                                    <div class="small text-muted mt-1">
                                        ${item.email ? '<i class="ri-mail-line me-1"></i>' + item.email : ''}
                                        ${item.phone ? '<i class="ri-phone-line ms-2 me-1"></i>' + item.phone : ''}
                                    </div>
                                </div>
                                <i class="ri-arrow-right-line text-muted"></i>
                            </div>
                        </a>
                    `;
                });
                html += '</div>';
            }
            
            // Orders
            if (data.results.orders.length > 0) {
                html += `
                    <div class="mb-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="avatar avatar-sm me-2">
                                <span class="avatar-initial rounded bg-label-info">
                                    <i class="ri-shopping-cart-line"></i>
                                </span>
                            </div>
                            <h6 class="mb-0">Orders</h6>
                        </div>
                `;
                data.results.orders.forEach(item => {
                    html += `
                        <a href="${item.url}" class="dropdown-item rounded mb-2 p-3" wire:navigate style="transition: all 0.2s;">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="flex-grow-1">
                                    <div class="fw-semibold text-dark">${item.order_number}</div>
                                    <div class="small text-muted mt-1">
                                        <span>${item.customer}</span>
                                        <span class="badge bg-label-info ms-2">$${parseFloat(item.total_amount).toFixed(2)}</span>
                                    </div>
                                </div>
                                <i class="ri-arrow-right-line text-muted"></i>
                            </div>
                        </a>
                    `;
                });
                html += '</div>';
            }
            
            // Invoices
            if (data.results.invoices.length > 0) {
                html += `
                    <div class="mb-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="avatar avatar-sm me-2">
                                <span class="avatar-initial rounded bg-label-warning">
                                    <i class="ri-file-list-line"></i>
                                </span>
                            </div>
                            <h6 class="mb-0">Invoices</h6>
                        </div>
                `;
                data.results.invoices.forEach(item => {
                    html += `
                        <a href="${item.url}" class="dropdown-item rounded mb-2 p-3" wire:navigate style="transition: all 0.2s;">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="flex-grow-1">
                                    <div class="fw-semibold text-dark">${item.name}</div>
                                    <div class="small text-muted mt-1">
                                        <span>${item.customer}</span>
                                        <span class="badge bg-label-warning ms-2">$${parseFloat(item.amount).toFixed(2)}</span>
                                    </div>
                                </div>
                                <i class="ri-arrow-right-line text-muted"></i>
                            </div>
                        </a>
                    `;
                });
                html += '</div>';
            }
            
            // Employees
            if (data.results.employees.length > 0) {
                html += `
                    <div class="mb-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="avatar avatar-sm me-2">
                                <span class="avatar-initial rounded bg-label-secondary">
                                    <i class="ri-team-line"></i>
                                </span>
                            </div>
                            <h6 class="mb-0">Employees</h6>
                        </div>
                `;
                data.results.employees.forEach(item => {
                    html += `
                        <a href="${item.url}" class="dropdown-item rounded mb-2 p-3" wire:navigate style="transition: all 0.2s;">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="flex-grow-1">
                                    <div class="fw-semibold text-dark">${item.name}</div>
                                    <div class="small text-muted mt-1">
                                        ${item.position ? '<span class="badge bg-label-secondary">' + item.position + '</span>' : ''}
                                        ${item.email ? '<span class="ms-2">' + item.email + '</span>' : ''}
                                    </div>
                                </div>
                                <i class="ri-arrow-right-line text-muted"></i>
                            </div>
                        </a>
                    `;
                });
                html += '</div>';
            }
            
            // Suppliers
            if (data.results.suppliers.length > 0) {
                html += `
                    <div class="mb-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="avatar avatar-sm me-2">
                                <span class="avatar-initial rounded bg-label-dark">
                                    <i class="ri-truck-line"></i>
                                </span>
                            </div>
                            <h6 class="mb-0">Suppliers</h6>
                        </div>
                `;
                data.results.suppliers.forEach(item => {
                    html += `
                        <a href="${item.url}" class="dropdown-item rounded mb-2 p-3" wire:navigate style="transition: all 0.2s;">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="flex-grow-1">
                                    <div class="fw-semibold text-dark">${item.name}</div>
                                    <div class="small text-muted mt-1">
                                        ${item.email ? '<i class="ri-mail-line me-1"></i>' + item.email : ''}
                                        ${item.phone ? '<i class="ri-phone-line ms-2 me-1"></i>' + item.phone : ''}
                                    </div>
                                </div>
                                <i class="ri-arrow-right-line text-muted"></i>
                            </div>
                        </a>
                    `;
                });
                html += '</div>';
            }
            
            html += `
                </div>
                <div class="dropdown-divider my-0"></div>
                <div class="p-3 text-center bg-light">
                    <small class="text-muted fw-semibold">
                        <i class="ri-search-2-line me-1"></i>
                        Found ${data.total} result(s) for "${data.query}"
                    </small>
                </div>
            `;
            
            searchContent.innerHTML = html;
            
            // Add hover effect
            document.querySelectorAll('#searchResults .dropdown-item').forEach(item => {
                item.addEventListener('mouseenter', function() {
                    this.style.backgroundColor = '#f8f9fa';
                    this.style.transform = 'translateX(4px)';
                });
                item.addEventListener('mouseleave', function() {
                    this.style.backgroundColor = '';
                    this.style.transform = '';
                });
            });
        }
        }
        
        // Menu Toggle Functionality
        window.toggleMenu = function(event) {
            if (event) {
                event.preventDefault();
                event.stopPropagation();
            }
            
            const layout = document.querySelector('.layout-wrapper');
            const overlay = document.querySelector('.layout-overlay');
            
            if (!layout) return;
            
            // Toggle menu open/close
            if (layout.classList.contains('layout-menu-expanded')) {
                layout.classList.remove('layout-menu-expanded');
                if (overlay) overlay.classList.remove('active');
            } else {
                layout.classList.add('layout-menu-expanded');
                if (overlay) overlay.classList.add('active');
            }
        };
        
        // Initialize menu functionality when DOM is ready
        document.addEventListener('DOMContentLoaded', function() {
            const overlay = document.querySelector('.layout-overlay');
            const menuToggle = document.querySelector('.layout-menu-toggle');
            
            // Close menu when clicking overlay
            if (overlay) {
                overlay.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    const layout = document.querySelector('.layout-wrapper');
                    if (layout && layout.classList.contains('layout-menu-expanded')) {
                        layout.classList.remove('layout-menu-expanded');
                        overlay.classList.remove('active');
                    }
                });
            }
            
            // Close menu on mobile when clicking a menu item
            const menuLinks = document.querySelectorAll('.menu-item .menu-link');
            menuLinks.forEach(link => {
                link.addEventListener('click', function() {
                    if (window.innerWidth < 1200) {
                        const layout = document.querySelector('.layout-wrapper');
                        const overlay = document.querySelector('.layout-overlay');
                        
                        setTimeout(() => {
                            if (layout) layout.classList.remove('layout-menu-expanded');
                            if (overlay) overlay.classList.remove('active');
                        }, 100);
                    }
                });
            });
        });
        
        // Re-initialize after Livewire navigation
        document.addEventListener('livewire:navigated', function() {
            const menuLinks = document.querySelectorAll('.menu-item .menu-link');
            menuLinks.forEach(link => {
                link.addEventListener('click', function() {
                    if (window.innerWidth < 1200) {
                        const layout = document.querySelector('.layout-wrapper');
                        const overlay = document.querySelector('.layout-overlay');
                        
                        setTimeout(() => {
                            if (layout) layout.classList.remove('layout-menu-expanded');
                            if (overlay) overlay.classList.remove('active');
                        }, 100);
                    }
                });
            });
        });
        
        // Global loading state
        window.pageLoader = window.pageLoader || document.getElementById('pageLoader');
        window.loaderTimeout = window.loaderTimeout || null;
        
        function showLoader() {
            if (window.pageLoader) {
                window.pageLoader.classList.add('active');
            }
        }

        function hideLoader() {
            if (window.pageLoader) {
                // Ensure loader shows for at least 300ms for better UX
                if (window.loaderTimeout) clearTimeout(window.loaderTimeout);
                window.loaderTimeout = setTimeout(() => {
                    window.pageLoader.classList.remove('active');
                }, 300);
            }
        }
        
        // Manual loader trigger for menu navigation
        document.addEventListener('DOMContentLoaded', function() {
            // Add click listeners to all wire:navigate links
            document.querySelectorAll('a[wire\\:navigate]').forEach(link => {
                link.addEventListener('click', function(e) {
                    showLoader();
                });
            });
        });
        
        // Show loader on Livewire navigation
        document.addEventListener('livewire:navigating', () => {
            showLoader();
        });
        
        document.addEventListener('livewire:navigated', () => {
            hideLoader();
        });
        
        // Alternative: Use Livewire hooks for more reliable loading
        document.addEventListener('livewire:init', () => {
            // Hook into navigation start
            Livewire.hook('before', ({ component, commit, succeed, fail, update }) => {
                showLoader();
            });
            
            // Hook into navigation completion
            Livewire.hook('after', ({ component, commit, succeed, fail, update }) => {
                hideLoader();
            });
            
            // Also listen for request/response cycle
            Livewire.hook('request', ({ uri, options, payload, respond, succeed, fail }) => {
                showLoader();
            });
            
            Livewire.hook('response', ({ request, response, succeed, fail }) => {
                hideLoader();
            });
        });
        
        // Show loader on form submissions
        window.addEventListener('beforeunload', () => {
            window.pageLoader?.classList.add('active');
        });
        
        // Hide loader when page is fully loaded
        window.addEventListener('load', () => {
            window.pageLoader?.classList.remove('active');
        });
    </script>
</body>
</html>
<?php /**PATH D:\School-Projects\Software-dev\Kessly\resources\views/layouts/commonMaster.blade.php ENDPATH**/ ?>