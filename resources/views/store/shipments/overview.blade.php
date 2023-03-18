<x-admin-layout>
    @section('title', __( 'Zendingen overzicht'))
    <h1 class="text-3xl font-semibold tracking-tight">{{ __('Pakketbeheer') }}</h1>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-2 mt-4 pb-16">
        <div class="flex w-full justify-between items-start">
            <x-store-switcher></x-store-switcher>
            <div class="flex justify-end p-2">
                <div x-data="{ modelOpen: false }">
                    <button @click="modelOpen =!modelOpen" class="flex items-center justify-center px-3 py-2 space-x-2 text-sm tracking-wide px-4 py-2 bg-secondary hover:bg-secondary-light text-primary rounded-md cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>

                        <span>{{__('Paketten Importeren')}}</span>
                    </button>

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
                                    <h1 class="text-xl font-medium text-gray-800 ">{{__('Importeer CSV')}}</h1>

                                    <button @click="modelOpen = false" class="text-gray-600 focus:outline-none hover:text-gray-700">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </button>
                                </div>
                                <form class="mt-5 flex flex-col" method="post" action="{{ route('store.shipments.import') }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="py-4">
                                        <input type="file" name="csvFile">
                                    </div>

                                    <button class="px-4 py-2 bg-secondary hover:bg-secondary-light text-primary rounded-md cursor-pointer w-2/5">{{__('Importeer Pakketten')}}</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <x-table
            :data="$shipments->items()"
            :headers="['ID', 'Tracking Number', 'Status', __('Vervoerder'), __('Datum creatie'), __('Acties')]"
            :fields="['id', 'tracking_number', 'ShipmentStatuses', 'carrier', 'created_at']"
            :baseRoute="'store.shipments'"
            :pageLinks="$shipments->links()"
            :currentPage="$shipments->currentPage()"
            :perPage="$shipments->perPage()"
            :sortField="$sortField"
            :sortDirection="$sortDirection"
            :sortableFields="$sortableFields"
            :filterValues="$filterValues"
            :selectable="$selectable"
        />
    </div>

</x-admin-layout>
