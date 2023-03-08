<x-admin-layout>
    @section('title', __( 'Labels aanmaken'))
    <h1 class="text-3xl font-semibold tracking-tight">{{ __('Labels aanmaken') }}</h1>
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-2 mt-4 pb-16">
            <div class="flex p-2 pl-8">
                <x-link-inline href="{{ route('store.shipments.overview') }}">{{ __('Terug naar overzicht') }}</x-link-inline>
            </div>

            <div class="mt-4 flex flex-col mt-8 pl-8">
                <h2 class="text-xl font-semibold">Pakketten</h2>
                <p class="text-sm mb-2">De pakket ID's waarvoor de labels zullen worden aangemaakt: </p>
                <div>
                    @foreach ($shipments as $shipment)
                        <span class="bg-gray-100 px-2 mx-1 py-1 rounded-full uppercase text-sm">{{ $shipment->id }}</span>
                    @endforeach
                </div>
            </div>

            <div class="mt-4 flex flex-col mt-8 pl-8">
                <h2 class="text-xl font-semibold">Selecteer verzender</h2>
                <p class="text-sm mb-2">De pakketten waarvoor de labels zullen worden aangemaakt.</p>
            <form action="{{route('store.labels.create')}}" method="POST">
                @csrf
                <table class="min-w-full divide-y divide-gray-200">
                    @foreach($shipmentIds as $shipment_id)
                        <input type="hidden" name="shipment_id[]" value="{{ $shipment_id }}">
                    @endforeach
                    <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Selecteer') }}</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Naam verzender') }}</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Kosten pakket') }}</th>
                    </tr>
                    </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($carriers as $carrier)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap w-1/12">
                                    <input type="radio" name="carrier_id" value="{{ $carrier->id }}">
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ $carrier->name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">&euro;{{number_format(floatval($carrier->shipping_cost), 2, ",", ".") }}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                </table>
                <x-input-error :messages="$errors->get('carrier_id')" class="mt-2" />
                <x-button-primary class="mt-8" type="submit">{{ __('Labels genereren') }}</x-button-primary>
            </form>
            </div>
        </div>
</x-admin-layout>
