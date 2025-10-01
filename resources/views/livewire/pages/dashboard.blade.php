<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;

new #[Layout('components.layouts.app')] class extends Component {
    //
}; ?>

<div>
    <!-- Page Navigation -->
    <x-page-navigation title="Dashboard" description="Welcome to your SCM system overview" :show-back="false" />

    <div class="p-4 sm:p-6">
        <livewire:dashboard />
    </div>
</div>