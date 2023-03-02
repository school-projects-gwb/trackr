<x-admin-layout>
    <h1 class="text-3xl font-semibold tracking-tight">{{ __('Gebruikersbeheer') }}</h1>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-2 mt-4">
        <div class="flex justify-end p-2">
            <x-link-primary href="{{ route('store.users.create') }}">{{ __('Gebruiker aanmaken') }}</x-link-primary>
        </div>

        <x-table
            :data="$users"
            :headers="['Naam', 'Emailadres', 'Toegang winkels', 'Rollen', 'Acties']"
            :fields="['name', 'email', 'stores', 'getRoleNames']"
            :baseRoute="'store.users'"
        />
    </div>
</x-admin-layout>
