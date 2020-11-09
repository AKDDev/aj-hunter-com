<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
        <link rel="manifest" href="/site.webmanifest">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <!--link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap"-->
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans&family=Satisfy&display=swap" rel="stylesheet">
        <script src="https://kit.fontawesome.com/d3736a4208.js" crossorigin="anonymous"></script>

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">

        <livewire:styles />

        <!-- Scripts -->
        <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.7.0/dist/alpine.js" defer></script>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 flex flex-col min-h-screen ">
            <livewire:navigation-dropdown/>

            <x-flash-messages></x-flash-messages>

            <!-- Page Content -->
            <main class="p-5 flex-grow">
                {{ $slot }}
            </main>

            <footer class="text-sm p-2">
                Copyright &copy; 2011 - {{ date('Y') }} All Rights Reserved - AJ Hunter |
                Site Created by <a href="http://akddev.net">AKD Development</a>
            </footer>
        </div>

        @stack('modals')

        <livewire:scripts />
    </body>
</html>
