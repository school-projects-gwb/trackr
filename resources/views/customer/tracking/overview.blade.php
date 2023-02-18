<x-site-layout>
    <div class="bg-gray-50 w-full min-h-full flex justify-center py-24">
        <div class="flex flex-col px-4">
            <x-link-inline href="/" class="mb-2">Terug naar Home</x-link-inline>
            <h1 class="text-4xl font-bold tracking-tight">Status van uw bestelling</h1>

            <div class="flex flex-col bg-secondary-lighter p-4 rounded-xl my-4">
                <p class="text-gray-700 text-sm font-semibold">Afzender:</p>
                <p class="mt-1 font-semibold">WinkelNaam, Straatnaam 58 Stad</p>

                <p class="text-gray-700 text-sm font-semibold mt-4">Ontvanger:</p>
                <p class="mt-1 font-semibold">
                    {{ $shipment->address->first_name }}
                    {{ $shipment->address->last_name }}
                    -
                    {{ $shipment->address->streetname }}
                    {{ $shipment->address->housenumber }},
                    {{ $shipment->address->postal_code }}
                    {{ $shipment->address->city }}
                </p>
            </div>
            <div class="flex flex-col">
                <h2 class="text-2xl font-semibold tracking-tight my-2">Waar is mijn pakket?</h2>
                @foreach($shipment->shipmentStatuses as $shipmentStatus)
                    <div class="pl-8 pt-8 border-l-4 border-secondary">
                        <span class="shipment-tracking-icon completed"></span>
                        <div class="flex flex-col">
                            <p>{{ $shipmentStatus->status->getDescription() }}</p>
                            <p class="text-gray-500">{{ date('Y-m-d H:i', strtotime($shipmentStatus->created_at)) }}</p>
                        </div>
                    </div>
                @endforeach

                @foreach($remainingStatuses as $remainingStatus)
                        <div class="pl-8 pt-8 border-l-4 border-gray-400">
                            <span class="shipment-tracking-icon"></span>
                            <p>{{ $remainingStatus->getDescription() }}</p>
                        </div>
                @endforeach

                <div class="mt-8 flex">
                    @if (!Auth::check())
                        <p>Bestelling bewaren?</p>
                        <x-link-inline class="ml-2" href="/login">Log in of registreer</x-link-inline>
                    @else
                        @if (!$shipment->attachedUsers()->first())
                            <form method="POST" action="{{ route('customer.tracking.save') }}">
                                @csrf
                                <input type="hidden" name="tracking_id" value="{{ $shipment->tracking_number }}" />
                                <input type="hidden" name="postal_code" value="{{ $shipment->address->postal_code }}" />
                                <x-button-secondary>Bewaar bestelling</x-button-secondary>
                            </form>
                        @else
                            <p class="text-gray-500 font-semibold">Bestelling bewaard in account.</p>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>

{{--    {{ $shipment->shipmentStatuses }}--}}
</x-site-layout>
