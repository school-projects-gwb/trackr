<x-admin-layout>
    <h1 class="text-3xl font-semibold tracking-tight">{{ __('Webwinkel bewerken') }}</h1>

    <div class="bg-primary overflow-hidden shadow-sm sm:rounded-lg p-2 mt-4">
        <div class="flex p-2">
            <x-link-inline href="{{ route('store.stores.overview') }}">{{ __('Terug naar overzicht') }}</x-link-inline>
        </div>
        <div class="flex p-2 flex-col w-11/12 lg:w-1/2">
            <form method="POST" action="{{ route('store.stores.update', $store) }}">
            @csrf

            <!-- Name -->
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
                        {{ __('Webwinkel opslaan') }}
                    </x-button-primary>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
