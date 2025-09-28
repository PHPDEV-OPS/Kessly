<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;

new #[Layout('components.layouts.app')] class extends Component {
    //
}; ?>

<div>
    //
    <div class="p-4">
        <h1 class="text-2xl font-bold mb-4">Reports Dashboard</h1>
        <livewire:settings.company-profile />
        <livewire:settings.roles />
        <livewire:settings.users />
    </div>    
</div>
