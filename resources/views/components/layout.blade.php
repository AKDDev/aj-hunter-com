<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
    </head>
    <body id="layout">
        <header>
            <x-logo />
            <x-menu />
            <x-social />
        </header>
        <main>
            <x-hero />
            {{ $slot }}
        </main>
        <footer>

        </footer>
    </body>
</html>
