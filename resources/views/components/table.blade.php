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
    'filterValues' => []
])
<div class="flex flex-col mt-8">
    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
            @foreach ($filterValues as $key => $filter)
                <div class="flex flex-col w-2/12 my-8">
                    <label class="mb-1 text-xs font-medium text-gray-500 uppercase tracking-wider">
                        {{ strtoupper($key)}}
                    </label>
                    <select class="border-gray-300 rounded-xl">
                        <option>{{ __('Alles') }}</option>
                        @foreach($filter as $value)
                            <option>{{$value->getShortLabel()}}</option>
                        @endforeach
                    </select>
                </div>
            @endforeach
            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                    <tr>
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
                                        <div class="flex space-x-2">
                                            <x-link-primary type="submit" href="{{route($baseRoute.'.edit', $item)}}">{{ __('Bewerk') }}</x-link-primary>
                                            <form class="" method="POST" action="{{route($baseRoute.'.delete', $item)}}" onsubmit="return confirm('Are you sure?');">
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
                <div class="p-4">
                    {!! $pageLinks !!}
                </div>
            </div>
        </div>
    </div>
</div>
