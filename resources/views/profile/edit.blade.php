<x-admin-layout>
    @section('title', __( 'Profiel bewerken'))
    <h1 class="text-3xl font-semibold tracking-tight">{{ __('Mijn profiel') }}</h1>
        <div class="max-w-7xl mt-8 grid lg:grid-cols-2 gap-8">

            <div class="p-4 sm:p-8 bg-secondary-lighter sm:rounded-lg w-full">
                <div>
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-secondary-lighter sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-secondary-lighter sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
{{--    </div>--}}
</x-admin-layout>
