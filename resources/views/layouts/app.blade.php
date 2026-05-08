<!DOCTYPE html>
<html class="light" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'PT. SINAR BRAWIJAYA GROUP') }}</title>

        <!-- Fonts & Icons -->
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet"/>
        <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
        
        <style>
            .material-symbols-outlined {
                font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            }
            .active-nav-pill {
                font-variation-settings: 'FILL' 1;
            }
        </style>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-background font-body-md text-on-background antialiased" x-data="{ mobileNavOpen: false }">
        @include('layouts.sidebar')
        
        <!-- Main Content Area -->
        <main class="lg:ml-sidebar-width min-h-screen flex flex-col">
            @include('layouts.topbar')
            @include('layouts.mobile-nav')

            <div class="p-lg space-y-lg flex-1">
                @isset($header)
                    <div class="mb-6">
                        {{ $header }}
                    </div>
                @endisset

                @include('components.flash')

                {{ $slot }}
            </div>
        </main>
        @stack('scripts')
    </body>
</html>
