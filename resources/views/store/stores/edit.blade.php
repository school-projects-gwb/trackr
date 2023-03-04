<x-admin-layout>
    @section('title', __( 'Webwinkel bewerken'))
    <h1 class="text-3xl font-semibold tracking-tight">{{ __('Webwinkel bewerken') }}</h1>

    <div class="bg-primary overflow-hidden shadow-sm sm:rounded-lg p-2 mt-4">
        <div class="flex p-2">
            <x-link-inline href="{{ route('store.stores.overview') }}">{{ __('Terug naar overzicht') }}</x-link-inline>
        </div>
        <h2 class="text-2xl font-bold tracking-tight my-4">{{ __('Basisgegevens') }}</h2>
        <div class="flex p-4 flex-col w-11/12 bg-secondary-lighter rounded-xl">
            <form method="POST" action="{{ route('store.stores.update', $store) }}">
            @csrf
                <div>
                    <x-input-label for="name" :value="__('Naam')" />
                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" value="{{ $store->name }}" required autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <div class="mt-4 flex flex-col mt-8">
                    <h2 class="text-xl font-semibold">Gebruikers</h2>
                    <p class="text-sm mb-2">Gebruikers die toegang hebben tot deze winkel.</p>

                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Naam') }}</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Rol') }}</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Acties') }}</th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($store->users as $user)
                            <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $user->name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @foreach($user->getRoleNames() as $role)
                                            <span class="bg-gray-100 px-2 py-1 rounded-full uppercase text-sm">
                                               {{ $role }}
                                            </span>
                                        @endforeach
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <a class="underline font-semibold" target="_blank" href="{{route('store.users.edit', $user)}}">Naar gebruiker</a>
                                    </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    <x-input-error :messages="$errors->get('user_role')" class="mt-2" />
                </div>

                <div class="flex items-center mt-8">
                    <x-button-primary>
                        {{ __('Basisgegevens opslaan') }}
                    </x-button-primary>
                </div>
            </form>
        </div>
        <h2 class="text-2xl font-bold tracking-tight mb-4 mt-8"><{{ __('Adresgegevens') }}/h2>
        <div class="flex p-4 flex-col w-11/12 bg-secondary-lighter rounded-xl">
            <form method="POST" action="{{ route('store.stores.updateAddress', $store) }}">
                @csrf
                <div class="mt-4">
                    <x-input-label for="first_name" :value="__('Voornaam')" />
                    <x-text-input id="first_name" class="block mt-1 w-full" type="text" name="first_name" value="{{ $store->address->first_name }}" required autofocus autocomplete="first_name" />
                    <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label for="last_name" :value="__('Achternaam')" />
                    <x-text-input id="last_anem" class="block mt-1 w-full" type="text" name="last_name" value="{{ $store->address->last_name }}" required autofocus autocomplete="last_name" />
                    <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label for="street_name" :value="__('Straatnaam')" />
                    <x-text-input id="street_name" class="block mt-1 w-full" type="text" name="street_name" value="{{ $store->address->street_name }}" required autofocus autocomplete="street_name" />
                    <x-input-error :messages="$errors->get('street_name')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label for="house_number" :value="__('Huisnummer')" />
                    <x-text-input id="house_number" class="block mt-1 w-full" type="text" name="house_number" value="{{ $store->address->house_number }}" required autofocus autocomplete="house_number" />
                    <x-input-error :messages="$errors->get('house_number')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label for="postal_code" :value="__('Postcode')" />
                    <x-text-input id="postal_code" class="block mt-1 w-full" type="text" name="postal_code" value="{{ $store->address->postal_code }}" required autofocus autocomplete="postal_code" />
                    <x-input-error :messages="$errors->get('postal_code')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label for="city" :value="__('Stad')" />
                    <x-text-input id="city" class="block mt-1 w-full" type="text" name="city" value="{{ $store->address->city }}" required autofocus autocomplete="city" />
                    <x-input-error :messages="$errors->get('city')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label for="country" :value="__('Land')" />
                    <x-text-input id="country" class="block mt-1 w-full" type="text" name="country" value="{{ $store->address->country }}" required autofocus autocomplete="country" />
                    <x-input-error :messages="$errors->get('country')" class="mt-2" />
                </div>

                <div class="flex items-center mt-8">
                    <x-button-primary>
                        {{ __('Adresgegevens opslaan') }}
                    </x-button-primary>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
