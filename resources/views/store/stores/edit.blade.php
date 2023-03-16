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
        <h2 class="text-2xl font-bold tracking-tight mb-4 mt-8">{{ __('Adresgegevens') }}</h2>
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

        <div class="flex mb-5 mt-7 p-4 flex-col w-11/12 bg-secondary-lighter rounded-xl">
            <div class="flex flex-row justify-between">
                <div>
                    <h2 class="text-xl font-semibold">{{ __('API Tokens') }}</h2>
                    <p class="text-sm mb-2">Web API tokens die toegang hebben tot de data van deze webwinkel</p>
                </div>
                <div x-data="{ modelOpen: false }">
                    <button @click="modelOpen =!modelOpen" class="flex items-center justify-center px-3 py-2 space-x-2 text-sm tracking-wide px-4 py-2 bg-secondary hover:bg-secondary-light text-primary rounded-md cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>

                        <span>Token Aanmaken</span>
                    </button>

                    <div x-show="modelOpen" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                        <div class="flex items-end justify-center min-h-screen px-4 text-center md:items-center sm:block sm:p-0">
                            <div x-cloak @click="modelOpen = false" x-show="modelOpen"
                                 x-transition:enter="transition ease-out duration-300 transform"
                                 x-transition:enter-start="opacity-0"
                                 x-transition:enter-end="opacity-100"
                                 x-transition:leave="transition ease-in duration-200 transform"
                                 x-transition:leave-start="opacity-100"
                                 x-transition:leave-end="opacity-0"
                                 class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-40" aria-hidden="true"
                            ></div>

                            <div x-cloak x-show="modelOpen"
                                 x-transition:enter="transition ease-out duration-300 transform"
                                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                                 x-transition:leave="transition ease-in duration-200 transform"
                                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                 class="inline-block w-full max-w-xl p-8 my-20 overflow-hidden text-left transition-all transform bg-white rounded-lg shadow-xl 2xl:max-w-2xl"
                            >
                                <div class="flex items-center justify-between space-x-4">
                                    <h1 class="text-xl font-medium text-gray-800 ">API Token</h1>

                                    <button @click="modelOpen = false" class="text-gray-600 focus:outline-none hover:text-gray-700">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </button>
                                </div>
                                <form class="mt-5 flex flex-col" method="post" action="{{ route('store.tokens.create') }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="flex flex-col mb-4">
                                        <h2 class="text-xl font-semibold">Rollen</h2>
                                        <p class="text-sm mb-2">Wijs een rol toe aan de API token</p>
                                        <input type="hidden" value="{{$store->id}}" name="store_id">
                                        @foreach ($roles as $role)
                                            <div class="my-0.5">
                                                <input class="mr-1" id="{{ $role->name . $role->id }}" type="radio" name="role_id" value="{{ $role->id  }}" />
                                                <label for="{{ $role->name . $role->id }}">{{ $role->name }}</label>
                                            </div>
                                        @endforeach
                                        <x-input-error :messages="$errors->get('role_id')" class="mt-2" />
                                    </div>

                                    <button class="px-4 py-2 bg-secondary hover:bg-secondary-light text-primary rounded-md cursor-pointer w-2/5">Aanmaken</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if(session('storeSuccess'))
                <div class="mb-4 bg-red-100 border-t border-b border-red-500 text-red-700 px-4 py-3" role="alert">
                    <p class="font-bold">Belangrijke Informatie</p>
                    <p class="text-sm">Dit zijn de gegevens van uw aangemaakte API Token. Na dat u deze pagina herlaad zijn de gegevens niet meer beschikbaar</p>
                    <ul>
                        <li>Api Token: {{ session('tokenId') }}:{{ session('tokenString') }}</li>
                        <li>Role: {{ session('tokenRole') }}</li>
                    </ul>
                </div>
            @endif

            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Token') }}</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Rol') }}</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Acties') }}</th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                @foreach($webstoreTokens as $webstoreToken)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{ $webstoreToken->id }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @foreach($webstoreToken->getRoleNames() as $role)
                                <span class="bg-gray-100 px-2 py-1 rounded-full uppercase text-sm">
                                               {{ $role }}
                                            </span>
                            @endforeach
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <form class="" method="POST" action="{{route('store.tokens.delete', $webstoreToken->id)}}" onsubmit="return confirm('Are you sure?');">
                                @csrf
                                @method('POST')
                                <button type="submit" class="underline font-semibold">Verwijder Token</button>

                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>


</x-admin-layout>
