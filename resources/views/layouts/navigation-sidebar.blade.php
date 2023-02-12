<nav class="h-screen max-h-screen bg-secondary w-2/12">

<div class="w-full flex flex-col items-center justify-center text-center my-6">
    <div class="w-3/4 text-primary font-extrabold text-4xl">Track<span class="text-darkgray">R</span></div>
    <div class="w-3/4 flex justify-center mt-4">
        <div class="rounded-full w-12 h-12 bg-primary"></div>
        <div class="flex flex-col text-left ml-4 text-primary">
            <span class="font-semibold text-xl">Andrew K.</span>
            <span class="text-sm">Webshop Owner</span>
        </div>
    </div>
</div>

@role('SuperAdmin')
    <x-sidebar-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
        {{ __('Dashboard') }}
    </x-sidebar-nav-link>

    <x-sidebar-nav-link :href="route('dashboard')" :active="request()->routeIs('test')">
        {{ __('Users') }}
    </x-sidebar-nav-link>
@endrole

</nav>
