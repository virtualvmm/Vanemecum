<x-guest-layout>
    <h1 class="text-xl font-semibold text-gray-800 text-center mb-6">Iniciar sesión</h1>

    <x-auth-session-status class="mb-4 text-sm text-green-600" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <div>
            <x-input-label for="email" :value="__('Correo electrónico')" />
            <x-text-input id="email" class="block mt-1 w-full rounded-lg border-gray-300" type="email" name="email" :value="old('email', request('email'))" required autofocus autocomplete="username" placeholder="tu@correo.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password" :value="__('Contraseña')" />
            <x-text-input id="password" class="block mt-1 w-full rounded-lg border-gray-300" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between text-sm">
            <label for="remember_me" class="inline-flex items-center text-gray-600">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ml-2">{{ __('Recordarme') }}</span>
            </label>
            @if (Route::has('password.request'))
                <a class="text-indigo-600 hover:text-indigo-800" href="{{ route('password.request') }}">
                    {{ __('¿Olvidaste tu contraseña?') }}
                </a>
            @endif
        </div>

        <button type="submit" class="w-full py-3 px-4 rounded-lg font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition">
            {{ __('Entrar') }}
        </button>
    </form>

    <p class="mt-6 text-center text-sm text-gray-500">
        ¿No tienes cuenta? <a href="{{ route('register') }}" class="text-indigo-600 hover:text-indigo-800 font-medium">{{ __('Registrarse') }}</a>
    </p>
</x-guest-layout>
