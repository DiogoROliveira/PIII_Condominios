<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
    </div>

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

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Email Password Reset Link') }}
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

        /* Melhora o estilo do dropdown */
        .group ul li a {
            color: #4a5568;
            text-decoration: none;
            display: block;
            padding: 0.5rem 1rem;
        }

        .group ul li a:hover {
            background-color: #edf2f7;
            color: #2d3748;
            border-radius: 0.25rem;
        }
    </style>
</x-guest-layout>