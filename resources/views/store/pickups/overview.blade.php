<x-admin-layout>
    @section('title', __( 'Pickups overzicht'))
    <h1 class="text-3xl font-semibold tracking-tight">{{ __('Pickups') }}</h1>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-2 mt-4 pb-16">
        <div class="flex w-full justify-between items-center">
            <x-store-switcher></x-store-switcher>
            <div class="flex justify-end p-2">
                <x-link-primary href="{{ route('store.pickups.create') }}">{{ __('Pickup aanmaken') }}</x-link-primary>
            </div>
        </div>

        @if($pickups->count() != 0)
            <div x-data="{ modelOpen: false, pickUp: {{$pickups[0]->toJson()}}}">
                <div class="p-3 grid grid-cols-5 gap-3">
                    @foreach($pickups as $pickup)
                        <div class="bg-primary border-2 border-gray-300 rounded-md w-full p-5 ">
                            <p class="text-black font-semibold">{{ __('Ophaalmoment') }}:</p>
                            <p>{{ $pickup->pickup_moment }}</p>
                            <div class="flex mb-5">
                                <p class="text-black font-semibold mr-1">{{__('Vervoerder')}}:</p>
                                <p>{{ $pickup->carrier->name }}</p>
                            </div>
                            <button x-on:click="[modelOpen =!modelOpen, pickUp = {{ $pickup->toJson() }}]" type="submit" class="w-full items-center underline font-semibold text-secondary">{{__('Meer informatie')}}</button>
                        </div>
                    @endforeach
                </div>

                <div x-show="modelOpen" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                    <div class="flex items-end justify-center min-h-screen px-4 text-center md:items-center sm:block sm:p-0">
                        <div x-cloak @click="modelOpen = false" x-show="modelOpen"
                             x-transition:enter="transition ease-out duration-300 transform"
                             x-transition:enter-start="opacity-0"
                             x-transition:enter-end="opacity-100"
                             x-transition:leave="transition ease-in duration-200 transform"
                             x-transition:leave-start="opacity-100"
                             x-transition:leave-end="opacity-0"
                             class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-40" aria-hidden="true"
                        ></div>

                        <div x-cloak x-show="modelOpen"
                             x-transition:enter="transition ease-out duration-300 transform"
                             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                             x-transition:leave="transition ease-in duration-200 transform"
                             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                             x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                             class="inline-block w-full max-w-xl p-8 my-20 overflow-hidden text-left transition-all transform bg-white rounded-lg shadow-xl 2xl:max-w-2xl"
                        >
                            <div class="flex items-center justify-between space-x-4">
                                <h1 class="text-xl font-medium text-gray-800 mb-5">{{__('Afhaal details')}}</h1>

                                <button @click="modelOpen = false" class="text-gray-600 focus:outline-none hover:text-gray-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </button>
                            </div>
                            <div class="flex flex-row justify-between mb-1">
                                <div class="flex">
                                    <p class="mr-2 text-black font-semibold">{{ __('Ophaalmoment') }}: </p>
                                    <p x-text="new Date(pickUp?.pickup_moment).toLocaleString('nl-NL');"></p>
                                </div>
                                <div class="flex">
                                    <p class="mr-2 text-black font-semibold">{{__('Vervoerder')}}: </p>
                                    <p x-text="pickUp?.carrier.name"></p>
                                </div>
                            </div>
                            <div class="flex mb-1">
                                <p class="mr-2 text-black font-semibold">{{__('Afhaal adres')}}: </p>
                                <p class="mr-1" x-text="pickUp?.webstore.address.street_name"></p>
                                <p class="mr-1"  x-text="pickUp?.webstore.address.house_number"> </p>
                                <p class="mr-1"  x-text="pickUp?.webstore.address.postal_code"> </p>
                                <p class="mr-1"  x-text="pickUp?.webstore.address.city"></p>
                                <p class="mr-1"  x-text="pickUp?.webstore.address.country"></p>
                            </div>

                            <p class="mr-2 text-black font-semibold">{{ __('Af te halen paketnummers') }}:</p>
                            <ul class="space-x-6 list-decimal">
                                <template x-for="shipment in pickUp?.shipments">
                                    <li x-text="shipment.tracking_number"></li>
                                </template>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @endif

    </div>
</x-admin-layout>
