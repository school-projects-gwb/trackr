<div class="w-1/4 p-2">
    <div @click.away="open = false" class="relative" x-data="{ open: false }">
        <button @click="open = !open" class="flex items-center justify-between w-full px-4 py-2 mt-2 text-sm font-semibold bg-transparent border rounded-lg hover:text-primary focus:text-primary hover:bg-primary focus:bg-primary focus:outline-none focus:shadow-outline">
            <div class="flex flex-col text-left">
                <span class="font-semibold text-md text-black">Geselecteerde winkel</span>
                <span class="text-gray-600 text-lg">{{ $selectedStore->name }}</span>
            </div>
            <svg fill="black" viewBox="0 0 20 20" :class="{'rotate-180': open, 'rotate-0': !open}" class="ml-2 inline w-8 h-8 transition-transform duration-200 transform"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
        </button>
        <div x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="absolute right-0 w-full mt-2 origin-top-right rounded-md shadow-lg">
            <div class="px-2 py-2 bg-primary rounded-md shadow dark-mode:bg-gray-700">
                @foreach($userStores as $store)
                    <x-sidebar-dropdown-link>
                        <form method="POST" action="{{ route('store.stores.switch', $store) }}">
                            @csrf
                            <input class="block w-full text-left cursor-pointer" type="submit" value="{{ $store->name }}"/>
                        </form>
                    </x-sidebar-dropdown-link>
                @endforeach
            </div>
        </div>
    </div>
</div>

