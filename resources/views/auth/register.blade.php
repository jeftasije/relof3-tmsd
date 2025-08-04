<form method="POST" action="{{ route('register') }}">
    @csrf

    <!-- Name -->
    <div>
        <x-input-label for="name">
            @switch(App::getLocale())
            @case('en') Name @break
            @case('sr-Cyrl') Име @break
            @default Ime
            @endswitch
        </x-input-label>
        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
        <x-input-error :messages="$errors->get('name')" class="mt-2" />
    </div>

    <!-- Email Address -->
    <div class="mt-4">
        <x-input-label for="email">
            @switch(App::getLocale())
            @case('en') Email @break
            @case('sr-Cyrl') Мејл адреса @break
            @default Mejl adresa
            @endswitch
        </x-input-label>
        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
        <x-input-error :messages="$errors->get('email')" class="mt-2" />
    </div>

    <!-- Password -->
    <div class="mt-4">
        <x-input-label for="password">
            @switch(App::getLocale())
            @case('en') Password @break
            @case('sr-Cyrl') Лозинка @break
            @default Lozinka
            @endswitch
        </x-input-label>

        <x-text-input id="password" class="block mt-1 w-full"
            type="password"
            name="password"
            required autocomplete="new-password" />

        <x-input-error :messages="$errors->get('password')" class="mt-2" />
    </div>

    <!-- Confirm Password -->
    <div class="mt-4">
        <x-input-label for="password_confirmation">
            @switch(App::getLocale())
            @case('en') Password confirmation @break
            @case('sr-Cyrl') Потврда лозинке @break
            @default Potvrda lozinke
            @endswitch
        </x-input-label>

        <x-text-input id="password_confirmation" class="block mt-1 w-full"
            type="password"
            name="password_confirmation" required autocomplete="new-password" />

        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
    </div>

    <div class="flex items-center justify-center mt-4">
        <x-primary-button>
            @switch(App::getLocale())
            @case('en') Register @break
            @case('sr-Cyrl') Региструј @break
            @default Registruj
            @endswitch
        </x-primary-button>
    </div>
</form>