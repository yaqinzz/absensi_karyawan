<!DOCTYPE html>
<html class="light" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'ProPay Enterprise') }}</title>

        <!-- Fonts & Icons -->
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet"/>
        <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>

        <style>
            .material-symbols-outlined {
                font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            }
        </style>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-background font-body-md text-on-background antialiased flex flex-col min-h-screen">
        <div class="flex-grow flex items-center justify-center p-6">
            <div class="w-full max-w-[440px]">
                <!-- Brand Header -->
                <div class="text-center mb-xl">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-primary-container text-primary mb-md">
                        <span class="material-symbols-outlined text-4xl">domain</span>
                    </div>
                    <h1 class="font-h3 text-h3 font-bold text-primary">{{ config('app.name') }}</h1>
                    <p class="text-on-surface-variant text-body-md mt-sm">Secure Authentication Portal</p>
                </div>

                <!-- Form Card -->
                <div class="bg-surface-container-lowest p-xl rounded-2xl border border-outline-variant shadow-lg">
                    {{ $slot }}
                </div>
                
                <!-- Footer -->
                <div class="text-center mt-lg">
                    <p class="text-xs text-on-surface-variant">&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
                </div>
            </div>
        </div>
    </body>
</html>
