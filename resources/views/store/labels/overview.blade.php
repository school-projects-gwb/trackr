<x-admin-layout>
    @section('title', __( 'Labels overzicht'))
    <h1 class="text-3xl font-semibold tracking-tight">{{ __('Labels') }}</h1>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-2 mt-4 pb-16">
        <div class="flex w-full justify-between items-center">
            <x-store-switcher></x-store-switcher>
        </div>
    </div>
</x-admin-layout>
