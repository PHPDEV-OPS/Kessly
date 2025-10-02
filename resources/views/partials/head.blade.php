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
    // Fix sticky sidebar layout spacing issues and mobile responsiveness
    document.addEventListener('DOMContentLoaded', function() {
        fixLayoutSpacing();
        setupMobileSidebar();
    });

    // Also run on Livewire navigation
    document.addEventListener('livewire:navigated', function() {
        fixLayoutSpacing();
        setupMobileSidebar();
    });

    function fixLayoutSpacing() {
        // Force remove all top spacing from main content
        const mainElements = document.querySelectorAll('main, [flux\\:main], .main-content-wrapper, .main-content');
        mainElements.forEach(element => {
            element.style.marginTop = '0';
            element.style.top = '0';
        });

        // Fix body layout
        document.body.style.marginTop = '0';
        
        // Ensure sidebar positioning on desktop
        if (window.innerWidth >= 1024) {
            const sidebar = document.querySelector('[flux\\:sidebar], flux\\:sidebar');
            if (sidebar) {
                sidebar.style.position = 'sticky';
                sidebar.style.top = '0';
                sidebar.style.alignSelf = 'start';
            }
        }
    }

    function setupMobileSidebar() {
        if (window.innerWidth < 1024) {
            const sidebar = document.querySelector('[flux\\:sidebar], flux\\:sidebar');
            
            if (sidebar) {
                // Close sidebar when clicking backdrop
                sidebar.addEventListener('click', function(e) {
                    // Check if click is on the backdrop (pseudo-element area)
                    const rect = sidebar.getBoundingClientRect();
                    if (e.clientX > rect.right) {
                        // Click is outside sidebar, close it
                        const toggleButton = document.querySelector('flux\\:sidebar\\.toggle[icon="x-mark"], [icon="x-mark"]');
                        if (toggleButton) {
                            toggleButton.click();
                        }
                    }
                });

                // Close sidebar when navigation occurs
                sidebar.querySelectorAll('a[wire\\:navigate]').forEach(link => {
                    link.addEventListener('click', function() {
                        setTimeout(() => {
                            const toggleButton = document.querySelector('flux\\:sidebar\\.toggle[icon="x-mark"], [icon="x-mark"]');
                            if (toggleButton && window.innerWidth < 1024) {
                                toggleButton.click();
                            }
                        }, 100);
                    });
                });
            }
        }
    }

    // Handle window resize
    let resizeTimer;
    window.addEventListener('resize', function() {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function() {
            fixLayoutSpacing();
            setupMobileSidebar();
        }, 250);
    });
</script>
