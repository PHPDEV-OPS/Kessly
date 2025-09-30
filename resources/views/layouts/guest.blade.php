<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        
        <!-- Volt CSS -->
        <style>
            .bg-soft {
                background-color: #f8f9fa !important;
            }
            .vh-lg-100 {
                min-height: 100vh;
            }
            .form-bg-image {
                background-size: cover;
                background-position: center;
                background-repeat: no-repeat;
            }
            .fmxw-500 {
                max-width: 500px;
            }
            .btn-gray-800 {
                background-color: #1f2937;
                border-color: #1f2937;
                color: #ffffff;
            }
            .btn-gray-800:hover {
                background-color: #111827;
                border-color: #111827;
                color: #ffffff;
            }
            .icon {
                width: 1rem;
                height: 1rem;
            }
            .icon-xs {
                width: 0.75rem;
                height: 0.75rem;
            }
            .icon-xxs {
                width: 0.625rem;
                height: 0.625rem;
            }
            .text-gray-600 {
                color: #4b5563;
            }
            .border-light {
                border-color: #e5e7eb !important;
            }
            .shadow-soft {
                box-shadow: 0 0.125rem 0.625rem rgba(0, 0, 0, 0.09);
            }
            .btn-icon-only {
                width: 2.5rem;
                height: 2.5rem;
                padding: 0;
                display: inline-flex;
                align-items: center;
                justify-content: center;
            }
            .btn-pill {
                border-radius: 50rem;
            }
            .btn-outline-gray-500 {
                color: #6b7280;
                border-color: #6b7280;
                background-color: transparent;
            }
            .btn-outline-gray-500:hover {
                color: #ffffff;
                background-color: #6b7280;
                border-color: #6b7280;
            }
            .form-bg-image[data-background-lg] {
                background-image: url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAwIiBoZWlnaHQ9IjQwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4gPGRlZnM+IDxsaW5lYXJHcmFkaWVudCBpZD0iYSIgeDE9IjAlIiB5MT0iMCUiIHgyPSIwJSIgeTI9IjEwMCUiPiA8c3RvcCBvZmZzZXQ9IjAlIiBzdHlsZT0ic3RvcC1jb2xvcjojNjc4M0ZGO3N0b3Atb3BhY2l0eToxIiAvPiA8c3RvcCBvZmZzZXQ9IjEwMCUiIHN0eWxlPSJzdG9wLWNvbG9yOiM0RjQ2RTU7c3RvcC1vcGFjaXR5OjEiIC8+IDwvbGluZWFyR3JhZGllbnQ+IDwvZGVmcz4gPHJlY3Qgd2lkdGg9IjEwMCUiIGhlaWdodD0iMTAwJSIgZmlsbD0idXJsKCNhKSIgLz4gPC9zdmc+');
                background-size: cover;
                background-position: center;
            }
            .invalid-feedback.d-block {
                display: block !important;
            }
        </style>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        {{ $slot }}
        
        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
