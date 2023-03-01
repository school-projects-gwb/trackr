@props(['data' => [], 'headers' => [], 'fields' => [], 'baseRoute' => ''])
<div class="flex flex-col mt-8">
    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                    <tr>
                        @foreach($headers as $header)
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ $header }}
                            </th>
                        @endforeach
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($data as $item)
                            <tr>
                                @foreach ($fields as $field)

                                    @if (!is_object($item->{$field} && !is_countable($item->{$field})))
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $item->{$field} }}</td>
                                    @else
                                        @foreach($item->{$field} as $child)
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="bg-gray-100 px-2 py-1 rounded-full uppercase text-sm">
                                                    {{ $child->name }}
                                                </span>
                                            </td>
                                        @endforeach
                                    @endif
                                @endforeach
                                <td>
                                    <div class="flex">
                                        <div class="flex space-x-2">
                                            <x-link-primary type="submit" href="{{route($baseRoute.'.edit', $item)}}">{{ __('Bewerk') }}</x-link-primary>
                                            <form class="" method="POST" action="{{route($baseRoute.'.delete', $item)}}" onsubmit="return confirm('Are you sure?');">
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
