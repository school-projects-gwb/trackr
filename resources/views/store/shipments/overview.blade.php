<x-admin-layout>
    <h1 class="text-3xl font-semibold tracking-tight">{{ __('Pakketbeheer') }}</h1>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-2 mt-4">
        <div class="flex justify-end p-2">
            <x-link-primary href="{{ route('store.shipments.create') }}">{{ __('Pakket aanmaken') }}</x-link-primary>
        </div>
    </div>
</x-admin-layout>
