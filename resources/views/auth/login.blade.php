<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-auto h-20 text-gray-500 fill-current" />
            </a>
        </x-slot>

        <div class="text-center text-xl mb-3 text-gray-600">LOGIN ADMINISTRATOR</div>
        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('login.admin') }}">
            @csrf

            <!-- Email Address -->
            <div>
                <x-c-label for="username" :value="__('Username')" />

                <x-c-input id="username" class="block w-full mt-1" type="text" name="username" :value="old('username')"
                    required autofocus />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-c-label for="password" :value="__('Password')" />

                <x-c-input id="password" class="block w-full mt-1" type="password" name="password" required
                    autocomplete="current-password" />
            </div>

            <!-- Remember Me -->
            <div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox"
                        class="text-indigo-600 border-gray-300 rounded shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                        name="remember" checked>
                    <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                <a class="text-sm text-gray-600 underline hover:text-gray-900" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
                @endif

                <x-c-button class="ml-3">
                    {{ __('Log in') }}
                </x-c-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>