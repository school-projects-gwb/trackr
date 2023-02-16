<x-admin-layout>
    <h1 class="text-3xl font-semibold tracking-tight">{{ __('Webwinkelbeheer') }}</h1>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-2 mt-4">
        <div class="flex justify-end p-2">
            <x-link-primary href="{{ route('store.stores.create') }}">{{ __('Webwinkel aanmaken') }}</x-link-primary>
        </div>
        <div class="flex flex-col">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Naam') }}</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Datum laatste update') }}</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Datum creatie') }}</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Acties') }}</th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($stores as $store)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            {{ $store->name }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            {{ $store->updated_at }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="flex items-center">
                                            {{ $store->created_at }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="flex">
                                            <div class="flex space-x-2">
                                                <x-link-primary type="submit" href="{{route('store.stores.edit', $store)}}">{{ __('Bewerk') }}</x-link-primary>
                                                <form class="" method="POST" action="" onsubmit="return confirm('Are you sure?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <x-button-secondary type="submit" disabled class="bg-gray-500 text-gray-300 border-0 hover:bg-gray-500 hover:text-gray-300">{{ __('Verwijder') }}</x-button-secondary>
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
