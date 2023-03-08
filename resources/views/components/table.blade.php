@props([
    'data' => [],
    'headers' => [],
    'fields' => [],
    'baseRoute' => '',
    'pageLinks' => [],
    'currentPage' => '',
    'itemsPerPage' => '',
    'sortField' => '',
    'sortDirection' => '',
    'sortableFields' => [],
    'filterValues' => [],
    'selectable' => []
])
<div class="flex flex-col">
    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
            <form class="w-full flex items-end mb-8" action="{{route($baseRoute.'.overview')}}" method="GET">
                <input type="hidden" name="sort" value="{{request('sort')}}"/>
                <input type="hidden" name="dir" value="{{request('dir')}}"/>
                @if (count($filterValues) > 0)
                    @foreach ($filterValues as $key => $filter)
                        <div class="flex flex-col w-2/12 px-2">
                            @if (!is_array($filter))
                                <label class="mb-1 text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{ strtoupper($key)}}
                                </label>
                                <x-text-input-border name="{{ $key }}" value="{{$filter}}"></x-text-input-border>
                            @else
                                <label class="mb-1 text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{ strtoupper($key)}}
                                </label>
                                <select name="{{ $key }}" class="border-gray-300 rounded-xl">
                                    <option value="">{{ __('Alles') }}</option>
                                    @foreach($filter as $value)
                                        <option value="{{ $value }}" {{ request($key) == $value ? 'selected' : '' }}>{{$value}}</option>
                                    @endforeach
                                </select>
                            @endif
                        </div>
                    @endforeach
                    <x-button-primary type="submit">{{ __('Filters toepassen') }}</x-button-primary>
                @endif
            </form>
            @if (count($selectable) > 0)
                <form action="{{route($selectable['actionRoute'])}}" method="GET">
                @foreach ($selectable['actions'] as $action)
                        <x-button-secondary class="ml-2 mb-8" type="submit" name="action" value="{{ $action['value'] }}">{{ $action['label'] }}</x-button-secondary>
                @endforeach
            @endif
            <p class="ml-2 mb-2">{{count($data) }} {{__('resultaten')}}</p>
            <form class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                    <tr>
                        @if (count($selectable) > 0)
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('Selecteer') }}
                            </th>
                        @endif
                        @for($i = 0; $i < count($headers); $i++)
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                @if (isset($fields[$i]) && in_array($fields[$i], $sortableFields))
                                    <a href="?sort={{ $fields[$i] }}&dir={{ $sortDirection === 'asc' ? 'desc' : 'asc' }}">
                                        {{ $headers[$i] }}
                                        @if (isset($fields[$i]) && $sortField == $fields[$i])
                                            @if ($sortDirection == 'asc')
                                                <i class="fa fa-caret-up"></i>
                                            @else
                                                <i class="fa fa-caret-down"></i>
                                            @endif
                                        @endif
                                    </a>
                                @else
                                    {{ $headers[$i] }}
                                @endif
                            </th>
                        @endfor
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($data as $item)
                            <tr>
                                @if (count($selectable) > 0)
                                    <td class="px-6 py-4 whitespace-nowrap w-1/12">
                                        <input type="checkbox" name="shipment_id[]" value="{{ $item->id }}">
                                    </td>
                                @endif
                                @foreach ($fields as $field)
                                    @if (str_contains($field, "get"))
                                        @foreach($item->{$field}() as $child)
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="bg-gray-100 px-2 py-1 rounded-full uppercase text-sm">
                                                    {{ $child }}
                                                </span>
                                            </td>
                                        @endforeach
                                    @elseif (!is_object($item->{$field}))
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $item->{$field} }}
                                        </td>
                                    @else
                                        @if (is_countable($item->{$field}))
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @foreach($item->{$field} as $child)
                                                    <span class="bg-gray-100 px-2 py-1 rounded-full uppercase text-sm">
                                                        {{ $child->tableDisplayField() }}
                                                    </span>
                                                @endforeach
                                            </td>
                                        @else
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                {{ $item->{$field}->name ?? $item->{$field} }}
                                            </td>
                                        @endif
                                    @endif
                                @endforeach
                                <td>
                                    <div class="flex">
                                        <div class="flex">
                                            @if (Route::has($baseRoute.'.edit'))
                                                <x-link-primary type="submit" href="{{route($baseRoute.'.edit', $item)}}">{{ __('Bewerk') }}</x-link-primary>
                                            @endif
                                            @if (Route::has($baseRoute.'.delete'))
                                                <form class="" method="POST" action="{{route($baseRoute.'.delete', $item)}}" onsubmit="return confirm('Are you sure?');">
                                                    @csrf
                                                    @method('POST')
                                                    <x-button-secondary class="ml-2" type="submit">{{ __('Verwijder') }}</x-button-secondary>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @if (count($selectable) > 0)
                    </form>
                @endif
                <div class="p-4">
                    {!! $pageLinks !!}
                </div>
            </div>
        </div>
    </div>
</div>
