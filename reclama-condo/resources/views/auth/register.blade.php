<x-guest-layout>

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/gh/lipis/flag-icons@7.2.3/css/flag-icons.min.css" />

    <!-- Language Switcher -->
    <div class="relative inline-block group mb-4 text-center" style="left: 9.75rem;">
        <button class="bg-gray-200 text-gray-700 font-semibold py-2 px-4 rounded inline-flex items-center focus:outline-none focus:ring-2 focus:ring-indigo-500">
            <i class="fa-solid fa-language mr-2"></i> {{ strtoupper(app()->getLocale()) }}
            <svg class="fill-current h-4 w-4 ml-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                <path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
            </svg>
        </button>
        <ul class="absolute hidden group-hover:block bg-white text-gray-700 rounded shadow-md mt-1 w-32">
            @foreach (config('localization.locales') as $locale)
            <li class="block px-4 py-1 hover:bg-gray-100">
                <a href="{{ route('lang', $locale) }}">
                    {{ strtoupper(__($locale)) }}
                </a>
            </li>
            @endforeach
        </ul>
    </div>


    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <x-input-label class="mt-4" for="phone_number" :value="__('Phone Number')" />
        <div class="mt-1 flex items-center gap-2">

            <!-- Select Country Code -->
            <div class="w-1/3 relative" style="width: 80%;">
                <select id="country_code" name="country_code" class="block w-full bg-gray-50 border border-gray-300 rounded-md py-2 pl-3 pr-3 shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    @foreach ($countries as $country)
                    <option value="{{ $country['code'] }}" class="d-flex align-items-center">
                        <span class="fi fi-gr"></span>
                        &nbsp;{{ $country['name'] }} ({{ $country['code'] }})
                    </option>
                    @endforeach
                </select>
            </div>
            <!-- Input Phone Number -->
            <div class="w-2/3">
                <x-text-input id="phone_number" class="block w-full" type="tel" name="phone_number" :value="old('phone_number')" autocomplete="tel" placeholder="123-456-789" />
                <x-input-error :messages="$errors->get('phone_number')" class="mt-2" />
            </div>
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                type="password"
                name="password"
                autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                type="password"
                name="password_confirmation" autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>


    <script>
        $(document).ready(function() {
            $('#country_code').select2({
                templateResult: function(state) {
                    if (!state.id) {
                        return state.text;
                    }
                    const flagClass = $(state.element).data('flag');
                    return $('<span><i class="' + flagClass + '"></i> ' + state.text + '</span>');
                }
            });
        });
    </script>


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

        #country_code {
            appearance: none;
            padding-left: 1rem;
            text-align: left;
        }

        #country_code option {
            text-align: left;
        }
    </style>
</x-guest-layout>