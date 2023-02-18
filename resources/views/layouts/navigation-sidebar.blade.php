<nav class="sticky top-0 bg-secondary w-full lg:h-screen lg:max-h-screen lg:w-4/12 2xl:w-2/12 pb-4 lg:pb-0">

<div class="w-full flex flex-col items-center justify-center text-center my-2 lg:my-6">
    <div class="w-3/4 text-primary font-extrabold text-4xl">
        <a href="/">Track<span class="text-darkgray">R</span></a>
    </div>
    <div class="w-11/12 flex justify-center items-center lg:mt-4">
        <div @click.away="open = false" class="relative" x-data="{ open: false }">
            <button @click="open = !open" class="flex items-center w-full px-4 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg hover:text-primary focus:text-primary hover:bg-darkgray focus:bg-darkgray focus:outline-none focus:shadow-outline">
                <div class="rounded-full w-12 h-12 bg-primary mr-2"></div>
                <div class="flex flex-col text-left">
                    <span class="font-semibold text-xl text-primary">{{ Auth::user()->name }}</span>
                    <span class="text-sm text-primary">
                        @foreach (Auth::user()->getRoleNames() as $role) {{ $role  }} @endforeach
                    </span>
                </div>
                <svg fill="white" viewBox="0 0 20 20" :class="{'rotate-180': open, 'rotate-0': !open}" class="ml-2 inline w-8 h-8 transition-transform duration-200 transform"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
            </button>
            <div x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="absolute right-0 w-full mt-2 origin-top-right rounded-md shadow-lg">
                <div class="px-2 py-2 bg-primary rounded-md shadow dark-mode:bg-gray-700">
                    <x-sidebar-dropdown-link :href="route('profile.edit')">
                        {{ __('Mijn profiel') }}
                    </x-sidebar-dropdown-link>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-sidebar-dropdown-link :href="route('logout')"
                                         onclick="event.preventDefault();
                                                this.closest('form').submit();">
                            {{ __('Uitloggen') }}
                        </x-sidebar-dropdown-link>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@role('SuperAdmin')
    <x-sidebar-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
        {{ __('Home') }}
    </x-sidebar-nav-link>

    <x-sidebar-nav-link :href="route('admin.users.overview')" :active="Route::is('*.users.*')">
        {{ __('Gebruikersbeheer') }}
    </x-sidebar-nav-link>
@else
    <x-sidebar-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
        {{ __('Home') }}
    </x-sidebar-nav-link>
@endrole

@role('StoreOwner')
    <x-sidebar-nav-link :href="route('store.users.overview')" :active="Route::is('*.users.*')">
        {{ __('Gebruikers') }}
    </x-sidebar-nav-link>
    <x-sidebar-nav-link :href="route('store.stores.overview')" :active="Route::is('*.stores.*')">
        {{ __('Webwinkels') }}
    </x-sidebar-nav-link>
@endrole

@can('access store')
    <x-sidebar-nav-link :href="route('admin.users.overview')" :active="Route::is('*.whatever.*')">
        {{ __('Pakketten') }}
    </x-sidebar-nav-link>
    <x-sidebar-nav-link :href="route('admin.users.overview')" :active="Route::is('*.whatever.*')">
        {{ __('Pickups') }}
    </x-sidebar-nav-link>
@endcan

@role('Customer')
    <x-sidebar-nav-link :href="route('customer.tracking.overview-saved')" :active="Route::is('*.tracking.*')">
        {{ __('Bewaarde bestellingen') }}
    </x-sidebar-nav-link>
@endrole


</nav>
