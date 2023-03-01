<x-admin-layout>
    <h1 class="text-3xl font-semibold tracking-tight">{{ __('Webwinkelbeheer') }}</h1>

    <x-table
        :data="$stores"
        :headers="['Naam', 'Datum laatste update', 'Datum creatie', 'Acties']"
        :fields="['name', 'updated_at', 'created_at']"
        :baseRoute="'store.stores'"
    />
</x-admin-layout>
