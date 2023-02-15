<x-admin-layout>
    <h1 class="text-3xl font-semibold tracking-tight">Webwinkel aanmaken</h1>

    <div class="bg-primary overflow-hidden shadow-sm sm:rounded-lg p-2 mt-4">
        <div class="flex p-2">
            <x-link-inline href="{{ route('store.stores.overview') }}">{{ __('Terug naar overzicht') }}</x-link-inline>
        </div>
        <div class="flex p-2 flex-col w-11/12 lg:w-1/2">
            <form method="POST" action="{{ route('store.stores.store') }}">
                @csrf

                <div>
                    <x-input-label for="name" :value="__('Naam')" />
                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <div class="mt-4">
                </div>

                <div class="flex items-center mt-8">
                    <x-button-primary>
                        {{ __('Webwinkel aanmaken') }}
                    </x-button-primary>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>