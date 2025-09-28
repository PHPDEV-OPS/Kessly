<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;

new #[Layout('components.layouts.app')] class extends Component {
    //
}; ?>

<div>
    //
    <div class="p-4">
        <h1 class="text-2xl font-bold mb-4">Inventory Management</h1>
        <livewire:inventory.products />
        <livewire:inventory.categories />
        <livewire:inventory.suppliers />
    </div>
</div>
