<x-admin-layout>
    @section('title', __( 'Reviews overzicht'))
    <h1 class="text-3xl font-semibold tracking-tight">{{ __('Reviews') }}</h1>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-2 mt-4 pb-16">
        <div class="flex w-full justify-between items-start">
            <x-store-switcher></x-store-switcher>
        </div>
        <x-table
            :data="$reviews->items()"
            :headers="['ID', __('Beoordeling'), __('Commentaar'), __('Geplaatst op'), __('Pakket ID')]"
            :fields="['id', 'rating', 'comment', 'created_at', 'shipment_id']"
            :baseRoute="'store.reviews'"
            :pageLinks="$reviews->links()"
            :currentPage="$reviews->currentPage()"
            :perPage="$reviews->perPage()"
            :sortField="$sortField"
            :sortDirection="$sortDirection"
            :sortableFields="$sortableFields"
        />
    </div>
</x-admin-layout>
