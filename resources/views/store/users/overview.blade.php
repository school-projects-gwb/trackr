<x-admin-layout>
    <h1 class="text-3xl font-semibold tracking-tight">{{ __('Gebruikersbeheer') }}</h1>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-2 mt-4">
        <div class="flex justify-end p-2">
            <x-link-primary href="{{ route('store.users.create') }}">{{ __('Gebruiker aanmaken') }}</x-link-primary>
        </div>
        <div class="flex flex-col">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Naam') }}</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Emailadres') }}</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Toegang winkels') }}</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Rollen') }}</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Acties') }}</th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($users as $user)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            {{ $user->name }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            {{ $user->email }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            @foreach ($user->stores as $store)
                                                <span class="bg-gray-100 px-2 py-1 rounded-full uppercase text-sm">
                                                    {{ $store->name }}
                                                </span>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td>
                                        @foreach($user->getRoleNames() as $role)
                                            <span class="bg-gray-100 px-2 py-1 rounded-full uppercase text-sm">
                                                {{ $role }}
                                            </span>
                                        @endforeach
                                    </td>
                                    <td>
                                        <div class="flex">
                                            <div class="flex space-x-2">
                                                <x-link-primary type="submit" href="{{route('store.users.edit', $user)}}">{{ __('Bewerk') }}</x-link-primary>
                                                <form class="" method="POST" action="" onsubmit="return confirm('Are you sure?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <x-button-secondary type="submit">{{ __('Verwijder') }}</x-button-secondary>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

</x-admin-layout>
