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

<main class="w-full h-full bg-primary flex">
    <div class="absolute w-full flex justify-center">
        <div class="flex justify-between items-center w-full lg:w-3/4 py-4 px-2">
            <a href="/" class="cursor-pointer"><h1 class="text-3xl font-extrabold">Track<span class="text-darkgray">R</span></h1></a>
            <div>
                @if(!Route::is('login') )
                    @guest
                        <x-link-secondary class="font-bold text-xl px-8 px-2 rounded-xl" :href="route('login')">Inloggen</x-link-secondary>
                    @endguest

                    @auth
                        @role('SuperAdmin')
                        <x-link-secondary class="font-bold text-xl px-8 px-2 rounded-xl" :href="route('admin.dashboard')">Mijn TrackR</x-link-secondary>
                    @else
                        <x-link-secondary class="font-bold text-xl px-8 px-2 rounded-xl" :href="route('dashboard')">Mijn TrackR</x-link-secondary>
                        @endrole
                    @endauth
                @endif
            </div>
        </div>
    </div>
    {{ $slot }}
</main>
</body>
</html>
