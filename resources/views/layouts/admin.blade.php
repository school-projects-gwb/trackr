<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">

    <div class="w-full min-h-full bg-primary flex flex-col lg:flex-row">
        @include('layouts.navigation-sidebar')
        <div class="w-full lg:w-3/4 p-4 lg:pb-0 lg:pr-0 lg:pt-16 lg:pl-16">
            <main>
                {{ $slot }}
            </main>
        </div>
    </div>
    </body>
</html>
