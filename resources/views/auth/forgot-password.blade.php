<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
        {{ __('¿Olvidaste tu password? No hay problema. Ingresa tu dirección de correo y te enviaremos un enlace para crear uno nuevo') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required
                autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex justify-between my-4">
            @if (Route::has('password.request'))
                <x-link :href="route('login')">
                    Iniciar sesión
                </x-link>
                <x-link :href="route('register')">
                    Crear cuenta
                </x-link>
            @endif
        </div>

        <x-primary-button class="w-full justify-center">
            {{ __('Iniciar Sesión') }}
        </x-primary-button>
    </form>
</x-guest-layout>
