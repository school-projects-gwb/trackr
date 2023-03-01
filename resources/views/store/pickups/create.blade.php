<x-admin-layout>
    <h1 class="text-3xl font-semibold tracking-tight">{{ __('Pickup aanmaken') }}</h1>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-2 mt-4 pb-16">
        <div class="flex p-2">
            <x-link-inline href="{{ route('store.pickups.overview') }}">{{ __('Terug naar overzicht') }}</x-link-inline>
        </div>
    </div>
</x-admin-layout>
