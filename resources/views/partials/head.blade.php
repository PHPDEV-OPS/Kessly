<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<title>{{ $title ?? config('app.name') }}</title>

<link rel="icon" href="/favicon.ico" sizes="any">
<link rel="icon" href="/favicon.svg" type="image/svg+xml">
<link rel="apple-touch-icon" href="/apple-touch-icon.png">

<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

@vite(['resources/css/app.css', 'resources/js/app.js'])
@fluxAppearance

<script>
    // Responsive layout helpers: compute header & sidebar sizes and install mobile behaviors
    function setLayoutCssVars() {
        const header = document.querySelector('flux\\:header, [flux\\:header], .mobile-header-modern');
        const sidebar = document.querySelector('flux\\:sidebar, [flux\\:sidebar]');

        const headerHeight = header ? header.getBoundingClientRect().height : 56;
        const sidebarWidth = sidebar ? Math.min(256, Math.max(200, sidebar.getBoundingClientRect().width || 256)) : 256;

        document.documentElement.style.setProperty('--flux-header-height', headerHeight + 'px');
        document.documentElement.style.setProperty('--flux-sidebar-width', sidebarWidth + 'px');
    }

    function installMobileSidebarBehavior() {
        const sidebar = document.querySelector('flux\\:sidebar, [flux\\:sidebar]');
        if (!sidebar) return;

        // Create or reuse a backdrop element that sits under the sidebar
        let backdrop = document.getElementById('flux-mobile-backdrop');
        if (!backdrop) {
            backdrop = document.createElement('div');
            backdrop.id = 'flux-mobile-backdrop';
            document.body.appendChild(backdrop);
        }

        // Clicking the backdrop should stash (close) the sidebar by setting data-stashed
        backdrop.addEventListener('click', function() {
            // Many sidebar implementations toggle a data-stashed attribute; set it to hide
            sidebar.setAttribute('data-stashed', '');
            // Also set inline transform to hide immediately in case the flux script uses another mechanism
            sidebar.style.transform = 'translateX(-100%)';
            sidebar.style.transition = 'transform 0.25s ease';
            backdrop.style.display = 'none';
            // restore body scrolling
            document.body.style.overflow = '';
        });

        // Observe sidebar attributes to show/hide the backdrop when sidebar opens/closes
        function updateBackdropVisibility() {
            // Determine if sidebar appears open by checking attribute OR computed position
            const hasAttr = sidebar.hasAttribute('data-stashed') === true;
            const rect = sidebar.getBoundingClientRect();
            const isVisibleByPosition = rect.right > 0 && rect.left >= 0; // visible if left is >= 0
            const isOpen = !hasAttr && isVisibleByPosition;
            backdrop.style.display = isOpen ? 'block' : 'none';
            // prevent body scrolling when sidebar open
            document.body.style.overflow = isOpen ? 'hidden' : '';
        }

        const observer = new MutationObserver(muts => {
            // Attribute changes may not capture every method of opening/closing
            // so recalc visibility to be safe
            updateBackdropVisibility();
        });

        observer.observe(sidebar, { attributes: true, attributeFilter: ['data-stashed', 'style', 'class'] });

        // Also recalc when window resizes or orientation changes
        window.addEventListener('resize', updateBackdropVisibility);
        window.addEventListener('orientationchange', updateBackdropVisibility);

        // On initial run, set backdrop visibility based on current sidebar state
        updateBackdropVisibility();

        // Close sidebar after navigation for mobile by stashing it (do not simulate button clicks)
        sidebar.querySelectorAll('a[wire\\:navigate], a[data-navigate], a').forEach(link => {
            link.addEventListener('click', function() {
                setTimeout(() => {
                    if (window.innerWidth < 1024) {
                        sidebar.setAttribute('data-stashed', '');
                        sidebar.style.transform = 'translateX(-100%)';
                        backdrop.style.display = 'none';
                    }
                }, 120);
            });
        });
    }

    // Run on start and Livewire navigations
    function initResponsiveHelpers() {
        setLayoutCssVars();
        installMobileSidebarBehavior();
    }

    document.addEventListener('DOMContentLoaded', initResponsiveHelpers);
    document.addEventListener('livewire:navigated', initResponsiveHelpers);

    // Update on resize but debounce
    let _resizeTimer;
    window.addEventListener('resize', function() {
        clearTimeout(_resizeTimer);
        _resizeTimer = setTimeout(() => {
            setLayoutCssVars();
        }, 200);
    });

    // Watch for clicks on flux:sidebar.toggle (hamburger/x) to sync backdrop state
    document.addEventListener('click', function(e) {
        const toggle = e.target.closest('flux\\:sidebar\\.toggle, [flux\\:sidebar] .toggle, [icon="bars-2"], [icon="bars-3"], [icon="x-mark"]');
        if (!toggle) return;

        // Small debounce to allow any UI code that toggles data attributes to run first
        setTimeout(() => {
            const sidebar = document.querySelector('flux\\:sidebar, [flux\\:sidebar]');
            const backdrop = document.getElementById('flux-mobile-backdrop');
            if (!sidebar || !backdrop) return;
            const isStashed = sidebar.hasAttribute('data-stashed');
            backdrop.style.display = isStashed ? 'none' : 'block';
        }, 60);
    }, true);
</script>
