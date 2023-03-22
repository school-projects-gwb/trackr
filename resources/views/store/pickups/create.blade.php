<x-admin-layout>
    @section('title', __( 'Pickup aanmaken'))
    <h1 class="text-3xl font-semibold tracking-tight">{{ __('Pickup aanmaken') }}</h1>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-2 mt-4 pb-16">
        <div class="flex flex-col p-2">
            <x-link-inline href="{{ route('store.pickups.overview') }}">{{ __('Terug naar overzicht') }}</x-link-inline>

            @foreach($errors as $error)
                <p>{{ $error }}</p>
            @endforeach
            <form method="POST" class="mt-5" action="{{ route('store.pickups.store') }}">
                @csrf
                <div class="flex flex-col mb-5">
                    <div>
                        <input class="p-3 w-72 rounded-md border-gray-300 focus:border-gray-500 focus:ring-transparent mr-5" type="datetime-local" name="pickup_datetime" >
                        <select class="p-3 w-72 rounded-md border-gray-300 focus:border-gray-500 focus:ring-transparent" name="carrier" id="carrierSelector">
                            @foreach($carriers as $carrier)
                                <option value="{{ $carrier->id }}">{{ $carrier->name }}</option>
                            @endforeach
                        </select>

                    </div>
                    <div>
                        <x-input-error :messages="$errors->get('pickup_datetime')" class="mt-2" />
                        <x-input-error :messages="$errors->get('carrier')" class="mt-2" />
                    </div>
                </div>

                <div class="mb-3">
                    <p>Selecteer de zendingen die opgehaald moeten worden</p>
                    <x-input-error :messages="$errors->get('shipment_id')"/>
                </div>
                @foreach($shipments as $shipment)
                    <div class="flex shipmentSelector pb-1" data-carrier="{{ $shipment->carrier_id }}">
                        <input type="checkbox" class="rounded-md border-gray-400 focus:border-gray-500 focus:ring-transparent mr-1" data-carrier="{{ $shipment->carrier_id }}" id="shipment-{{$loop->index}}" name="shipment_id[{{ $loop->index }}]" value="{{ $shipment->id }}">
                        <label class="leading-5" for="shipment-{{$shipment->id}}">Tracking Nr: {{$shipment->tracking_number}}</label>
                    </div>
                @endforeach
                <div class="flex items-center mt-8">
                    <x-button-primary name="submit">
                        {{ __('Pickup aanmaken') }}
                    </x-button-primary>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>

<script>
    const carrierSelector = document.getElementById("carrierSelector")
    const selectableShipments = document.getElementsByClassName("shipmentSelector");
    carrierSelector.addEventListener('change', () => {
       handleSelectables();
    })


    function handleSelectables(){
        Array.from(selectableShipments).forEach(e => {
            if(carrierSelector.value !== e.dataset.carrier){
                e.style.display = "none"
            } else {
                e.style.display = ""
            }
            e.firstElementChild.checked = false
        });
    }
</script>
