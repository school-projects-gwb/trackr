<section>
    <header>
        <h2 class="text-lg font-medium text-black">
            {{ __('Wachtwoord updaten') }}
        </h2>

        <p class="text-sm text-gray-700">
            {{ __('Zorg ervoor dat je een lang, willekeurig wachtwoord kiest om zo veilig mogelijk te blijven.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="">
        @csrf
        @method('put')

        <div class="mt-8">
            <x-input-label for="current_password" :value="__('Huidig wachtwoord')" />
            <x-text-input id="current_password" name="current_password" type="password" class="mt-1 block w-full" autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div class="mt-8">
            <x-input-label for="password" :value="__('Nieuw wachtwoord')" />
            <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div class="mt-8">
            <x-input-label for="password_confirmation" :value="__('Bevestig nieuw wachtwoord')" />
            <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4 mt-4">
            <x-button-primary>{{ __('Opslaan') }}</x-button-primary>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
