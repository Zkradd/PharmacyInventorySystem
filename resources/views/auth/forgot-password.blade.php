<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <div class="mb-4 text-sm text-gray-600">
            {{ __('Zapomniałeś/aś hasła? Nie ma problemu. Podaj swój adres e-mail a wyślemy link do resetu hasła, który pozwoli Ci wybrać nowe.') }}
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="__('Email')" />

                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />

                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="flex items-center justify-between mt-4 gap-9">
                <a href="/">
                <span>
                    {{ __('Wróć') }}
                </span>
                   <a>
                <x-primary-button>
                    {{ __('Prześlij link do resetowania') }}
                </x-primary-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
