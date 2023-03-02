<x-admin-layout>
    <h1 class="text-3xl font-semibold tracking-tight">{{ __('Webwinkelbeheer') }}</h1>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-2 mt-4">
        <div class="flex justify-end p-2">
            <x-link-primary href="{{ route('store.stores.create') }}">{{ __('Webwinkel aanmaken') }}</x-link-primary>
        </div>
        <x-table
            :data="$stores->items()"
            :headers="['Naam', 'Datum laatste update', 'Datum creatie', 'Acties']"
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
