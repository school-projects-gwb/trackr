<x-admin-layout>
    @section('title', __( 'Webwinkel'))
    <h1 class="text-3xl font-semibold tracking-tight">Webwinkel aanmaken</h1>

    <div class="bg-primary overflow-hidden shadow-sm sm:rounded-lg p-2 mt-4">
        <div class="flex p-2">
            <x-link-inline href="{{ route('store.stores.overview') }}">{{ __('Terug naar overzicht') }}</x-link-inline>
        </div>
        <div class="flex p-2 flex-col w-11/12 lg:w-1/2">
            <h2 class="text-2xl font-bold tracking-tight my-4">{{ __('Basisgegevens') }}</h2>
            <form method="POST" action="{{ route('store.stores.store') }}">
                @csrf
                <div>
                    <x-input-label for="name" :value="__('Naam winkel')" />
                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <h2 class="text-2xl font-bold tracking-tight mb-4 mt-8">{{ __('Adresgegevens') }}</h2>

                <div class="mt-4">
                    <x-input-label for="first_name" :value="__('Voornaam')" />
                    <x-text-input id="first_name" class="block mt-1 w-full" type="text" name="first_name" :value="old('first_name')" required autofocus autocomplete="first_name" />
                    <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label for="last_name" :value="__('Achternaam')" />
                    <x-text-input id="last_name" class="block mt-1 w-full" type="text" name="last_name" :value="old('last_name')" required autofocus autocomplete="last_name" />
                    <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label for="street_name" :value="__('Straatnaam')" />
                    <x-text-input id="street_name" class="block mt-1 w-full" type="text" name="street_name" :value="old('street_name')" required autofocus autocomplete="street_name" />
                    <x-input-error :messages="$errors->get('street_name')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label for="house_number" :value="__('Huisnummer')" />
                    <x-text-input id="house_number" class="block mt-1 w-full" type="text" name="house_number" :value="old('house_number')" required autofocus autocomplete="house_number" />
                    <x-input-error :messages="$errors->get('house_number')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label for="postal_code" :value="__('Postcode')" />
                    <x-text-input id="postal_code" class="block mt-1 w-full" type="text" name="postal_code" :value="old('postal_code')" required autofocus autocomplete="postal_code" />
                    <x-input-error :messages="$errors->get('postal_code')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label for="city" :value="__('Stad')" />
                    <x-text-input id="city" class="block mt-1 w-full" type="text" name="city" :value="old('city')" required autofocus autocomplete="city" />
                    <x-input-error :messages="$errors->get('city')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label for="country" :value="__('Land')" />
                    <x-text-input id="country" class="block mt-1 w-full" type="text" name="country" :value="old('country')" required autofocus autocomplete="country" />
                    <x-input-error :messages="$errors->get('country')" class="mt-2" />
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
