<x-site-layout>
    @section('title', __( 'Track & Trace'))
    <div class="bg-gray-50 w-full min-h-full flex justify-center py-24">
        <div class="flex flex-col px-4">
            <x-link-inline href="/" class="mb-2">{{ __('Terug naar Home') }}</x-link-inline>
            @if (!$isDelivered)
                <h1 class="text-4xl font-bold tracking-tight">{{ __('Status van uw bestelling') }}</h1>
            @endif

            @if ($isDelivered)
                <div class="flex flex-col bg-secondary-lighter p-8 rounded-xl my-4 max-w-xl">
                    <h1 class="text-4xl font-bold tracking-tight">{{ __('Uw bestelling is bezorgd!') }}</h1>
                    <p class="mt-4 text-lg">{{ __('Laat weten hoe u de bezorging vond verlopen en hoe we onze service kunnen verbeteren.') }}</p>
                    <form method="POST" action="{{ route('customer.tracking.review', $shipment) }}" class="flex flex-col @if($shipment->review != null) opacity-40 pointer-events-none @endif">
                        @csrf
                        <input class="w-full lg:w-1/2 border-0 rounded-xl" type="number" name="rating" value="1" min="1" max="5" value="{{ $shipment->review == null ? '' : $shipment->review->rating }}"/>
                        <x-input-error :messages="$errors->get('rating')" class="mt-2" />
                        <label class="mt-4 font-bold text-lg" for="comment">Toelichting</label>
                        <textarea id="comment" name="comment" class="border-0 bg-white rounded-xl resize-none mb-4 w-full lg:w-1/2">{{ $shipment->review == null ? '' : $shipment->review->comment }}</textarea>
                        @if(!$shipment->review != null)
                            <x-button-primary name="submit" class="w-1/2">{{ __('Verstuur beoordeling') }}</x-button-primary>
                        @else
                            <p class="font-bold text-lg mt-4">{{ __('Beoordeling verstuurd!') }}</p>
                        @endif
                    </form>
                </div>
            @endif
            <div class="flex flex-col bg-secondary-lighter p-8 rounded-xl my-4">
                <p class="text-gray-700 text-sm font-semibold">{{ __('Afzender:') }}</p>
                <p class="mt-1 font-semibold">
                    <b>{{ $shipment->store->name }}</b>
                    -
                    {{ $shipment->store->address->street_name }}
                    {{ $shipment->store->address->house_number }},
                    {{ $shipment->store->address->postal_code }}
                    {{ $shipment->store->address->city }}
                </p>
                <p class="text-gray-700 text-sm font-semibold mt-4">{{ __('Ontvanger:') }}</p>
                <p class="mt-1 font-semibold">
                    <b>{{ $shipment->address->first_name }} {{ $shipment->address->last_name }}</b>
                    -
                    {{ $shipment->address->street_name }}
                    {{ $shipment->address->house_number }},
                    {{ $shipment->address->postal_code }}
                    {{ $shipment->address->city }}
                </p>
            </div>
            <div class="flex flex-col @if ($isDelivered) opacity-40 pointer-events-none @endif">
                <h2 class="text-2xl font-semibold tracking-tight my-2">{{ __('Waar is mijn pakket?') }}</h2>
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
                        <p>{{ __('Bestelling bewaren?') }}</p>
                        <x-link-inline class="ml-2" href="/login">{{ __('Log in of registreer') }}</x-link-inline>
                    @else
                        @if (!$shipment->attachedUsers()->first())
                            <form method="POST" action="{{ route('customer.tracking.save') }}">
                                @csrf
                                <input type="hidden" name="tracking_id" value="{{ $shipment->tracking_number }}" />
                                <input type="hidden" name="postal_code" value="{{ $shipment->address->postal_code }}" />
                                <x-button-secondary name="save-shipment">{{ __('Bewaar bestelling') }}</x-button-secondary>
                            </form>
                        @else
                            <p class="text-gray-500 font-semibold">{{ __('Bestelling bewaard in account.') }}</p>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-site-layout>
