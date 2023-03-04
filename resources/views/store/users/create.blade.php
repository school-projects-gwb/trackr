<x-admin-layout>
    @section('title', __( 'Gebruiker aanmaken'))
    <h1 class="text-3xl font-semibold tracking-tight">Gebruiker aanmaken</h1>

    <div class="bg-primary overflow-hidden shadow-sm sm:rounded-lg p-2 mt-4">
        <div class="flex p-2">
            <x-link-inline href="{{ route('store.users.overview') }}">{{ __('Terug naar overzicht') }}</x-link-inline>
        </div>
        <div class="flex p-2 flex-col w-11/12 lg:w-1/2">
            <form method="POST" action="{{ route('store.users.store') }}">
            @csrf

            <!-- Name -->
                <div>
                    <x-input-label for="name" :value="__('Naam')" />
                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Email Address -->
                <div class="mt-4">
                    <x-input-label for="email" :value="__('Emailadres')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Wachtwoord')" />

                    <x-text-input id="password" class="block mt-1 w-full"
                                  type="password"
                                  name="password"
                                  required autocomplete="new-password" />

                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirm Password -->
                <div class="mt-4">
                    <x-input-label for="password_confirmation" :value="__('Bevestig wachtwoord')" />

                    <x-text-input id="password_confirmation" class="block mt-1 w-full"
                                  type="password"
                                  name="password_confirmation" required autocomplete="new-password" />

                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <div class="mt-4 flex flex-col mt-4">
                    <h2 class="text-xl font-semibold">Webwinkels</h2>
                    <p class="text-sm mb-2">Voeg je gebruiker minimaal aan één webwinkel toe.</p>
                    @foreach ($stores as $store)
                        <div class="my-0.5">
                            <input class="mr-1" id="{{ $store->name . $store->id }}" type="checkbox" name="store_id[]" value="{{ $store->id  }}" />
                            <label for="{{ $store->name . $store->id }}">{{ $store->name }}</label>
                        </div>
                    @endforeach
                    <x-input-error :messages="$errors->get('store_id')" class="mt-2" />
                </div>

                <div class="mt-4 flex flex-col mt-4">
                    <h2 class="text-xl font-semibold">Rollen</h2>
                    <p class="text-sm mb-2">Geef je gebruiker een rol.</p>
                    @foreach ($roles as $role)
                        <div class="my-0.5">
                            <input class="mr-1" id="{{ $role->name . $role->id }}" type="radio" name="role_id" value="{{ $role->id  }}" />
                            <label for="{{ $role->name . $role->id }}">{{ $role->name }}</label>
                        </div>
                    @endforeach
                    <x-input-error :messages="$errors->get('role_id')" class="mt-2" />
                </div>

                <div class="flex items-center mt-8">
                    <x-button-primary>
                        {{ __('Gebruiker aanmaken') }}
                    </x-button-primary>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
