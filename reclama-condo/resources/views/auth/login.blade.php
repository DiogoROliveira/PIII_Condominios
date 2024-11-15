<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <!-- Language Switcher -->
    <div class="relative inline-block group mb-3 text-center" style="left: 9.75rem;">
        <button class="bg-gray-200 text-gray-700 font-semibold py-2 px-4 rounded inline-flex items-center focus:outline-none focus:ring-2 focus:ring-indigo-500">
            {{ strtoupper(app()->getLocale()) }}
            <svg class="fill-current h-4 w-4 ml-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                <path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
            </svg>
        </button>
        <ul class="absolute hidden group-hover:block bg-white text-gray-700 rounded shadow-md mt-2 w-full">
            @foreach (config('localization.locales') as $locale)
            <li class="block px-4 py-2 hover:bg-gray-100">
                <a href="{{ route('lang', $locale) }}">
                    {{ strtoupper(__($locale)) }}
                </a>
            </li>
            @endforeach
        </ul>
    </div>

    <!-- Login Form -->
    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                type="password"
                name="password"
                autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                {{ __('Forgot your password?') }}
            </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>

    <style>
        .group:hover ul,
        .group:focus-within ul {
            display: block;
        }

        .group ul {
            display: none;
        }

        .group button {
            background-color: #f9fafb;
            border: 1px solid #e5e7eb;
            transition: background-color 0.3s ease;
        }

        .group button:hover {
            background-color: #e5e7eb;
        }
    </style>

</x-guest-layout>