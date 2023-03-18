<x-site-layout>

    <div class="w-full lg:w-1/2 h-full mt-16 lg:mt-0 bg-gray-100 flex justify-center items-center  py-24">
        <form class="w-11/12 lg:w-1/2" method="POST" action="{{ route('register') }}">
            @csrf
            <a href="/" class="underline font-semibold text-sm">{{ __('Terug naar Home') }}</a>
            <h1 class="text-4xl font-semibold">{{__('Registreren')}}</h1>

            <div class="mt-8">
                <x-input-label for="name" :value="__('Naam')" />
                <x-text-input id="name" class="w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="email" :value="__('Emailadres')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="mt-4" class="mt-8">
                <x-input-label for="password" :value="__('Wachtwoord')" />
                <x-text-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="password_confirmation" :value="__('Wachtwoord Herhaald')" />
                <x-text-input id="password_confirmation" class="block mt-1 w-full"
                                type="password"
                                name="password_confirmation" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <div class="flex flex-col items-center mt-8">
                <x-button-primary class="w-full text-xl font-bold" name="submit">
                    {{ __('Registreren') }}
                </x-button-primary>
            </div>
        </form>
    </div>
</x-site-layout>
