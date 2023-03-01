<x-admin-layout>
    <h1 class="text-3xl font-semibold tracking-tight">{{ __('Pickups') }}</h1>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-2 mt-4 pb-16">
        <div class="flex w-full justify-between items-center">
            <x-store-switcher></x-store-switcher>
            <div class="flex justify-end p-2">
                <x-link-primary href="{{ route('store.pickups.create') }}">{{ __('Pickup aanmaken') }}</x-link-primary>
            </div>
        </div>
    </div>
</x-admin-layout>
