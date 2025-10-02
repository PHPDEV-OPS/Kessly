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
    // Fix sticky sidebar layout spacing issues
    document.addEventListener('DOMContentLoaded', function() {
        fixLayoutSpacing();
    });

    // Also run on Livewire navigation
    document.addEventListener('livewire:navigated', function() {
        fixLayoutSpacing();
    });

    function fixLayoutSpacing() {
        // Force remove all top spacing from main content
        const mainElements = document.querySelectorAll('main, [flux\\:main], .main-content-wrapper, .main-content');
        mainElements.forEach(element => {
            element.style.marginTop = '0';
            element.style.paddingTop = '0';
            element.style.top = '0';
        });

        // Fix body grid layout
        document.body.style.marginTop = '0';
        document.body.style.paddingTop = '0';
        
        // Ensure sidebar doesn't push content down
        const sidebar = document.querySelector('[flux\\:sidebar], flux\\:sidebar');
        if (sidebar) {
            sidebar.style.position = 'sticky';
            sidebar.style.top = '0';
            sidebar.style.alignSelf = 'start';
        }

        // Reset scroll position
        window.scrollTo(0, 0);
    }
</script>
