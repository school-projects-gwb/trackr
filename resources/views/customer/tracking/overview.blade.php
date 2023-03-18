<x-admin-layout>
    @section('title', __( 'Bewaarde bestellingen'))
    <h1 class="text-3xl font-semibold tracking-tight">{{ __('Bewaarde bestellingen') }}</h1>

    <div class="flex flex-col mt-8">
        <div class="flex justify-start mb-4">
            <x-link-secondary href="/">{{ __('Bestellingen zoeken') }}</x-link-secondary>
        </div>

        <x-table
            :data="$shipments->items()"
            :headers="['TrackR ID', __('Huidige status'), __('Acties')]"
            :fields="['tracking_number', 'ShipmentStatuses']"
            :baseRoute="'customer.tracking'"
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
