<x-layouts.app.sidebar :title="$title ?? null">
    <flux:main>
        <div class="container-fluid">
            {{ $slot }}
        </div>
    </flux:main>
</x-layouts.app.sidebar>
