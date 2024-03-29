<x-admin-layout>
    @section('title', __( 'Webwinkels overzicht'))
    <h1 class="text-3xl font-semibold tracking-tight">{{ __('Webwinkelbeheer') }}</h1>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-2 mt-4">
        <div class="flex justify-end p-2">
            <x-link-primary href="{{ route('store.stores.create') }}">{{ __('Webwinkel aanmaken') }}</x-link-primary>
        </div>
        <x-table
            :data="$stores->items()"
            :headers="[__('Naam'), __('Datum laatste update'), __('Datum creatie'), __('Acties')]"
            :fields="['name', 'updated_at', 'created_at']"
            :baseRoute="'store.stores'"
            :pageLinks="$stores->links()"
            :currentPage="$stores->currentPage()"
            :perPage="$stores->perPage()"
            :sortField="$sortField"
            :sortDirection="$sortDirection"
            :sortableFields="$sortableFields"
        />
    </div>
</x-admin-layout>
