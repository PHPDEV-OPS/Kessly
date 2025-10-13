<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white antialiased">
        <div class="bg-background flex min-h-svh flex-col items-center justify-center gap-6 p-6 md:p-10">
            <div class="flex w-full max-w-sm flex-col gap-2">
                <a href="{{ route('home') }}" class="flex flex-col items-center gap-2 font-medium" wire:navigate>
                    @php
                        $companyLogo = \App\Models\Setting::getCompanyLogo();
                        $companyName = \App\Models\Setting::getCompanyName();
                    @endphp
                    
                    <span class="flex h-9 w-9 mb-1 items-center justify-center rounded-md {{ $companyLogo ? 'bg-white border border-gray-200' : '' }}">
                        @if($companyLogo)
                            <img src="{{ $companyLogo }}" alt="{{ $companyName }} Logo" class="size-8 object-contain rounded">
                        @else
                            <x-app-logo-icon class="size-9 fill-current text-black" />
                        @endif
                    </span>
                    <span class="sr-only">{{ $companyName }}</span>
                </a>
                <div class="flex flex-col gap-6">
                    {{ $slot }}
                </div>
            </div>
        </div>
        @fluxScripts
    </body>
</html>
