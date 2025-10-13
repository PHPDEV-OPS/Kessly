@php
    $companyLogo = \App\Models\Setting::getCompanyLogo();
@endphp

<div class="flex aspect-square size-8 items-center justify-center rounded-md {{ $companyLogo ? 'bg-white' : 'bg-accent-content text-accent-foreground' }}">
    @if($companyLogo)
        <img src="{{ $companyLogo }}" alt="Company Logo" class="size-7 object-contain rounded">
    @else
        <x-app-logo-icon class="size-5 fill-current text-white" />
    @endif
</div>
<div class="ms-1 grid flex-1 text-start text-sm">
    <span class="mb-0.5 truncate leading-tight font-semibold">{{ \App\Models\Setting::getCompanyName() }}</span>
</div>
