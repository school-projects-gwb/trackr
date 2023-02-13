<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-black">
            {{ __('Account verwijderen') }}
        </h2>

        <p class="text-sm text-gray-700">
            {{ __('Zodra je account verwijderd is, gaat al je informatie verloren. Zorg voor backups voordat je verder gaat met het verwijderen.') }}
        </p>
    </header>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >{{ __('Verwijder account') }}</x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Weet je zeker dat je je account wil verwijderen?') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ __('Je account gaat permanent verloren. Vul je wachtwoord in om het verwijderen van je account te bevestigen,') }}
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="Password" class="sr-only" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-3/4"
                    placeholder="Password"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Annuleren') }}
                </x-secondary-button>

                <x-danger-button class="ml-3">
                    {{ __('Verwijder account') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
