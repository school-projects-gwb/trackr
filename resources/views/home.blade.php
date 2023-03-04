<x-site-layout>
    @section('title', __( 'Trackr - Home'))
    <div class="min-h-full w-full xl:w-1/2 bg-gray-100 flex items-center justify-center">
        <div class="flex flex-col w-11/12 xl:w-11/12">
            <div class="flex flex-col items-center xl:items-start mt-8">
                <h1 class="text-4xl font-bold tracking-tight">Track & Trace</h1>
                <h3 class="mt-2 text-xl">Vul je gegevens in om je pakket in te zien!</h3>
            </div>
            <form method="get" action="{{ route('customer.tracking.overview-tracking') }}" class="flex flex-col xl:flex-row items-center xl:items-end mt-8">
                <div class="w-3/4 xl:w-6/12 flex flex-col mr-0 xl:mr-4">
                    <x-input-label for="tracking_id" :value="__('TrackR ID')" />
                    <x-text-input name="tracking_id" id="tracking_id" />
                </div>
                <div class="w-3/4 xl:w-4/12 flex flex-col mr-0 xl:mr-4 mt-8 xl:mt-0">
                    <x-input-label for="postal_code" :value="__('Postcode')" />
                    <x-text-input name="postal_code" id="postal_code" placeholder="1234 AB" />
                </div>
                <x-button-primary class="w-3/4 xl:w-2/12 mt-8 xl:mt-0">
                    {{ __('Zoeken') }}
                </x-button-primary>
            </form>
        </div>
    </div>
    <div class="min-h-full w-full xl:w-1/2 bg-secondary-lighter"></div>
</x-site-layout>
