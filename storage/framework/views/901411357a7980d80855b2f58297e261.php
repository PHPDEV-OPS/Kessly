<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;

?>

<div>
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Dashboard</h4>
            <p class="text-muted mb-0">Welcome to your SCM system overview</p>
        </div>
    </div>

    <!-- Dashboard Content -->
    <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('dashboard', []);

$__html = app('livewire')->mount($__name, $__params, 'lw-4241004920-1', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
</div><?php /**PATH D:\School-Projects\Software-dev\Kessly\resources\views\livewire\pages\dashboard.blade.php ENDPATH**/ ?>