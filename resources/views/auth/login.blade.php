<x-site-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="h-full w-1/2 bg-gray-100 flex justify-center items-center">
        <form class="w-1/2" method="POST" action="{{ route('login') }}">
            <a href="/" class="underline font-semibold text-sm">{{ __('Terug naar Home') }}</a>
            <h1 class="text-4xl font-semibold">Inloggen</h1>
        @csrf

        <!-- Email Address -->
            <div class="mt-8">
                <x-input-label class="text-lg text-black" for="email" :value="__('Emailadres')" />
                <x-text-input id="email" class="w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-8">
                <div class="flex justify-between">
                    @if (Route::has('password.request'))
                        <x-input-label for="password" :value="__('Password')" />
                        <a class="text-sm underline font-semibold" href="{{ route('password.request') }}">
                            {{ __('Wachtwoord vergeten?') }}
                        </a>
                    @endif
                </div>

                <x-text-input id="password" class="block mt-1 w-full"
                              type="password"
                              name="password"
                              required autocomplete="current-password" />

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Remember Me -->
            <div class="block mt-8">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" name="remember">
                    <span class="ml-2 text-sm text-black">{{ __('Onthoud mij') }}</span>
                </label>
            </div>

            <div class="flex flex-col items-center mt-4">
                <x-button-primary class="ml-3 w-full text-xl font-bold">
                    {{ __('Inloggen') }}
                </x-button-primary>

                <div class="mt-2">
                    Nog geen account? <a class="underline font-semibold" href="/register">Registreren</a>
                </div>
            </div>
        </form>
    </div>
    <div class="h-full w-1/2 bg-secondary-lighter"></div>

</x-site-layout>
