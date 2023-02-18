<x-admin-layout>
    <h1 class="text-3xl font-semibold tracking-tight">{{ __('Bewaarde bestellingen') }}</h1>

    <div class="flex flex-col mt-8">
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('TrackR ID') }}</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Postcode') }}</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Huidige status') }}</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Acties') }}</th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($shipments as $shipment)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        {{ $shipment->tracking_number }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        {{ $shipment->address->postal_code }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <b>{{ $shipment->ShipmentStatuses->first()->status->getShortLabel() }}</b>
                                    </div>
                                </td>
                                <td>
                                    <div class="flex">
                                        <div class="flex space-x-2">
                                            <form method="get" action="{{ route('customer.tracking.overview') }}" target="_blank">
                                                <input type="hidden" name="tracking_id" value="{{ $shipment->tracking_number}}" />
                                                <input type="hidden" name="postal_code" value="{{ $shipment->address->postal_code }}" />
                                                <x-button-primary>
                                                    {{ __('Bekijken') }}
                                                </x-button-primary>
                                            </form>
                                            <form method="POST" action="{{ route('customer.tracking.delete', $shipment->id) }}" onsubmit="return confirm('Zeker weten?');">
                                                @csrf
                                                @method('POST')
                                                <x-button-secondary type="submit">{{ __('Stop met bewaren') }}</x-button-secondary>
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
