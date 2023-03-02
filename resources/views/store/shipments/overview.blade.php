<x-admin-layout>
    <h1 class="text-3xl font-semibold tracking-tight">{{ __('Pakketbeheer') }}</h1>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-2 mt-4 pb-16">
        <div class="flex w-full justify-between items-center">
            <x-store-switcher></x-store-switcher>
            <div class="flex justify-end p-2">
                <x-link-primary href="{{ route('store.shipments.create') }}">{{ __('Pakket aanmaken') }}</x-link-primary>
            </div>
        </div>
        <x-table
            :data="$shipments->items()"
            :headers="['ID', 'Tracking Number', 'Status', 'Vervoerder', 'Datum creatie', 'Acties']"
            :fields="['id', 'tracking_number', 'ShipmentStatuses', 'carrier', 'created_at']"
            :baseRoute="'store.shipments'"
            :pageLinks="$shipments->links()"
            :currentPage="$shipments->currentPage()"
            :perPage="$shipments->perPage()"
            :sortField="$sortField"
            :sortDirection="$sortDirection"
            :sortableFields="$sortableFields"
            :filterValues="$filterValues"
        />
    </div>
</x-admin-layout>
